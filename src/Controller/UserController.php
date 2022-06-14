<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Service\UserUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user/new', name: 'user_new')]
    public function new(Request $request,  UserUploader $userUploader): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $pictureFile */
            $pictureFile = $form->get('photoFile')->getData();

            if ($pictureFile) {
                $originalFilename = pathinfo($pictureFile->getClientOriginalName(), PATHINFO_FILENAME);
                $pictureFileName = $userUploader->upload($pictureFile);
                $newFilename = $user->getUserIdentifier();

                // Move the file to the directory where user pictures are stored
                try {
                    $pictureFile->move(
                        $this->getParameter('user_photos_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

            }

            return $this->redirectToRoute('app_welcome');
        }

        return $this->renderForm('user/new.html.twig', [
            'userForm' => $form,           // ... changed name from form into userForm
            'logedusername'=> '1TESTUSER1',
            'logeduserphoto'=> '1.png',
        ]);
    }

/////////////////////////delete everything below\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

//////////////////////////////////\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
}