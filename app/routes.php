<?php
// tableaux de route, la clef du tableaux représente la route, la valeur le endPoint souhaiter pour la route
// le endPoint a une syntaxe a respecter :  "nomDeLaClasse.nomDeLaMethode"
return array(
    "/" =>                                         "Accueil.landingAccueil",
    "firstroute" =>                                      "Accueil.sayHello",
    "secondroute" =>                                     "Accueil.sayGoodBye",
);
 ?>
