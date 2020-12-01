<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Сайт поиска информации про фильмы">
    <meta name="author" content="Иващенко Владислав Романович">
    <title>Трекер фильмов</title>
    <link rel='stylesheet' href="/CSS/validation.css">
    <link rel='stylesheet' href="/CSS/elements.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="icon" href="/images/favicon.ico">
</head>

<body>
<?php
include('include/header.php');
?>

<article>
    <div class="container">
        <form class="validation-content" action="auth" method="GET">
            <div class="validation-input">
                <h2 class="validation-title">Авторизация</h2>
                <label>Имя пользователя<br>
                    <input name="username" type="text" required>
                </label>

                <label>Пароль<br>
                    <input name="password" type="password" required>
                </label>

                <label>Запомнить меня?
                    <input name="isSave" type="checkbox" style="width: 5%">
                </label>
                <br>
                <?
                if (!empty($error)) echo "<label style='color: orangered; font-weight: bold'>Ошибка: $error<br></label>";
                ?>

                <button class="validation-btn" type="submit">Войти</button>
            </div>
        </form>
    </div>
</article>
<?php
include('include/footer.php');
?>
</body>
</html>