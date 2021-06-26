<?php

namespace App\DataFixtures;

use App\Entity\Carte;
use App\Entity\Couleur;
use App\Entity\Valeur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
//Carreau, Cœur, Pique, Trèfle
        $couleur=new Couleur();
        $couleur->setName('Carreau');
        $couleur->setColor('#F00');
        $couleur->setSymbole('♦');
        $couleur->setOrdre(0);
        $manager->persist($couleur);

        $couleur=new Couleur();
        $couleur->setName('Cœur');
        $couleur->setColor('#04C600');
        $couleur->setSymbole('♥');
        $couleur->setOrdre(1);
        $manager->persist($couleur);

        $couleur=new Couleur();
        $couleur->setName('Pique');
        $couleur->setColor('#0044C6');
        $couleur->setSymbole('♠');
        $couleur->setOrdre(2);
        $manager->persist($couleur);

        $couleur=new Couleur();
        $couleur->setName('Trèfle');
        $couleur->setColor('#C600A2');
        $couleur->setSymbole('♣');
        $couleur->setOrdre(3);
        $manager->persist($couleur);

        $manager->flush();
  // AS, 5, 10, 8, 6, 5, 7, 4, 2, 3, 9, Dame, Roi, Valet

        $valeur=new Valeur();
        $valeur->setName('AS');
        $valeur->setOrdre(1);
        $manager->persist($valeur);

        for($i=2; $i<=10; $i++){
            $valeur=new Valeur();
            $valeur->setName($i);
            $valeur->setOrdre($i-1);
            $manager->persist($valeur);

        }

        $valeur=new Valeur();
        $valeur->setName('Dame');
        $valeur->setOrdre(11);
        $manager->persist($valeur);

        $valeur=new Valeur();
        $valeur->setName('Roi');
        $valeur->setOrdre(12);
        $manager->persist($valeur);

        $valeur=new Valeur();
        $valeur->setName('Valet');
        $valeur->setOrdre(13);
        $manager->persist($valeur);

        $manager->flush();


        $couleurs=$manager->getRepository(Couleur::class)->findAll();
        $valeurs=$manager->getRepository(Valeur::class)->findAll();
        foreach ($couleurs as $couleur){
            foreach ($valeurs as $valeur){
                $carte=new Carte();
                $carte->setValeur($valeur);
                $carte->setCouleur($couleur);
                $manager->persist($carte);
            }
        }
        $manager->flush();

    }
}
