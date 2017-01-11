<?php
require 'model/Ocena_B.php';


class OcenaIzdelkaDBTest
{

    public static function index()
    {


        //echo Ocena_B::insert(["uporabnik_id"=>1,"izdelek_id"=>2,"ocena"=>5]);

        var_dump(Ocena_B::getAll());






    }

}