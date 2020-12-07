<?php

class FilmsList extends Database
{
    public function __construct()
    {
        parent::__construct();
    }

    private function getFilmsFromQuery($query)
    {
        $result = mysqli_query($this->connection, $query) or die("Ошибка " . mysqli_error($this->connection));

        $filmsIDs = null;
        for ($i = 0; $i < mysqli_num_rows($result); ++$i) {
            $row = mysqli_fetch_row($result);
            $filmsIDs[] = $row[0];
        }

        return $filmsIDs;
    }

    public function getCountries()
    {
        $query = "SELECT * FROM countries";

        $result = mysqli_query($this->connection, $query) or die("Ошибка " . mysqli_error($this->connection));

        $countries = array();
        for ($i = 0; $i < mysqli_num_rows($result); ++$i) {
            $row = mysqli_fetch_row($result);
            $countries[] = new Country($row[0], $row[1]);
        }

        return $countries;
    }

    public function getFilmsIdsBySearch($param)
    {
        $query = "SELECT films.title_id
            FROM films
            INNER JOIN ratings ON films.title_id=ratings.title_id
            INNER JOIN films_translated on films_translated.title_id=films.title_id
            WHERE films_translated.lang_id=3 AND films_translated.title like '%$param%'
            ORDER BY ratings.votes DESC, ratings.rating DESC";

        return $this->getFilmsFromQuery($query);
    }

    public function getYearsRange()
    {
        $query = "SELECT DISTINCT films.premiered FROM films ORDER BY films.premiered DESC;";

        $result = mysqli_query($this->connection, $query) or die("Ошибка " . mysqli_error($this->connection));

        $years = array();
        for ($i = 0; $i < mysqli_num_rows($result); ++$i)
            $years[] = mysqli_fetch_row($result)[0];

        return $years;
    }

    public function getFilmsByFilters($where, $order)
    {
        $whereQuery = "WHERE ";
        for ($i = 0; $i < count($where); ++$i) {
            $whereQuery .= $where[$i];
            if ($i != count($where) - 1) $whereQuery .= " AND ";
        }

        if ($where != null) $whereQuery .= " AND ";
        $whereQuery .= " films_translated.lang_id = 3";

        $query = "SELECT films.title_id
            FROM films
            INNER JOIN ratings ON films.title_id=ratings.title_id
            INNER JOIN films_translated on films_translated.title_id=films.title_id " . $whereQuery . " ORDER BY " . $order;

        return $this->getFilmsFromQuery($query);
    }
}
