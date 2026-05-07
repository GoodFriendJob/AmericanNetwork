<?php
require __DIR__ . "/config/db.php";
session_start();

header("Content-Type: application/json");

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "Not logged in"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
if (!is_array($data)) {
    echo json_encode(["success" => false, "message" => "Invalid JSON"]);
    exit;
}

$first_name = trim($data["first_name"] ?? "");
$last_name  = trim($data["last_name"] ?? "");
$username   = trim($data["username"] ?? "");
$username   = ltrim($username, "@");
$city       = trim($data["city"] ?? "");
$state      = trim($data["state"] ?? "");
$sport      = trim($data["sport"] ?? "");
$position   = trim($data["position"] ?? "");
$bio        = trim($data["bio"] ?? "");
$goals      = trim($data["goals"] ?? "");
$ratingRaw  = $data["rating"] ?? null;

if ($first_name === "") {
    echo json_encode(["success" => false, "message" => "First name is required."]);
    exit;
}

if ($username === "") {
    echo json_encode(["success" => false, "message" => "Username is required."]);
    exit;
}

if (strlen($username) > 50) {
    echo json_encode(["success" => false, "message" => "Username is too long (max 50 characters)."]);
    exit;
}

$rating = null;
if ($ratingRaw === "" || $ratingRaw === null) {
    $rating = 0.0;
} else {
    $rating = (float) $ratingRaw;
    if ($rating < 0) {
        $rating = 0.0;
    }
    if ($rating > 10) {
        $rating = 10.0;
    }
}

$user_id = (int) $_SESSION["user_id"];

$dup = $pdo->prepare("SELECT id FROM users WHERE username = ? AND id <> ?");
$dup->execute([$username, $user_id]);
if ($dup->fetch()) {
    echo json_encode(["success" => false, "message" => "That username is already taken."]);
    exit;
}

$stmt = $pdo->prepare("
    UPDATE users
    SET first_name = ?,
        last_name = ?,
        username = ?,
        city = ?,
        state = ?,
        sport = ?,
        position = ?,
        bio = ?,
        goals = ?,
        rating = ?
    WHERE id = ?
");

try {
    $ok = $stmt->execute([
        $first_name,
        $last_name,
        $username,
        $city,
        $state,
        $sport,
        $position,
        $bio,
        $goals,
        $rating,
        $user_id,
    ]);
} catch (PDOException $e) {
    if ((int) $e->getCode() === 23000) {
        echo json_encode(["success" => false, "message" => "That username is already taken."]);
        exit;
    }
    throw $e;
}

echo json_encode([
    "success" => (bool) $ok,
    "message" => $ok ? "Profile updated." : "Update failed.",
]);
