<?php
require 'model/Uporabnik_B.php';

class UporabnikDBTest
{

    public static function index()
    {

//        echo (Uporabnik_B::insert(
//            [
//                "ime" => "prodajalec2", "priimek" => "prodajalec2", "email" => "prodajalec2@3xkca.si", "geslo" => "prodajalec2", "telefon" => "", "naslov" => "", "posta" => "", "vloga_id" => 2, "aktiven" => 1, "aktivacija_hash" => "", "certifikat_id" => ""
//            ]
//        ));

        echo (Uporabnik_B::insert(
            [
                "ime" => "administrator", "priimek" => "administrator", "email" => "administrator@3xkca.si", "geslo" => "administrator", "telefon" => "", "naslov" => "", "posta" => "", "vloga_id" => 1, "aktiven" => 1, "aktivacija_hash" => "", "certifikat_id" => ""
            ]
        ));

//        echo (Uporabnik_B::updatePass(["idUporabnik" => 26, "geslo" => "administrator"]));

        //echo Uporabnik_B::updateAktivno(["idUporabnik" => 5,"aktiven" =>1]);

//        var_dump(Uporabnik_B::get(["id"=>23]));




    }

}