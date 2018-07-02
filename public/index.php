<?php
ini_set('display_errors', -1);
// charge fichier config
require '../app/config/config.php';

//charge les helpers
require_once '../app/helpers/session_helper.php';

// charge les librairies
require_once '../app/libraries/Core.php';
require_once '../app/libraries/BaseController.php';
require_once '../app/libraries/Database.php';

require_once '../app/entity/HydratorTrait.php';

require_once '../app/entity/Comment.php';
require_once '../app/entity/Post.php';


// Init Core Library
use \App\Libraries\Core;
$init = new Core;