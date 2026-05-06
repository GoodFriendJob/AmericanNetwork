<?php

header("Content-Type: application/json");
require __DIR__ . "/app/config/db.php";

// Load PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . "/app/phpmailer/src/Exception.php";
require __DIR__ . "/app/phpmailer/src/PHPMailer.php";
require __DIR__ . "/app/phpmailer/src/SMTP.php";

// Read JSON input
$data = json_decode(file_get_contents("php://input"), true);

$first_name = trim($data["first_name"] ?? "");
$last_name = trim($data["last_name"] ?? "");
$username = trim($data["username"] ?? "");
$email = trim($data["email"] ?? "");
$password = trim($data["password"] ?? "");
$confirm_password = trim($data["confirm_password"] ?? "");
$city = trim($data["city"] ?? "");
$state = trim($data["state"] ?? "");

// Debug log
file_put_contents("debug.txt", print_r($data, true));

// Validate required fields
if (!$first_name || !$last_name || !$username || !$email || !$password || !$confirm_password || !$city || !$state) {
    echo json_encode(["success" => false, "message" => "All fields are required."]);
    exit;
}

if ($password !== $confirm_password) {
    echo json_encode(["success" => false, "message" => "Passwords do not match."]);
    exit;
}

// Check if email already exists
$check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$check->execute([$email]);

if ($check->rowCount() > 0) {
    echo json_encode(["success" => false, "message" => "Registration failed. Email already in use."]);
    exit;
}

// Hash password
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

// Generate verification token
$token = bin2hex(random_bytes(32));

// Insert user with first + last name
$stmt = $pdo->prepare("
    INSERT INTO users (first_name, last_name, username, email, password, city, state, verification_token, email_verified)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0)
");

if (!$stmt->execute([$first_name, $last_name, $username, $email, $hashedPassword, $city, $state, $token])) {
    echo json_encode(["success" => false, "message" => "Registration failed."]);
    exit;
}

// Build verification link
$verifyLink = "https://allamericaatlantic.com/verify.php?token=" . $token;

// Send verification email
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = "mail.allamericaatlantic.com";
    $mail->SMTPAuth = true;
    $mail->Username = "admin@allamericaatlantic.com";
    $mail->Password = "DianaCharles8626";
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;

    // Debug
    $mail->SMTPDebug = 2;
    $mail->Debugoutput = function($str, $level) {
        file_put_contents("mail_debug.txt", $str . "\n", FILE_APPEND);
    };

    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        ]
    ];

    $mail->setFrom("admin@allamericaatlantic.com", "All America Atlantic");
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = "Verify Your Email - All America Atlantic";
    $mail->Body = "
        <h2>Welcome to All America Atlantic!</h2>
        <p>Click the link below to verify your email:</p>
        <p><a href='$verifyLink'>$verifyLink</a></p>
        <p>If you did not create this account, you can ignore this email.</p>
    ";

    $mail->send();

    echo json_encode(["success" => true, "message" => "Account created! Please check your email to verify your account."]);

} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "Account created, but email could not be sent. Contact support.",
        "error" => $mail->ErrorInfo
    ]);
}
?>
