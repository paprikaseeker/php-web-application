<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'databaselogin.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $action = $_POST['action'] ?? '';
        
        switch($action) {
            case 'register':
                $firstName = htmlspecialchars($_POST['firstName'] ?? '');
                $lastName = htmlspecialchars($_POST['lastName'] ?? '');
                $email = htmlspecialchars($_POST['email'] ?? '');
                $password = $_POST['password'] ?? '';
                $phoneNumber = htmlspecialchars($_POST['phoneNumber'] ?? '');
                $country = htmlspecialchars($_POST['country'] ?? '');
                $city = htmlspecialchars($_POST['city'] ?? '');
                $postal = htmlspecialchars($_POST['postal'] ?? '');
                $address = htmlspecialchars($_POST['address'] ?? '');
                $csrf_token = $_POST['csrf_token'] ?? null;
                
                // Validate CSRF token
                if (!$csrf_token || !validateCSRFToken($csrf_token)) {
                    echo json_encode(["success" => false, "message" => "Invalid security token"]);
                    break;
                }
                
                $result = $db->registerUser($firstName, $lastName, $email, $password, $phoneNumber, $country, $city, $postal, $address);
                echo json_encode($result);
                break;
            
        case 'login':
            $email = htmlspecialchars($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $csrf_token = $_POST['csrf_token'] ?? null;
            
            $result = $db->loginUser($email, $password, $csrf_token);
            echo json_encode($result);
            break;
            
        case 'logout':
            $result = $db->logoutUser();
            echo json_encode($result);
            break;
            
        case 'forgot_password':
            $email = htmlspecialchars($_POST['email'] ?? '');
            $csrf_token = $_POST['csrf_token'] ?? null;
            
            // Validate CSRF token
            if (!$csrf_token || !validateCSRFToken($csrf_token)) {
                echo json_encode(["success" => false, "message" => "Invalid security token"]);
                break;
            }
            
            $result = $db->requestPasswordReset($email);
            echo json_encode($result);
            break;
            
        case 'reset_password':
            $token = htmlspecialchars($_POST['token'] ?? '');
            $newPassword = $_POST['newPassword'] ?? '';
            $csrf_token = $_POST['csrf_token'] ?? null;
            
            // Validate CSRF token
            if (!$csrf_token || !validateCSRFToken($csrf_token)) {
                echo json_encode(["success" => false, "message" => "Invalid security token"]);
                break;
            }
            
            $result = $db->resetPassword($token, $newPassword);
            echo json_encode($result);
            break;
            
        default:
            echo json_encode(["success" => false, "message" => "Invalid action"]);
        }
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Method not allowed"]);
}
