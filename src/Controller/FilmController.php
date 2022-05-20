<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FilmController extends AbstractController
{
    #[Route('/', name: 'welcome', methods: ['GET'])]
    public function welcome(): Response
    {
        return $this->render('base.html.twig');
    }

    #[Route('/film', name: 'film_page', methods: ['GET'])]
    public function id(): Response
    {
        return $this->render('film.html.twig');
    }
}