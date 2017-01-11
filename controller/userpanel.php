<?php
/**
 * Created by PhpStorm.
 * User: ep
 * Date: 31.12.2015
 * Time: 12:55
 */

function getRandomWord($len = 5)
{
    $word = array_merge(range('0', '9'), range('A', 'Z'));
    shuffle($word);
    return substr(implode($word), 0, $len);
}

// posodobi status uporabnika
if (isset($_GET["aktiven"]) && isset($_GET["id"]) && $_GET["id"] != -1) {
    // le administrator !
    $params = array("idUporabnik" => filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS), "aktiven" => filter_input(INPUT_GET, 'aktiven', FILTER_SANITIZE_SPECIAL_CHARS));
    Uporabnik_B::updateAktivno($params);

    if (isset($_GET["f"]) && $_GET["f"] == "p") {
        header("Location:prodajalci");
        exit;
    } else if (isset($_GET["f"]) && $_GET["f"] == "c") {
        header("Location:sellerpanel?manage");
        exit;
    }

    header("Location:adminpanel?id=" . $_GET['id']);
    exit;
}

// posodobi uporabnika
if (isset($_POST["id"]) && $_POST["id"] != -1 && isset($_POST["vloga_id"]) && $_POST["vloga_id"] != null) {
    // posodobi uporabnika
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_SPECIAL_CHARS);

    if (isset($_POST["password"]) && $_POST["password"] === $_POST["confirm"] && !empty($_POST["password"])) {
        $params = array("idUporabnik" => $id, "geslo" => filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS));
        Uporabnik_B::updatePass($params);

    }

    if (isset($_POST["ime"]) && !empty($_POST["ime"]) && isset($_POST["priimek"]) && !empty($_POST["priimek"])) {
        $params = array("idUporabnik" => $id, "ime" => filter_input(INPUT_POST, 'ime', FILTER_SANITIZE_SPECIAL_CHARS), "priimek" => filter_input(INPUT_POST, 'priimek', FILTER_SANITIZE_SPECIAL_CHARS));
        Uporabnik_B::update($params);
    }

    if (isset($_POST["naslov"]) && !empty($_POST["naslov"]) && isset($_POST["posta"]) && !empty($_POST["posta"]) && isset($_POST["telefon"]) && !empty($_POST["telefon"])) {
        $params = array("idUporabnik" => $id, "naslov" => filter_input(INPUT_POST, 'naslov', FILTER_SANITIZE_SPECIAL_CHARS), "posta" => filter_input(INPUT_POST, 'posta', FILTER_SANITIZE_SPECIAL_CHARS), "telefon" => filter_input(INPUT_POST, 'telefon', FILTER_SANITIZE_SPECIAL_CHARS));
        Uporabnik_B::updateStranka($params);
    }

    if ($_POST["vloga_id"] === "2") {
        header("Location:prodajalci");
        exit;
    } elseif ($_POST["vloga_id"] === "1") {
        header("Location:adminpanel");
        exit;
    } elseif ($_POST["vloga_id"] === "3") {
        if (isset($_POST["editing"]) && $_POST["editing"] == "customer") {
            if($_SESSION["vloga_id"] == 1 || $_SESSION["vloga_id"] == 2) {
                header("Location:sellerpanel?manage");
                exit;
            } else {
                header("Location:sellerpanel?id=$id");
                exit;
            }
        } else {
            header("Location:sellerpanel");
            exit;
        }
    }
}

// ustvari uporabnika
$ustvari = 0;
if (isset($_POST["id"]) && $_POST["id"] == -1 && isset($_POST["vloga_id"]) && $_POST["vloga_id"] != null) {

    if(isset($_POST["registracija"]) && $_POST["registracija"] === "1") {
        if($_POST["captcha"] == $_SESSION["mojaVarnost"]) {
            $ustvari = 1;
        } else {
            header("refresh:5;url=register");
            echo "Varnostna koda ni pravilna.";
            exit;
        }
    } else {
        $ustvari = 1;
    }

    if($ustvari === 1) {
        $aktiv_hash_string = getRandomWord();  // string
        $aktiv_hash = password_hash($aktiv_hash_string, PASSWORD_BCRYPT);
        $cert_id = "";

        if (isset($_POST["email"]) && !empty($_POST["email"])) {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
        }
        if (isset($_POST["password"]) && $_POST["password"] === $_POST["confirm"] && !empty($_POST["password"])) {
            $geslo = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
        }
        if (isset($_POST["ime"]) && !empty($_POST["ime"])) {
            $ime = filter_input(INPUT_POST, 'ime', FILTER_SANITIZE_SPECIAL_CHARS);
        }
        if (isset($_POST["priimek"]) && !empty($_POST["priimek"])) {
            $priimek = filter_input(INPUT_POST, 'priimek', FILTER_SANITIZE_SPECIAL_CHARS);
        }
        if (isset($_POST["vloga_id"]) && !empty($_POST["vloga_id"])) {   //type
            $vloga_id = filter_input(INPUT_POST, 'vloga_id', FILTER_SANITIZE_SPECIAL_CHARS);
        }

        // stranka
        $naslov = null;
        $posta = null;
        $telefon = null;
        if (isset($_POST["naslov"]) && !empty($_POST["naslov"])) {
            $naslov = filter_input(INPUT_POST, 'naslov', FILTER_SANITIZE_SPECIAL_CHARS);
        }
        if (isset($_POST["posta"]) && !empty($_POST["posta"])) {
            $posta = filter_input(INPUT_POST, 'posta', FILTER_SANITIZE_SPECIAL_CHARS);
        }
        if (isset($_POST["telefon"]) && !empty($_POST["telefon"])) {
            $telefon = filter_input(INPUT_POST, 'telefon', FILTER_SANITIZE_SPECIAL_CHARS);
        }

        $idNovega = Uporabnik_B::insert(
            [
                //:ime, :priimek, :email, :geslo, :telefon, :naslov, :posta, :vloga_id, :aktiven, :aktivacija_hash, :certifikat_id
                "ime" => $ime, "priimek" => $priimek, "email" => $email, "geslo" => $geslo, "telefon" => $telefon,
                "naslov" => $naslov, "posta" => $posta, "vloga_id" => $vloga_id, "aktiven" => 0,
                "aktivacija_hash" => $aktiv_hash, "certifikat_id" => $cert_id
            ]
        );


        if (isset($_POST["registracija"]) && $_POST["registracija"] === "1") {       // registracija uporabnika
            header("Location:emailActivation?id=$idNovega&ime=$ime&email=$email");
            exit;
        } elseif ($_POST["vloga_id"] === "2") {                                      // prodajalec
            header("Location:prodajalci");
            exit;
        } elseif ($_POST["vloga_id"] === "3") {                                      // stranka
            header("Location:sellerpanel?manage");
            exit;
        }

    } else {
        header("refresh:5;url=register");
        echo "Registracija ni uspela.";
        exit;
    }
}

// nismo bili v nobenem if-u, preusmerimo na trgovino
header("Location:store");
