<?php

use \App\Libraries\Database;
use \App\Entity\Post;
use \App\Entity\Comment;

/**
 * Class PostManager
 */
class PostManager extends Database
{
    /**
     * @return array mixed
     */
    public function getPosts()
    {
        $posts = [];
        $req = $this->pdo->query('
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

    /**
     * @param $postId int
     * @return Post mixed
     */
    public function getPostById($postId)
    {
        $req = $this->pdo->prepare('
            SELECT id, user_id 
            AS userId, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') creationDateFr
            FROM posts WHERE id = ?');

        $req->execute(array($postId));
        $data = $req->fetch();

        // si la variable n'est pas un booléen, retourne une class post avec en paramètres les données récupérées dans $post
        if(!is_bool($data)) {
            $post =  new Post($data);
            return $post;
        }
        return $data;
    }

    /**
     * @param $postId int
     * @return array mixed
     */
    public function getComments($postId)
    {
        $comments = [];
        $stmt = $this->pdo->prepare('
          SELECT id, author, comment, DATE_FORMAT(commentDate, \'%d/%m/%Y à %Hh%imin%ss\') 
          AS commentDateFr, signalement
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

    /**
     * @param Post $post
     * @return bool
     */
    public function addPost(Post $post)
    {
        $stmt = $this->pdo->prepare('
          INSERT INTO posts (title, user_id, content, creation_date)
          VALUES (:title, :user_id, :content, NOW())');

        $stmt->bindValue(':title', $post->getTitle());
        $stmt->bindValue(':user_id', $post->getUserId(), PDO::PARAM_INT);
        $stmt->bindValue(':content', $post->getContent());

        $postAdded =  $stmt->execute();

        return $postAdded;
    }

    /**
     * @param Post $post
     * @return bool
     */
    public function updatePost(Post $post)
    {
        $stmt = $this->pdo->prepare('
          UPDATE posts 
          SET title = :title, content = :content, creation_date = NOW()
          WHERE id = :id');

        $stmt->bindValue(':id', $post->getId(), PDO::PARAM_INT);
        $stmt->bindValue(':title', $post->getTitle());
        $stmt->bindValue(':content', $post->getContent());

        $postEdited = $stmt->execute();

        return $postEdited;
    }

    /**
     * @param $id
     * @return bool
     */
    public function deletePost($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM posts WHERE id = :id');
        $postDeleted = $stmt->execute(array('id' => $id));

        return $postDeleted;
    }
}