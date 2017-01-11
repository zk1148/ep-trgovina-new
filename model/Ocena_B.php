<?php

require_once 'model/AbstractDB.php';

class Ocena_B extends AbstractDB
{

    public static function insert(array $params)
    {
        return parent::modify("INSERT INTO Ocena (uporabnik_id, izdelek_id, ocena) "
            . " VALUES (:uporabnik_id, :izdelek_id, :ocena)", $params);
    }

    public static function update(array $params)
    {
        return parent::modify("UPDATE Ocena SET ocena = :ocena"
            . " WHERE uporabnik_id = :uporabnik_id AND izdelek_id = :izdelek_id", $params);
    }

    public static function delete(array $params)
    {
        return parent::modify("DELETE FROM Ocena WHERE uporabnik_id = :uporabnik_id AND izdelek_id = :izdelek_id", $params);
    }

    public static function get(array $params)
    {
        return parent::query("SELECT u.ime, o.uporabnik_id, o.izdelek_id, o.ocena"
            . " FROM Ocena o, Uporabnik u"
            . " WHERE o.izdelek_id = :izdelek_id AND u.idUporabnik = o.uporabnik_id", $params);

    }

    public static function insertOrUpdate(array $params)
    {
        return parent::modify("INSERT INTO Ocena (uporabnik_id, izdelek_id, ocena) "
            . "VALUES (:uporabnik_id, :izdelek_id, :ocena)"
            . "ON DUPLICATE KEY UPDATE ocena=:ocena", $params);

    }

    public static function getAll()
    {
        return parent::query("SELECT uporabnik_id, izdelek_id, ocena"
            . " FROM Ocena"
            . " ORDER BY uporabnik_id ASC");
    }

}
