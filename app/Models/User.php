<?php
namespace App\Models;
use StickFramework\StickClass\StickModels as StickModels;

final class User extends StickModels
{

    public function __construct()   {
        $this->primaryKey = 'userId';
        $this->champs =  array(
                            'userName',
                            'userNickname',
                            'userMail',
                            'userIsActive',
                            );
        $this->values = null;
    }

    public function userSetGroup(){

    }

    public function userGroups(){
        $targetTable = 'groups';
        $pivot = 'users_groups';
        $this->getManyToMany($targetTable,$pivot);
        return $this;
    }

}

 ?>
