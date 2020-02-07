<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Entity\Stage;

class ProStageController extends AbstractController
{

    public function index()
    {
        $repositoryStage=$this->getDoctrine()->getRepository(Stage::class);
        $stages = $repositoryStage->findStagesEtEntreprises();

        return $this->render('pro_stage/index.html.twig', ['stages' => $stages]);
    }

    public function entreprises()
    {
        $repositoryEntreprise=$this->getDoctrine()->getRepository(Entreprise::class);
        $entreprises = $repositoryEntreprise->findAll();

        return $this->render('pro_stage/entreprises.html.twig', ['entreprises' => $entreprises]);
    }

    public function formations()
    {
        $repositoryFormation=$this->getDoctrine()->getRepository(Formation::class);
        $formations = $repositoryFormation->findAll();
        return $this->render('pro_stage/formations.html.twig', ['formations' => $formations]);
    }

    public function stages($id)
    {
        $repositoryStage=$this->getDoctrine()->getRepository(Stage::class);
        $stage = $repositoryStage->find($id);
        return $this->render('pro_stage/stages.html.twig',
                                        ['stage'=>$stage]);
    }

    public function affichageStageParEntreprise($id)
    {
        $repositoryEntreprise=$this->getDoctrine()->getRepository(Entreprise::class);
        $entreprise = $repositoryEntreprise->find($id);
        return $this->render('pro_stage/affichageStageParEntreprise.html.twig', ['entreprise' => $entreprise]);
    }

    public function affichageStageParFormation($id)
    {
        $repositoryFormation=$this->getDoctrine()->getRepository(Formation::class);
        $formation = $repositoryFormation->find($id);
        return $this->render('pro_stage/affichageStageParFormation.html.twig', ['formation' => $formation]);
    }

    public function formulaireEntreprise()
    {
        //Création d'une ressource initialement vierge
        $ressource = new Entreprise();

        //création d'un objet formulaire pour saisir une ressource
        $formulaireRessource = $this -> createFormBuilder($ressource)
                                     -> add ('nom')
                                     -> add ('activite')
                                     -> add ('adresse')
                                     -> add ('email')
                                     -> getForm();

        //Génerer la vue représentant le formulaire
        $vueFormulaireRessource = $formulaireRessource -> createView();

        //Affocher la page d'ajout d'une ressource
        return $this->render('pro_stage/formulaireEntreprise.html.twig', ['vueFormulaireRessource' => $vueFormulaireRessource]);
    }

    
}


