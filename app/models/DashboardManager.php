<?php

/**
 * Class DashboardManager
 */
class DashboardManager extends \App\Libraries\Database
{
    /**
     * Obtient le nombre de ligne pour les tables chaque tables
     */
    public function inTable()
    {
        $stmt = $this->pdo->query(
            "SELECT 'members', COUNT(*)
            FROM members 
            UNION 
            SELECT 'posts', COUNT(*)
            FROM posts
            UNION
            SELECT 'comments', COUNT(*)
            FROM comments");
        $data = $stmt->fetchAll();
        return $data;
    }

    /**
     * renvoie les commentaires qui ont été signalés
     * @return array mixed
     */
    public function getComments()
    {
        $stmt = $this->pdo->query(
            "SELECT 
            comments.id, 
            comments.postId, 
            comments.author, 
            comments.comment, 
            comments.signalement,
            DATE_FORMAT(comments.commentDate, '%d/%m/%Y à %Hh%imin%ss') AS commentDateFr, 
            posts.title
            FROM comments
            JOIN posts
            ON  comments.postId = posts.id
            ORDER BY comments.signalement DESC");

        $results = $stmt->fetchAll(PDO::FETCH_OBJ);
//WHERE comments.signalement = true
        return $results;
    }


    /**
     * supprime un commentaire
     * @param $id int
     * @return bool
     */
    public function deleteComment($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM Comments WHERE id = :id');
        $commentDeleted = $stmt->execute(array('id' => $id));

        return $commentDeleted;
    }


    /**
     * valide un commentaire signalé et remet sa valeur à 0
     * @param $id int
     * @return bool
     */
    public function seeComment($id)
    {
        $stmt = $this->pdo->prepare('
            UPDATE comments SET  signalement = false WHERE id = ?
        ');
        return $stmt->execute(array($id));
    }
}