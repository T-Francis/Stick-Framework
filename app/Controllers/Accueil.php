<?php
// on se trouve dans le namespace;
namespace App\Controllers;
// on a besoin des classes qui se situe dans les namespaces suivant ;
use StickFramework\StickFramework as StickFramework;
use App\Models\User as User;

/**
 * [final description]
 * @var [type]
 */
final class Accueil
{
    /**
     * [__construct description]
     */
    public function __construct()   {
        $this->stickFramework = new StickFramework;
    }

    /**
     * [landingAccueil description]
     * @return [type] [description]
     */
    public function landingAccueil(){
        $user = new User;
        $targetTable = "stck_posts";
        $this->stickFramework->debug($user->getbyId(1)->userGroups()->haveOne($targetTable));
        $user = $user->getbyId(2)->userGroups();
        $this->stickFramework->stickView->setFlash(array( 'info' => 'Welcome to you new playground' , 'warning' => 'But carefull it\'s not really bugfree :D'));
        $this->stickFramework->stickView->render('Accueil', array('userName'=> $user->values->userName ,'userGroups'=> $user->values->groups),true);
    }

    /**
     * [sayHello description]
     * @return [type] [description]
     */
    public function sayHello(){
        $user = new User;
        $user = $user->getbyId(2)->userGroups();
        $this->stickFramework->stickView->setFlash(array( 'info' => 'hello '.$user->values->userName.' :)'));
        $this->stickFramework->stickView->render('', array());
    }

    /**
     * [sayGoodBye description]
     * @return [type] [description]
     */
    public function sayGoodBye(){
        $user = new User;
        $user = $user->getbyId(2)->userGroups();
        $this->stickFramework->stickView->setFlash(array( 'info' => 'good bye '.$user->values->userName.' ! hope to see you soon'));
        $this->stickFramework->stickView->render('', array());
    }

}


?>
