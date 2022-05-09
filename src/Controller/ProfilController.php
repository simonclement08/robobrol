<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    /**
     * @Route("/profil/{id}", name="profil_user", methods={"GET"})
     */
    public function index(User $user): Response
    {
        $wishlist = $user->getBoardGameWishes();
        $collection = $user->getBoardGameOwneds();
        $user_notes = $user->getBoardGameNotes();

        return $this->render('profil/index.html.twig', [
            'user' => $user,
            'wishlist' => $wishlist,
            'collection' => $collection,
            'user_notes' => $user_notes,
        ]);
    }
}
