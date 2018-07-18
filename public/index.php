<?php

use \App\Autoloader;

ini_set('display_errors', -1);
// charge fichier config
require '../app/config/config.php';

//charge les helpers
require_once '../app/helpers/session_helper.php';

// charge les librairies
require '../app/Autoloader.php';
Autoloader::register();

// Init Core Library
$init = new \App\Libraries\Core();