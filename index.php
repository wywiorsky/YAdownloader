<?php

if (empty($_GET['errors'])) {
    error_reporting(0);
} else {
    error_reporting(E_ALL);
}



// if localhost


if (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false) {

    $directory_a = explode("\\", __DIR__);
    $directory = end($directory_a);

    $request_a = explode($directory, $_SERVER['REQUEST_URI']);
} else {

    $request_a = explode($config_url, $_SERVER['REQUEST_URI']);
}

$request = $request_a[1];
$params = split("/", $request);



if (empty($params[1]) || $params[1] == 'download') {

    require_once '/./controler/mainControler.class.php';

    $main_controler = new mainControler;

    if (empty($_POST['action'])) {
        $main_controler->DisplayForm();
    }

    if ($_POST['action'] == 'getphotos') {
        $main_controler->GetPhotos($_POST);
    }
} else {

    header("Location:/" . $directory);
}
die();


