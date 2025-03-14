<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\Employe;
use App\Entity\Formation;
use App\Entity\Inscription;
use App\Repository\InscriptionRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Form\RechercheFormationType;



class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'app_inscription')]
    public function index(): Response
    {
        return $this->render('inscription/index.html.twig', [
            'controller_name' => 'InscriptionController',
        ]);
    }

    #[Route('/inscription/{id}', name: 'app_formation_inscription')]
    public function inscrire($id,ManagerRegistry $doctrine,SessionInterface $session)
    {
        $employeId = $session->get('employe_id');
    

        $entityManager = $doctrine->getManager();

        $employe = $entityManager->getRepository(Employe::class)->find($employeId);
        $formation = $entityManager->getRepository(Formation::class)->find($id);

        $inscr = $doctrine->getRepository(Inscription::class)->findOneBy(['employe' => $employe, 'formation'=> $formation]);
        if($inscr){
            $this->addFlash('ERREUR', 'Inscription deja effectuée');

            echo"Vous êtes deja inscrit a cette formation";
        }
        else{
            $inscription = new Inscription();
            $inscription->setEmploye($employe);
            $inscription->setFormation($formation);
            $inscription->setStatut('en cours');
    
            $entityManager->persist($inscription);
            $entityManager->flush();
        }
        

        return $this->redirectToRoute('app_affichageEmploye');
}

    #[Route('/afficherInscription', name: 'app_afficher_inscription')]
    public function afficherInscriptions(ManagerRegistry $doctrine)
    {
        $entityManager = $doctrine->getManager();
        $inscriptions = $entityManager->getRepository(Inscription::class)->findAll();
        if (!$inscriptions) {

            $message = "Pas de formations";

         } else {
             $message = null;
         }

        return $this->render('inscription/afficherInscriptions.html.twig', ['inscriptions' => $inscriptions,'message'=>$message]);
    }

    #[Route('/validerInscription/{idInscription}', name: 'app_valider_inscription')]
    public function validerInscription(ManagerRegistry $doctrine, $idInscription, SessionInterface $session)
    {   
        $entityManager = $doctrine->getManager();
        $inscr = $entityManager->getRepository(Inscription::class)->find($idInscription);
    
        $formation = $inscr->getFormation();
        
        if ($formation) {
            if ($formation->getNbInscription() < $formation->getInscriptionMax() && $inscr->getStatut()!= 'validée') {
                $formation->setNbInscription($formation->getNbInscription() + 1);
                $entityManager->persist($formation);
                $inscr->setStatut('validée');
                $session->getFlashBag()->add('success', "L'inscription a été validée avec succès.");
            } else {
                if($inscr->getStatut()=== 'validée'){
                    $session->getFlashBag()->add('danger', "Cet employe est deja validé");
                }
                else{
                    $session->getFlashBag()->add('danger', "Le nombre maximum d'inscriptions est atteint.");
                }
            }
        }
    
        $entityManager->persist($inscr);
        $entityManager->flush();
    
        return $this->redirectToRoute('app_afficher_inscriptionParStatut');
    }
    

    #[Route('/refuserInscription/{idInscription}', name: 'app_refuser_inscription')]
    public function refuserInscription(ManagerRegistry $doctrine, $idInscription, SessionInterface $session)
    {
        

        $entityManager = $doctrine->getManager();
        $inscr = $entityManager->getRepository(Inscription::class)->find($idInscription);

        $formation = $inscr->getFormation(); 
        if($inscr->getStatut() === 'validée'){
            $formation->setNbInscription($formation->getNbInscription() - 1);
        }
        $session->getFlashBag()->add('success', "L'inscription a été refusé avec succès.");

        $inscr->setStatut('refusée');

        $entityManager->persist($inscr);
        $entityManager->flush();


        
        return $this->redirectToRoute('app_afficher_inscriptionParStatut');
    
    }


    #[Route('/afficherInscriptionParStatut', name: 'app_afficher_inscriptionParStatut')]
    public function afficherInscriptionParStatut(ManagerRegistry $doctrine)
    {
        $entityManager = $doctrine->getManager();
        $inscriptions = $entityManager->getRepository(Inscription::class)->findAll();
        
        return $this->render('inscription/afficherInscriptionParStatut.html.twig', ['inscriptions' => $inscriptions]);
    }

    #[Route('/afficherInscription/encours', name: 'app_afficher_inscription_en_cours')]
    public function afficherInscriptionsEnCours(ManagerRegistry $doctrine)
    {
        $entityManager = $doctrine->getManager();
        $inscriptions = $entityManager->getRepository(Inscription::class)->findBy(['statut' => 'en cours']);

        return $this->render('inscription/afficherInscriptionParStatut.html.twig', ['inscriptions' => $inscriptions]);
    }

    #[Route('/afficherInscription/validee', name: 'app_afficher_inscription_validee')]
    public function afficherInscriptionsValidees(ManagerRegistry $doctrine)
    {
        $entityManager = $doctrine->getManager();
        $inscriptions = $entityManager->getRepository(Inscription::class)->findBy(['statut' => 'validée']);

        return $this->render('inscription/afficherInscriptionParStatut.html.twig', ['inscriptions' => $inscriptions]);
    }

    #[Route('/afficherInscription/refusee', name: 'app_afficher_inscription_refusee')]
    public function afficherInscriptionsRefusees(ManagerRegistry $doctrine)
    {
        $entityManager = $doctrine->getManager();
        $inscriptions = $entityManager->getRepository(Inscription::class)->findBy(['statut' => 'refusée']);

        return $this->render('inscription/afficherInscriptionParStatut.html.twig', ['inscriptions' => $inscriptions]);
    }

    #[Route('/afficherInscriptionTest', name: 'app_afficher_inscription_test')]
    public function afficherInscriptionTest(InscriptionRepository $inscriptionRepository)
    {
        $inscriptions = $inscriptionRepository->rechInscriptionEmployeNomPrenom('toto', 'toto');
        if (!$inscriptions) {

            $message = "Employe toto toto non trouvé";

         } else {
             $message = null;
         }
          return $this->render('inscription/afficherTest.html.twig', array('inscriptions'=>$inscriptions, 'message'=>$message));
    }

    #[Route('/afficherInscriptionParNomPrenom', name: 'app_afficher_inscription_ParNomPrenom')]
    public function afficherInscriptionParNomPrenom(Request $request, ManagerRegistry $doctrine)
    {
        $form = $this->createForm(RechercheFormationType::class);
        return $this->render('inscription/afficherInscriptionParNomPrenom.html.twig', array('form'=>$form->createView()));

    }


}
