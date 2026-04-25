<?php
session_start();

// Подключение к базе данных
$db_file = __DIR__ . '/users.db';
$db = new SQLite3($db_file);

header('Content-Type: application/json');

// Проверка авторизации
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Пользователь не авторизован']);
    exit;
}

// Получение данных из запроса
$data = json_decode(file_get_contents('php://input'), true);
$nickname = trim($data['nickname'] ?? '');

if (empty($nickname)) {
    echo json_encode(['success' => false, 'message' => 'Никнейм не может быть пустым']);
    exit;
}

// Обновление никнейма в базе данных
$stmt = $db->prepare("UPDATE users SET nickname = :nickname WHERE id = :id");
$stmt->bindValue(':nickname', $nickname, SQLITE3_TEXT);
$stmt->bindValue(':id', $_SESSION['user_id'], SQLITE3_INTEGER);
$result = $stmt->execute();

if ($result) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Ошибка при обновлении никнейма']);
}
?>
