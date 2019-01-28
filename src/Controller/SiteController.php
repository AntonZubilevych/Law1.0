<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends AbstractController
{
    public function index()
    {
        return $this->render('site/index.html.twig', [
            'main' => true
        ]);
    }

    public function getPrices()
    {
        return $this->render('site/index.html.twig', [
            'price' => true
        ]);
    }
}
