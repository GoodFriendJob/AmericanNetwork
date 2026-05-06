<?php
require __DIR__ . "/../app/config/db.php";
session_start();

header("Content-Type: application/json");

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "Not logged in"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

$first_name = trim($data["first_name"] ?? "");
$last_name  = trim($data["last_name"] ?? "");
$city       = trim($data["city"] ?? "");
$state      = trim($data["state"] ?? "");
$sport      = trim($data["sport"] ?? "");
$bio        = trim($data["bio"] ?? "");
$goals      = trim($data["goals"] ?? "");

if (!$first_name || !$last_name) {
    echo json_encode(["success" => false, "message" => "First and last name are required."]);
    exit;
}

$stmt = $pdo->prepare("
    UPDATE users
    SET first_name = ?, last_name = ?, city = ?, state = ?, sport = ?, bio = ?, goals = ?
    WHERE id = ?
");

$ok = $stmt->execute([
    $first_name, $last_name, $city, $state, $sport, $bio, $goals,
    $_SESSION['user_id']
]);

echo json_encode([
    "success" => $ok,
    "message" => $ok ? "Profile updated." : "Update failed."
]);
