<?php

use App\Models\User as User;
$user = new User;
$params = array(
                'userName' => 'Justin',
                'userNickname' => 'Not this FCKNG bieber!',
                'userMail' => 'Justin@notbieber.com',
                'userIsActive' => 1
                );
$user->create($params);

?>
