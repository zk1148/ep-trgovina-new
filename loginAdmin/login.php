<?php
/**
 * Created by PhpStorm.
 * User: ep
 * Date: 30.12.2015
 * Time: 15:37
 */

try {
    if ($_POST["email"] != null && !empty($_POST["email"])) {
        $username = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
        $result = Uporabnik_B::getUser(["email" => $username]);
    } else {
        header("refresh:5;url=login");
        echo "Vnesite uporabnisko ime.";
        exit;
    }

    if (password_verify($_POST["password"], $result["geslo"])) {
    //if ($result["geslo"] === SHA1($_POST["password"])) {

        $_SESSION["idUporabnik"] = $result["idUporabnik"];
        $_SESSION["vloga_id"] = $result["vloga_id"];
        if($_REQUEST['email'] == $result["email"]) {
            echo "Certificirana prijava uspela.";
        }

        if ($result["vloga_id"] === "1") {
            Log_B::insert(["idUporabnik" => $result["idUporabnik"]]);
            header("Location:adminpanel");
        }
        elseif ($result["vloga_id"] === "2") {
            Log_B::insert(["idUporabnik" => $result["idUporabnik"]]);
            header("Location:sellerpanel");
        }
        else
            header("Location:store");
        exit;

    } else {
        header("refresh:5;url=login");
        echo "Napacno geslo. baza: " . $result["geslo"] . " Vtipkano: " . $_POST["password"];
        exit;
    }
} catch (InvalidArgumentException $e) {
    header("refresh:5;url=login");
    echo($e->getMessage());
}