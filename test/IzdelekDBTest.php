<?php
require 'model/Izdelek_B.php';

class IzdelekDBTest
{

    public static function index()
    {

//        echo (Izdelek_B::insert(
//            [
//                "ime" => "Blazina za jogo", "opis" => "Blazina, modra", "cena" => "15.8", "aktiven" => 1
//            ]
//        ));

//        echo Izdelek_B::update(
//            [
//                "idIzdelek" => "1", "ime" => "kolebnica", "opis" => "Najboljsa kolebnica na svetu", "cena" => "7", "aktiven" => "1"
//            ]
//        );

//        echo Izdelek_B::delete(
//            [
//                "idIzdelek" => "6"
//            ]
//        );
//
//        echo var_dump(Izdelek_B::get(
//            [
//                "id" => "5"
//            ]
//        ));

        echo var_dump(Izdelek_B::getAktivni());



    }
}
