<?php
/**
 * Created by PhpStorm.
 * User: ep
 * Date: 07.01.2015
 * Time: 20:37
 */

    session_start();
    $authorized_users = ["administrator"];

    $client_cert = filter_input(INPUT_SERVER, "SSL_CLIENT_CERT");

    if ($client_cert == null) {
        die('err: Spremenljivka SSL_CLIENT_CERT ni nastavljena.');  #nismo na zavarovanem kanalu
    }

    $cert_data = openssl_x509_parse($client_cert);  #sparsamo podatke
    $commonname = (is_array($cert_data['subject']['CN']) ?
        $cert_data['subject']['CN'][0] : $cert_data['subject']['CN']);  #cn = common name
    $email = (is_array($cert_data['subject']['emailAddress']) ?
        $cert_data['subject']['emailAddress'][0] : $cert_data['subject']['emailAddress']);
    if (in_array($commonname, $authorized_users)) {
        echo "$email\n";
        echo "certifikat sprejet.";
        $_SESSION["certRole"] = 1;
        $_SESSION["pE"] = $email;
    //    echo "<p>Vsebina certifikata: ";
    //    var_dump($cert_data);


    } else {
        echo "$commonname ni avtoriziran uporabnik!";
    }

    header("refresh:2;url=../login");


    exit;
?>