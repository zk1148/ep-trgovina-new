<?php

require_once("ViewHelper.php");
require_once("model/Izdelek_B.php");
require_once("model/Narocilo_B.php");
require_once("model/Postavka_B.php");


class CartController
{
    private static function cenaSkupaj()
    {
        $cena = 0;
        if (!isset($_SESSION["cart"]))
            return 0;
        $vozick = $_SESSION["cart"];
        foreach ($vozick as $id => $kolicina) {
            $izdelek = Izdelek_B::get(["id" => $id]);
            $cena += $izdelek["cena"] * $kolicina;
        }
        return $cena;
    }

    public static function index()
    {
        if (!isset($_SESSION["idUporabnik"])) {
            header("Location:" . BASE_URL . "login");
            exit;
        }
        $izdelki = [];
        if (isset($_SESSION["cart"])) {
            $vozick = $_SESSION["cart"];
            foreach ($vozick as $id => $kolicina) {
                $izdelki[] = array_merge(Izdelek_B::get(["id" => $id]), ["kolicina" => $kolicina]);
            }
        }

        echo ViewHelper::render("view/cart.php", ["izdelki" => $izdelki, "skupaj" => CartController::cenaSkupaj()]);
    }

    public static function ajax()
    {
        if (!isset($_SESSION["idUporabnik"])) {
            header('HTTP/1.1 401 Unauthorized', true, 401);
            exit;
        }

        $validationRules = [
            'do' => [
                'filter' => FILTER_VALIDATE_REGEXP,
                'options' => ["regexp" => "/^(add_into_cart|vecvec|manjmanj|purge_cart)$/"]
            ],
            'id' => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['min_range' => 0]
            ]
        ];
        $data = filter_input_array(INPUT_POST, $validationRules);

        switch ($data["do"]) {
            case "add_into_cart":
                try {
                    $izdelek = Izdelek_B::get($data);

                    if (isset($_SESSION["cart"][$data["id"]])) {
                        $_SESSION["cart"][$data["id"]]++;
                    } else {
                        $_SESSION["cart"][$data["id"]] = 1;
                    }
                    header("Status: 200");
                } catch (Exception $exc) {
                    die($exc->getMessage());
                }
                break;
            case "vecvec": {
                try {
                    $izdelek = Izdelek_B::get($data);

                    if (isset($_SESSION["cart"][$data["id"]])) {
                        $_SESSION["cart"][$data["id"]]++;
                    } else {
                        $_SESSION["cart"][$data["id"]] = 1;
                    }
                    header("Status: 200");
                } catch (Exception $exc) {
                    die($exc->getMessage());
                }
            }
                break;
            case "manjmanj": {
                try {
                    $izdelek = Izdelek_B::get($data);

                    if (isset($_SESSION["cart"][$data["id"]])) {
                        $_SESSION["cart"][$data["id"]]--;
                        if ($_SESSION["cart"][$data["id"]] == 0) {
                            unset($_SESSION["cart"][$data["id"]]);
                        }
                    }
                    header("Status: 200");
                } catch (Exception $exc) {
                    die($exc->getMessage());
                }
            }
                break;
            case "purge_cart":
                unset($_SESSION["cart"]);
                break;
            default:
                break;
        }
    }

    public static function oddajNarocilo()
    {
        if (!isset($_SESSION["idUporabnik"])) {
            header("Location:store");
            exit;
        }
        $narociloId = Narocilo_B::insert([
            "znesek" => CartController::cenaSkupaj(),
            "stranka_id" => $_SESSION["idUporabnik"]
        ]);
        foreach ($_SESSION["cart"] as $id => $kolicina) {
            Postavka_B::insert([
                "narocilo_id" => $narociloId,
                "izdelek_id" => $id,
                "kolicina" => $kolicina
            ]);
        }
        unset($_SESSION["cart"]); // Spraznimo voziček ob oddaji naročila
        header("Location:".BASE_URL."narocila");
    }


}
