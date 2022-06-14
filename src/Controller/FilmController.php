<?php

namespace App\Controller;

use App\Entity\Film;
use App\Form\FilmType;
use App\Service\FilmUploader;
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

        return $this->renderForm('film/new.html.twig', [
            'filmForm' => $form,             // ... changed name from form into filmForm
            'logedusername'=> 'Default',//$user->getUserIdentifier(),
            'logeduserphoto'=> '1.png',
        ]);
    }

    #[Route('/', name: 'app_welcome', methods: ['GET'])]
    public function welcome(): Response
    {
        return $this->render('home\homepage.html.twig',[
            'logedusername'=> 'NameNick99',
            'logeduserphoto'=> '1.png',
            'Filmsnames' => $Barrayname = array(
                1 => 'V means Vendetto',
                2 => 'D means Dislecsia',
                3 => 'L means Logic',
            ),
            'Filmsfotos' => $Barrayfoto = array(
                1 => '2.png',
                2 => '3.png',
                3 => '4.png',
            ),
        ]);
    }

    #[Route('/film', name: 'app_filmpage', methods: ['GET'])]
    public function id(): Response
    {
        return $this->render('film\filmpage.html.twig',[
            'logedusername'=> '00NickName',
            'logeduserphoto'=> '1.png',
            'Filmsname'=> 'L means Logic',
            'Filmsfoto' => '4.png',
            'reviewfotos' => $Barrayreviewfoto = array(
                1 => '2.png',
                2 => '3.png',
            ),
            'reviewcoments' => $Barrayreviewcoment = array(
                1 => 'I hate my live',
                2 => 'I love my hate',
            ),
            'reviewusers' => $Barrayreviewusers = array(
                1 => 'NameNick99',
                2 => '1TESTUSER1',
            ),
            'reviewpluss' => $Barrayreviewpluss = array(
                1 => '10',
                2 => '0',
            ),
            'reviewminus' => $Barrayreviewminus = array(
                1 => '20',
                2 => '100',
            ),
        ]);
    }


/////////////////////delete everything below\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
   


//////////////////////////////////\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
}