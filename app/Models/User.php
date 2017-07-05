<?php
namespace App\Models;
use StickFramework\StickClass\StickModels as StickModels;

final class User extends StickModels
{
    /**
     * [__construct on peut appeler le constructeur de cette classe sans parametres pour l'instancier
     * mais il faut définir ses champs et le nom du champ de sa clef primaire]
     */
    public function __construct()   {
        //on doit définir le nom de la clef primaire a utiliser
        $this->primaryKey = 'userId';
        // SI les tables son préfixer ET SI on n'a pas définit le préfix dans les settings, alors il faut préciser le nom de la table
        // OU SINON SI la table ne porte pas le meme nom que la classe au pluriel
        // $this->table = 'stck_users';
        
        //on definit le nom des champs de la table
        $this->champs =  (object)array(
                            'userName',
                            'userNickname',
                            'userMail',
                            'userIsActive',
                            );

    }

    /**
     * [userGroups Méthode de récuperation des groupes de l'utilisateur]
     * RELATION  users 1,n <-> 0,n groups
     * @return [object] [retourne les groupes de l'utilisateur]
     */
    public function userGroups(){
        //methode haveManyToMany(); de la classe StickModels, prend en parametres; le namespace de la classe cible et la table de relation
        return $this->haveManyToMany('App\Models\Group','users_groups');
    }

    /**
     * [userPosts Méthode de récuperation des posts de l'utilisateur
     * RELATION  users 0,n <-> 1,1 posts
     * @return [type] [description]
     */
    public function userPosts(){
        //methode haveOneAndMany(); de la classe StickModels, prend en parametre le namespace de la classe cible
        return $this->haveOneAndMany('App\Models\Post');

    }

}

 ?>
