<?php

use \App\Libraries\Database;

class PostManager extends Database
{
    public function getPosts()
    {
        $posts = [];
        $db = $this->dbConnect();
        $req = $db->query('
          SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') 
          AS creationDateFr
          FROM posts 
          ORDER BY creation_date 
          DESC LIMIT 0, 5');

        $data = $req->fetchAll();
        if(!is_bool($data)) {
            foreach ($data as $info) {
                // retourne objet comments avec en paramètres les données récupérées dans $comments
                $posts[] =  new Post($info);
            }
        }
        return $posts;
    }

    public function getPostById($postId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('
            SELECT id, user_id 
            AS userId, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') creationDateFr
            FROM posts WHERE id = ?');

        $req->execute(array($postId));
        $data = $req->fetch();

        // si la varialble n'est pas un booléen, retourne une class post avec en paramètres les données récupérées dans $post
        if(!is_bool($data)) {
            $post =  new Post($data);
            return $post;
        }
        return $data;
    }

    public function getComments($postId)
    {
        $comments = [];
        $db = $this->dbConnect();
        $stmt = $db->prepare('
      SELECT id, author, comment, DATE_FORMAT(commentDate, \'%d/%m/%Y à %Hh%imin%ss\') AS commentDateFr, signalement
      FROM comments 
      WHERE postId = ?
      ORDER BY commentDateFr DESC
');
        $stmt->execute(array($postId));

        while ($data = $stmt->fetch()) {
            $comments[] = new Comment($data);
        }

        return $comments;
    }

    public function addPost(Post $post)
    {
        $db = $this->dbConnect();
        $stmt = $db->prepare('
          INSERT INTO posts (title, user_id, content, creation_date)
          VALUES (:title, :user_id, :content, NOW())');

        $stmt->bindValue(':title', $post->getTitle());
        $stmt->bindValue(':user_id', $post->getUserId(), PDO::PARAM_INT);
        $stmt->bindValue(':content', $post->getContent());

        $postAdded =  $stmt->execute();

        return $postAdded;
    }

    public function updatePost(Post $post)
    {
        $db = $this->dbConnect();
        $stmt = $db->prepare('
          UPDATE posts 
          SET title = :title, content = :content, creation_date = NOW()
          WHERE id = :id');

        $stmt->bindValue(':id', $post->getId(), PDO::PARAM_INT);
        $stmt->bindValue(':title', $post->getTitle());
        $stmt->bindValue(':content', $post->getContent());

        $postEdited = $stmt->execute();

        return $postEdited;
    }

    public function deletePost($id)
    {
        $db = $this->dbConnect();
        $stmt = $db->prepare('DELETE FROM posts WHERE id = :id');
        $postDeleted = $stmt->execute(array('id' => $id));

        return $postDeleted;
    }
}