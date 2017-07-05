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
                $this->stickFramework = new StickFramework; // on instancie le framework
            }

            /**
             * [landingAccueil méthode de la page d'acceuil, recupere un utilisateur, affiche son nom et ses groupes et deux messages "flash"]
             * @return [type] [description]
             */
             public function landingAccueil(){
                 $user = new User; // on instancie le modèle User
                 $user->getbyId(2)->userGroups(); // on le récupere par son id, et on appel sa méthode userGroups();

                 //on utilise la classe View du framework pour definir un message
                 $this->stickFramework->stickView->setFlash(array( 'info' => 'Welcome to you new playground' , 'warning' => 'But carefull it\'s not really bugfree :D'));

                 //on utilise la méthode render() pour appeler la vue et lui passer les résultats en paramétres
                 $this->stickFramework->stickView->render('Accueil', array('userName'=> $user->values->userName ,'userGroups'=> $user->relateds['groups']),true);

             }

            /**
             * [sayHello méthode de la page d'acceuil, recupere un utilisateur, affiche son nom et ses groupes et un messages "flash"]
             * @return [type] [description]
             */
            public function sayHello(){
                $user = new User;
                $user = $user->getbyId(2);
                $this->stickFramework->stickView->setFlash(array( 'info' => 'hello '.$user->values->userName.' :)'));
                $this->stickFramework->stickView->render('', array());
            }

            /**
             * [sayGoodBye méthode de la page d'acceuil, recupere un utilisateur, affiche son nom et ses groupes et un messages "flash"]
             * @return [type] [description]
             */
            public function sayGoodBye(){
                $user = new User;
                $user = $user->getbyId(2);
                $this->stickFramework->stickView->setFlash(array( 'info' => 'good bye '.$user->values->userName.' ! hope to see you soon'));
                $this->stickFramework->stickView->render('', array());
            }

    }
?>
