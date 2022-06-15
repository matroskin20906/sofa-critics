<?php

namespace App\Controller;

use App\Entity\Review;
use App\Form\ReviewType;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReviewController extends AbstractController
{
    public function __construct(
        private UserService $userService,
    ){
    }

    #[Route('/review/new/{filmId}', name: 'app_review_new', requirements: ['filmId' => '\d+'],
        defaults: ['filmId' => '1'])]
    public function new(Request $request, string $filmId, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $review = new Review();
        $userNow = $this->userService->getById($user->getUserIdentifier());
        $review->setAuthorId($userNow->getId());
        $review->setFilmId((int)$filmId);
        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($review);
            $entityManager->flush();
            return $this->redirectToRoute('app_welcome');
        }

        return $this->renderForm('review/new.html.twig', [
            'reviewForm' => $form,
            'logedusername'=> $userNow->getUsername(),
            'logeduserphoto'=> $userNow->getPhotoFile(),
            ''
        ]);
    }
}