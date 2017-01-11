<?php
require 'model/Slika_B.php';
require 'model/Izdelek_B.php';

class SlikaIzdelekDBTest
{

    public static function index()
    {

//        echo Slika_B::insert(
//            [
//                "izdelek_id" => "1", "slika" => "blazina.jpg"
//            ]
//        );

        $izdelki = Izdelek_B::getAll();
//        var_dump($izdelki);
        echo "\n\n";

        foreach ($izdelki as $izdelek) {
            $izdelek["slikce"] = "rgthr";
//            var_dump($izdelek);
            var_dump(Slika_B::get(["izdelek_id" => $izdelek["idIzdelek"]]));
        }
//        var_dump($izdelki);



//        var_dump(Slika_B::get(
//            [
//                "izdelek_id" => "1"
//            ]
//        ));

    }

}



//SlikaIzdelkaDB::update(
//    [
//        "idSlikaIzdelka" => "1", "idIzdelek" => "1", "slika" => "pot do slike2"
//    ]
//);

//SlikaIzdelkaDB::delete(
//    [
//        "idSlikaIzdelka" => "1"
//    ]
//);
SlikaIzdelekDBTest::index();


//SlikaIzdelkaDB::getAll();
