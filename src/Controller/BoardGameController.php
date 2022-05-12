<?php

namespace App\Controller;

use App\Entity\BoardGame;
use App\Form\BoardGameType;
use App\Repository\BoardGameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class BoardGameController extends AbstractController
{
    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function index(BoardGameRepository $boardGameRepository): Response
    {
        foreach ($boardGameRepository->findAll() as $key => $board) {
            $board->getImages()->initialize();
        }
        return $this->render('board_game/index.html.twig', [
            'board_games' => $boardGameRepository->findAll(),
        ]);
    }

    /**
     * @Route("/board_game/new", name="board_game_new", methods={"GET", "POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request, BoardGameRepository $boardGameRepository): Response
    {
        $boardGame = new BoardGame();
        $form = $this->createForm(BoardGameType::class, $boardGame);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $boardGameRepository->add($boardGame);
            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('board_game/new.html.twig', [
            'board_game' => $boardGame,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/board_game/{id}", name="board_game_show", methods={"GET"})
     */
    public function show(BoardGame $boardGame): Response
    {
        return $this->render('board_game/show.html.twig', [
            'board_game' => $boardGame,
        ]);
    }

    /**
     * @Route("/board_game/{id}/edit", name="board_game_edit", methods={"GET", "POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, BoardGame $boardGame, BoardGameRepository $boardGameRepository, EntityManagerInterface $entityManager): Response
    {
        dump($boardGame->getImages()->getValues());
        $form = $this->createForm(BoardGameType::class, $boardGame);
        $form->handleRequest($request);

        $originalImages = new ArrayCollection();

        foreach ($boardGame->getImages() as $image) {
            $originalImages->add($image);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($originalImages as $image) {
                if (false === $boardGame->getImages()->contains($image)) {
                    $entityManager->remove($image);
                }
            }

            $boardGameRepository->add($boardGame);
            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('board_game/edit.html.twig', [
            'board_game' => $boardGame,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/board_game/{id}", name="board_game_delete", methods={"POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, BoardGame $boardGame, BoardGameRepository $boardGameRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$boardGame->getId(), $request->request->get('_token'))) {
            $boardGameRepository->remove($boardGame);
        }

        return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
    }
}
