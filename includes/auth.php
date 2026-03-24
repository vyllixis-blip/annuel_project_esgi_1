<?php
/*
** ESGI PROJECT, 2025
** includes/auth.php
** File description:
** Session-based authentication helpers
*/

/* ─── Session start ─────────────────────────────────────────────── */
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => SESSION_LIFETIME,
        'path'     => '/',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

/* ─── State checks ──────────────────────────────────────────────── */
function isLoggedIn(): bool {
    return !empty($_SESSION['user_id']);
}

function currentUser(): ?array {
    if (!isLoggedIn()) return null;
    return [
        'id'       => $_SESSION['user_id'],
        'username' => $_SESSION['username'] ?? 'Utilisateur',
        'email'    => $_SESSION['email']    ?? '',
        'avatar'   => $_SESSION['avatar']   ?? '🎮',
        'role'     => $_SESSION['role']     ?? 'user',
    ];
}

function requireLogin(string $redirectTo = 'pages/login.php'): void {
    if (!isLoggedIn()) {
        $_SESSION['intended'] = $_SERVER['REQUEST_URI'] ?? '';
        redirect($redirectTo);
    }
}

function requireGuest(string $redirectTo = 'pages/profile.php'): void {
    if (isLoggedIn()) {
        redirect($redirectTo);
    }
}

/* ─── Login / Logout ────────────────────────────────────────────── */
function loginUser(array $user): void {
    session_regenerate_id(true);
    $_SESSION['user_id']  = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['email']    = $user['email']    ?? '';
    $_SESSION['avatar']   = $user['avatar']   ?? '🎮';
    $_SESSION['role']     = $user['role']     ?? 'user';
}

function logoutUser(): void {
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params['path'], $params['domain'],
            $params['secure'], $params['httponly']
        );
    }
    session_destroy();
}

/* ─── Password helpers ──────────────────────────────────────────── */
function hashPassword(string $password): string {
    return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
}

function verifyPassword(string $password, string $hash): bool {
    return password_verify($password, $hash);
}

/* ─── Mock login (remove when DB is ready) ──────────────────────── */
function mockLogin(string $username, string $password): ?array {
    /* Hardcoded demo user — replace with real DB query */
    $demo = [
        'id'       => 1,
        'username' => 'demo',
        'email'    => 'demo@gamelib.fr',
        'password' => hashPassword('demo1234'),
        'avatar'   => '🧑‍💻',
        'role'     => 'user',
    ];
    if ($username === $demo['username'] && verifyPassword($password, $demo['password'])) {
        return $demo;
    }
    return null;
}
