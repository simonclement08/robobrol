<?php

namespace App\Controller;

use App\Entity\BoardGame;
use App\Entity\BoardGameOwned;
use App\Entity\BoardGameWish;
use App\Form\BoardGameType;
use App\Form\FilterFormType;
use App\Repository\BoardGameOwnedRepository;
use App\Repository\BoardGameRepository;
use App\Repository\BoardGameWishRepository;
use App\Repository\ImageRepository;
use App\Repository\ThemeRepository;
use App\Repository\TypeRepository;
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
    public function index(BoardGameRepository $boardGameRepository, ThemeRepository $themeRepository, TypeRepository $typeRepository, Request $request): Response
    {
        $form = $this->createForm(FilterFormType::class, null, [
            'method' => 'GET',
        ]);
        $form->handleRequest($request);

        $search = $form->get('search')->getData();
        $price = $form->get('price')->getData();
        $nb_players = $form->get('nb_player')->getData();
        $game_time = $form->get('game_time')->getData();
        $target = $form->get('target')->getData();
        $age_min = $form->get('age_min')->getData();
        $gamme = $form->get('gamme')->getData();
        $theme = $form->get('theme')->getData();
        $type = $form->get('type')->getData();

        $boardGames = $boardGameRepository->createQueryBuilder('b')
            ->leftJoin('b.boardGameThemes', 'th')
            ->leftJoin('b.boardGameTypes', 't')
            ->where('b.name LIKE :name')
            ->setParameter('name', '%' . $search . '%');
        dump($form->getData());

        if ($price === '+60') {
            $boardGames = $boardGames->andWhere('b.price > 61');
        } elseif ($price) {
            $boardGames->andWhere('b.price <= ' . $price);
        }

        if ($nb_players === 9) {
            $boardGames = $boardGames->andWhere('b.nbMaxPlayer >= ' . $nb_players);
        } elseif ($nb_players) {
            $boardGames = $boardGames->andWhere('b.nbMinPlayer <= ' . $nb_players . ' and b.nbMaxPlayer >= ' . $nb_players);
        }

        if ($game_time) {
            $game_time = explode("-", $game_time);
            $boardGames = $boardGames->andWhere('b.gameTime >= ' . $game_time[0]);
            if (isset($game_time[1])) {
                $boardGames->andWhere('b.gameTime <= ' . $game_time[1]);
            }
        }

        if ($target) {
            $boardGames = $boardGames->andWhere('b.target = :target')
                ->setParameter('target', $target);
        }

        if ($age_min) {
            $age_min = explode("-", $age_min);
            $boardGames = $boardGames->andWhere('b.ageMin >= ' . $age_min[0]);
            if (isset($age_min[1])) {
                $boardGames = $boardGames->andWhere('b.ageMin <= ' . $age_min[1]);
            }
        }

        if ($gamme) {
            $boardGames = $boardGames->andWhere('b.gamme = :target')
                ->setParameter('target', $gamme);
        }

        if ($theme) {
            $boardGames = $boardGames->andWhere('th.theme = :theme')
                ->setParameter('theme', $theme);
        }

        if ($type) {
            $boardGames = $boardGames->andWhere('t.type = :type')
                ->setParameter('type', $type);
        }

        $boardGames = $boardGames->groupBy('b.id')
            ->orderBy('b.name', 'ASC')
            ->getQuery()
            ->getResult();

        return $this->render('board_game/index.html.twig', [
            'board_games' => $boardGames,
            'form' => $form->createView(),
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
     * @Route("/board_game/{slug}", name="board_game_show", methods={"GET"})
     */
    public function show(BoardGame $boardGame): Response
    {
        return $this->render('board_game/show.html.twig', [
            'board_game' => $boardGame,
        ]);
    }

    /**
     * @Route("/board_game/{slug}/edit", name="board_game_edit", methods={"GET", "POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, BoardGame $boardGame, BoardGameRepository $boardGameRepository, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BoardGameType::class, $boardGame);
        $form->handleRequest($request);

        $originalImages = new ArrayCollection();
        $originalMarkets = new ArrayCollection();
        $originalThemes = new ArrayCollection();
        $originalTypes = new ArrayCollection();
        $originalVideos = new ArrayCollection();

        foreach ($boardGame->getImages() as $image) {
            $originalImages->add($image);
        }
        foreach ($boardGame->getBoardGameMarkets() as $market) {
            $originalMarkets->add($market);
        }
        foreach ($boardGame->getBoardGameThemes() as $theme) {
            $originalThemes->add($theme);
        }
        foreach ($boardGame->getBoardGameTypes() as $type) {
            $originalTypes->add($type);
        }
        foreach ($boardGame->getVideos() as $video) {
            $originalVideos->add($video);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($originalImages as $image) {
                if (false === $boardGame->getImages()->contains($image)) {
                    $entityManager->remove($image);
                }
            }
            foreach ($originalMarkets as $market) {
                if (false === $boardGame->getBoardGameMarkets()->contains($market)) {
                    $entityManager->remove($market);
                }
            }
            foreach ($originalThemes as $theme) {
                if (false === $boardGame->getBoardGameThemes()->contains($theme)) {
                    $entityManager->remove($theme);
                }
            }
            foreach ($originalTypes as $type) {
                if (false === $boardGame->getBoardGameTypes()->contains($type)) {
                    $entityManager->remove($type);
                }
            }
            foreach ($originalVideos as $video) {
                if (false === $boardGame->getVideos()->contains($video)) {
                    $entityManager->remove($video);
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
     * @Route("/board_game/{slug}", name="board_game_delete", methods={"POST"})
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
     * @Route("/board_game/{slug}/wish", name="board_game_wish", methods={"POST"})
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
     * @Route("/board_game/{slug}/own", name="board_game_own", methods={"POST"})
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
