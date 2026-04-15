<?php
// 1. Session Management
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Database Connection (PDO)
$db_config = [
    'host' => 'localhost',
    'name' => 'comp1841_coursework',
    'user' => 'root',
    'pass' => '',
    'char' => 'utf8'
];

try {
    $dsn = "mysql:host={$db_config['host']};dbname={$db_config['name']};charset={$db_config['char']}";
    $pdo = new PDO($dsn, $db_config['user'], $db_config['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database Connection Failed: " . $e->getMessage());
}

// 3. Global User State Initialization
$current_user_id = $_SESSION['user_id'] ?? null;
$is_admin = false;
$logged_in_name = 'Guest';

if ($current_user_id) {
    $stmt = $pdo->prepare('SELECT name, is_admin FROM author WHERE id = ?');
    $stmt->execute([$current_user_id]);
    $user = $stmt->fetch();
    
    if ($user) {
        $is_admin = (bool)$user['is_admin'];
        $logged_in_name = $user['name'];
    }
}