<?php

require_once 'model/AbstractDB.php';

class Postavka_B extends AbstractDB {

    public static function insert(array $params) {
        $defaultVals = ["kolicina" => null];
        $params = array_merge($defaultVals, $params);
        return parent::modify("INSERT INTO Postavka (narocilo_id, izdelek_id, kolicina) "
            . " VALUES (:narocilo_id, :izdelek_id, :kolicina)", $params);
    }

    public static function update(array $params) {
        return parent::modify("UPDATE Postavka SET kolicina = :kolicina"
            . " WHERE narocilo_id = :narocilo_id AND izdelek_id = :izdelek_id", $params);
    }

    public static function delete(array $params) {
        return parent::modify("DELETE FROM Postavka WHERE narocilo_id = :narocilo_id AND izdelek_id = :izdelek_id", $params);
    }

    public static function get(array $params) {
        $postavke = parent::query("SELECT narocilo_id, izdelek_id, kolicina"
            . " FROM Postavka"
            . " WHERE narocilo_id = :narocilo_id AND izdelek_id = :izdelek_id", $params);

        if (count($postavke) == 1) {
            return $postavke[0];
        } else {
            throw new InvalidArgumentException("Postavka narocila ne obstaja.");
        }
    }

    public static function getAll() {
        return parent::query("SELECT narocilo_id, izdelek_id, kolicina"
            . " FROM Postavka"
            . " ORDER BY narocilo_id ASC");
    }

}
