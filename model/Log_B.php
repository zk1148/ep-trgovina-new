<?php

require_once 'model/AbstractDB.php';

class Log_B extends AbstractDB
{

    public static function insert(array $params)
    {
        return parent::modify("INSERT INTO Log (uporabnik_id, cas, komentar) "
            . " VALUES (:idUporabnik, now(), :komentar)", $params);
    }

    public static function update(array $params)
    {
    }

    public static function delete(array $id)
    {
        return parent::modify("DELETE FROM Log WHERE idLog = :id", $id);
    }

    public static function get(array $id)
    {
        $books = parent::query("SELECT uporabnik_id, cas, komentar"
            . " FROM Log"
            . " WHERE id = :id", $id);

        if (count($books) == 1) {
            return $books[0];
        } else {
            throw new InvalidArgumentException("No such book");
        }
    }

    public static function getAll()
    {
        return parent::query("SELECT idLog, uporabnik_id, cas, komentar"
            . " FROM Log"
            . " ORDER BY idLog ASC");
    }

}
