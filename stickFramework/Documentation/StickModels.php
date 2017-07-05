<?php
/**
 * USER EXAMPLE
 */

use App\Models\User as User; // use the namespace of your model
$user = new User; // will return a new instance of the user model

$user = $user->getAll(); //will return an array of all the users
$user = $user->getById(1); //will return an object user by id as arg, with methods and values
$user = $user->getByField('userName','Francis'); // will return an object user selected by field(a single one) and value as arg, with methods and values


$params = array( //array of params
                'userName' => 'Justin',
                'userNickname' => 'Not this FCKNG bieber!',
                'userMail' => 'Justin@notbieber.com',
                'userIsActive' => 1
                );
$user->create($params); //will create a new user with params as arg


/**
 * GROUP EXAMPLE
 */

 $group = new Group;
 $params = array( //array of params
                 'groupName' => 'Confirmed',
                 );
 $lastId = $group->create($params,true); //will create a new group with params as arg and give back the last insertId, /*object*/ /*lastInsertId*/

?>
