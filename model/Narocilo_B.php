<?php

require_once 'model/AbstractDB.php';

class Narocilo_B extends AbstractDB {

    public static function insert(array $params) {
        $defaultVals = ["prodajalec_id" => null, "datum_potrditve" => null];
        $params["status_id"] = 1;
        $params = array_merge($defaultVals, $params);
        return parent::modify("INSERT INTO Narocilo (znesek, status_id, datum_oddaje, datum_potrditve, stranka_id, prodajalec_id) "
            . " VALUES (:znesek, :status_id, now(), :datum_potrditve, :stranka_id, :prodajalec_id)", $params);
    }

    public static function update(array $params) {
        return parent::modify("UPDATE Narocilo SET status_id = :status_id, prodajalec_id = :prodajalec_id, datum_potrditve = :datum_potrditve "
            . " WHERE idNarocilo = :idNarocilo", $params);
    }

    public static function updateStatus(array $params) {
        return parent::modify("UPDATE Narocilo SET status_id = :status_id"
            . " WHERE idNarocilo = :idNarocilo", $params);
    }

    public static function delete(array $id) {
        return parent::modify("DELETE FROM Narocilo WHERE idNarocilo = :id", $id);
    }

    public static function get(array $id) {
        $narocila = parent::query("SELECT idNarocilo, znesek, status_id, datum_oddaje, datum_potrditve, stranka_id, prodajalec_id"
            . " FROM Narocilo"
            . " WHERE idNarocilo = :id", $id);

        if (count($narocila) == 1) {
            return $narocila[0];
        } else {
            throw new InvalidArgumentException("Narocilo ne obstaja.");
        }
    }
    public static function getForStranka(array $params){
        return  parent::query("SELECT idNarocilo, znesek, status_id, datum_oddaje, datum_potrditve, stranka_id, prodajalec_id"
            . " FROM Narocilo"
            . " WHERE stranka_id = :stranka_id", $params);
    }

    public static function getAll() {
        return parent::query("SELECT idNarocilo, znesek, status_id, datum_oddaje, datum_potrditve, stranka_id, prodajalec_id"
            . " FROM Narocilo"
            . " ORDER BY idNarocilo ASC");
    }

}
