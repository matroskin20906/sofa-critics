<?php

namespace App\Controller;

use App\Entity\Film;
use App\Form\FilmType;
use App\Service\FilmService;
use App\Service\FilmUploader;
use App\Service\ReviewService;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class FilmController extends AbstractController
{
    public function __construct(
        private UserService $userService,
        private FilmService $filmService,
        private ReviewService $reviewService
    ){
    }

    #[Route('/film/new', name: 'film_new')]
    public function new(Request $request,  FilmUploader $filmUploader, EntityManagerInterface $entityManager): Response
    {
        $film = new Film();
        $form = $this->createForm(FilmType::class, $film);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newFilename = $film->getId();
            ///** @var UploadedFile $pictureFile */
            /*$pictureFile = $form->get('photoFile')->getData();

            // Move the file to the directory where film pictures are stored
            try {
                $pictureFile->move(
                    $this->getParameter('film_photos_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }*/
            $entityManager->persist($film);
            $entityManager->flush();
            return $this->redirectToRoute('app_welcome');
        }
        $user = $this->getUser();
        //$userNow = $this->userService->getById($user->getUserIdentifier());

        return $this->renderForm('film/new.html.twig', [
            'filmForm' => $form,             // ... changed name from form into filmForm
            'logedusername'=> 'Default',//$userNow->getUsername(),
            'logeduserphoto'=> '1.png',//$userNow->getPhoto(),
        ]);
    }

    #[Route('/{page}/{n}', name: 'app_welcome', requirements: ['page' => '\d+', 'n' => '\d+'],
        defaults: ['page' => '1', 'n' => '8'], methods: ['GET'])]
    public function welcome(string $page, string $n): Response
    {
        $user = $this->getUser();
        $userNow = $this->userService->getById($user->getUserIdentifier());

        $films = $this->filmService->findNFilms((int)$page, (int)$n);
        $filmsNames = array();
        $filmsPhotos = array();
        for ($i = 0; $i < $n; $i++) {
            $filmsNames[$i+1] = $films[$i]->getName();
            $filmsPhotos[$i+1] = $films[$i]->getPhoto();
            $filmsIDs[$i+1] = $films[$i]->getId();
        }
        return $this->render('home\homepage.html.twig',[
            'logedusername'=> $userNow->getUsername(),
            'logeduserphoto'=> $userNow->getPhoto(),
            'FilmsIDs' => $filmsIDs,
            'Filmsnames' => $filmsNames,
            'Filmsfotos' => $filmsPhotos,
            'pagenum' => $page,
            'nnum' => $n,
        ]);
    }


    #[Route('/film/{id}', name: 'app_filmpage', requirements: ['id' => '\d+'], defaults: ['id' => '2'], methods: ['GET'])]
    public function id(string $id): Response
    {

        $user = $this->getUser();
        //$userNow = $this->userService->getById($user->getUserIdentifier());
        $film = $this->filmService->findById((int)$id);
        $reviews = $this->reviewService->getByFilmId($id);

        $reviewsContent = array();
        $reviewsAuthor = array();
        $reviewsGood = array();
        $reviewsBad = array();
        $reviewsTitle = array();
        $reviewsAuthorAvatar = array();

        foreach ($reviews as $review) {
            $reviewsContent[] = $review->getContent();
            $reviewsAuthor[] = $this->userService->getById($review->getAuthorId())->getUsername();
            $reviewsAuthorAvatar[] = $this->userService->getById($review->getAuthorId())->getPhoto();
            $reviewsTitle[] = $review->getTitle();
            $reviewsGood[] = $review->getGoodVotes();
            $reviewsBad[] = $review->getBadVotes();
        }

        return $this->render('film\filmpage.html.twig',[
            'logedusername'=> '00NickName',//$userNow->getUsername(),
            'logeduserphoto'=> '1.png',//$userNow->getPhoto(),
            'Filmsname'=> $film->getName(),
            'Filmsfoto' => $film->getPhoto(),
            'FilmDirector' => $film->getDirector(),
            'FilmActors' => $film->getActors(),
            'reviewfotos' => $reviewsAuthorAvatar,
            'reviewcoments' => $reviewsContent,
            'reviewusers' => $reviewsAuthor,
            'reviewpluss' => $reviewsGood,
            'reviewminus' => $reviewsBad,
        ]);
    }


/////////////////////delete everything below\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
   


//////////////////////////////////\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
}