<?php
/**
 * Security helpers for rate limiting and CSRF protection
 */

class Security {
    private $conn;
    private $max_attempts = 5; // Maximum login attempts per hour
    private $lockout_time = 3600; // Lockout time in seconds (1 hour)

    public function __construct($conn) {
        $this->conn = $conn;
    }

    /**
     * Get the lockout time in seconds
     */
    public function getLockoutTime() {
        return $this->lockout_time;
    }

    private function ensureLoginAttemptsTable() {
        try {
            $this->conn->query(
                "CREATE TABLE IF NOT EXISTS login_attempts (" .
                "id SERIAL PRIMARY KEY, " .
                "ip_address INET NOT NULL, " .
                "email VARCHAR(255), " .
                "attempt_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP, " .
                "successful BOOLEAN DEFAULT FALSE)"
            );
            return true;
        } catch (PDOException $e) {
            error_log("Failed to ensure login_attempts table exists: " . $e->getMessage());
            return false;
        }
    }

    private function getSessionAttemptCount($ip, $email = null) {
        $key = 'login_attempts_' . hash('sha256', $ip . '|' . ($email ?? ''));

        if (!isset($_SESSION[$key]) || !is_array($_SESSION[$key])) {
            $_SESSION[$key] = [];
        }

        $cutoff = time() - $this->lockout_time;
        $_SESSION[$key] = array_values(array_filter($_SESSION[$key], function ($timestamp) use ($cutoff) {
            return $timestamp > $cutoff;
        }));

        return count($_SESSION[$key]);
    }

    private function recordSessionAttempt($ip, $email = null) {
        $key = 'login_attempts_' . hash('sha256', $ip . '|' . ($email ?? ''));

        if (!isset($_SESSION[$key]) || !is_array($_SESSION[$key])) {
            $_SESSION[$key] = [];
        }

        $_SESSION[$key][] = time();

        $cutoff = time() - $this->lockout_time;
        $_SESSION[$key] = array_values(array_filter($_SESSION[$key], function ($timestamp) use ($cutoff) {
            return $timestamp > $cutoff;
        }));
    }

    private function getDatabaseAttemptCount($ip, $email = null) {
        try {
            if (!$this->ensureLoginAttemptsTable()) {
                throw new Exception('login_attempts table unavailable');
            }

            $time_limit = date('Y-m-d H:i:s', time() - $this->lockout_time);

            $stmt = $this->conn->prepare("
                SELECT COUNT(*) as attempts
                FROM login_attempts
                WHERE ip_address = :ip
                AND attempt_time > :time_limit
                AND successful = FALSE
            ");
            $stmt->execute([
                ':ip' => $ip,
                ':time_limit' => $time_limit
            ]);

            $result = $stmt->fetch();
            $attempts = (int) $result['attempts'];

            if ($email) {
                $stmt = $this->conn->prepare("
                    SELECT COUNT(*) as attempts
                    FROM login_attempts
                    WHERE email = :email
                    AND attempt_time > :time_limit
                    AND successful = FALSE
                ");
                $stmt->execute([
                    ':email' => $email,
                    ':time_limit' => $time_limit
                ]);

                $email_result = $stmt->fetch();
                $attempts = max($attempts, (int) $email_result['attempts']);
            }

            return $attempts;
        } catch (Exception $e) {
            error_log("Rate limiting query failed: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Generate a CSRF token
     */
    public static function generateCSRFToken() {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    /**
     * Validate CSRF token
     */
    public static function validateCSRFToken($token) {
        if (!isset($_SESSION['csrf_token']) || empty($token)) {
            return false;
        }
        return hash_equals($_SESSION['csrf_token'], $token);
    }

    /**
     * Check if IP is rate limited
     */
    public function isRateLimited($ip, $email = null) {
        $session_attempts = $this->getSessionAttemptCount($ip, $email);
        $database_attempts = $this->getDatabaseAttemptCount($ip, $email);
        $attempts = max($session_attempts, $database_attempts);

        return $attempts >= $this->max_attempts;
    }

    /**
     * Record a login attempt
     */
    public function recordLoginAttempt($ip, $email, $successful = false) {
        $this->recordSessionAttempt($ip, $email);

        try {
            if (!$this->ensureLoginAttemptsTable()) {
                return;
            }

            $stmt = $this->conn->prepare("
                INSERT INTO login_attempts (ip_address, email, successful)
                VALUES (:ip, :email, :successful)
            ");
            $stmt->execute([
                ':ip' => $ip,
                ':email' => $email,
                ':successful' => $successful
            ]);

            // Clean up old records (older than 24 hours)
            $cleanup_time = date('Y-m-d H:i:s', time() - 86400);
            $stmt = $this->conn->prepare("
                DELETE FROM login_attempts
                WHERE attempt_time < :cleanup_time
            ");
            $stmt->execute([':cleanup_time' => $cleanup_time]);

        } catch (PDOException $e) {
            // Log error but don't fail the login process
            error_log("Failed to record login attempt: " . $e->getMessage());
        }
    }

    /**
     * Get remaining attempts for an IP
     */
    public function getRemainingAttempts($ip, $email = null) {
        $session_attempts = $this->getSessionAttemptCount($ip, $email);
        $database_attempts = $this->getDatabaseAttemptCount($ip, $email);
        $attempts = max($session_attempts, $database_attempts);

        return max(0, $this->max_attempts - $attempts);
    }

    /**
     * Get client IP address
     */
    public static function getClientIP() {
        $ip_headers = [
            'HTTP_CF_CONNECTING_IP',
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR'
        ];

        foreach ($ip_headers as $header) {
            if (!empty($_SERVER[$header])) {
                $ip = $_SERVER[$header];
                // Handle comma-separated IPs (like X-Forwarded-For)
                if (strpos($ip, ',') !== false) {
                    $ip = trim(explode(',', $ip)[0]);
                }
                // Validate IP
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                    return $ip;
                }
            }
        }

        return $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
    }
}

/**
 * Helper functions for easy use
 */

/**
 * Generate CSRF token for forms
 */
function generateCSRFToken() {
    return Security::generateCSRFToken();
}

/**
 * Validate CSRF token from form submission
 */
function validateCSRFToken($token) {
    return Security::validateCSRFToken($token);
}

/**
 * Get client IP address
 */
function getClientIP() {
    return Security::getClientIP();
}