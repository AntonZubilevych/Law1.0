<?php

namespace App\Controller\Admin;


use App\Form\PostType;
use App\Repository\PostRepository;
use App\Services\PostService\PostFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\{Request,Response};
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class PostController extends AbstractController
{
    private $repository;
    private $entityManager;

    public function __construct(PostRepository $repository , EntityManagerInterface $em )
    {

        $this->repository = $repository;
        $this->entityManager = $em;
    }


    public function add(Request $request,PostFactory $factory):Response
    {
        $form = $this->createForm(PostType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $post = $factory->create($form->getData());
            $this->entityManager->persist($post);
            $this->entityManager->flush();

            return $this->redirectToRoute('posts');

        }

        return $this->render('post/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function changeStatus($id , $status):Response
    {
        $post = $this->repository->find($id);
        $post->setStatus($status);
        $this->entityManager->merge($post);
        $this->entityManager->flush();

        return $this->redirectToRoute('posts');

    }

    public function edit(Request $request , $id):Response
    {
        $post = $this->repository->find($id);
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->entityManager->merge($post);
            $this->entityManager->flush();

            return $this->redirectToRoute('posts');

        }

        return $this->render('post/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function delete($id):Response
    {
        $post = $this->repository->find($id);
        $this->entityManager->remove($post);
        $this->entityManager->flush();

        return $this->redirectToRoute('posts');
    }

    public function getPost():Response
    {

        $posts = $this->repository->findAll();


        return $this->render('post/posts.html.twig', [
            'posts' => $posts,
        ]);
    }
}
