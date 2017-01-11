<?php

require_once("model/Uporabnik_B.php");
require_once("model/Log_B.php");
require_once("ViewHelper.php");

class UporabnikController {

    public static function login() {
        echo ViewHelper::render("view/login.html");
    }

    public static function adminLogin() {
        echo ViewHelper::render("loginAdmin/loginCert.php");
    }

    public static function sellerLogin() {
        echo ViewHelper::render("loginSeller/loginCert.php");
    }

    public static function checkLogin() {
        echo ViewHelper::render("controller/login.php");
    }

    public static function logout() {
        session_destroy();
        header("Location:store");
    }

    public static function register() {
        if (isset($_SESSION["idUporabnik"])) {
            header("Location:store");
            exit;
        } else {
            header("Location:sellerpanel?id=-1");
        }
    }

    public static function captcha() {
        echo ViewHelper::render("controller/captcha.php");
    }

    public static function emailActivation() {
        echo ViewHelper::render("controller/emailActivation.php");
    }

    public static function activateAccount() {
        if (isset($_GET["id"]) && isset($_GET["email"])) {
            $id = $_GET["id"];
            $email = $_GET["email"];
            $hash_iz_linka = $_GET["hash"];
            $hash_iz_serverja = hash_hmac('sha256', $email, 'nePoznasMe');

            $bazaUser = Uporabnik_B::get(["id" => $id]);
            if($bazaUser["email"] == $email && (0 == strcmp($hash_iz_linka, $hash_iz_serverja))) {
                Uporabnik_B::updateAktivno(["idUporabnik" => $id, "aktiven" => 1]);
                header("Location:login");
                exit;
            } else {
                header("Location:store");
                exit;
            }
        } else {
            header("Location:store");
            exit;
        }
    }

    public static function layout() {
        echo ViewHelper::render("view/includes/layout.html");
    }

    public static function poste() {
        echo ViewHelper::render("controller/shraniPoste.php");
    }

    public static function adminPanel() {
        echo ViewHelper::render("view/adminpanel.php");
    }

    public static function sellers() {
        echo ViewHelper::render("view/prodajalci.php");
    }

    public static function sellerPanel() {
        echo ViewHelper::render("view/sellerpanel.php");
    }

    public static function editUser() {
        echo ViewHelper::render("controller/userpanel.php");
    }

    public static function add() {
        $form = new BooksInsertForm("add_form");

        if ($form->isSubmitted() && $form->validate()) {
            $id = BookDB::insert($form->getValue());
            ViewHelper::redirect(BASE_URL . "books?id=" . $id);
        } else {
            echo ViewHelper::render("view/book-form.php", [
                "title" => "Add book",
                "form" => $form
            ]);
        }
    }

}
