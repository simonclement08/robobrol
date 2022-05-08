<?php

namespace App\Controller;

use App\Entity\BoardGame;
use App\Form\BoardGameType;
use App\Repository\BoardGameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class BoardGameController extends AbstractController
{
    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function index(BoardGameRepository $boardGameRepository): Response
    {
        return $this->render('board_game/index.html.twig', [
            'board_games' => $boardGameRepository->findAll(),
        ]);
    }

    /**
     * @Route("/board_game/new", name="board_game_new", methods={"GET", "POST"})
     */
    public function new(Request $request, BoardGameRepository $boardGameRepository): Response
    {
        $boardGame = new BoardGame();
        $form = $this->createForm(BoardGameType::class, $boardGame);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $boardGameRepository->add($boardGame);
            return $this->redirectToRoute('board_game_index', [], Response::HTTP_SEE_OTHER);
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
     */
    public function edit(Request $request, BoardGame $boardGame, BoardGameRepository $boardGameRepository): Response
    {
        $form = $this->createForm(BoardGameType::class, $boardGame);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
     */
    public function delete(Request $request, BoardGame $boardGame, BoardGameRepository $boardGameRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$boardGame->getId(), $request->request->get('_token'))) {
            $boardGameRepository->remove($boardGame);
        }

        return $this->redirectToRoute('board_game_index', [], Response::HTTP_SEE_OTHER);
    }
}
