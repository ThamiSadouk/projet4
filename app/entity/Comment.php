<?php

namespace App\Entity;

/**
 * Class Comment représente une entrée de la table posts enregistréé dans la BDD
 */
class Comment
{
    use HydratorTrait;
    private $id;
    private $postId;
    private $author;
    private $comment;
    private $commentDateFr;
    private $signalement;

    public function __construct($data)
    {
        $this->hydrate($data);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getPostId()
    {
        return $this->postId;
    }

    /**
     * @param mixed $postId
     */
    public function setPostId($postId)
    {
        $postId = (int) $postId;
        $this->postId = $postId;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return htmlspecialchars($this->author);
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return htmlspecialchars($this->comment);
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return mixed
     */
    public function getCommentDateFr()
    {
        return $this->commentDateFr;
    }

    /**
     * @param mixed $commentDateFr
     */
    public function setCommentDateFr($commentDateFr)
    {
        $this->commentDateFr = $commentDateFr;
        ;
    }

    /**
     * @return mixed
     */
    public function getSignalement()
    {
        return $this->signalement;
    }

    /**
     * @param mixed $signalement
     */
    public function setSignalement($signalement)
    {
        $this->signalement = $signalement;
    }


}