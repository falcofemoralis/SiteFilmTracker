<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Трекер фильмов</title>
    <link rel='stylesheet' href="./CSS//header.css">
    <link rel='stylesheet' href="./CSS//main.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>

<body style="background-color: #efefef;">
    <?php
    require_once 'connection.php'; // подключаем скрипт

    // подключаемся к серверу
    $connect = mysqli_connect($host, $user, $password, $database)
        or die("Ошибка " . mysqli_error($connect));
    ?>
    <header class='header'>
        <div class="container" id="header_container">
            <div class="header-top">
                <a class='header__logo' href="#">
                    <img src="./images/site_logo.svg" alt="site_logo">
                </a>

                <nav class="header-top__right">
                    <ul class="menu__list">
                        <li class='menu__item'>
                            <a href="#" class='menu__link'>Закладки</a>
                        </li>
                        <li class='menu__item'>
                            <a href="#" class='menu__link'>Пользователь</a>
                        </li>
                    </ul>
                </nav>
            </div>

            <div class='header-bot'>
                <nav class="header-bot__left" id="header-bot__left">
                    <ul class="menu__list">
                        <div class="dropdown-menu">
                            <button class="dropdown-menu__btn menu__link">Все жанры</button>
                            <div class="dropdown-content container">
                                <ul>
                                    <?php
                                    $query = "SELECT genres.genre FROM genres;";

                                    $result = mysqli_query($connect, $query) or die("Ошибка " . mysqli_error($connect));
                                    if ($result) {
                                        $rows = mysqli_num_rows($result); // количество полученных строк


                                        for ($i = 0; $i < $rows; ++$i) {
                                            $row = mysqli_fetch_row($result);
                                            echo "<li>
                                         <a href='#'>$row[0]</a>
                                         </li>";
                                        }

                                        // очищаем результат
                                        mysqli_free_result($result);
                                    }
                                    ?>
                                </ul>

                            </div>
                        </div>
                        <li>
                            <a href="#" class='menu__link'>Боевики</a>
                        </li>
                        <li>
                            <a href="#" class='menu__link'>Комедии</a>
                        </li>
                        <li>
                            <a href="#" class='menu__link'>Драма</a>
                        </li>
                        <li>
                            <a href="#" class='menu__link'>Фантастика</a>
                        </li>
                        <li>
                            <a href="#" class='menu__link'>Триллеры</a>
                        </li>
                    </ul>
                </nav>
                <div class='header-bot__right'>
                    <img class='header__search_button' src="./images/ic_search.svg" alt="ic_search">
                    <input class='header__search_input' name="search" type="text" id="search"
                        placeholder="Я ищу фильм...">
                </div>
            </div>
        </div>
    </header>
    <article style="margin: 25px;">
        <div class="container">
            <?php
            $query = "SELECT * FROM titles limit 8";

            //Популярные фильмы
            $result = mysqli_query($connect, $query) or die("Ошибка " . mysqli_error($connect));
            if ($result) {
                $rows = mysqli_num_rows($result); // количество полученных строк

                echo "<p class='films-row__name'>Популярные фильмы</p>
                      <div class='films-row__popular'>";
                for ($i = 0; $i < $rows; ++$i) {
                    $row = mysqli_fetch_row($result);
                    echo "<div class='films-row__film'>
                    <img class='films-row__poster' src='./images/posters/$row[0].jpeg' alt='poster'>
                    <h1>$row[1]</h1>
                    2020, Приключения
                    </div>";
                }
                echo "</div>";

                // очищаем результат
                mysqli_free_result($result);
            }

            //фильмы 2020 года
            $query = "SELECT * FROM titles where premiered=2020 limit 15";

            $result = mysqli_query($connect, $query) or die("Ошибка " . mysqli_error($connect));
            if ($result) {
                $rows = mysqli_num_rows($result); // количество полученных строк

                echo "<p class='films-row__name'>Фильмы 2020 года</p>
                        <table class='films-table'><tr>";

                for ($i = 1; $i <= $rows; ++$i) {
                    $row = mysqli_fetch_row($result);

                    echo "<td><div>
                        <img class='films-row__poster' src='./images/posters/$row[0].jpeg' alt='poster'>
                        <h1>$row[1]</h1>
                        2020, Приключения
                        </div></td>";
                    if (($i % 4) == 0) echo "<tr>";
                }
                echo "</table>";

                // очищаем результат
                mysqli_free_result($result);
            }
            ?>
        </div>

    </article>
    <footer>
        <div class="container">
            <div class="b-footer">
                <h3>FilmsTracker.ua — трекер информации про фильмы!</h3>
            </div>
    </footer>
</body>

</html>