<?php

use \App\Libraries\Database;
use App\Entity\Comment;


/**
 * Class CommentManager
 */
class CommentManager extends Database
{
    /**
     * @param $comment
     * @return bool
     */
    public function addComment(Comment $comment)
    {
        $stmt = $this->pdo->prepare('
          INSERT INTO comments(postId, author, comment, commentDate) 
          VALUES (:postId, :author, :comment, NOW())');

        //$commentAdded = $stmt->execute(array($data['postId'], $data['author'], $data['comment']));
        $stmt->bindValue(':postId', $comment->getPostId(), PDO::PARAM_INT);
        $stmt->bindValue(':author', $comment->getAuthor());
        $stmt->bindValue(':comment', $comment->getComment());


        $commentAdded =  $stmt->execute();



        return $commentAdded;
    }

    /**
     * @param $idComment
     * @return bool
     */
    public function signalComment($idComment)
    {
        $stmt = $this->pdo->prepare('
            UPDATE comments SET  signalement = true WHERE id = ?
        ');
        return $stmt->execute(array($idComment));
    }

    public function deleteComments($postId)
    {
        $stmt = $this->pdo->prepare('DELETE FROM comments WHERE postId = ?');
        $result = $stmt->execute([$postId]);

        return $result;
    }
}