<?php

class Database
{
    private $host = 'localhost';
    private $username = 'root';
    private $password = 'root';
    private $db_name = 'projet4';

    protected function dbConnect() {
        try
        {
            $db = new PDO('mysql:host='.$this->host.';dbname='.$this->db_name.';charset=utf8', $this->username, $this->password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            return $db;
        }
        catch(Exception $e)
        {
            die('Erreur : '.$e->getMessage());
        }
    }
}