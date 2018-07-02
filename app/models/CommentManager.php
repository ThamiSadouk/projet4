<?php

use \App\Libraries\Database;

class CommentManager extends Database
{
    public function addComment($data)
    {
        $db = $this->dbConnect();
        $stmt = $db->prepare('
          INSERT INTO comments(postId, author, comment, commentDate) 
          VALUES (?, ?, ?, NOW())');
        $commentAdded = $stmt->execute(array($data['postId'], $data['author'], $data['comment']));

        return $commentAdded;
    }

    public function signalComment($idComment) {
        $db =   $this->dbConnect();
        $stmt = $db->prepare('
            UPDATE comments SET  signalement = true WHERE id = ?
        ');
        return $stmt->execute(array($idComment));
    }
}