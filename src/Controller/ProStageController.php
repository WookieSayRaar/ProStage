<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProStageController extends AbstractController
{
    /**
     * @Route("/", name="prostage_acceuil")
     */
    public function index(): Response
    {
        return $this->render('prostage/acceuil.html.twig', [
            'controller_name' => 'ProStageController',
        ]);
    }

    /**
     * @Route("/formations", name="prostage_formations")
     */
     public function formation(): Response{
     return $this->render('prostage/formation.html.twig', [
         'controller_name' => 'ProStageController',
     ]);
   }


     /**
      * @Route("/entreprises", name="prostage_entreprises")
      */
      public function entreprise(): Response{
      return $this->render('prostage/entreprise.html.twig', [
          'controller_name' => 'ProStageController',
      ]);}

      /**
       * @Route("/stage/{id}", name="prostage_stage")
       */

       public function stage($id): Response {
       return $this->render('prostage/stage.html.twig', [
           'controller_name' => 'ProStageController','idStage'=>$id
       ]);}
}
?>
