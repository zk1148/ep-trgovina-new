<?php

require_once("model/Narocilo_B.php");
require_once("model/Uporabnik_B.php");
require_once("ViewHelper.php");

class NarocilaController
{
    public static $statusi = [
        1 => "Oddano",
        2 => "Potrjeno",
        3 => "Stornirano"
    ];

    public static function index()
    {
        if (!isset($_SESSION["idUporabnik"])) {
            header("Location:" . BASE_URL . "login");
            exit;
        }
        if ($_SESSION["vloga_id"] == 3){ // Stranka vidi samo svoja naročila
            $narocila = Narocilo_B::getForStranka(["stranka_id" => $_SESSION["idUporabnik"]]);
        } else {
            $narocila = Narocilo_B::getAll();
        }

        foreach ($narocila as &$narocilo) {
            $narocilo["stranka"] = Uporabnik_B::get(["id" => $narocilo["stranka_id"]]);
            $narocilo["statusDisplay"] = NarocilaController::$statusi[$narocilo["status_id"]];
        }
        echo ViewHelper::render("view/narocila.php", [
            "narocila" => $narocila
        ]);
    }


    public static function akcije()
    {
        if (!isset($_SESSION["idUporabnik"])) {
            header("Location:" . BASE_URL . "login");
            exit;
        }

        $validationRules = [
            'do' => [
                'filter' => FILTER_VALIDATE_REGEXP,
                'options' => ["regexp" => "/^(storniraj|potrdi)$/"]
            ],
            'id' => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['min_range' => 0]
            ]
        ];
        $data = filter_input_array(INPUT_POST, $validationRules);

        switch ($data["do"]) {
            case "storniraj":
                try {
                    $narocilo = Narocilo_B::get($data);
                    // stranka lahko stornira samo svoja narocila
                    if ($_SESSION["vloga_id"] == 3 && $narocilo["stranka_id"] != $_SESSION["idUporabnik"]) {
                        die("Operacija ni dovoljena.");
                    }
                    Narocilo_B::updateStatus(["idNarocilo" => $data["id"], "status_id" => 3]);

                    header("Location:" . BASE_URL . "narocila");
                } catch (Exception $exc) {
                    die($exc->getMessage());
                }
                break;
            case "potrdi":
                try {
                    $narocilo = Narocilo_B::get($data);
                    // stranka ne more potrjevati naročil
                    if ($_SESSION["vloga_id"] == 3) {
                        die("Operacija ni dovoljena.");
                    }
                    Narocilo_B::updateStatus(["idNarocilo" => $data["id"], "status_id" => 2]);

                    header("Location:" . BASE_URL . "narocila");
                } catch (Exception $exc) {
                    die($exc->getMessage());
                }
                break;
            default:
                break;
        }
    }

}
