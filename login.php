<?php
session_start();
require __DIR__ . "/app/config/db.php";

header("Content-Type: application/json");

// Get POST data
$email = $_POST["email"] ?? '';
$password = $_POST["password"] ?? '';

$stmt = $pdo->prepare("SELECT id, password, email_verified FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo json_encode(["success" => false, "message" => "Email not found"]);
    exit;
}

// Check email verification
if ($user["email_verified"] == 0) {
    echo json_encode(["success" => false, "message" => "Please verify your email before logging in."]);
    exit;
}

// Check password
if (!password_verify($password, $user["password"])) {
    echo json_encode(["success" => false, "message" => "Incorrect password"]);
    exit;
}

// Login success
$_SESSION["user_id"] = $user["id"];

echo json_encode(["success" => true, "message" => "Login successful"]);
exit;
?>
