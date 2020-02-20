<?php

namespace App\Controller;
use Doctrine\Common\Persistence\ObjectManager ;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request ;
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

    public function formulaireEntreprise(Request $requetteHttp)
    {
        $manager=$this->getDoctrine()->getManager();
        //Création d'une ressource initialement vierge
        $ressource = new Entreprise();

        //création d'un objet formulaire pour saisir une ressource
        $formulaireRessource = $this -> createFormBuilder($ressource)
                                     -> add ('nom')
                                     -> add ('activite')
                                     -> add ('adresse')
                                     -> add ('email')
                                     -> add ('siteWeb')
                                     -> getForm();
        
        $formulaireRessource->handleRequest($requetteHttp);

        if ($formulaireRessource->isSubmitted()){

            $manager->persist($ressource);
            $manager->flush();
            return $this->redirectToRoute('entreprises');
        }

        //Génerer la vue représentant le formulaire
        $vueFormulaireRessource = $formulaireRessource -> createView();

        //Afficher la page d'ajout d'une ressource
        return $this->render('pro_stage/formulaireEntreprise.html.twig', ['vueFormulaireRessource' => $vueFormulaireRessource]);
    }

    public function formulaireModifEntreprise(Request $requetteHttp, ObjectManager $manager, Entreprise $entreprise)
    {
        $formulaireEntreprise = $this-> createFormBuilder($entreprise)
        -> add ('nom')
        -> add ('activite')
        -> add ('adresse')
        -> add ('email')
        -> add ('siteWeb')
        -> getForm();
        $formulaireEntreprise->handleRequest($requetteHttp);
        
        if ($formulaireEntreprise->isSubmitted()){
            $manager->persist($entreprise);
            $manager->flush();
            return $this->redirectToRoute('entreprises');
        }

        return $this->render('pro_stage/formulaireEntreprise.html.twig', ['vueFormulaireRessource' => $formulaireEntreprise->createView()]);
    }

    
}


