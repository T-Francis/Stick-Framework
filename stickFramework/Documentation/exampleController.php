<?php
namespace App\Controllers;
use StickFramework\StickFramework as StickFramework;
use App\Models\User as User;
use App\Models\Group as Group;

final class Accueil
{

    public function __construct()   {
        $this->stickFramework = new StickFramework;
    }

     public function landingAccueil(){
         $user = new User;
         $user->getbyId(2)->userGroups();
         $this->stickFramework->stickView->setFlash(array( 'info' => 'Welcome to you new playground' , 'warning' => 'But carefull it\'s not really bugfree :D'));
         $this->stickFramework->stickView->render('Accueil', array('userName'=> $user->values->userName ,'userGroups'=> $user->relateds['groups']),true);
     }

    public function sayHello(){
        $user = new User;
        $user = $user->getbyId(2);
        $this->stickFramework->stickView->setFlash(array( 'info' => 'hello '.$user->values->userName.' :)'));
        $this->stickFramework->stickView->render('', array());
    }

    public function sayGoodBye(){
        $user = new User;
        $user = $user->getbyId(2);
        $this->stickFramework->stickView->setFlash(array( 'info' => 'good bye '.$user->values->userName.' ! hope to see you soon'));
        $this->stickFramework->stickView->render('', array());
    }

}


?>
