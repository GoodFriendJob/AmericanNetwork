<?php

class AuthController {

    /* -------------------------
       REGISTER NEW USER
    -------------------------- */
    public static function register($params) {
        global $pdo;

        // Read JSON body safely
        $data = json_decode(file_get_contents('php://input'), true);
        if (!is_array($data)) {
            Response::error("Invalid JSON body", 400);
            return;
        }

        $username = trim($data['username'] ?? '');
        $email    = trim($data['email'] ?? '');
        $password = trim($data['password'] ?? '');

        if ($username === '' || $email === '' || $password === '') {
            Response::error("Missing fields", 400);
            return;
        }

        // Hash password
        $hash = password_hash($password, PASSWORD_BCRYPT);

        // Insert user
        $stmt = $pdo->prepare(
            "INSERT INTO users (username, email, password, created_at)
             VALUES (?, ?, ?, NOW())"
        );
        $stmt->execute([$username, $email, $hash]);

        $userId = $pdo->lastInsertId();

        // Create empty profile
        $stmt = $pdo->prepare(
            "INSERT INTO profiles (user_id, bio, avatar_url, created_at)
             VALUES (?, '', '', NOW())"
        );
        $stmt->execute([$userId]);

        Response::success(['success' => true, 'id' => (int)$userId]);
    }

    /* -------------------------
       LOGIN USER (Option B)
    -------------------------- */
    public static function login($params) {
        global $pdo;

        // Read JSON OR form-data
        $input = json_decode(file_get_contents('php://input'), true);
        if (!is_array($input)) {
            $input = $_POST; // fallback for form-data
        }

        $email    = trim($input['email'] ?? '');
        $password = trim($input['password'] ?? '');

        if ($email === '' || $password === '') {
            Response::error("Email and password are required", 400);
            return;
        }

        // Fetch user
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Invalid credentials
        if (!$user || !password_verify($password, $user['password'])) {
            Response::error("Invalid credentials", 400);
            return;
        }

        // Banned check
        if (!empty($user['banned'])) {
            Response::error("Your account has been banned", 403);
            return;
        }

        // Fetch user role
        $stmt = $pdo->prepare("SELECT role FROM admin_roles WHERE user_id = ?");
        $stmt->execute([$user['id']]);
        $roleRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $role = $roleRow['role'] ?? 'user';

        // Build JWT payload
        $payload = [
            "id"       => (int)$user['id'],
            "username" => $user['username'],
            "role"     => $role,
            "exp"      => time() + 86400 // 24 hours
        ];

        // Encode token
        $token = JWT::encode($payload);

        // Return token
        Response::success([
            "success" => true,
            "token"   => $token
        ]);
    }
}
