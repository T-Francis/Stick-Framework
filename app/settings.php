<?php
//tableaux de settings
return array(
    'settings' => array(
        'paths' => array(
            'pathModels' => ROOT.'/app/Models/',
            'pathViews' => ROOT.'/app/Views/',
            'pathPublic' => ROOT.'/public/',
            'pathLogs' => ROOT.'/logs/',
            'uploadedFiles' => '',
            'test' => ROOT,
        ),
        'db' => array(
            'dbHost' => 'localhost',
            'dbDriver' => 'mysql',
            'dbLogin' => 'root',
            'dbPsw' => 'root',
            'dbName' => 'stickframework',
            'dbCharset' => 'utf8',
            'dbCollation' => 'utf8_unicode_ci',
            'prefix' => 'stck_',
        ),
        'logo' => '/ressources/img/logo.png',
        'appName' => 'Stick Framework'
    )
);
