<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Employe;


class RechercheController extends AbstractController
{
    #[Route('/recherche', name: 'app_recherche')]
    public function index(): Response
    {
        return $this->render('recherche/index.html.twig', [
            'controller_name' => 'RechercheController',
        ]);
    }
    #[Route('/rechercheFindBy', name: 'app_recherche_findBy')]
    public function rechercheFindByAction(ManagerRegistry $doctrine)
    {
        $employes = $doctrine->getRepository(Employe::class)->findBy(
            ['statut'=> 0, 'nom'=> 'castaing']
        );


         if (!$employes) {

            $message = "Il n'existe pas de d'employer qui s'appelle Castaing";

         } else {
             $message = null;
         }
          return $this->render('employe/listeEmployeCastaing.html.twig', array('lesEmployes'=>$employes, 'message'=>$message));
    }


}
