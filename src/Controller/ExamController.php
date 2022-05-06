<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Form\EtudiantType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/exam')]
class ExamController extends AbstractController
{
    #[Route('/acc', name: 'acc_exam')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repositery=$doctrine->getRepository(Etudiant::class);
        $p= $repositery->findAll();
        return $this->render('exam/index.html.twig',[
            'etudiant'=>$p
        ]);
    }

    #[Route('/edit/{id?0}', name: 'edit_exam')]
    public function add(ManagerRegistry $doctrine,Etudiant $e= null,Request $request): Response
    {  $entityManager=$doctrine->getManager();
        $new=false;
        if(!$e){
            $e=new Etudiant();
            $new=true;
        }
        $form=$this->createForm(EtudiantType::class,$e);
        $form->handleRequest($request);

        if(!$form->isSubmitted()){
            return $this->render('exam/formulaire.html.twig',[
                'form'=>$form->createView(),
            ]);}
        else{
            $entityManager->persist($e);
            $entityManager->flush();
            if(!$new){
                $this->addFlash('success',$e->getNom().' est edité avec success');}
            else{$this->addFlash('success',$e->getNom().' est ajouté avec success');}
        }
        return $this->redirectToRoute('acc_exam');
    }
    #[Route('/add', name: 'add_exam')]
    public function addEtudiant(ManagerRegistry $doctrine,Request $request): Response
    {  $entityManager=$doctrine->getManager();
        $e=new Etudiant();
        $form=$this->createForm(EtudiantType::class,$e);
        $form->handleRequest($request);
        if(!$form->isSubmitted()){
            return $this->render('exam/formulaire.html.twig',[
                'form'=>$form->createView(),
            ]);}
        else{
            $entityManager->persist($e);
            $entityManager->flush();
            $this->addFlash('success',$e->getNom().' est ajouté avec success');
            return $this->redirectToRoute('acc_exam');
        }
    }
    #[Route('/supp/{id}', name: 'del_exam')]
    public function DeleteEtudiant(ManagerRegistry $doctrine,Etudiant $e=null): RedirectResponse
    {
        if($e){
            $Manager=$doctrine->getManager();
            $Manager->remove($e);
            $Manager->flush();
            $this->addFlash('success',"personne supprimer avec success");
        }
        else{
            $this->addFlash('error',"tu ne peux pas supp ce id car il n'existe pas");
        }
        return $this->redirectToRoute('acc_exam');

    }

}
