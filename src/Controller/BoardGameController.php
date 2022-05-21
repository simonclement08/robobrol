<?php

namespace App\Controller;

use App\Entity\BoardGame;
use App\Entity\BoardGameOwned;
use App\Entity\BoardGameWish;
use App\Form\BoardGameType;
use App\Repository\BoardGameOwnedRepository;
use App\Repository\BoardGameRepository;
use App\Repository\BoardGameWishRepository;
use App\Repository\ImageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

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
        if ($this->isCsrfTokenValid('delete' . $boardGame->getId(), $request->request->get('_token'))) {
            $boardGameRepository->remove($boardGame);
        }

        return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/board_game/{id}/wish", name="board_game_wish", methods={"POST"})
     * @IsGranted("ROLE_USER")
     */
    public function wish(BoardGame $boardGame, EntityManagerInterface $entityManager, BoardGameWishRepository $boardGameWishRepository): Response
    {
        $user = $this->getUser();

        if ($boardGame->isWishByUser($user)) {
            $wish = $boardGameWishRepository->findOneBy([
                'user' => $user,
                'boardGame' => $boardGame
            ]);
            $entityManager->remove($wish);
            $entityManager->flush();
            return $this->json([
                'wish' => false,
                'game_wishes' => $boardGameWishRepository->count(
                    ['user' => $user]
                )
            ], 200);
        }

        $wish = new BoardGameWish();

        $wish->setUser($user)
            ->setBoardGame($boardGame);

        $entityManager->persist($wish);
        $entityManager->flush();
        return $this->json([
            'wish' => true,
            'game_wishes' => $boardGameWishRepository->count(
                ['user' => $user]
            )
        ], 200);
    }

    /**
     * @Route("/board_game/{id}/own", name="board_game_own", methods={"POST"})
     * @IsGranted("ROLE_USER")
     */
    public function own(BoardGame $boardGame, EntityManagerInterface $entityManager, BoardGameWishRepository $boardGameWishRepository, BoardGameOwnedRepository $boardGameOwnedRepository, SerializerInterface $serializer, ImageRepository $imageRepository, UploaderHelper $helper): Response
    {
        $user = $this->getUser();

        if ($boardGame->isOwnByUser($user)) {
            $wish = $boardGameOwnedRepository->findOneBy([
                'user' => $user,
                'boardGame' => $boardGame
            ]);
            $entityManager->remove($wish);
            $entityManager->flush();
            return $this->json([
                'own' => false,
                'board_game' => $serializer->serialize(
                    $boardGame,
                    'json',
                    ['groups' => 'ajax']
                ),
                'game_owned' => $boardGameOwnedRepository->count(
                    ['user' => $user]
                )
            ], 200);
        }

        $own = new BoardGameOwned();
        $own->setUser($user)
            ->setBoardGame($boardGame);
        $entityManager->persist($own);

        if ($boardGame->isWishByUser($user)) {
            $wish = $boardGameWishRepository->findOneBy([
                'user' => $user,
                'boardGame' => $boardGame
            ]);
            $entityManager->remove($wish);
        }

        $src = $imageRepository->findOneBy([
            'position' => 1,
            'boardGame' => $boardGame
        ]);
        $src = $src ? $helper->asset($src, 'imageFile') : "";

        $entityManager->flush();

        return $this->json([
            'own' => true,
            'board_game' => $serializer->serialize(
                $boardGame,
                'json',
                ['groups' => 'ajax']
            ),
            'image' => $src,
            'game_owned' => $boardGameOwnedRepository->count(
                ['user' => $user]
            ),
            'game_wishes' => $boardGameWishRepository->count(
                ['user' => $user]
            )
        ], 200);
    }
}
