<?php

namespace App\Controller;

use App\Repository\CatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CatController extends AbstractController
{
    #[Route('/cats', name: 'cat_index')]
    public function index(CatRepository $catRepository): Response
    {
        $cats = $catRepository->findAll();

        return $this->render('cat/index.html.twig', [
            'cats' => $cats,
        ]);
    }
}
