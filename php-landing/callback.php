<?php
session_start();

// Конфигурация OAuth (замените на свои значения)
$yandex_client_id = 'YOUR_YANDEX_CLIENT_ID';
$yandex_client_secret = 'YOUR_YANDEX_CLIENT_SECRET';
$yandex_redirect_uri = 'http://localhost/php-landing/callback.php?provider=yandex';

$vk_client_id = 'YOUR_VK_CLIENT_ID';
$vk_client_secret = 'YOUR_VK_CLIENT_SECRET';
$vk_redirect_uri = 'http://localhost/php-landing/callback.php?provider=vk';

// Получаем провайдер из URL
$provider = $_GET['provider'] ?? '';
$code = $_GET['code'] ?? '';

if (!$provider || !$code) {
    header('Location: index.php');
    exit;
}

// Обмен кода на токен доступа
$access_token = '';
$user_info = [];

try {
    if ($provider === 'yandex') {
        // Яндекс OAuth - получение токена
        $token_url = 'https://oauth.yandex.ru/token';
        $params = [
            'grant_type' => 'authorization_code',
            'code' => $code,
            'client_id' => $yandex_client_id,
            'client_secret' => $yandex_client_secret,
            'redirect_uri' => $yandex_redirect_uri
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $token_url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $token_data = json_decode($response, true);
        
        if (isset($token_data['access_token'])) {
            $access_token = $token_data['access_token'];
            
            // Получение информации о пользователе Яндекса
            $user_url = 'https://login.yandex.ru/info';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $user_url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: OAuth ' . $access_token]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $user_response = curl_exec($ch);
            curl_close($ch);
            
            $user_info = json_decode($user_response, true);
        }

    } elseif ($provider === 'vk') {
        // ВКонтакте OAuth - получение токена
        $token_url = 'https://oauth.vk.com/access_token';
        $params = [
            'client_id' => $vk_client_id,
            'client_secret' => $vk_client_secret,
            'redirect_uri' => $vk_redirect_uri,
            'code' => $code
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $token_url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $token_data = json_decode($response, true);
        
        if (isset($token_data['access_token'])) {
            $access_token = $token_data['access_token'];
            $user_id = $token_data['user_id'];
            
            // Получение информации о пользователе ВКонтакте
            $user_url = 'https://api.vk.com/method/users.get';
            $params = [
                'user_ids' => $user_id,
                'fields' => 'photo_max_orig,first_name,last_name',
                'access_token' => $access_token,
                'v' => '5.131'
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $user_url . '?' . http_build_query($params));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $user_response = curl_exec($ch);
            curl_close($ch);
            
            $user_data = json_decode($user_response, true);
            
            if (isset($user_data['response'][0])) {
                $user_info = $user_data['response'][0];
            }
        }
    }

    // Если получили информацию о пользователе
    if (!empty($user_info)) {
        // Подключение к базе данных
        $db_file = __DIR__ . '/users.db';
        $db = new SQLite3($db_file);

        // Подготовка данных
        if ($provider === 'yandex') {
            $provider_user_id = $user_info['id'] ?? '';
            $nickname = $user_info['display_name'] ?? ($user_info['login'] ?? 'User');
            $avatar_path = isset($user_info['default_avatar_id']) ? 'https://avatars.yandex.net/get-yapic/' . $user_info['default_avatar_id'] . '/islands-200' : '';
        } elseif ($provider === 'vk') {
            $provider_user_id = $user_info['id'] ?? '';
            $nickname = trim(($user_info['first_name'] ?? '') . ' ' . ($user_info['last_name'] ?? '')) ?: 'User';
            $avatar_path = $user_info['photo_max_orig'] ?? '';
        }

        // Проверка существования пользователя
        $stmt = $db->prepare("SELECT id FROM users WHERE provider_id = :provider_id AND provider_name = :provider_name");
        $stmt->bindValue(':provider_id', $provider_user_id, SQLITE3_TEXT);
        $stmt->bindValue(':provider_name', $provider, SQLITE3_TEXT);
        $result = $stmt->execute();
        $existing_user = $result->fetchArray(SQLITE3_ASSOC);

        if ($existing_user) {
            // Пользователь существует - обновляем аватарку
            $user_id = $existing_user['id'];
            $update_stmt = $db->prepare("UPDATE users SET avatar_path = :avatar_path WHERE id = :id");
            $update_stmt->bindValue(':avatar_path', $avatar_path, SQLITE3_TEXT);
            $update_stmt->bindValue(':id', $user_id, SQLITE3_INTEGER);
            $update_stmt->execute();
        } else {
            // Новый пользователь - создаем запись
            $insert_stmt = $db->prepare("INSERT INTO users (provider_id, provider_name, avatar_path, nickname) VALUES (:provider_id, :provider_name, :avatar_path, :nickname)");
            $insert_stmt->bindValue(':provider_id', $provider_user_id, SQLITE3_TEXT);
            $insert_stmt->bindValue(':provider_name', $provider, SQLITE3_TEXT);
            $insert_stmt->bindValue(':avatar_path', $avatar_path, SQLITE3_TEXT);
            $insert_stmt->bindValue(':nickname', $nickname, SQLITE3_TEXT);
            $insert_stmt->execute();
            $user_id = $db->lastInsertRowID();
        }

        // Сохранение в сессию
        $_SESSION['user_id'] = $user_id;

        // Перенаправление на главную страницу
        header('Location: index.php');
        exit;
    }

} catch (Exception $e) {
    error_log('OAuth error: ' . $e->getMessage());
}

// В случае ошибки возвращаем на главную
header('Location: index.php?error=auth_failed');
exit;
?>
