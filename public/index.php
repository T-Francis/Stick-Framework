<?php
//************************************
// INDEX CONTROLLERS
//************************************

define('ROOT', dirname(__DIR__));
require ROOT . '/app/BootApp.php';
BootApp::load();

$bootApp = new BootApp;

if(isset($_GET['r'])){
    $r = $_GET['r'];
}else{
    $r = '/';
}

$bootApp->runApp($r);

?>
