<?php
/**
 * EXAMPLE
 */

//on use le namespace de la classe StickFramework;
use StickFramework;
//on instancie la classe StickFramework;
$stickFramework = new StickFramework\StickFramework;

// fake datas;
$userName = "Balthazar";
$userGroup = "Admin";
$updatedId = 102;

//tableaux associatif de logs [ "LogLabel" => "message"];
$logs = array('Update User' => $userName . " du groupe " . $userGroup . ' a modifier l\'id : '. $updatedId);

// utilise la méthode log qui prend en paramètres un tableaux;
$stickFramework->stickFramework->stickLogger->logger($logs);
?>
