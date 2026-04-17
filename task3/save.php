<?php
session_start();

$host = 'localhost';
$dbname = 'u82609';
$username = 'u82609';
$password = '7050514';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 1. Валидация ФИО
    $full_name = trim($_POST['full_name'] ?? '');
    if (empty($full_name)) {
        $errors['full_name'] = 'ФИО обязательно для заполнения';
    } elseif (strlen($full_name) > 150) {
        $errors['full_name'] = 'ФИО не должно превышать 150 символов';
    } elseif (strlen($full_name) < 2) {
        $errors['full_name'] = 'ФИО должно содержать минимум 2 символа';
    } elseif (!preg_match('/^[a-zA-Zа-яА-ЯёЁ\s\-]+$/u', $full_name)) {
        $errors['full_name'] = 'ФИО может содержать только буквы, пробелы и дефисы';
    }
    
    // 2. Валидация телефона
    $phone = trim($_POST['phone'] ?? '');
    $phone_clean = preg_replace('/[^0-9+]/', '', $phone);
    if (empty($phone_clean)) {
        $errors['phone'] = 'Телефон обязателен для заполнения';
    } elseif (strlen($phone_clean) < 10 || strlen($phone_clean) > 15) {
        $errors['phone'] = 'Телефон должен содержать 10-15 цифр';
    } elseif (!preg_match('/^[\+0-9]{10,15}$/', $phone_clean)) {
        $errors['phone'] = 'Введите корректный номер телефона';
    }
    
    // 3. Валидация email
    $email = trim($_POST['email'] ?? '');
    if (empty($email)) {
        $errors['email'] = 'Email обязателен для заполнения';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Введите корректный email адрес';
    } elseif (strlen($email) > 100) {
        $errors['email'] = 'Email не должен превышать 100 символов';
    }
    
    // 4. Валидация даты рождения
    $birth_date = $_POST['birth_date'] ?? '';
    if (empty($birth_date)) {
        $errors['birth_date'] = 'Дата рождения обязательна';
    } elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $birth_date)) {
        $errors['birth_date'] = 'Неверный формат даты';
    } else {
        $date = DateTime::createFromFormat('Y-m-d', $birth_date);
        if (!$date || $date->format('Y-m-d') !== $birth_date) {
            $errors['birth_date'] = 'Несуществующая дата';
        } elseif ($date->format('Y') < 1900 || $date->format('Y') > date('Y')) {
            $errors['birth_date'] = 'Год рождения должен быть между 1900 и текущим годом';
        }
    }
    
    // 5. Валидация пола 
    $gender = $_POST['gender'] ?? '';
    $allowed_genders = ['male', 'female'];
    if (empty($gender)) {
        $errors['gender'] = 'Выберите пол';
    } elseif (!in_array($gender, $allowed_genders)) {
        $errors['gender'] = 'Недопустимое значение пола';
    }
    
    // 6. Валидация языков программирования
    $languages = $_POST['languages'] ?? [];
    $allowed_languages = ['Pascal', 'C', 'C++', 'JavaScript', 'PHP', 'Python', 'Java', 'Haskel', 'Clojure', 'Prolog', 'Scala', 'Go'];
    
    if (empty($languages)) {
        $errors['languages'] = 'Выберите хотя бы один язык программирования';
    } else {
        foreach ($languages as $lang) {
            if (!in_array($lang, $allowed_languages)) {
                $errors['languages'] = 'Выбран недопустимый язык программирования';
                break;
            }
        }
    }
    
    // 7. Валидация биографии (необязательное поле)
    $biography = trim($_POST['biography'] ?? '');
    if (strlen($biography) > 5000) {
        $errors['biography'] = 'Биография не должна превышать 5000 символов';
    }
    
    // 8. Валидация согласия с контрактом
    $agree_to_contract = isset($_POST['agree_to_contract']) && $_POST['agree_to_contract'] == '1';
    if (!$agree_to_contract) {
        $errors['agree_to_contract'] = 'Вы должны ознакомиться с контрактом и согласиться';
    }
    
    // Если ошибок нет - сохраняем в БД
    if (empty($errors)) {
        try {
            $pdo->beginTransaction();
            
            $stmt = $pdo->prepare("
                INSERT INTO applications (full_name, phone, email, birth_date, gender, biography, agree_to_contract)
                VALUES (:full_name, :phone, :email, :birth_date, :gender, :biography, :agree_to_contract)
            ");
            
            $stmt->execute([
                ':full_name' => $full_name,
                ':phone' => $phone_clean,
                ':email' => $email,
                ':birth_date' => $birth_date,
                ':gender' => $gender,
                ':biography' => $biography,
                ':agree_to_contract' => $agree_to_contract ? 1 : 0
            ]);
            
            $application_id = $pdo->lastInsertId();
            
            $lang_stmt = $pdo->prepare("SELECT id, name FROM programming_languages WHERE name = :name");
            $insert_lang_stmt = $pdo->prepare("
                INSERT INTO application_languages (application_id, language_id)
                VALUES (:application_id, :language_id)
            ");
            
            foreach ($languages as $lang_name) {
                $lang_stmt->execute([':name' => $lang_name]);
                $lang = $lang_stmt->fetch(PDO::FETCH_ASSOC);
                if ($lang) {
                    $insert_lang_stmt->execute([
                        ':application_id' => $application_id,
                        ':language_id' => $lang['id']
                    ]);
                }
            }
            
            $pdo->commit();
            
            $_SESSION['success'] = 'Данные успешно сохранены! Спасибо за регистрацию.';
            header('Location: index.php');
            exit;
            
        } catch (PDOException $e) {
            $pdo->rollBack();
            $errors['database'] = 'Ошибка при сохранении: ' . $e->getMessage();
        }
    }
}

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    $_SESSION['old_data'] = $_POST;
    header('Location: index.php');
    exit;
}
?>
