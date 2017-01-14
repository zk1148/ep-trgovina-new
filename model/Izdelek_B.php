<?php

require_once 'AbstractDB.php';

class Izdelek_B extends AbstractDB
{

    public static function insert(array $params)
    {
        return parent::modify("INSERT INTO Izdelek (ime, opis, cena, aktiven) "
            . " VALUES (:ime, :opis, :cena, :aktiven)", $params);
    }

    public static function update(array $params)
    {
        return parent::modify("UPDATE Izdelek SET ime = :ime, opis = :opis, cena = :cena, aktiven = :aktiven"
            . " WHERE idIzdelek = :idIzdelek", $params);
    }

    public static function delete(array $params)
    {
        return parent::modify("DELETE FROM Izdelek WHERE idIzdelek = :idIzdelek", $params);
    }

    public static function get(array $params)
    {
        $izdelki = parent::query("SELECT i.idIzdelek, i.ime, i.opis, i.cena, i.aktiven, AVG(o.ocena) AS avg_ocena, "
            . "COUNT(o.ocena) AS count_ocena"
            . " FROM Izdelek i, Ocena o"
            . " WHERE i.idIzdelek = :id AND o.izdelek_id = i.idIzdelek", $params);

        if (count($izdelki) == 1) {
            return $izdelki[0];
        } else {
            throw new InvalidArgumentException("Izdelek ne obstaja.");
        }
    }

    public static function getAll()
    {
        return parent::query("SELECT i.idIzdelek, i.ime, i.opis, i.cena, i.aktiven, AVG(o.ocena) AS avg_ocena, "
            . "COUNT(o.ocena) AS count_ocena"
            . " FROM Izdelek i  LEFT JOIN Ocena o"
            . " ON i.idIzdelek = o.izdelek_id GROUP BY i.idIzdelek");
    }

    public static function getAllRest()
    {
        return parent::query("SELECT idIzdelek, ime "
            . " FROM Izdelek i "
            . " WHERE i.aktiven = 1");
    }

    public static function iskanje(array $params)
    {
//SELECT * FROM articles WHERE MATCH (title,body)
//-> AGAINST ('+MySQL -YourSQL' IN BOOLEAN MODE);
        $i = $params["iskanje"];
        return parent::query("SELECT i.idIzdelek, i.ime, i.opis, i.cena, i.aktiven, AVG(o.ocena) AS avg_ocena, "
            . "COUNT(o.ocena) AS count_ocena"
            . " FROM Izdelek i  LEFT JOIN Ocena o"
            . " ON i.idIzdelek = o.izdelek_id  WHERE i.aktiven=1 AND i.idIzdelek IN"
            . " (SELECT i.idIzdelek FROM Izdelek WHERE MATCH (ime,opis) AGAINST ('".$i."' IN BOOLEAN MODE))"
            . "GROUP BY i.idIzdelek", $params);


    }

    public static function getRest(array $params)
    {
        $izdelki = parent::query("SELECT i.idIzdelek, i.ime, i.opis, i.cena, AVG(o.ocena) AS avg_ocena, "
            . "COUNT(o.ocena) AS count_ocena"
            . " FROM Izdelek i, Ocena o"
            . " WHERE i.idIzdelek = :id AND o.izdelek_id = i.idIzdelek AND i.Aktiven = 1 ", $params);

        if (count($izdelki) == 1) {
            return $izdelki[0];
        } else {
            throw new InvalidArgumentException("Izdelek ne obstaja.");
        }
    }

    public static function getAktivni()
    {
        return parent::query("SELECT i.idIzdelek, i.ime, i.opis, i.cena, i.aktiven, AVG(o.ocena) AS avg_ocena, "
            . "COUNT(o.ocena) AS count_ocena"
            . " FROM Izdelek i  LEFT JOIN Ocena o"
            . " ON i.idIzdelek = o.izdelek_id  WHERE i.aktiven=1 GROUP BY i.idIzdelek");
    }

}
