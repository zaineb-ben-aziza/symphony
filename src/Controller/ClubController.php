<?php

namespace App\Controller;

use App\Entity\Club;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ClubRepository;
use Doctrine\Persistence\ManagerRegistry;
use SebastianBergmann\CodeCoverage\Report\Html\Renderer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ClubType;

class ClubController extends AbstractController
{
    #[Route('/club', name: 'app_club')]
    public function list(): Response
    {
        $clubs = [ ["name" => "AIESEC", "inscriptionDate"=> "09/09/2022", "openSpots" => '50'],
                    ["name" => "ENACTUS", "inscriptionDate"=> "30/09/2022", "openSpots" => '0'],  
                    ["name" => "AUTO CLUB", "inscriptionDate"=> "12/09/2022", "openSpots" => '30']      
        ];
        return $this->render('club/index.html.twig', [
            'clubs' => $clubs,
        ]);
    }
    #[Route('/club/list', name: 'app_list')]
    public function index(): Response
    {
        $formations = array(
            array('ref' => 'form147', 'Titre' => 'Formation Symfony4','Description'=>'formation pratique',
            'date_debut'=>'12/06/2020', 'date_fin'=>'19/06/2020',
            'nb_participants'=>19) ,
            array('ref'=>'form177','Titre'=>'Formation SOA' ,
            'Description'=>'formation
            theorique','date_debut'=>'03/12/2020','date_fin'=>'10/12/2020',
            'nb_participants'=>0),
            array('ref'=>'form178','Titre'=>'Formation Angular' ,
            'Description'=>'formation
            theorique','date_debut'=>'10/06/2020','date_fin'=>'14/06/2020',
            'nb_participants'=>12));
    
        return $this->render('club/list.html.twig', [
            'formations' => $formations,
        ]);
    }
    #[Route('detail/{titre}', name: 'app_detail')]
    public function detail($titre): Response
    {
        return $this->render('club/detail.html.twig', [
            'titre' => $titre,
        ]);
    }
    #[Route('/listClub', name: 'listClub')]
    public function listClub(ManagerRegistry $doctrine): Response {
        $clubs = $doctrine->getRepository(Club::class)->findAll();
        return $this->render('club/listClub.html.twig',[
            'clubs'=> $clubs
        ]);
    }

    #[Route('/listClub1', name: 'listClub1')]
    public function listClub1(ClubRepository $repo): Response {
        $clubs = $repo->findAll();
        return $this->render('club/listClub.html.twig',[
            'clubs'=> $clubs
        ]);
    }
    #[Route('/show/{id}', name: "clubDetails")]
    public function show (ManagerRegistry $doctrine, $id): Response{
        $club = $doctrine->getRepository(Club::class)->find($id);
        return $this->render('club/showClub.html.twig',[
            'club'=> $club
        ]);    
    }
    #[Route('/show1/{id}', name: "clubDetails1")]
    public function show1 (ClubRepository $repo, $id): Response{
        $club = $repo->find($id);
        return $this->render('club/showClub.html.twig',[
            'club'=> $club
        ]);    
    }
    #[Route('/show2/{id}', name: "clubDetails2")]
    public function show2 (Club $club): Response{
        return $this->render('club/showClub.html.twig',[
            'club'=> $club
        ]);    
    }

    #[Route('/delete/{id}', name: "clubDelete")]
    public function delete(ManagerRegistry $doctrine, $id): Response {
        $club = $doctrine->getRepository(Club::class)->find($id);
       
        $entityManager = $doctrine->getManager();
        $entityManager->remove($club);
        $entityManager->flush();

        return new Response('Deleted');
    }
    #[Route('/delete1/{id}', name: "clubDelete1")]
    public function delete1(ClubRepository $repo, $id): Response {
        
        $club = $repo->find($id);

        $repo->remove($club, true);

        return new Response('Deleted');
    }
    
    #[Route('/add', name: "clubAdd")]
    public function add(Request $request, ManagerRegistry $doctrine): Response{
    // clubrepository $repo
        $club = new Club();
     // $club->setNom('Test');

       // $form = $this->createFormBuilder($club)
       // ->add('nom', TextType::class)
       // ->add('save', SubmitType::class)
       // ->getForm();

        $form = $this->createForm(ClubType::class, $club);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $club = $form->getData();
           //$repo->add($club, true);
            $entityManager = $doctrine->getManager();
            $entityManager->persist($club);
            $entityManager->flush();

            return $this->redirectToRoute('listClub');
        }

        return $this->renderForm('club/add.html.twig',[
            'form' => $form 
        ]);   
    }

    #[Route('/update/{id}',name:'update_club')]
    public function update(Request $request, ClubRepository $repo, $id):Response {
        $club = $repo->find($id);
        $form = $this->createForm(ClubType::class, $club);
        $form->handleRequest($request);
        if  ($form->isSubmitted() && $form->isValid()){
            $repo->save($club, true); //f3oudh ladd save
            return $this->redirectToRoute('listClub');
        }
        return $this->renderForm('club/add.html.twig',[
            'form' => $form 
        ]);  
    }

}


