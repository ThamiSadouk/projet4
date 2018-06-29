<?php


/**
 * Class Post représente une entrée de la table posts enregistréé dans la BDD
 */
class Post
{
    use HydratorTrait;
    private $id;
    private $title;
    private $content;
    private $creationDateFr;

    public function __construct($data)
    {
        $this->hydrate($data);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return htmlspecialchars($this->title);
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return htmlspecialchars($this->content);
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getCreationDateFr()
    {
        return $this->creationDateFr;
    }

    /**
     * @param mixed $creationDateFr
     */
    public function setCreationDateFr($creationDateFr)
    {
        $this->creationDateFr = $creationDateFr;
    }

}