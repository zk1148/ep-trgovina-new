<?php

require_once 'AbstractDB.php';

class Slika_B extends AbstractDB
{

    public static function insert(array $params)
    {
        return parent::modify("INSERT INTO Slika (izdelek_id, slika) "
            . " VALUES (:izdelek_id, :slika)", $params);
    }

    public static function update(array $params)
    {
        return parent::modify("UPDATE Slika SET izdelek_id = :izdelek_id, slika = :slika"
            . " WHERE idSlika = :idSlika", $params);
    }

    public static function delete(array $params)
    {
        return parent::modify("DELETE FROM Slika WHERE idSlika = :idSlika", $params);
    }

    public static function get(array $params)
    {
        return parent::query("SELECT idSlika, slika"
            . " FROM Slika"
            . " WHERE izdelek_id = :izdelek_id", $params);


    }

    public static function getAll()
    {
        return parent::query("SELECT idSlika, izdelek_id, slika"
            . " FROM Slika"
            . " ORDER BY idSlika ASC");
    }

}
