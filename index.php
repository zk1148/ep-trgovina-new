<?php

// enables sessions for the entire app
session_start();

require_once("controller/IzdelkiController.php");
require_once("controller/UporabnikController.php");
require_once("controller/ProductPanelController.php");
require_once("controller/SlikaController.php");
require_once("controller/CartController.php");
require_once("controller/NarocilaController.php");

//require_once("test/NarociloDBTest.php");
//require_once("test/UporabnikDBTest.php");
//require_once("test/IzdelekDBTest.php");
//require_once("test/OcenaIzdelkaDBTest.php");
//require_once("test/PostavkaNarociloDBTest.php");
//require_once("test/PrijavaLogTest.php");
//require_once("test/SlikaIzdelekDBTest.php");

define("BASE_URL", rtrim($_SERVER["SCRIPT_NAME"] , "index.php"));
define("IMAGES_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/images/");
define("CSS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/css/");
define ('SITE_ROOT', realpath(dirname(__FILE__)));

$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";

// ROUTER: defines mapping between URLS and controllers
$urls = [
    "login" => function () {
        UporabnikController::login();
    },
    "loginAdmin/loginCertAdmin.php" => function () {
        UporabnikController::adminLogin();
    },
    "loginSeller/loginCertSeller.php" => function () {
        UporabnikController::sellerLogin();
    },
    "checkLogin" => function () {
        UporabnikController::checkLogin();
    },
    "logout" => function () {
        UporabnikController::logout();
    },
    "register" => function () {
        UporabnikController::register();
    },
    "captcha" => function () {
        UporabnikController::captcha();
    },
    "emailActivation" => function () {
        UporabnikController::emailActivation();
    },
    "activate" => function () {
        UporabnikController::activateAccount();
    },
    "shraniPoste" => function () {
        UporabnikController::poste();
    },
    "adminpanel" => function () {
        UporabnikController::adminPanel();
    },
    "prodajalci" => function () {
        UporabnikController::sellers();
    },
    "sellerpanel" => function () {
        UporabnikController::sellerPanel();
    },
    "productpanel" => function () {
        ProductPanelController::panel();
    },
    "userpanel" => function () {
        UporabnikController::editUser();
    },
    "store" => function () {
        IzdelkiController::index();
    },
    "store/oceni" => function () {
        IzdelkiController::oceni();
    },
    "cart" => function(){
        CartController::index();
    },
    "cart/ajax" => function(){
        CartController::ajax();
    },
    "cart/oddaj" => function(){
        CartController::oddajNarocilo();
    },
    "narocila" => function(){
        NarocilaController::index();
    },
    "narocila/akcije" => function(){
        NarocilaController::akcije();
    },
    "addproduct" => function(){
        ProductPanelController::add();
    },
    "editproduct" => function(){
        ProductPanelController::edit();
    },
    "slike" => function () {
        SlikaController::controller();
    },
    "api" => function () {
        IzdelkiController::rest();
    },
    "testNarocilo" => function () {
        NarociloDBTest::index();
    },
    "testUporabnik" => function () {
        UporabnikDBTest::index();
    },
    "testIzdelek" => function () {
        IzdelekDBTest::index();
    },
    "testOcena" => function () {
        OcenaIzdelkaDBTest::index();
    },
    "testPostavka" => function () {
        PostavkaNarociloDBTest::index();
    },
    "testLog" => function () {
        PrijavaLogTest::index();
    },
    "testSlika" => function () {
        SlikaIzdelekDBTest::index();
    },
    "" => function () {
        ViewHelper::redirect("store");
    },
];

try {
    if (isset($urls[$path])) {
        $urls[$path]();
    } else {
        echo "No controller for '$path'";
    }
} catch (InvalidArgumentException $e) {
    ViewHelper::error404();
} catch (Exception $e) {
    echo "An error occurred: <pre>$e</pre>";
} 
