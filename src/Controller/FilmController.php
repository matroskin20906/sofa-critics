<?php

namespace App\Controller;

use App\Entity\Film;
use App\Form\FilmType;
use App\Service\FilmUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class FilmController extends AbstractController
{

    #[Route('/film/new', name: 'film_new')]
    public function new(Request $request,  FilmUploader $filmUploader): Response
    {
        $film = new Film();
        $form = $this->createForm(FilmType::class, $film);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $pictureFile */
            $pictureFile = $form->get('film_picture')->getData();

            // this condition is needed because the 'picture' field is not required
            // so the png file must be processed only when a file is uploaded
            if ($pictureFile) {
                $originalFilename = pathinfo($pictureFile->getClientOriginalName(), PATHINFO_FILENAME);
                $pictureFileName = $filmUploader->upload($pictureFile);
                $newFilename = $film->getId();

                // Move the file to the directory where film pictures are stored
                try {
                    $pictureFile->move(
                        $this->getParameter('film_picture_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

            }

            return $this->redirectToRoute('app_welcome');
        }

        return $this->renderForm('film/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/', name: 'welcome', methods: ['GET'])]
    public function welcome(): Response
    {
        return $this->render('base.html.twig');
    }

    #[Route('/film/{id}', name: 'film_page', methods: ['GET'])]
    public function id(): Response
    {
        return $this->render('film.html.twig');
    }
}