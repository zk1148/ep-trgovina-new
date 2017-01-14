<?php


require_once 'static/swiftmailer-5.x/lib/swift_required.php';

if (isset($_GET["id"]) && isset($_GET["ime"]) && isset($_GET["email"])) {
    $id = $_GET["id"];
    $ime = $_GET["ime"];
    $email = $_GET["email"];
    $aktiv_hash = hash_hmac('sha256', $email, 'nePoznasMe');
    $url = "http://localhost/netbeans/trgovina/activate?id=$id&email=$email&hash=$aktiv_hash";
} else {
    header("refresh:5;url=store");
    echo "Ni parametrov za posiljanje aktivacijske povezave na elektronski naslov.";
    exit;
}

$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, "ssl")
    ->setUsername('best.super.awesome4937@gmail.com')
    ->setPassword('testiranje');

$mailer = Swift_Mailer::newInstance($transport);

$message = Swift_Message::newInstance('Aktivacija racuna v 3xK')
    ->setFrom(array('best.super.awesome4937@gmail.com' => '3xK'))
    ->setTo(array($email))
    ->setBody(
    'Pozdravljeni,

    pošiljamo vam povezavo za aktivacijo uporabniškega računa v trgovini 3xK:
    '. $url . '

    Lep dan še naprej!');

$result = $mailer->send($message);

echo "Uspeh posiljanja aktivacijskega emaila: " . $result;
header("refresh:5;url=login");
