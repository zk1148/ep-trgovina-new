<?php

try {
    if ($_POST["email"] != null && !empty($_POST["email"])) {
        $username = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
        $result = Uporabnik_B::getUser(["email" => $username]);
    } else {
        header("refresh:5;url=login");
        echo "Vnesite uporabnisko ime.";
        exit;
    }

    if ($result["vloga_id"] == 1) {
        if (!(isset($_SESSION["certRole"]) && $_SESSION["certRole"] == 1)) {
            // prijaviti se je zelel administrator, vendar ni podal certifikata
            header("refresh:5;url=./loginAdmin/loginCertAdmin.php");
            echo "Niste podali certifikata administratorja.";
            exit;
        }
    } else if ($result["vloga_id"] == 2) {
        if (!(isset($_SESSION["certRole"]) && $_SESSION["certRole"] == 2)) {
            // prijaviti se je zelel prodajalec, vendar ni podal certifikata
            header("refresh:5;url=./loginSeller/loginCertSeller.php");
            echo "Niste podali certifikata prodajalca.";
            exit;
        }
    }

    if ((isset($_SESSION["pE"])) && ($_SESSION["pE"]) != $result["email"]) {
        header("refresh:5;url=login");
        echo "Certifikat se ne ujema z uporabniškim imenom.";
        exit;

    }
//(!(isset($_SESSION["pE"])) && ($_SESSION["pE"]) == $result["email"])


//    if ($_POST["password"] != $result["geslo"]) {
//        echo $result["geslo"]."\n"; echo password_hash($_POST["password"], PASSWORD_BCRYPT)."\n";
//        echo SHA1($_POST["password"])."\n";
//        if ($result["geslo"] === SHA1($_POST["password"])) {
//            echo "tinaaaa";
//            $_SESSION["idUporabnik"] = $result["idUporabnik"];
//            $_SESSION["vloga_id"] = $result["vloga_id"];
//
//            if ($result["vloga_id"] == "1") {
//                Log_B::insert(["idUporabnik" => $result["idUporabnik"], "komentar" => "Prijava administratorja."]);
//                header("Location:adminpanel");
//            } elseif ($result["vloga_id"] == "2") {
//                Log_B::insert(["idUporabnik" => $result["idUporabnik"], "komentar" => "Prijava prodajalca."]);
//                header("Location:sellerpanel");
//            } else
//                header("Location:store");
//
//
//
//            exit;
//        }
//
//    }
//    else {
//        if (password_verify($_POST["password"], ($result["geslo"]))) {
//            $_SESSION["idUporabnik"] = $result["idUporabnik"];
//            $_SESSION["vloga_id"] = $result["vloga_id"];
//
//            if ($result["vloga_id"] == "1") {
//                Log_B::insert(["idUporabnik" => $result["idUporabnik"], "komentar" => "Prijava administratorja."]);
//                header("Location:adminpanel");
//            } elseif ($result["vloga_id"] == "2") {
//                Log_B::insert(["idUporabnik" => $result["idUporabnik"], "komentar" => "Prijava prodajalca."]);
//                header("Location:sellerpanel");
//            } else
//                header("Location:store");
//            exit;
//        }
//        else {
//            header("refresh:5;url=login");
//            echo "Napacno geslo.";
//            exit;
//        }
//    }

    if (password_verify($_POST["password"], ($result["geslo"]))) {
        $_SESSION["idUporabnik"] = $result["idUporabnik"];
        $_SESSION["vloga_id"] = $result["vloga_id"];

        if ($result["vloga_id"] == "1") {
            Log_B::insert(["idUporabnik" => $result["idUporabnik"], "komentar" => "Prijava administratorja."]);
            header("Location:adminpanel");
        } elseif ($result["vloga_id"] == "2") {
            Log_B::insert(["idUporabnik" => $result["idUporabnik"], "komentar" => "Prijava prodajalca."]);
            header("Location:sellerpanel");
        } else {
            header("Location:store");
        }
        exit;
    } elseif ($result["geslo"] === SHA1($_POST["password"])) {
        $_SESSION["idUporabnik"] = $result["idUporabnik"];
        $_SESSION["vloga_id"] = $result["vloga_id"];

        if ($result["vloga_id"] == "1") {
            Log_B::insert(["idUporabnik" => $result["idUporabnik"], "komentar" => "Prijava administratorja."]);
            header("Location:adminpanel");
        } elseif ($result["vloga_id"] == "2") {
            Log_B::insert(["idUporabnik" => $result["idUporabnik"], "komentar" => "Prijava prodajalca."]);
            header("Location:sellerpanel");
        } else {
            header("Location:store");
        }
        exit;
    } else {
        header("refresh:5;url=login");
        echo "Napacno geslo.";
        exit;
    }



//    if ($result["geslo"] === SHA1($_POST["password"])) {


} catch (InvalidArgumentException $e) {
    header("refresh:5;url=login");
    echo($e->getMessage());
}
