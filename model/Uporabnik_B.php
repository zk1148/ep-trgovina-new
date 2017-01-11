<?php

require_once 'model/AbstractDB.php';

class Uporabnik_B extends AbstractDB {

    public static function insert(array $params) {
        //$defaultVals = ["telefon" => null, "naslov" => null, "posta" => null, "certifikat_id" => null];
        $params["aktiven"] = 0;
        $params["geslo"] = password_hash($params["geslo"], PASSWORD_BCRYPT);
        //$params["geslo"] = SHA1($params["geslo"]);
        //$params = array_merge($params, $defaultVals);
        return parent::modify("INSERT INTO Uporabnik (ime, priimek, email, geslo, telefon, naslov, posta, vloga_id, aktiven, aktivacija_hash, certifikat_id) "
            . " VALUES (:ime, :priimek, :email, :geslo, :telefon, :naslov, :posta, :vloga_id, :aktiven, :aktivacija_hash, :certifikat_id)", $params);
    }

    public static function update(array $params) {
        return parent::modify("UPDATE Uporabnik SET ime = :ime, priimek = :priimek"
            . " WHERE idUporabnik = :idUporabnik", $params);
    }

    public static function updateStranka(array $params) {
        return parent::modify("UPDATE Uporabnik SET "
            . "telefon = :telefon, naslov = :naslov, posta = :posta"
            . " WHERE idUporabnik = :idUporabnik", $params);
    }

    public static function updatePass(array $params) {
        $params["geslo"] = SHA1($params["geslo"]);

        return parent::modify("UPDATE Uporabnik SET geslo = :geslo"
            . " WHERE idUporabnik = :idUporabnik", $params);
    }

    public static function updateVloga(array $params) {
        return parent::modify("UPDATE Uporabnik SET vloga_id = :vloga_id"
            . " WHERE idUporabnik = :idUporabnik", $params);
    }

    public static function updateAktivno(array $params) {
        return parent::modify("UPDATE Uporabnik SET aktiven = :aktiven"
            . " WHERE idUporabnik = :idUporabnik", $params);
    }

    public static function delete(array $id) {
        return parent::modify("DELETE FROM Uporabnik WHERE idUporabnik = :id", $id);
    }

    public static function get(array $id) {
        $users = parent::query("SELECT ime, priimek, email, geslo, telefon, naslov, posta, vloga_id, aktiven, aktivacija_hash, certifikat_id"
            . " FROM Uporabnik"
            . " WHERE idUporabnik = :id", $id);

        if (count($users) == 1) {
            return $users[0];
        } else {
            throw new InvalidArgumentException("Uporabnik ne obstaja.");
        }
    }

    public static function getUser(array $params) {
        $users = parent::query("SELECT idUporabnik, ime, priimek, email, geslo, telefon, naslov, posta, vloga_id, aktiven, aktivacija_hash, certifikat_id"
            . " FROM Uporabnik"
            . " WHERE email = :email AND aktiven = 1", $params);

        if (count($users) == 1) {
            return $users[0];
        } else {
            throw new InvalidArgumentException("Uporabnik ne obstaja.");
        }
    }

    public static function getCustomers() {
        return parent::query("SELECT idUporabnik, ime, priimek, email, telefon, naslov, posta, aktiven"
            . " FROM Uporabnik"
            . " WHERE vloga_id = 3");
    }

    public static function getSellers() {
        return parent::query("SELECT idUporabnik, ime, priimek, email, aktiven"
            . " FROM Uporabnik"
            . " WHERE vloga_id = 2");
    }

    public static function getAll() {
        return parent::query("SELECT ime, priimek, email, geslo, telefon, naslov, posta, vloga_id, aktiven, aktivacija_hash, certifikat_id"
            . " FROM Uporabnik"
            . " ORDER BY idUporabnik ASC");
    }

}
