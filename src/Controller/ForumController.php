<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ForumController extends AbstractController
{
    /**
     * @Route("/forum/{id}", name="forum")
     */
    public function index($id)

    // je dois recuperer tous les commentaires par pages 
    // faire un query qui va permettre de récupérer les figures  between tel page a tel page 
    {
        dump($id);
        return $this->render('forum/index.html.twig', [
            'controller_name' => 'ForumController',
        ]);
    }
}
