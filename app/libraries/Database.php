<?php

namespace App\Libraries;

class Database
{
    private $host = DB_HOST;
    private $username = DB_USER;
    private $password = DB_PASS;
    private $dbname = DB_NAME;

    protected function dbConnect() {
        try
        {
            // Déclaration d'une instance PDO
            $db = new \PDO('mysql:host='.$this->host.';dbname='.$this->dbname.';charset=utf8', $this->username, $this->password, array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
            // établit attribut 'fetch' en tant qu'objet
            return $db;
        }
        catch(\Exception $e)
        {
            die('Erreur : '.$e->getMessage());
        }
    }
}