<?php

// charge fichier config
require '../app/config/config.php';

//charge les helpers
require_once '../app/helpers/session_helper.php';
// charge le les librairies
require_once '../app/libraries/Core.php';
require_once '../app/libraries/BaseController.php';
require_once '../app/libraries/Database.php';

// Init Core Library
use \App\Libraries\Core;
$init = new Core;