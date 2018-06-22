<?php

use \App\Libraries\Database;

class CommentManager extends Database
{
    public function addComment($data)
    {
        $db = $this->dbConnect();
        $stmt = $db->prepare('
          INSERT INTO comments(post_id, author, comment, comment_date) 
          VALUES (?, ?, ?, NOW())');
        $commentAdded = $stmt->execute(array($data['postId'], $data['author'], $data['comment']));

        return $commentAdded;
    }
}