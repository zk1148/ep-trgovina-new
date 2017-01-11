<?php
require 'model/Narocilo_B.php';

class NarociloDBTest
{

public static function index()
    {

//    	echo (Narocilo_B::insert(
//           [
//                "znesek" => "100", "status_id" => "1", "stranka_id" => "1"
//            ]
//        ));

//        echo Narocilo_B::update(
//        [
//            "status_id" => "1", "prodajalec_id" => "1", "datum_potrditve" => "2016-11-18 15:57:21", "idNarocilo" => "7"
//        ]
//        );


//        echo var_dump(Narocilo_B::get(
//                [
//                    "id" => "8"
//                ]
//            ));

        //echo var_dump(Narocilo_B::getAll());

        echo Narocilo_B::delete(
            [
                "id" => "9"
            ]
        );

    }

}
