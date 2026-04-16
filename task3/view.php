<?php
$host = 'localhost';
$dbname = 'u82609';
$username = 'u82609';
$password = '7050514';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения: " . $e->getMessage());
}

$stmt = $pdo->query("
    SELECT a.*, GROUP_CONCAT(pl.name SEPARATOR ', ') as languages
    FROM applications a
    LEFT JOIN application_languages al ON a.id = al.application_id
    LEFT JOIN programming_languages pl ON al.language_id = pl.id
    GROUP BY a.id
    ORDER BY a.created_at DESC
");
$applications = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Просмотр сохранённых анкет</title>
    <link rel="stylesheet" href="style.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background: #667eea;
            color: white;
        }
        tr:nth-child(even) {
            background: #f9f9f9;
        }
        .back-button {
            text-align: center;
            margin-top: 20px;
        }
        .back-button a {
            display: inline-block;
            background-color: #667eea;
            color: white;
            text-decoration: none;
            padding: 10px 25px;
            border-radius: 5px;
            font-weight: bold;
        }
        .back-button a:hover {
            background-color: #5a67d8;
        }
        .gender-male {
            color: #2c3e50;
        }
        .gender-female {
            color: #e91e63;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Сохранённые анкеты</h1>
        
        <?php if (count($applications) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ФИО</th>
                        <th>Телефон</th>
                        <th>Email</th>
                        <th>Дата рождения</th>
                        <th>Пол</th>
                        <th>Языки</th>
                        <th>Биография</th>
                        <th>Согласие</th>
                        <th>Дата создания</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($applications as $app): ?>
                        <tr>
                            <td><?= $app['id'] ?></td>
                            <td><?= htmlspecialchars($app['full_name']) ?></td>
                            <td><?= htmlspecialchars($app['phone']) ?></td>
                            <td><?= htmlspecialchars($app['email']) ?></td>
                            <td><?= $app['birth_date'] ?></td>
                            <td class="gender-<?= $app['gender'] ?>">
                                <?= $app['gender'] == 'male' ? 'Мужской' : 'Женский' ?>
                            </td>
                            <td><?= htmlspecialchars($app['languages'] ?? '-') ?></td>
                            <td><?= nl2br(htmlspecialchars(substr($app['biography'] ?? '', 0, 200))) ?><?= strlen($app['biography'] ?? '') > 200 ? '...' : '' ?></td>
                            <td><?= $app['agree_to_contract'] ? 'Да' : 'Нет' ?></td>
                            <td><?= $app['created_at'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Пока нет сохранённых анкет.</p>
        <?php endif; ?>
        
        <div class="back-button">
            <a href="index.php">Вернуться к анкете</a>
        </div>
    </div>
</body>
</html>