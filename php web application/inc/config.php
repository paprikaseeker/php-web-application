<?php
// Database Configuration for PostgreSQL
// Update these with your actual database credentials

define('DB_HOST', 'localhost');      // Your database host
define('DB_PORT', '5432');           // PostgreSQL port (default: 5432)
define('DB_USER', 'user');       // Your PostgreSQL username
define('DB_PASS', 'password');       // Your PostgreSQL password
define('DB_NAME', 'seaofblack_db');  // Your database name

// Create connection using PDO
try {
    $dsn = "pgsql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME;
    $conn = new PDO($dsn, DB_USER, DB_PASS);
    
    // Set error mode to throw exceptions
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Set default fetch mode to associative array
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Session configuration
session_start();

// Load environment variables from .env file (if exists)
function loadEnv($filePath) {
    if (!file_exists($filePath)) {
        return;
    }
    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue; // Skip comments
        }
        if (strpos($line, '=') === false) {
            continue; // Skip invalid lines
        }
        list($key, $value) = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);
        if (!array_key_exists($key, $_ENV)) {
            $_ENV[$key] = $value;
        }
    }
}

// Load .env file from root directory
loadEnv(__DIR__ . '/../.env');

// Email Configuration
define('ADMIN_EMAIL', 'adminemail@example.com');  // Admin receives contact form emails
define('SITE_NAME', 'Sea Of Black Brewery');
define('SITE_EMAIL', 'info@seaofblack.beer');     // From email address

// Email settings (ABV.bg SMTP)
define('SMTP_HOST', 'smtp.abv.bg');
define('SMTP_PORT', '465');
define('SMTP_USERNAME', 'email@example.com');
define('SMTP_SECURE', 'ssl');  // SSL encryption for ABV.bg
define('SMTP_PASSWORD', $_ENV['your_app_password'] ?? '');  // Loaded from .env file
