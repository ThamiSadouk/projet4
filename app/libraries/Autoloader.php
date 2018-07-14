<?php

namespace App\Libraries;

class Autoloader
{
    /**
     * va demander à exécuter un spl_autoload_register et va appeler autoload
     */
    static function register()
    {
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }


    /**
     * charge les libraries dynamiquement
     * @param $class string
     */
    static function autoload($class)
    {
        // Si les classes commencent par app\Libraries
        if(strpos($class, __NAMESPACE__ . '\\') === 0) {
            // supprime la chaine du namespace et remplace les antislash par des slash pour faire fonctionner le require
            $class = str_replace(__NAMESPACE__ . '\\', '', $class);
            $class = str_replace('\\', '/', $class);
            require '../app/libraries/' . $class . '.php';
        }

    }
}