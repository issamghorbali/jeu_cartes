<?php

namespace App\Controller;

use App\Entity\Carte;
use App\Entity\Couleur;
use App\Entity\Valeur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartesController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {

        $this->em = $em;
    }
    /**
     * @Route("/cartes", name="cartes")
     */
    public function index(SessionInterface $session): Response
    {
        $couleurs=$this->em->getRepository(Couleur::class)->findAllRandom();
        $valeurs=$this->em->getRepository(Valeur::class)->findAllRandom();
        //affichage des cartes par ordre aleatoire
        $cartes=$this->em->getRepository(Carte::class)->findAllRandom();

        //affectation ordre aleatoire pour les couleurs et les valeurs
        $ordre=0;
        foreach ($couleurs as $couleur) {

            $ordre++;
            $couleur->setOrdre($ordre);
            $this->em ->persist($couleur);
            $this->em ->flush();
        }
        $ordre=0;
        foreach ($valeurs as $valeur) {
            $ordre++;
            $valeur->setOrdre($ordre);
            $this->em ->persist($valeur);
            $this->em ->flush();

        }

        $session->set('cartes',$cartes);

        return $this->render('cartes/index.html.twig', [
            'controller_name' => 'CartesController',
            'couleurs'=>$couleurs,
            'valeurs'=>$valeurs,
            'cartes'=>$cartes
        ]);
    }

    /**
     * @Route("/cartes/piocher", name="piocher_cartes")
     */
    public function piocher_cartes(Request $request, SessionInterface $session)
    {
        $error=0;
        $n=$request->request->get('n');
        if($n==0|| $n=='' || $n>52) $error=1;

        $session->set('nb_cartes_piocher',$n);
        return $this->json(['msg'=>1, 'error'=>$error]);
    }

    /**
     * @Route("/cartes/main", name="main_picher")
     */
    public function main(Request $request, SessionInterface $session)
    {


        $nb_cartes_piocher=$session->get('nb_cartes_piocher');

        $cartes=$session->get('cartes');

        $k=0;
        foreach ($cartes as $carte){
            $k++;
            if($k<=$nb_cartes_piocher)
                $main[]= clone $carte;
            else break;

        }

        $cartesForce = array();
        $mainTri=$main;
        foreach ($mainTri as $my_object) {
            $cartesForce[] = $my_object->getForce(); //any object field
            // dd($my_object->getForce());
        }

        array_multisort($cartesForce, SORT_DESC, $mainTri);

        return $this->render('cartes/main.html.twig', [
            'controller_name' => 'CartesController',
            'main'=>$main,
            'mainTri'=>$mainTri
        ]);
    }

    /**
     * @Route("/set_ordre_couleurs", name="set_ordre_couleurs")
     */
    public function set_ordre_couleurs(Request $request)
    {



        $page_id_array=$request->request->get('page_id_array');

        for($count = 0;  $count < count($page_id_array); $count++){
            $id=$page_id_array[$count];
            $groupe=$this->em ->getRepository(Couleur::class)->findOneBy(['id'=>$id]);

            $groupe->setOrdre($count);
            $this->em ->persist($groupe);
            $this->em ->flush();
        }


        return $this->json(['msg'=>1]);

    }

    /**
     * @Route("/set_ordre_valeurs", name="set_ordre_valeurs")
     */
    public function set_ordre_valeurs(Request $request)
    {

        $valeurs=$this->em ->getRepository(Valeur::class)->findAllRandom();

        $page_id_array=$request->request->get('page_id_array');
        for($count = 0;  $count < count($page_id_array); $count++){
            $id=$page_id_array[$count];
            $valeur=$this->em ->getRepository(Valeur::class)->findOneBy(['id'=>$id]);

            $valeur->setOrdre($count);
            $this->em ->persist($valeur);
            $this->em ->flush();
        }


        return $this->json(['msg'=>1]);

    }
}
