<?php
session_start();

// Конфигурация базы данных
$db_file = __DIR__ . '/users.db';
$db = new SQLite3($db_file);

// Создание таблицы пользователей
$db->exec("CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    provider_id TEXT NOT NULL,
    provider_name TEXT NOT NULL,
    avatar_path TEXT,
    nickname TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(provider_id, provider_name)
)");

// Конфигурация OAuth (замените на свои значения)
$yandex_client_id = 'YOUR_YANDEX_CLIENT_ID';
$yandex_client_secret = 'YOUR_YANDEX_CLIENT_SECRET';
$yandex_redirect_uri = 'http://localhost/php-landing/callback.php?provider=yandex';

$vk_client_id = 'YOUR_VK_CLIENT_ID';
$vk_client_secret = 'YOUR_VK_CLIENT_SECRET';
$vk_redirect_uri = 'http://localhost/php-landing/callback.php?provider=vk';

// Проверка авторизации
$is_logged_in = isset($_SESSION['user_id']);
$user = null;

if ($is_logged_in) {
    $stmt = $db->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->bindValue(':id', $_SESSION['user_id'], SQLITE3_INTEGER);
    $result = $stmt->execute();
    $user = $result->fetchArray(SQLITE3_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Лендинг с авторизацией</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 500px;
            width: 100%;
            text-align: center;
        }

        h1 {
            color: #333;
            margin-bottom: 30px;
            font-size: 2em;
        }

        .auth-buttons {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .auth-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 15px 30px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            text-decoration: none;
            color: white;
        }

        .auth-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
        }

        .yandex {
            background: #fc3f1d;
        }

        .vk {
            background: #0077FF;
        }

        .user-profile {
            display: none;
        }

        .user-profile.active {
            display: block;
        }

        .avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid #667eea;
            margin-bottom: 20px;
        }

        .nickname-form {
            margin: 20px 0;
        }

        .nickname-input {
            padding: 12px 20px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            width: 100%;
            max-width: 300px;
            margin-bottom: 10px;
        }

        .nickname-input:focus {
            outline: none;
            border-color: #667eea;
        }

        .save-btn {
            background: #667eea;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.2s;
        }

        .save-btn:hover {
            background: #5568d3;
        }

        .logout-btn {
            background: #ff4757;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 15px;
            transition: background 0.2s;
        }

        .logout-btn:hover {
            background: #ff3838;
        }

        .welcome-text {
            color: #666;
            margin-bottom: 20px;
        }

        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (!$is_logged_in): ?>
            <h1>Добро пожаловать!</h1>
            <p class="welcome-text">Войдите через социальную сеть</p>
            <div class="auth-buttons">
                <a href="https://oauth.yandex.ru/authorize?response_type=code&client_id=<?php echo $yandex_client_id; ?>&redirect_uri=<?php echo urlencode($yandex_redirect_uri); ?>" class="auth-btn yandex">
                    Войти через Яндекс
                </a>
                <a href="https://oauth.vk.com/authorize?client_id=<?php echo $vk_client_id; ?>&redirect_uri=<?php echo urlencode($vk_redirect_uri); ?>&scope=email&response_type=code&v=5.131" class="auth-btn vk">
                    Войти через ВКонтакте
                </a>
            </div>
        <?php else: ?>
            <div class="user-profile active">
                <img src="<?php echo htmlspecialchars($user['avatar_path'] ?: 'https://via.placeholder.com/150'); ?>" alt="Аватар" class="avatar" id="userAvatar">
                <h2>Привет, <span id="currentNickname"><?php echo htmlspecialchars($user['nickname']); ?></span>!</h2>
                
                <div class="nickname-form">
                    <input type="text" class="nickname-input" id="nicknameInput" placeholder="Введите новый никнейм" value="<?php echo htmlspecialchars($user['nickname']); ?>">
                    <br>
                    <button class="save-btn" onclick="updateNickname()">Сохранить</button>
                </div>

                <a href="logout.php" class="logout-btn">Выйти</a>
            </div>
        <?php endif; ?>
    </div>

    <?php if ($is_logged_in): ?>
    <script>
        async function updateNickname() {
            const nickname = document.getElementById('nicknameInput').value.trim();
            if (!nickname) {
                alert('Пожалуйста, введите никнейм');
                return;
            }

            try {
                const response = await fetch('update_nickname.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ nickname: nickname })
                });

                const result = await response.json();
                
                if (result.success) {
                    document.getElementById('currentNickname').textContent = nickname;
                    alert('Никнейм успешно обновлен!');
                } else {
                    alert('Ошибка: ' + result.message);
                }
            } catch (error) {
                alert('Произошла ошибка при обновлении никнейма');
                console.error('Error:', error);
            }
        }
    </script>
    <?php endif; ?>
</body>
</html>
