<?php
/**
 * [BootApp class qui se charge d'autoLoad les classes et re retourner la route au routeur]
 */
class BootApp
{

    public static function load(){
        session_start();
        require ROOT . '/app/AutoLoader.php';
        App\Autoloader::register();
        require ROOT . '/stickFramework/AutoLoader.php';
        StickFramework\Autoloader::register();
    }

    public function runApp($r){
        //on instancie la classe StickFramework
        $stickFramework = new StickFramework\StickFramework;
        $stickFramework->stickRouter->redirect($r);
    }

}


 ?>
