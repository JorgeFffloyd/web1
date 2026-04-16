<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Этапы выполнения лабораторной работы N3</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .back-button {
            text-align: center;
            margin-top: 30px;
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
        .subtask {
            background: #f9fcfd;
            margin: 20px 0;
            padding: 15px;
            border-radius: 10px;
            border-left: 4px solid #667eea;
        }
        .subtask h3 {
            margin-top: 0;
            color: #4a5568;
        }
        .screenshot img {
            max-width: 100%;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        .caption {
            font-size: 0.85em;
            color: #666;
            margin-top: 8px;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Этапы выполнения лабораторной работы N3</h1>
        <p style="text-align: center; color: #666;">Студент: u82609 | Сервер: kubsu-dev.ru</p>

        <section class="task">
            <h2>1. Подготовка к выполнению работы</h2>

            <div class="subtask">
                <h3>1.1. Инициализация Git и отправка на GitHub</h3>
                <div class="description">
                    <p>На локальном компьютере в репозиторий добавлены файлы задания 3 (index.php, save.php, style.css, report.php, view.php) и выполнена отправка на GitHub.</p>
                </div>
                <div class="screenshot">
                    <img src="24.PNG" alt="Git init и push">
                    <p class="caption">Скриншот 0: Инициализация Git и push</p>
                </div>
            </div>

            <div class="subtask">
                <h3>1.2. Подключение к учебному серверу по SSH</h3>
                <div class="description">
                    <p>Через PuTTY выполнен вход на сервер kubsu-dev.ru (порт 58528) под логином u82609.</p>
                </div>
                <div class="screenshot">
                    <img src="25.PNG" alt="SSH подключение">
                    <p class="caption">Скриншот 1: Подключение к серверу по SSH</p>
                </div>
            </div>

            <div class="subtask">
                <h3>1.3. Создание рабочего каталога</h3>
                <div class="description">
                    <p>В домашней директории создан каталог ~/www/task3, в который будут помещены файлы лабораторной работы (через симлинк на ~/web1/task3).</p>
                </div>
                <div class="screenshot">
                    <img src="26.PNG" alt="mkdir task3">
                    <p class="caption">Скриншот 2: Создание каталога task3</p>
                </div>
            </div>

            <div class="subtask">
                <h3>1.4. Подключение к MySQL</h3>
                <div class="description">
                    <p>Запущен клиент MySQL для создания таблиц. Использована команда mysql -u u82609 -p.</p>
                </div>
                <div class="screenshot">
                    <img src="21.PNG" alt="MySQL подключение">
                    <p class="caption">Скриншот 4: Вход в MySQL</p>
                </div>
            </div>

            <div class="subtask">
                <h3>1.5. Создание таблиц и заполнение языков</h3>
                <div class="description">
                    <p>Созданы три таблицы: applications, programming_languages, application_languages в соответствии с 3-й нормальной формой. Затем таблица programming_languages заполнена списком языков из задания.</p>
                </div>
                <div class="screenshot">
                    <img src="22.PNG" alt="SQL запросы">
                    <p class="caption">Скриншот 5: Создание таблиц и вставка языков</p>
                </div>
            </div>

            <div class="subtask">
                <h3>1.6. Выход из MySQL</h3>
                <div class="description">
                    <p>После завершения работы с базой данных выполнен выход из клиента MySQL.</p>
                </div>
                <div class="screenshot">
                    <img src="23.PNG" alt="exit">
                    <p class="caption">Скриншот 6: Выход из MySQL</p>
                </div>
            </div>

            <div class="subtask">
                <h3>1.7. Проверка сохранённых данных</h3>
                <div class="description">
                    <p>Выполнена выборка записей из таблицы applications для проверки успешного сохранения данных. Для удобного просмотра всех сохранённых анкет создана отдельная страница: <a href="view.php" target="_blank">Просмотр сохранённых записей</a>.</p>
                </div>
                <div class="screenshot">
                    <img src="27.PNG" alt="SELECT запрос">
                    <p class="caption">Скриншот 7: Просмотр сохранённых записей</p>
                </div>
            </div>
        </section>

        <div class="back-button">
            <a href="index.php">Вернуться к анкете</a>
        </div>
    </div>
</body>
</html>