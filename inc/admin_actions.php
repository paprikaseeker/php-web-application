<?php
require_once 'databaselogin.php';
require_once 'auth_helper.php';

header('Content-Type: application/json; charset=utf-8');

// Require authenticated admin access for all admin actions.
if (!isUserLoggedIn()) {
    echo json_encode(["success" => false, "message" => "Authentication required."]);
    exit;
}

if (!isUserAdmin()) {
    echo json_encode(["success" => false, "message" => "Unauthorized access."]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
    exit;
}

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'approve_review':
        $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
        if ($id <= 0) {
            echo json_encode(["success" => false, "message" => "Invalid review ID"]);
            exit;
        }
        $result = $db->approveReview($id);
        echo json_encode($result);
        break;

    case 'delete_review':
        $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
        if ($id <= 0) {
            echo json_encode(["success" => false, "message" => "Invalid review ID"]);
            exit;
        }
        $result = $db->deleteReview($id);
        echo json_encode($result);
        break;

    case 'add_beer':
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $price = isset($_POST['price']) ? (float) $_POST['price'] : 0;
        $stock = isset($_POST['stock']) ? (int) $_POST['stock'] : 0;
        $imagePath = './images/shop/default.png';

        if (!empty($_FILES['beerImage']['name']) && $_FILES['beerImage']['error'] === UPLOAD_ERR_OK) {
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            $uploadDir = __DIR__ . '/../images/shop/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $fileName = basename($_FILES['beerImage']['name']);
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            if (!in_array($fileExt, $allowedExtensions, true)) {
                echo json_encode(["success" => false, "message" => "Image must be JPG, JPEG, PNG, or GIF."]);
                exit;
            }

            $safeBase = preg_replace('/[^A-Za-z0-9_-]/', '_', pathinfo($fileName, PATHINFO_FILENAME));
            $newFileName = time() . '_' . $safeBase . '.' . $fileExt;
            $targetPath = $uploadDir . $newFileName;
            if (move_uploaded_file($_FILES['beerImage']['tmp_name'], $targetPath)) {
                $imagePath = './images/shop/' . $newFileName;
            } else {
                echo json_encode(["success" => false, "message" => "Failed to upload beer image."]);
                exit;
            }
        }

        $result = $db->addBeer($name, $description, $price, $stock, $imagePath);
        echo json_encode($result);
        break;

    default:
        echo json_encode(["success" => false, "message" => "Unknown action"]);
}
?>
