<?php
require_once 'databaselogin.php';
require_once 'auth_helper.php';
require_once 'security.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
    exit;
}

$comment = trim($_POST['comment'] ?? '');
$rating = isset($_POST['rating']) ? (int) $_POST['rating'] : 0;
$accountReview = isset($_POST['account_review']) && $_POST['account_review'] === '1';
$csrf_token = $_POST['csrf_token'] ?? null;

// Validate CSRF token
if (!$csrf_token || !validateCSRFToken($csrf_token)) {
    echo json_encode(["success" => false, "message" => "Invalid security token"]);
    exit;
}

if ($comment === '' || $rating < 1 || $rating > 5) {
    echo json_encode(["success" => false, "message" => "Please enter a comment and star rating."]);
    exit;
}

$authorImage = null;
if (isset($_FILES['author_image']) && $_FILES['author_image']['error'] === UPLOAD_ERR_OK) {
    $fileTmp = $_FILES['author_image']['tmp_name'];
    $fileName = basename($_FILES['author_image']['name']);
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowedExt = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($fileExt, $allowedExt)) {
        $uploadDir = __DIR__ . '/../images/review/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $targetFile = $uploadDir . uniqid('review_pic_') . '.' . $fileExt;
        if (move_uploaded_file($fileTmp, $targetFile)) {
            $authorImage = './images/review/uploads/' . basename($targetFile);
        }
    }
}

if ($accountReview) {
    if (!isUserLoggedIn()) {
        echo json_encode(["success" => false, "message" => "You must be logged in to post with account."]);
        exit;
    }

    $userId = getCurrentUserId();
    $result = $db->addAccountReview($userId, $comment, $rating, $authorImage);
    echo json_encode($result);
    exit;
}

$name = trim($_POST['name'] ?? '');
if ($name === '') {
    echo json_encode(["success" => false, "message" => "Please enter a name."]);
    exit;
}

$result = $db->addGuestReview($name, $comment, $rating);
echo json_encode($result);
?>