<?php

namespace App\Controller;
use App\Entity\User;

use App\Form\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;



class SecurityController extends AbstractController
{

     /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request, UserPasswordEncoderInterface $encoder, SluggerInterface $slugger) {
        if ($this->getUser()){
            
            $this->addFlash(
                'notice',
                'vous devez vous deconnecter pour register'
            );
            return $this->redirectToRoute('figure_list');
         }
        $user = new User();
        
        // on creer le formulaire et on relie les champs a l'entity User
        $form = $this->createForm(RegistrationType::class, $user);

        // on analyse la requete

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            $photofile = $form->get('file')->getData();
            if ($photofile) {
                $originalFilename = pathinfo($photofile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$photofile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $photofile->move(
                        $this->getParameter('photo_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                
                $LienPhoto =  $newFilename;
                
            }
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $user->setlienPhoto($LienPhoto);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();

            // quand j'enregistre je veux rediriger vers mon espace login

            return $this->redirectToRoute('app_login');
        }

        return  $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);
 
    }

    


    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
             return $this->redirectToRoute('figure_list');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
        return $this->redirectToRoute('home');
    }

     
}
