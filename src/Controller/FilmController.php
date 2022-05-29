<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FilmController extends AbstractController
{
    #[Route('/', name: 'app_welcome', methods: ['GET'])]
    public function welcome(): Response
    {
        return $this->render('home\homepage.html.twig');
    }

    #[Route('/film', name: 'app_filmpage', methods: ['GET'])]
    public function id(): Response
    {
        return $this->render('film\filmpage.html.twig');
    }
}