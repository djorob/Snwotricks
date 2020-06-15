<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
* @ORM\Table(name="Figure")
* @ORM\Entity
* @UniqueEntity("Nom")
* */
class Figure
{
    /**
    * @ORM\Id()
    * @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(type="integer")
    */
    public $Id;

    /**
    * @ORM\Column(type="string")
    * @Assert\Length(min=4, max=255)
    */
    public $Nom;

    /**
    * @ORM\Column(type="text")
    * @Assert\Length( max=255)
    */
    public $Description;

    /**
    * @ORM\Column(type="text")
    */
    public $GroupeFigure;

    /**
    * @ORM\Column(type="text")
    * @Assert\Url
    */
    public $LienVideo;

    /**
    * @ORM\Column(type="text")
    * @Assert\Url
    */
    public $LienPhoto;


    /**
    * @ORM\Column(type="integer")
    */
    private $userId;

    
    

    //les figures sont liées a un user

    /**  
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="figure")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id")
     */
    private $user;

    /**  
     * @ORM\OneToMany(targetEntity="App\Entity\Forum", mappedBy="figure")
     */

    public $forum;

    public function __construct() {
       $this->user = new ArrayCollection();
       $this->forum = new ArrayCollection();
   }
    

  //getter and setter


  public function getId()
  {
    return $this->Id;
  }

  public function setId($Id)
  {
    $this->Id = $Id;
  }
  public function getNom()
  {
    return $this->Nom;
  }

  public function setNom($nom)
  {
    $this->Nom = $nom;
  }

  public function getDescription()
  {
    return $this->Description;
  }

  public function setDescription($Description)
  {
    $this->Description = $Description;
  }

  public function getLienVideo()
  {
    return $this->LienVideo;
  }

  public function setLienVideo($LienVideo)
  {
    $this->LienVideo = $LienVideo;
  }

  public function getGroupeFigure()
  {
    return $this->GroupeFigure;
  }

  public function setGroupeFigure($GroupeFigure)
  {
    $this->GroupeFigure = $GroupeFigure;
  }

  public function getLienPhoto()
  {
    return $this->LienPhoto;
  }

  public function setLienPhoto($LienPhoto)
  {
    $this->LienPhoto = $LienPhoto;
  }

  public function getUserId()
  {
    return $this->userId;
  }

  public function setUserId($userId)
  {
    $this->userId = $userId;
  }

  public function setUser($user)
  {
    $this->user = $user;
  }
  


  
}