<?php

use \App\Libraries\Database;

class PostManager extends Database
{
    public function getPosts()
    {
        $db = $this->dbConnect();
        $req = $db->query('
          SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') 
          AS creation_date_fr 
          FROM posts 
          ORDER BY creation_date 
          DESC LIMIT 0, 5');
        return $req;
    }

    public function getPostById($id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('
        SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') creation_date_fr 
        FROM posts WHERE id = ?');

        $req->execute(array($id));
        $post = $req->fetch();

        return $post;
    }
}