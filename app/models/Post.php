<?php

class Post
{
    private $db;

    public function getPosts()
    {
        $this->db = $this->dbConnect();
        $req = $this->db->query('
          SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') 
          AS creation_date_fr 
          FROM posts 
          ORDER BY creation_date 
          DESC LIMIT 0, 5');

        return $req;
    }

    public function dbConnect()
    {
        try
        {
            $this->db = new PDO('mysql:host=localhost;dbname=projet4;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

            return $this->db;
        }
        catch(Exception $e)
        {
            die('Erreur : '.$e->getMessage());
        }
    }
}