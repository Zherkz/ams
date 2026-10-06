<?php
declare(strict_types=1);
require_once __DIR__ . '/config.php';

function currentUser(): ?array
{
    if (empty($_SESSION['user_id'])) {
        return null;
    }
    static $user = false;
    if ($user !== false) {
        return $user;
    }
    $stmt = db()->prepare('SELECT id, student_no, full_name, email, role, course, year_level, section FROM users WHERE id = ? AND status = "active"');
    $stmt->execute([(int)$_SESSION['user_id']]);
    $user = $stmt->fetch() ?: null;
    return $user;
}

function requireLogin(): array
{
    $user = currentUser();
    if (!$user) {
        redirect('/ams/index.php');
    }
    return $user;
}

function requireRole(string ...$roles): array
{
    $user = requireLogin();
    if (!in_array($user['role'], $roles, true)) {
        http_response_code(403);
        exit('403 — You do not have permission to access this page.');
    }
    return $user;
}

function loginUser(int $id): void
{
    session_regenerate_id(true);
    $_SESSION['user_id'] = $id;
}

function logoutUser(): void
{
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
    session_destroy();
}
