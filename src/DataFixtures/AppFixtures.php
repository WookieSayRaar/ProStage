<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Formation;
use App\Entity\Stage;
use App\Entity\Entreprise;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        /* Création d'un générateur de données à partir de la classe Faker*/
        $faker = \Faker\Factory::create('fr_FR');

        /***************************************
        *** CREATION DES ENTREPRISES ***
        ****************************************/
        $safran = new Entreprise();
        $safran -> setId($faker->randomDigitNotNull());
        $safran -> setNom("Safran");
        $safran -> setDomaine("Aéronautique");
        $safran -> setAdresse("1545 Route de Bidart");
        $safran -> setUrlSiteWeb("www.siteSafran.com");

        $dassault = new Entreprise();
        $dassault -> setId($faker->randomDigitNotNull());
        $dassault -> setNom("Dassault");
        $dassault -> setDomaine("Aéronautique");
        $dassault -> setAdresse("1555 Route de Bidart");
        $dassault -> setUrlSiteWeb("www.siteDassault.com");

        $turbomeca = new Entreprise();
        $turbomeca -> setId($faker->randomDigitNotNull());
        $turbomeca -> setNom("TurboMéca");
        $turbomeca -> setIcone("Aéronautique");
        $turbomeca -> setAdresse("1745 Route de Bidart");
        $turbomeca -> setUrlSiteWeb("www.siteTurbo.com");

        $ubisoft = new Entreprise();
        $ubisoft -> setId($faker->randomDigitNotNull());
        $ubisoft -> setNom("Ubisoft");
        $ubisoft -> setIcone("Jeux vidéo");
        $ubisoft -> setAdresse("7446 Avenue de Matignon");
        $ubisoft -> setUrlSiteWeb("www.siteUbisoft.com");

        $clsGroup = new Entreprise();
        $clsGroup -> setId($faker->randomDigitNotNull());
        $clsGroup -> setNom("CLS Group");
        $clsGroup -> setIcone("Aide à la navigation");
        $clsGroup -> setAdresse("1548 Route de Bidart");
        $clsGroup -> setUrlSiteWeb("www.siteCLS.com");

        /* On regroupe les objets "entreprise" dans un tableau
        pour pouvoir s'y référer au moment de la création d'un stage */
        $tableauEntreprises = array($safran,$dassault,$turbomeca,$ubisoft,$clsGroup);

        // Mise en persistance des objets entreprises
        foreach ($tableauEntreprises as $entreprise) {
            $manager->persist($entreprise);
        }


        /***************************************
         ***  LISTE DES FORMATIONS   ***
         ****************************************/
        $formations = array(
         "DUTI" => "Diplôme Universitaire et Technologique d'Informatique",
         "LPMN" => "Licence Professionnelle Métiers du Numériques",
         "LI" => "Licence Informatique",
         "DUI" => "Diplôme Universitaire Informatique",
         "LPPA" => "Licence Professionnelle Programmation Avancee",
         );

        /********************************************************
        *** CREATION DES FORMATIONS ET DES STAGES  ***
        *********************************************************/
        foreach ($formations as $typeFormation => $titreFormation) {
            // ************* Création d'une nouvelle formation *************
            $formation = new Formation();
            $formation -> setId($faker->randomDigitNotNull());
            // Définition du type de formation
            $formation->setTypeFormation($typeFormation);
            // Définition du type de formation
            $formation->setNom($typeFormation);
            // Définition du domaine
            $formation->setDomaine($nbWords = 6, $variableNbWords = true);
            //Définition de la $ville
            $formation->setVille($nbWords = 6, $variableNbWords = true);
            // Enregistrement de la formation créée
            $manager->persist($formation);

            // **** Création de plusieurs stages associées à la formation
            $nbStagesAGenerer = $faker->numberBetween($min = 0, $max = 7);
            for ($numStage=0; $numStage < $nbStagesAGenerer; $numStage++) {
                $stage = new Stage();
                $stage -> setId($faker->randomDigitNotNull());
                $stage -> setNom($faker->sentence($nbWords = 6, $variableNbWords = true));
                $stage -> setDescription($faker->realText($maxNbChars = 200, $indexSize = 2));
                $stage -> setDateDebut($faker->dateTimeBetween($startDate = 'now', $endDate = '+6 months', $timezone = 'Europe/Paris'));
                $stage -> setCompetencesRequises($faker->sentence($nbWords = 6, $variableNbWords = true));
                $stage -> setExperienceRequise($faker->sentence($nbWords = 6, $variableNbWords = true));
                $stage -> setEmail($faker->sentence($nbWords = 6, $variableNbWords = true));
                $stage -> setContact($faker->sentence($nbWords = 6, $variableNbWords = true));
                // Création relation Ressource --> Module
                $stage -> addFormation($formation);

                /****** Définir et mettre à jour le type de ressource ******/
                // Sélectionner un type de ressource au hasard parmi les 8 types enregistrés dans $tableauTypesRessources
                $numEntreprise = $faker->numberBetween($min = 0, $max = 7);
                // Création relation Ressource --> TypeRessource
                $stage -> setEntreprise($tableauEntreprises[$numEntreprise]);
                // Création relation TypeRessource --> Ressource
                $tableauEntreprises[$numEntreprise] -> addStage($stage);

                // Persister les objets modifiés
                $manager->persist($stage);
                $manager->persist($tableauEntreprises[$numEntreprise]);
            }
        }
        // Envoi des objets créés en base de données
        $manager->flush();
    }
}
