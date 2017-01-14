<?php


require_once(dirname(__FILE__).'/../model/Izdelek_B.php');
require_once(dirname(__FILE__).'/../model/Slika_B.php');

header('Content-Type: application/json');

$http_method = filter_input(INPUT_SERVER, "REQUEST_METHOD", FILTER_SANITIZE_SPECIAL_CHARS);
$server_addr = "10.0.2.2"; // kadar dostopamo preko Android emulatorja
$php_self = filter_input(INPUT_SERVER, "PHP_SELF", FILTER_SANITIZE_SPECIAL_CHARS);
$script_uri = substr($php_self, 0, strripos($php_self, "/"));
$request = filter_input(INPUT_GET, "request", FILTER_SANITIZE_SPECIAL_CHARS);


$return_url = "/api/";

$rules = array(
    'id' => array(
        'filter' => FILTER_VALIDATE_INT,
        'options' => array('min_range' => 1)
    ),
);

function returnError($code, $message)
{
    http_response_code($code);
    echo json_encode($message);
    exit();
}

if ($request != null) {
    $path = explode("/", $request);
} else {
    returnError(400, "Missing request path.");
}

if (isset($path[0])) {
    $resource = $path[0];
} else {
    returnError(400, "Missing resource.");
}

if (isset($path[1])) {
    $param = $path[1];
} else {
    $param = null;
}

switch ($resource) {
    case "izdelki":
        if ($http_method == "GET" && $param == null) {
            // prva slika app
            $izdelki = Izdelek_B::getAllRest();
            echo json_encode($izdelki);
        } else if ($http_method == "GET" && $param != null) {
            // za drugo sliko
            $izdelek = Izdelek_B::getRest(["id" => $param]);
            if ($izdelek != null) {

                echo json_encode($izdelek);
            } else {
                returnError(404, "No entry for id: " . $param);
            }
        } else {
            // error
            echo "evo me";
            echo returnError(404, "Unknown request: [$http_method $resource]");
        }
        break;
    default:
        returnError(404, "Invalid resource: " . $resource);
        break;
}
