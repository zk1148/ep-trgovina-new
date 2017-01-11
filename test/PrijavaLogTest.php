<?php
require 'model/Log_B.php';

class PrijavaLogTest
{

    public static function index()
{


    Log_B::insert(
        ["idUporabnik" => 1]
    );

    //var_dump(Prijava_B::getAll());




}

}