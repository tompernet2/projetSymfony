<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;

use App\Entity\Employe;
use App\Form\ConnexionType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;



class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(): Response
    {
        return $this->render('login/index.html.twig', [
            'controller_name' => 'LoginController',
        ]);
    }

    #[Route('/connexion', name:'app_connexion')]

    public function connexion(Request $request, ManagerRegistry $doctrine, SessionInterface $session, $employe = null){

        if($employe == null) {
            $employe = new Employe();
        }

        $form = $this -> createForm(ConnexionType::class, $employe);
        $form -> handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){

            $login = $employe->getLogin();
            $mdp = $employe->getMdp();

            $m = $doctrine->getManager()->getRepository(Employe::class)->findOneBySomeLoginMdp($login, $mdp);

            if($m != null) {
                $session->set('employe_id', $m->getId());  
                $session->set('employe_statut', $m->getStatut());  

                if($m->getStatut()==1){
                    echo"employe";
                    return $this->redirectToRoute('app_affichageEmploye');

                }
                else{
                echo"admin";
                return $this->redirectToRoute('app_affichageAdmin');
                }
            }  
            echo"Erreur d'identification";
        }
        return  $this->render('login/editer.html.twig', ['form' => $form -> createView()]);

    }   

    #[Route('/deconnexion', name: 'app_deconnexion')]
    public function deconnexion(SessionInterface $session)
    {
        $session->clear();

        return $this->redirectToRoute('app_connexion');
    }

}
