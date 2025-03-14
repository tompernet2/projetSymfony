<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;

use App\Entity\Formation;
use App\Entity\Produit;
use App\Entity\Employe;
use App\Form\FormationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class FormationController extends AbstractController
{
    #[Route('/formation', name: 'app_formation')]
    public function index(): Response
    {
        return $this->render('formation/index.html.twig', [
            'controller_name' => 'FormationController',
        ]);
    }


    #[Route('/ajoutFor', name: 'app_ajoutFormation')]

    public function ajoutFormation(ManagerRegistry $doctrine){

        $produit = new Produit();
        $produit->setLibelle("aaaaaaa");

        $formation = new Formation();
        $date = new \DateTime('2025-10-10');
        $formation->setDateDebut($date);
        $formation->setNbreHeures(20);
        $formation->setDepartement("Booooooo");
        $formation->setProduit($produit);

        $entityManager = $doctrine->getManager();

        $entityManager->persist($produit);
        $entityManager->persist($formation);

        $entityManager->flush();
        return $this->render('formation/index.html.twig', ['controller_name' => 'FormationController']);
    }


    #[Route('/ajoutEmploye', name: 'app_ajoutEmploye')]

    public function ajoutEmploye(ManagerRegistry $doctrine){

        $employe = new Employe();
        $employe->setLogin("titi");
        $employe->setMdp("titi");
        $employe->setNom("titi");
        $employe->setPrenom("titi");
        $employe->setStatut("0");


        $entityManager = $doctrine->getManager();

        $entityManager->persist($employe);

        $entityManager->flush();
        return $this->render('formation/index.html.twig', ['controller_name' => 'FormationController']);
    }


    #[Route('/afficheLesFormations', name: 'app_affFormations')]

    public function afficheLesFormations(ManagerRegistry $doctrine){
         $formation = $doctrine->getManager()->getRepository(Formation::class)->findAll();


         if (!$formation) {

            $message = "Pas de formations";

         } else {
             $message = null;
         }
          return $this->render('formation/listeFormation.html.twig', array('lesFormations'=>$formation, 'message'=>$message));
    }

    #[Route('/ajoutformation', name: 'app_ajoutformation')]
    public function ajoutFormationActionF(Request $request, ManagerRegistry $doctrine, $formation = null) {
        if ($formation == null) {
            $formation = new Formation();
        }
        $form = $this->createForm(FormationType::class, $formation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($formation);
            $em->flush();
            return $this->redirectToRoute('app_affichageAdmin');
        }
        
        return $this->render('formation/editer.html.twig',array('form'=>$form->createView()));
    }


    #[Route('/suppFormation/{id}', name: 'app_formation_sup')]

    public function suppFormation($id, ManagerRegistry $doctrine){
        $formation = $doctrine->getManager()->getRepository(Formation::class)->find($id);
        $entityManager = $doctrine->getManager();
        $entityManager->remove($formation);
        $entityManager->flush();
        return $this->redirectToRoute('app_affichageAdmin');
    }

    #[Route('/affichageAdmin', name: 'app_affichageAdmin')]

    public function affichageAdmin(ManagerRegistry $doctrine, SessionInterface $session){
        $employeId = $session->get('employe_id');
        $employe = $doctrine->getRepository(Employe::class)->find($employeId);

        $formation = $doctrine->getManager()->getRepository(Formation::class)->findAll();

        if (!$formation) {

        $message = "Pas de formations";

        } else {
            $message = null;
        }
        return $this->render('formation/affichageAdmin.html.twig', array('lesFormations'=>$formation, 'message'=>$message, 'employeNom' => $employe->getNom()));

}
    #[Route('/affichageEmploye', name: 'app_affichageEmploye')]

    public function affichageEmploye(ManagerRegistry $doctrine, SessionInterface $session){

        $employeId = $session->get('employe_id');
        $employe = $doctrine->getRepository(Employe::class)->find($employeId);



        $formation = $doctrine->getManager()->getRepository(Formation::class)->findAll();

        if (!$formation) {

            $message = "Pas de formations";

        } else {
            $message = null;
        }
        return $this->render('formation/affichageEmploye.html.twig', array('lesFormations'=>$formation, 'message'=>$message, 'employeNom' => $employe->getNom()));

    }

    }
