<?php
/*
* Permet de stocker l'url APPROOT dans une constante pour l'appeler dans les autres fichiers
* la magic const APPROOT nous renvoie le chemin du fichier config.php
* dirname nous renvoie le chemin du dossier parent
* la fonction define permet de définir une constante
*/
define('APPROOT', dirname(dirname(__FILE__)));

// URL Root
define('URLROOT', 'http://localhost:8888/projet4');

// Site Name
define('SITENAME', 'Jean Forteroche');

//  BD Params
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'root');
define('DB_NAME', 'projet4');