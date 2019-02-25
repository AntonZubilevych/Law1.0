<?php

namespace App\Controller\Admin;

use App\Form\ClientType;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\{Request,Response};
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{

    private $repository;
    private $entityManager;

    public function __construct(ClientRepository $repository , EntityManagerInterface $em )
    {
        $this->repository = $repository;
        $this->entityManager = $em;
    }

    public function index()
    {
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }

    public function add(Request $request)
    {
        $form = $this->createForm(ClientType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            dd($form->getData());
            return $this->redirectToRoute('posts');

        }

        return $this->render('post/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
