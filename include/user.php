<!DOCTYPE html>
<html lang="en">

<?php
require_once 'scripts/php/Managers/DatabaseManager.php';
require_once 'scripts/php/Objects/User.php';
?>

<head>

</head>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Сайт поиска информации про фильмы">
    <meta name="author" content="Иващенко Владислав Романович">
    <title>Трекер фильмов</title>
    <link rel='stylesheet' href="./CSS//elements.css">
    <link rel='stylesheet' href="./CSS//user.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="icon" href="./images/favicon.ico">
</head>

<body>
<?php
include('include/header.php');

$databaseManager = new DatabaseManager();

$username = $_COOKIE['username'];
$user = $databaseManager->getUserByUserId($databaseManager->getUserId($username));
$email = $user->getEmail();
?>

<article>
    <div class="container">
        <div class="main">
            <h1 class="main-header">Настройки профиля</h1>
            <label><b>Никнейм</b></label>
            <div class="row"><? echo "$username"; ?> <br></div>
            <label><b>Email</b></label>
            <div class="row"><? echo "$email"; ?></div>
            <form action="exit" method="post">
                <button class="exit-btn">Выйти</button>
            </form>
        </div>
    </div>
</article>
<?php
include('include/footer.php');
?>
</body>
</html>