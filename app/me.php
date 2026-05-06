<?php
require __DIR__ . "/../app/config/db.php";
session_start();

header("Content-Type: application/json");

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "Not logged in"]);
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("
    SELECT u.id, u.username, u.first_name, u.last_name, u.email,
           u.city, u.state, u.sport, u.bio, u.goals, u.profile_pic,
           COALESCE(b.likes, 0) AS likes
    FROM users u
    LEFT JOIN achievement_badges b ON b.user_id = u.id
    WHERE u.id = ?
");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo json_encode(["success" => false, "message" => "User not found"]);
    exit;
}

echo json_encode(["success" => true, "user" => $user]);
