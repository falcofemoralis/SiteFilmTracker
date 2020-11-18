<?php

require_once 'scripts/php/Managers/DatabaseManager.php';

$requestUri = explode('/', stristr($_SERVER['REQUEST_URI'] . '?', '?', true));
array_shift($requestUri); //т.к 1 элемент пустой, поэтому сдигаем

//array_shift отдает 0 значений и сдигет вправо
array_shift($requestUri); //выдаст название сайта

$databaseManager = new DatabaseManager();


$arg = array_shift($requestUri);
switch ($arg) {
    case "films":
        include('include/film.php');
        break;
    case "list":
        include('include/list.php');
        break;
    case "actors":
        include('include/actor.php');
        break;
    case "register":
        //если все поля пустые, то просто показываем регистрацию
        if (empty($_POST['username']) && empty($_POST['password']) && empty($_POST['email'])) {
            include('include/registration.php');
            break;
        }

        //если какое-то из полей пустое, сообщаем, что нужно ввести все поля
        if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
            $error = "Введите все поля!";
            include('include/registration.php');
        } else { //иначе получаем  данные
            $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
            $username = filter_var(trim($_POST['username']), FILTER_SANITIZE_STRING);
            $password = filter_var(trim($_POST['password']), FILTER_SANITIZE_STRING);
            $password = md5($password . "asdfhgewq123"); //шифрование пароля с солью

            //запоминать ли юзера
            $isSave = false;
            if (!empty($_POST['isSave'])) $isSave = true;

            $error = $databaseManager->registerUser($username, $password, $email);

            //если была ошибка, то показываем регистрацию и ошибку
            if (!empty($error)) {
                include('include/registration.php');
            } else { //иначе сохранаяем пользователя в куки и показываем стартовую страницу
                if ($isSave)  setcookie("username", $username, 120); //time() + 3600 * 24 * 365) "/"
                else  setcookie("username", $username);
                header('location: /');
            }
        }
        break;
    case "auth":
        //если все поля пустые, то просто показываем форму логина
        if (empty($_POST['username']) && empty($_POST['password'])) {
            include('include/auth.php');
            break;
        }

        //если какое-то из полей пустое, сообщаем, что нужно ввести все поля
        if (empty($_POST['username']) || empty($_POST['password'])) {
            $error = "Введите все поля!";
            include('include/auth.php');
        } else {
            $username = filter_var(trim($_POST['username']), FILTER_SANITIZE_STRING);
            $password = filter_var(trim($_POST['password']), FILTER_SANITIZE_STRING);
            $password = md5($password . "asdfhgewq123");

            //запоминать ли юзера
            $isSave = false;
            if (!empty($_POST['isSave'])) $isSave = true;

            $error = $databaseManager->authUser($username, $password);

            if (!empty($error)) {
                include('include/auth.php');
            } else {
                if ($isSave)  setcookie("username", $username, 120); //time() + 3600 * 24 * 365) "/"
                else  setcookie("username", $username);
                header('location: /');
            }
        }
        break;
    case "addComment":

        $comment = $_POST['comment'];
        $filmId = $_POST['filmId'];

        $databaseManager->addComment($comment, $filmId, $_COOKIE['username'], time());
        $url = "location: films?id=" . $filmId;
        header($url);
        break;
    default:
        include('include/main.php');
}
