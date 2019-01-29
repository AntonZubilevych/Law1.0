<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use App\Services\Converter;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\{Request,Response};
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{

    public function index($offset)
    {

        $repository = $this->getDoctrine()->getRepository(Post::class);

        $posts = $repository->findBy(['status' => 1],null , $offset);
        $posts = Converter::callbackShorter($posts);

        return $this->render('post/index.html.twig', [
            'posts' => $posts,
            'offset' => $offset
        ]);
    }

    public function page($url)
    {
        $repository = $this->getDoctrine()->getRepository(Post::class);
        $post = $repository->findOneBy(['url' => $url]);

        if(!isset($post)){
            throw new NotFoundHttpException();
        }

        $archives = $repository->findBy(['status' => 1],null , 10);

        return $this->render('post/page.html.twig', [
            'post' => $post,
            'archives' => $archives
        ]);
    }

    public function price()
    {
        return $this->render('post/price.html.twig', [
            'price' => true
        ]);
    }

}
