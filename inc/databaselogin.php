<?php
require_once 'config.php';
require_once 'security.php';
require_once __DIR__ . '/../vendor/phpmailer/phpmailer/src/Exception.php';
require_once __DIR__ . '/../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/../vendor/phpmailer/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Database {
    private $conn;
    private $security;
    
    public function __construct($conn) {
        $this->conn = $conn;
        $this->security = new Security($conn);
    }
    
    /**
     * Register a new user
     */
    public function registerUser($firstName, $lastName, $email, $password, 
    $phoneNumber, $country, $city, $postal, $address) {
        // Validate inputs
        if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
            return ["success" => false, "message" => "Please fill in all required fields"];
        }
        
        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ["success" => false, "message" => "Invalid email format"];
        }
        
        try {
            // Check if email already exists
            $stmt = $this->conn->prepare("SELECT id FROM users WHERE email = :email");
            $stmt->execute([':email' => $email]);
            
            if ($stmt->rowCount() > 0) {
                return ["success" => false, "message" => "Email already exists"];
            }
            
            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            
            // Insert user into database
            $stmt = $this->conn->prepare("INSERT INTO users (firstname, lastname, email, password, phonenumber, country, city, postal, address) VALUES (:firstName, :lastName, :email, :password, :phoneNumber, :country, :city, :postal, :address)");
            
            $stmt->execute([
                ':firstName' => $firstName,
                ':lastName' => $lastName,
                ':email' => $email,
                ':password' => $hashedPassword,
                ':phoneNumber' => $phoneNumber,
                ':country' => $country,
                ':city' => $city,
                ':postal' => $postal,
                ':address' => $address
            ]);
            
            return ["success" => true, "message" => "Registration successful! You can now login."];
        } catch (PDOException $e) {
            return ["success" => false, "message" => "Error: " . $e->getMessage()];
        }
    }
    
    /**
     * Login user with security features
     */
    public function loginUser($email, $password, $csrf_token = null) {
        // Validate inputs
        if (empty($email) || empty($password)) {
            return ["success" => false, "message" => "Please enter email and password"];
        }

        // Validate CSRF token if provided
        if ($csrf_token && !Security::validateCSRFToken($csrf_token)) {
            return ["success" => false, "message" => "Invalid security token"];
        }

        $client_ip = Security::getClientIP();

        // Check rate limiting
        if ($this->security->isRateLimited($client_ip, $email)) {
            $remaining_time = ceil($this->security->getLockoutTime() / 60);
            return ["success" => false, "message" => "Too many failed attempts. Please try again in {$remaining_time} minutes."];
        }

        try {
            // Check if user exists
            $stmt = $this->conn->prepare("SELECT id, firstname, email, password FROM users WHERE email = :email");
            $stmt->execute([':email' => $email]);

            if ($stmt->rowCount() === 0) {
                // Record failed attempt
                $this->security->recordLoginAttempt($client_ip, $email, false);
                $remaining_attempts = $this->security->getRemainingAttempts($client_ip, $email);
                return ["success" => false, "message" => "Email not found. {$remaining_attempts} attempts remaining."];
            }

            $user = $stmt->fetch();

            // Verify password
            if (!password_verify($password, $user['password'])) {
                // Record failed attempt
                $this->security->recordLoginAttempt($client_ip, $email, false);
                $remaining_attempts = $this->security->getRemainingAttempts($client_ip, $email);
                return ["success" => false, "message" => "Incorrect password. {$remaining_attempts} attempts remaining."];
            }

            // Record successful login
            $this->security->recordLoginAttempt($client_ip, $email, true);

            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['firstname'];
            $_SESSION['logged_in'] = true;

            // Regenerate session ID for security
            session_regenerate_id(true);

            $redirect = ($user['email'] === 'adminlogs@example.com') ? 'admin.php' : 'index.php';

            return ["success" => true, "message" => "Login successful!", "redirect" => $redirect];
        } catch (PDOException $e) {
            return ["success" => false, "message" => "Error: " . $e->getMessage()];
        }
    }
    
    /**
     * Request password reset
     */
    public function requestPasswordReset($email) {
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ["success" => false, "message" => "Invalid email address"];
        }

        try {
            $stmt = $this->conn->prepare("SELECT id, firstname, lastname FROM users WHERE email = :email");
            $stmt->execute([':email' => $email]);

            if ($stmt->rowCount() === 0) {
                return ["success" => false, "message" => "Email not found in our system"];
            }

            $user = $stmt->fetch();
            $token = bin2hex(random_bytes(32));
            $token_hash = hash("sha256", $token);
            $expiry = date("Y-m-d H:i:s", time() + 3600);

            $stmt = $this->conn->prepare("UPDATE users SET reset_token = :token, reset_token_expiry = :expiry WHERE email = :email");
            $stmt->execute([
                ':token' => $token_hash,
                ':expiry' => $expiry,
                ':email' => $email
            ]);

            $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || ($_SERVER['SERVER_PORT'] ?? '') === '443') ? 'https' : 'http';
            $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
            $scriptDir = dirname($_SERVER['PHP_SELF'] ?? '');
            $rootDir = rtrim(str_replace('\\', '/', dirname($scriptDir)), '/');
            if ($rootDir === '' || $rootDir === '.') {
                $rootDir = '';
            }
            $resetLink = $protocol . '://' . $host . $rootDir . '/restorepass.php?token=' . urlencode($token);

            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = SMTP_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = SMTP_USERNAME;
            $mail->Password = SMTP_PASSWORD;
            $mail->SMTPSecure = SMTP_SECURE;
            $mail->Port = SMTP_PORT;
            $mail->CharSet = 'UTF-8';
            $mail->setFrom(SMTP_USERNAME, SITE_NAME);
            $mail->addAddress($email, trim($user['firstname'] . ' ' . $user['lastname']));
            $mail->addReplyTo(SITE_EMAIL, SITE_NAME);
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request for ' . SITE_NAME;

            $mailBody = "<html><body>" .
                "<p>Hi " . htmlspecialchars($user['firstname']) . ",</p>" .
                "<p>We received a request to reset your password for your " . SITE_NAME . " account.</p>" .
                "<p>Please click the link below to reset your password:</p>" .
                "<p><a href='" . htmlspecialchars($resetLink) . "'>Reset your password</a></p>" .
                "<p>If you did not request this, please ignore this email.</p>" .
                "<p>Regards,<br>" . SITE_NAME . "</p>" .
                "</body></html>";

            $mail->Body = $mailBody;
            $mail->AltBody = "Hi " . $user['firstname'] . ",\n\n" .
                "We received a request to reset your password for your " . SITE_NAME . " account.\n\n" .
                "Reset your password using the link below:\n" . $resetLink . "\n\n" .
                "If you did not request this, please ignore this email.\n\n" .
                SITE_NAME;

            $mail->send();

            return ["success" => true, "message" => "Password reset link sent to your email address. Please check your inbox."];
        } catch (Exception $e) {
            return ["success" => false, "message" => "Unable to send password reset email. Please try again later."];
        } catch (PDOException $e) {
            return ["success" => false, "message" => "Error processing request: " . $e->getMessage()];
        }
    }
    
    /**
     * Reset password with token
     */
    public function resetPassword($token, $newPassword) {
        if (empty($token) || empty($newPassword)) {
            return ["success" => false, "message" => "Invalid request"];
        }
        
        try {
            $token_hash = hash("sha256", $token);
            
            // Check if token exists and is valid
            $stmt = $this->conn->prepare("SELECT id FROM users WHERE reset_token = :token AND reset_token_expiry > NOW()");
            $stmt->execute([':token' => $token_hash]);
            
            if ($stmt->rowCount() === 0) {
                return ["success" => false, "message" => "Invalid or expired reset token"];
            }
            
            // Hash new password
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            
            // Update password and clear token
            $stmt = $this->conn->prepare("UPDATE users SET password = :password, reset_token = NULL, reset_token_expiry = NULL WHERE reset_token = :token");
            $stmt->execute([
                ':password' => $hashedPassword,
                ':token' => $token_hash
            ]);
            
            return ["success" => true, "message" => "Password reset successful!"];
        } catch (PDOException $e) {
            return ["success" => false, "message" => "Error resetting password: " . $e->getMessage()];
        }
    }

    /**
     * Add a guest review
     */
    public function addGuestReview($name, $comment, $rating) {
        if (empty($name) || empty($comment) || $rating < 1 || $rating > 5) {
            return ["success" => false, "message" => "Invalid review data"];
        }

        try {
            $stmt = $this->conn->prepare("INSERT INTO reviews_guests (name, comment, rating, approved) VALUES (:name, :comment, :rating, false)");
            $stmt->execute([
                ':name' => $name,
                ':comment' => $comment,
                ':rating' => $rating
            ]);

            return ["success" => true, "message" => "Review submitted. It will appear after approval."];
        } catch (PDOException $e) {
            return ["success" => false, "message" => "Error saving review: " . $e->getMessage()];
        }
    }

    public function addAccountReview($userId, $comment, $rating, $authorImage = null) {
        if (empty($userId) || empty($comment) || $rating < 1 || $rating > 5) {
            return ["success" => false, "message" => "Invalid review data"];
        }

        $user = $this->getUserData($userId);
        if (!$user) {
            return ["success" => false, "message" => "Unable to identify logged in user"];
        }

        $name = trim($user['firstname'] . ' ' . $user['lastname']);
        if ($name === '') {
            $name = $user['email'] ?? 'Account user';
        }

        try {
            $stmt = $this->conn->prepare("INSERT INTO reviews_guests (name, comment, rating, approved, author_image) VALUES (:name, :comment, :rating, false, :author_image)");
            $stmt->execute([
                ':name' => $name,
                ':comment' => $comment,
                ':rating' => $rating,
                ':author_image' => $authorImage
            ]);

            return ["success" => true, "message" => "Review submitted. It will appear after approval."];
        } catch (PDOException $e) {
            return ["success" => false, "message" => "Error saving review: " . $e->getMessage()];
        }
    }

    /**
     * Get approved reviews for display
     */
    public function getApprovedReviews() {
        try {
            $stmt = $this->conn->prepare("SELECT name, comment, rating, author_image FROM reviews_guests WHERE approved = true ORDER BY id DESC");
            $stmt->execute();
            $reviews = $stmt->fetchAll();
            // Ensure author_image has a default if null
            foreach ($reviews as &$review) {
                $review['author_image'] = $review['author_image'] ?: './images/review/default_profile.png';
            }
            return $reviews;
        } catch (PDOException $e) {
            return [];
        }
    }

    /**
     * Get a random approved review
     */
    public function getRandomApprovedReview() {
        try {
            $stmt = $this->conn->prepare("SELECT name, comment, rating, author_image FROM reviews_guests WHERE approved = true");
            $stmt->execute();
            $reviews = $stmt->fetchAll();
            if (!empty($reviews)) {
                $randomReview = $reviews[array_rand($reviews)];
                $randomReview['author_image'] = $randomReview['author_image'] ?: './images/review/default_profile.png';
                return $randomReview;
            }
            return null;
        } catch (PDOException $e) {
            return null;
        }
    }

    /**
     * Get pending reviews for admin
     */
    public function getPendingReviews() {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM reviews_guests WHERE approved = false ORDER BY created_at DESC");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }

    /**
     * Approve a review
     */
    public function approveReview($id) {
        try {
            $stmt = $this->conn->prepare("UPDATE reviews_guests SET approved = true WHERE id = :id");
            $stmt->execute([':id' => $id]);
            return ["success" => true, "message" => "Review approved"];
        } catch (PDOException $e) {
            return ["success" => false, "message" => "Error approving review: " . $e->getMessage()];
        }
    }

    /**
     * Delete a review
     */
    public function deleteReview($id) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM reviews_guests WHERE id = :id");
            $stmt->execute([':id' => $id]);
            return ["success" => true, "message" => "Review deleted"];
        } catch (PDOException $e) {
            return ["success" => false, "message" => "Error deleting review: " . $e->getMessage()];
        }
    }

    /**
     * Add a beer (product)
     */
    public function addBeer($name, $description, $price, $stock, $imagePath = null) {
        if (empty($name) || $price < 0 || $stock < 0) {
            return ["success" => false, "message" => "Invalid beer data"];
        }

        if (empty($imagePath)) {
            $imagePath = './images/shop/default.png';
        }

        try {
            $stmt = $this->conn->prepare("INSERT INTO products (name, description, price, stock, image) VALUES (:name, :description, :price, :stock, :image)");
            $stmt->execute([
                ':name' => $name,
                ':description' => $description,
                ':price' => $price,
                ':stock' => $stock,
                ':image' => $imagePath
            ]);
            return ["success" => true, "message" => "Beer added successfully"];
        } catch (PDOException $e) {
            return ["success" => false, "message" => "Error adding beer: " . $e->getMessage()];
        }
    }

    /**
     * Get all beers
     */
    public function getBeers() {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM products ORDER BY id DESC");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }

    /**
     * Save contact message
     */
    public function saveContactMessage($firstName, $email, $message) {
        if (empty($firstName) || empty($email) || empty($message)) {
            return ["success" => false, "message" => "Please fill in all required fields"];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ["success" => false, "message" => "Invalid email format"];
        }

        try {
            $stmt = $this->conn->prepare("INSERT INTO contact_messages (first_name, email, message) VALUES (:firstName, :email, :message)");
            $stmt->execute([
                ':firstName' => $firstName,
                ':email' => $email,
                ':message' => $message
            ]);

            return ["success" => true, "message" => "Thank you for your message! We'll get back to you soon."];
        } catch (PDOException $e) {
            return ["success" => false, "message" => "Error saving message: " . $e->getMessage()];
        }
    }

    /**
     * Logout user
     */
    public function logoutUser() {
        $_SESSION = [];
        session_destroy();
        return ["success" => true, "message" => "Logged out successfully"];
    }
    
    /**
     * Check if user is logged in
     */
    public function isLoggedIn() {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }
    
    /**
     * Get user data
     */
    public function getUserData($userId) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = :id");
            $stmt->execute([':id' => $userId]);
            
            return $stmt->fetch();
        } catch (PDOException $e) {
            return null;
        }
    }

    /**
     * Get a random review from the database
     * Returns approved review data: name, comment, rating, author_image
     */
    public function getRandomReview() {
        try {
            $stmt = $this->conn->prepare("SELECT name, comment, rating, author_image FROM reviews_guests WHERE approved = true ORDER BY RANDOM() LIMIT 1");
            $stmt->execute();
            $result = $stmt->fetch();
            if ($result) {
                $result['author_image'] = $result['author_image'] ?: './images/review/default_profile.png';
            }
            return $result;
        } catch (PDOException $e) {
            return null;
        }
    }

    /**
     * Get all reviews from the database
     */
    public function getAllReviews() {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM reviews_guests ORDER BY id DESC");
            $stmt->execute();
            $reviews = $stmt->fetchAll();
            foreach ($reviews as &$review) {
                $review['author_image'] = $review['author_image'] ?: './images/review/default_profile.png';
            }
            return $reviews;
        } catch (PDOException $e) {
            return [];
        }
    }

    /**
     * Add a new review to the database
     */
    public function addReview($name, $comment, $rating, $approved = false, $authorImage = null) {
        if (empty($comment)) {
            return ["success" => false, "message" => "Comment is required"];
        }
        if (!is_int($rating) || $rating < 1 || $rating > 5) {
            return ["success" => false, "message" => "Rating must be an integer between 1 and 5"];
        }

        try {
            $stmt = $this->conn->prepare("INSERT INTO reviews_guests (name, comment, rating, approved, author_image) VALUES (:name, :comment, :rating, :approved, :authorImage)");
            $stmt->execute([
                ':name' => $name ?: 'Guest',
                ':comment' => $comment,
                ':rating' => $rating,
                ':approved' => $approved,
                ':authorImage' => $authorImage
            ]);

            return ["success" => true, "message" => "Review added successfully"];
        } catch (PDOException $e) {
            return ["success" => false, "message" => "Error adding review: " . $e->getMessage()];
        }
    }

    /**
     * Calculate average rating from reviews
     * Requirement #13: calculateRating() function
     */
    public function calculateRating() {
        try {
            $stmt = $this->conn->prepare("SELECT AVG(rating) as average_rating FROM reviews_guests WHERE approved = true");
            $stmt->execute();
            $result = $stmt->fetch();
            
            if ($result && $result['average_rating'] !== null) {
                return round($result['average_rating'], 1);
            }
            return 0;
        } catch (PDOException $e) {
            return 0;
        }
    }
}

// Initialize database class
$db = new Database($conn);
