<?php

// src/Controller/FigureController.php

namespace App\Controller;
use App\Entity\Figure;
use App\Entity\Forum as EntityForum;
use App\Entity\User;
use App\Form\CommentType;
use App\Entity\forum;
use App\Form\FigureType;
use App\Form\EditFigureType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\BrowserKit\Request as BrowserKitRequest;
use Doctrine\Common\Annotations\DocLexer;
use Doctrine\Persistence\ObjectManager as PersistenceObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;




class FigureController extends AbstractController
{
    /**
     * @Route("/figure", name="figure")
     */

     // je veux afficher tte les figure et faire un loop sur le front end
    public function index()
    {

       

        return $this->render('figure/index.html.twig', [
            'controller_name' => 'FigureController',
        ]);
    }

    // je creer la foction pour creer la page d'acceuil du site avec /rien

    /**
     * @Route("/", name="home")
     */

    public function home(){

  // Méthode findAll qui permet de récupérer toutes les données 
  //$figure = $this->getDoctrine()->getRepository(Figure::class)->findAll();
  $repo = $this->getDoctrine()->getRepository(Figure::class);

  $figure = $repo->findAll();

  
       return $this->render('figure/home.html.twig', [
       'controller_name' => 'FigureController',
       'figures' => $figure
   ]);
            
        
    }



    // pour creer une figure
    /**
     * @Route("/figure/new", name="figure_create")
     */
    public function figure( Request $request, SluggerInterface $slugger){
        //if (!$figure) {
        
            //$figure = new Figure();
       //  }

        
        // je creer le formulaire
        $figure = new Figure();
        $form = $this->createForm(FigureType::class, $figure);
        $form->handleRequest($request);

        

        
        // on creer le formulaire et on relie les champs a l'entity User
        
            // on controle la requete

      
        if($form->isSubmitted() && $form->isValid()){
            if (!$this->getUser()){
               return $this->redirectToRoute('app_login');
            }
            //dd($request->files->get('file'));
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
            
            
            $data = $form->getData();
            $nom = $form->get('Nom')->getData();
            //$description = $form->get('Description')->getData();
            $groupeFigure = $form->get('GroupeFigure')->getData();
            $LienVideo = $form->get('lienVideo')->getData();
            
            $figure = new Figure();
            $figure->setNom($nom);
            $figure->setDescription('description');
            $figure->setGroupeFigure($groupeFigure);
            $figure->setLienPhoto($LienPhoto);
            $figure->setLienVideo($LienVideo);
            $figure->setuser($this->getUser());
            $figure->setUserId($this->getUser()->id);
            

            // on ajoute a la BDD
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($figure);
            $em->flush();

            $this->addFlash(
                'notice',
                'Votre figure à été ajouté!'
            );

            //return new Response('figure ajouté');
            return $this->redirectToRoute('figure_list');

        }

    

            //on crée le formulaire et on rend la vue
            return $this->render('figure/create.html.twig', [
                'formFigure' => $form->createView(),
               
               // 'editMode' => $figure->getId() !== null
            ]);
            

        
    }


    // meetre a jour une figure

    /**
     * @Route("/figure/{id}/edit", name="figure_edit" )
     */

     public function editFigure(Request $request, int $id){
        // on sauvegarde la figure trouvé dans une variable
        dump($id);

        
        $repo = $this->getDoctrine()->getRepository(Figure::class);
        $figureFound = $repo->findOneBy((['Id' => $id ]));
        $form = $this->createForm(EditFigureType::class, $figureFound);
        

        $form->handleRequest($request);

       

         if($form->isSubmitted() && $form->isValid()){
// recup les donnes qui sont dans figure et save dans la BDD et persist Bdd et redirect vers liste des figures
                $em = $this->getDoctrine()->getManager();
                $em->persist($figureFound);
                $em->flush();

                return $this->redirectToRoute('figure_list');

        }
        
       

        return $this->render('figure/create.html.twig', [
            'formFigure' => $form->createView(),
           
           // 'editMode' => $figure->getId() !== null
        ]);
        
     }


 


// pour voir une figure
    /**
     * @Route("/show/{id}", name="figure_show")
     */

    public function show($id, Request $request){

        // on vérifie que les user est bien identifié 

        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
         }
        
        $repo = $this->getDoctrine()->getRepository(Figure::class);
        $figure = $repo->find($id);
        // si la figure est vide on retourne sur la liste des figures
        if (!$figure){
            return $this->redirectToRoute('figure_list');

        }
        dump($id);
        

         // on charge tous les commentaires 

         $repo = $this->getDoctrine()->getRepository(Forum::class);

        $forum = $repo->findBy(['figureId' => $id ], ['createdAt'=> 'DESC'])->getRes;


        
        //voici le formulaire pour ajouter des new commetnaires

        $Comment = new Forum();
        $form = $this->createForm(CommentType::class, $Comment);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            
                $Comment->setCreatedAt(new \DateTime() );
                $userId =   $this->getUser()->id;

                $Comment->setUserId($userId);
                $Comment->setFigureId($id);
                $Comment->setFigure($figure);
                $Comment->setUser($this->getUser());
                                  
                $em = $this->getDoctrine()->getManager();
                $em->persist($Comment);
                $em->flush();


          
            
                    }

                    

        return $this->render('figure/show.html.twig',[
            'figure' => $figure,
            'comment' => $forum,
           'CommentType' => $form->createView(),
        ] );
    }



    // pour afficher toutes les figure
    /**
     * @Route("/list", name="figure_list")
     */

    public function figureList( Request $request ){

        $repo = $this->getDoctrine()->getRepository(Figure::class);

        $figures = $repo->findAll();

       
        return $this->render('figure/figureList.html.twig',[
            'figures' => $figures,
           'controller name' =>  "FigureController",
        ] );
    }



    // pour supprimer une figure
    /**
     * @Route("/delete/{id}", name="figure_delete")
     * 
     */

    public function delete(int $id){
        dump($id);
        

        $em = $this->getDoctrine()->getManager();
        $figure = $em->getRepository(Figure::class)->findOneBy((['Id' => $id ]));

        if (!$figure) {
            return $this->redirectToRoute('figure_list');
        }

       

       

        $em->remove($figure);
        $em->flush();

        //return new Response('figure supprimé');

        return $this->redirectToRoute('figure_list');
    }

    


   
}
