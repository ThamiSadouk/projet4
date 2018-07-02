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

    /*public function getComments($postId)
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
        $data = $stmt->fetchAll();

        if(!is_bool($data)) {
            foreach ($data as $info) {
            // retourne objet comments avec en paramètres les données récupérées dans $comments
                $comments[] =  new Comment($info);
            }
        }

        var_dump($comments);
        die();

        return $comments;
    }*/

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

    public function addPost($data)
    {
        $db = $this->dbConnect();
        $stmt = $db->prepare('
        INSERT INTO posts (title, user_id, content, creation_date)
        VALUES (:title, :user_id, :content, NOW())');

        $postAdded= $stmt->execute(array(
            'title' => $data['title'],
            'user_id' => $data['user_id'],
            'content' => $data['content']
        ));

        return $postAdded;
    }

    public function updatePost($data)
    {
        $db = $this->dbConnect();
        $stmt = $db->prepare('
          UPDATE posts 
          SET title = :title, content = :content, creation_date = NOW()
          WHERE id = :id');

        $postEdited = $stmt->execute(array(
            'id' => $data['id'],
            'title' => $data['title'],
            'content' => $data['content']
        ));

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