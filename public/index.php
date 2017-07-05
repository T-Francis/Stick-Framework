<?php
//************************************
// INDEX CONTROLLERS
//************************************

// on définit le dossier ROOT
define('ROOT', dirname(__DIR__));
require ROOT . '/app/BootApp.php';

// on appel la class Boot App qui charge les classe
BootApp::load();

// on instancie app
$bootApp = new BootApp;

// récupération de la route en parametre GET
if(isset($_GET['r'])){
    $r = $_GET['r'];
}else{
    $r = '/';
}

// on lance app avec la route en parametre
$bootApp->runApp($r);

?>
