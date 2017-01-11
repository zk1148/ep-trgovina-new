<?php
require 'model/Postavka_B.php';

class PostavkaNarociloDBTest
{

    public static function index()
    {

//        echo Postavka_B::insert(
//            [
//                "narocilo_id" => "7", "izdelek_id" => "1", "kolicina" => "12"
//            ]
//        );

//        echo Postavka_B::update(
//            [
//                "kolicina" => "3", "narocilo_id" => "7", "izdelek_id" => "1"
//            ]
//        );

//        echo var_dump(Postavka_B::get(
//            [
//                "narocilo_id" => "7", "izdelek_id" => "1"
//            ]
//        ));

        var_dump(Postavka_B::getAll());




    }

}



//PostavkaNarocilaDB::delete(
//    [
//        "idNarocilo" => "4", "idIzdelek" => "1"
//    ]
//);


