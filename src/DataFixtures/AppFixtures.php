<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Formation;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
      //Création d'un générateur de données Faker
        $faker = \Faker\Factory::create('fr_FR');
        $nbFormations = 10;
        $nbEntreprises = 5;

        for($i=1; $i <= $nbFormations;$i++){
          $dutInfo = new Formation();
          //Num random pour l'ID
          $dutInfo->setId($faker->randomDigitNotNull());
          //Texte random pour le nom, la bille, le type et le domaine de la formation
          $dutInfo->setNom($faker->realText($maxNbChars = 40, $indexSize = 2));
          $dutInfo->setTypeFormation($faker->realText($maxNbChars = 20, $indexSize = 2));
          $dutInfo->setVille($faker->realText($maxNbChars = 50, $indexSize = 2));
          $dutInfo->setDomaine($faker->realText($maxNbChars = 40, $indexSize = 2));
          //enregistrement de la formation créée
          $manager->persist($dutInfo);
      }

      for($i=1; $i <= $nbEntreprises;$i++){
        $entreprises = new Entreprise();
        //Num random pour l'ID
        $entreprises->setAdresse($faker->realText($maxNbChars = 10, $indexSize = 2));
        //Texte random pour le nom, la bille, le type et le domaine de la formation
        $entreprises->setId($faker->randomDigitNotNull());
        $entreprises->setDomaine($faker->realText($maxNbChars = 30, $indexSize = 2));
        $entreprises->setNom($faker->realText($maxNbChars = 10, $indexSize = 2));
        $entreprises->setUrlSiteWeb($faker->realText($maxNbChars = 10, $indexSize = 2));
        //enregistrement de la formation créée
        $manager->persist($entreprises);}



//Envoie des données vers la BD
        $manager->flush();
    }
}
