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

        $posts = $req->fetchAll();
        return $posts;
    }

    public function getPostById($postId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('
        SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') creation_date_fr 
        FROM posts WHERE id = ?');

        $req->execute(array($postId));
        $post = $req->fetch();

        return $post;
    }

    public function getComments($postId)
    {
        $db = $this->dbConnect();
        $stmt = $db->prepare('
          SELECT id, author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr 
          FROM comments 
          WHERE post_id = ? 
          ORDER BY comment_date DESC
    ');
        $stmt->execute(array($postId));
        $comments = $stmt->fetchAll();

        return $comments;
    }
}