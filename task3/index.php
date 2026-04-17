<?php
session_start();
$errors = $_SESSION['errors'] ?? [];
$old_data = $_SESSION['old_data'] ?? [];
unset($_SESSION['errors'], $_SESSION['old_data']);
$success = $_SESSION['success'] ?? null;
unset($_SESSION['success']);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Задание 3 - Анкета разработчика</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .error-message {
            background: #fee;
            color: #c0392b;
            padding: 12px 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            border-left: 4px solid #c0392b;
            font-size: 14px;
        }
        .success-message {
            background: #e8f5e9;
            color: #2e7d32;
            padding: 12px 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            border-left: 4px solid #2e7d32;
            font-size: 14px;
        }
        .error-list {
            margin-top: 10px;
            padding-left: 20px;
        }
        .error-list li {
            margin: 5px 0;
        }
        input:invalid {
            border-color: #e74c3c;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Анкета разработчика</h1>
            <p>Заполните форму, чтобы зарегистрироваться в базе данных</p>
        </div>

        <?php if ($success): ?>
            <div class="success-message">
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="error-message">
                <strong>Пожалуйста, исправьте следующие ошибки:</strong>
                <ul class="error-list">
                    <?php foreach ($errors as $field => $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="save.php" method="POST" id="application-form">
            <!-- ФИО -->
            <div class="form-group">
                <label for="full_name">ФИО <span class="required">*</span></label>
                <input type="text" id="full_name" name="full_name" required 
                       pattern="[A-Za-zА-Яа-яЁё\s\-]{2,150}"
                       title="Только буквы, пробелы и дефисы. От 2 до 150 символов."
                       placeholder="Иванов Иван Иванович"
                       value="<?php echo isset($old_data['full_name']) ? htmlspecialchars($old_data['full_name']) : ''; ?>">
                <small>Только буквы, пробелы и дефисы (2-150 символов)</small>
            </div>

            <!-- Телефон -->
            <div class="form-group">
                <label for="phone">Телефон <span class="required">*</span></label>
                <input type="tel" id="phone" name="phone" required 
                       pattern="[\+0-9\(\)\-\s]{10,20}"
                       title="Введите номер телефона (10-20 символов)"
                       placeholder="+7 (123) 456-78-90"
                       value="<?php echo isset($old_data['phone']) ? htmlspecialchars($old_data['phone']) : ''; ?>">
                <small>Формат: +7 (123) 456-78-90 или 89123456789</small>
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email">E-mail <span class="required">*</span></label>
                <input type="email" id="email" name="email" required 
                       placeholder="ivanov@example.com"
                       value="<?php echo isset($old_data['email']) ? htmlspecialchars($old_data['email']) : ''; ?>">
                <small>Введите корректный email адрес</small>
            </div>

            <!-- Дата рождения -->
            <div class="form-group">
                <label for="birth_date">Дата рождения <span class="required">*</span></label>
                <input type="date" id="birth_date" name="birth_date" required
                       min="1900-01-01" max="2025-12-31"
                       value="<?php echo isset($old_data['birth_date']) ? htmlspecialchars($old_data['birth_date']) : ''; ?>">
            </div>

            <!-- Пол  -->
            <div class="form-group">
                <label>Пол <span class="required">*</span></label>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="gender" value="male" required
                            <?php echo (isset($old_data['gender']) && $old_data['gender'] == 'male') ? 'checked' : ''; ?>> Мужской
                    </label>
                    <label>
                        <input type="radio" name="gender" value="female" required
                            <?php echo (isset($old_data['gender']) && $old_data['gender'] == 'female') ? 'checked' : ''; ?>> Женский
                    </label>
                </div>
            </div>

            <!-- Любимые языки программирования -->
            <div class="form-group">
                <label for="languages">Любимые языки программирования <span class="required">*</span></label>
                <select name="languages[]" id="languages" multiple required>
                    <option value="Pascal" <?php echo (isset($old_data['languages']) && in_array('Pascal', $old_data['languages'])) ? 'selected' : ''; ?>>Pascal</option>
                    <option value="C" <?php echo (isset($old_data['languages']) && in_array('C', $old_data['languages'])) ? 'selected' : ''; ?>>C</option>
                    <option value="C++" <?php echo (isset($old_data['languages']) && in_array('C++', $old_data['languages'])) ? 'selected' : ''; ?>>C++</option>
                    <option value="JavaScript" <?php echo (isset($old_data['languages']) && in_array('JavaScript', $old_data['languages'])) ? 'selected' : ''; ?>>JavaScript</option>
                    <option value="PHP" <?php echo (isset($old_data['languages']) && in_array('PHP', $old_data['languages'])) ? 'selected' : ''; ?>>PHP</option>
                    <option value="Python" <?php echo (isset($old_data['languages']) && in_array('Python', $old_data['languages'])) ? 'selected' : ''; ?>>Python</option>
                    <option value="Java" <?php echo (isset($old_data['languages']) && in_array('Java', $old_data['languages'])) ? 'selected' : ''; ?>>Java</option>
                    <option value="Haskel" <?php echo (isset($old_data['languages']) && in_array('Haskel', $old_data['languages'])) ? 'selected' : ''; ?>>Haskel</option>
                    <option value="Clojure" <?php echo (isset($old_data['languages']) && in_array('Clojure', $old_data['languages'])) ? 'selected' : ''; ?>>Clojure</option>
                    <option value="Prolog" <?php echo (isset($old_data['languages']) && in_array('Prolog', $old_data['languages'])) ? 'selected' : ''; ?>>Prolog</option>
                    <option value="Scala" <?php echo (isset($old_data['languages']) && in_array('Scala', $old_data['languages'])) ? 'selected' : ''; ?>>Scala</option>
                    <option value="Go" <?php echo (isset($old_data['languages']) && in_array('Go', $old_data['languages'])) ? 'selected' : ''; ?>>Go</option>
                </select>
                <small>Удерживайте Ctrl (Cmd) для выбора нескольких языков</small>
            </div>

            <!-- Биография -->
            <div class="form-group">
                <label for="biography">Биография</label>
                <textarea name="biography" id="biography" maxlength="5000" placeholder="Расскажите немного о себе..."><?php echo isset($old_data['biography']) ? htmlspecialchars($old_data['biography']) : ''; ?></textarea>
                <small>Не более 5000 символов</small>
            </div>

            <!-- Согласие с контрактом -->
            <div class="form-group">
                <div class="checkbox-group">
                    <input type="checkbox" name="agree_to_contract" id="agree_to_contract" value="1" required
                        <?php echo (isset($old_data['agree_to_contract']) && $old_data['agree_to_contract'] == '1') ? 'checked' : ''; ?>>
                    <label for="agree_to_contract">Я ознакомлен(а) с контрактом и согласен(на) <span class="required">*</span></label>
                </div>
            </div>

            <button type="submit">Сохранить</button>
        </form>
    </div>
</body>
</html>
