<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;



/**
* @ORM\Entity()
* @ORM\Table(name="User")
* */
class User implements UserInterface
{
    /**
    * @ORM\Id()
    * @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(type="integer")
    */
    public $id;

    /**
    * @ORM\Column(type="string")
    * @Assert\Length(min=4, max=255)
    */
    public $nom;

    /**
    * @ORM\Column(type="text")
    * @Assert\Length(min=4, max=255)
    */
    public $prenom;

    /**
    * @ORM\Column(type="text")
    * @Assert\Url
    */
    public $lien_photo;

    /**
    * @ORM\Column(name="email", type="string", length=255)
    * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
    */
    public $email;

    /**
    * @ORM\Column(type="text")
    */
    private $password;
    /**
    * @Assert\EqualTo(propertyPath="password", message="La confirmation et le mot de passe ne correspondent pas !")
    */
    public $confirm_password;

    // un user peu avoir plusieurs figures
    //Un forum a plusieurs a potentiellement user
    

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Figure", mappedBy="user")
     */
     private $figure;

      /**
     * @ORM\OneToMany(targetEntity="App\Entity\Forum", mappedBy="user")
     */
    private $forum;

     public function __construct() {
        $this->figure = new ArrayCollection();
        $this->forum = new ArrayCollection();
    }

    public function getNom() {
        return $this->nom;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPassword($password) {
        $this->password = $password;
    }
    
    public function getPassword() {
        return $this->password;
    }

    public function setlienPhoto($lienPhoto) {
        $this->lien_photo = $lienPhoto;
    }

    public function getlienPhoto() {
        return $this->lien_photo;
    }

    public function eraseCredentials()
    {
        
    }

    public function getSalt()
    {
        
    }

    public function getRoles()
    {
        return [ 'Role_User'];
    }

    public function getUsername()
    {
        return $this->email;
    }
    

}