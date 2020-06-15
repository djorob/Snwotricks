<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;



/**
* @ORM\Entity()
* @ORM\Table(name="Forum")
* */
class Forum
{
    /**
    * @ORM\Id()
    * @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(type="integer")
    */
    public $id;

    /**
    * @ORM\Column(type="date")
    * @Assert\Date
    */
    public $createdAt;

    /**
    * @ORM\Column(type="text")
    * @Assert\Length(min=8, max=255)
    */
    public $content;

   

    /**
    * @ORM\Column(type="integer")
    */
    public $userId;

    /**
    * @ORM\Column(type="integer")
    */
    public $figureId;

   

    //Un forum a plusieurs a potentiellement user
   


     /**  
     * @ORM\ManyToOne(targetEntity="App\Entity\Figure", inversedBy="forum")
     * @ORM\JoinColumn(name="figureId", referencedColumnName="id")
     */
    private $figure;

    /**  
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="forum")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id")
     */
    private $user;



     public function __construct() {
       $this->user = new ArrayCollection();
        $this->figure = new ArrayCollection();
        $this->forum = new ArrayCollection();
    }



  public function getId()
  {
    return $this->id;
  }

  public function setId($Id)
  {
    $this->id = $Id;
  }

  public function getCreatedAt()
  {
    return $this->createdAt;
  }

  public function setCreatedAt($CreatedAt)
  {
    $this->createdAt = $CreatedAt;
  }

  public function getContent()
  {
    return $this->content;
  }

  public function setContent($Content)
  {
    $this->content = $Content;
  }

  public function getUserId()
  {
    return $this->userId;
  }

  public function setUserId($UserId)
  {
    $this->userId = $UserId;
  }

  public function getFigureId()
  {
    return $this->figureId;
  }

  public function setFigureId($figureId)
  {
    $this->figureId = $figureId;
  }

  public function getUser()
  {
    return $this->user;
  }

  public function setUser($user)
  {
    $this->user = $user;
  }

  public function getFigure()
  {
    return $this->figure;
  }

  public function setFigure($figure)
  {
    $this->figure = $figure;
  }
    
}