<?php

namespace App\Controller\Admin;

use App\Entity\Settings;
use App\Form\SettingsType;
use App\Repository\SettingsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Request,Response};

class SettingsController extends AbstractController
{
    private $repository;
    private $entityManager;

    public function __construct(SettingsRepository $repository , EntityManagerInterface $em )
    {

        $this->repository = $repository;
        $this->entityManager = $em;
    }


    public function index(Request $request):Response
    {
        $set =  $this->repository->find(1);
        $form = $this->createForm(SettingsType::class,$set);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->entityManager->merge($set);
            $this->entityManager->flush();

            return $this->redirectToRoute('settings');

        }

        return $this->render('settings/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
