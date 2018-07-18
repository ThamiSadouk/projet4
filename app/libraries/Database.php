<?php

namespace App\Libraries;


/**
 * Class Database Se connecte à la BDD
 * @package App\Libraries
 */
class Database
{
    private $host = DB_HOST;
    private $username = DB_USER;
    private $password = DB_PASS;
    private $dbname = DB_NAME;

    protected $pdo;

    public function __construct()
    {
        $this->dbConnect();
    }

    /**
     * gère la connection avec la BDD
     * @return \PDO
     */
    private function dbConnect()
    {
        // set DSN
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        $options = [
            \PDO::ATTR_PERSISTENT => true, // améliore les performances en cherchant si une connection est déjà établie avec la db
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        ];

        try
        {
            $this->pdo = new \PDO($dsn, $this->username, $this->password, $options);
            return $this->pdo;
        }
        catch(\Exception $e)
        {
            die('Erreur : ' .$e->getMessage());
        }
    }
}