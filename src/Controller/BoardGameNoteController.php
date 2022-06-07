<?php

namespace App\Controller;

use App\Entity\BoardGameNote;
use App\Repository\BoardGameNoteRepository;
use App\Repository\BoardGameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

class BoardGameNoteController extends AbstractController
{
    /**
     * @Route("/board_game/note/new", name="board_game_wish_new", methods={"POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function note_add(Request $request, EntityManagerInterface $entityManager, BoardGameNoteRepository $boardGameNoteRepository, BoardGameRepository $boardGameRepository, SerializerInterface $serializer): Response
    {
        $data = $request->request->all();

        $boardGame = $boardGameRepository->findOneBy([
            'id' => $data["board_game"],
        ]);

        if ($boardGameNoteRepository->findOneBy([
            'boardGame' => $data["board_game"],
            'user' => $this->getUser(),
        ])) {
            return $this->json([
                'add' => false,
            ], 200);
        }

        $boardGameNote = new BoardGameNote();
        $boardGameNote->setBoardGame($boardGame);
        $boardGameNote->setUser($this->getUser());
        $boardGameNote->setNote($data["note"]);
        $boardGameNote->setComment($data["comment"]);

        $boardGameNoteRepository->add($boardGameNote);
        return $this->json([
            'add' => true,
            'boardGameNote' => $serializer->serialize(
                $boardGameNote,
                'json',
                ['groups' => 'note']
            ),
        ], 200);
    }

    /**
     * @Route("/board_game/note/{id}/edit", name="board_game_wish_edit", methods={"POST"})
     * @IsGranted("NOTE_EDIT", subject="boardGameNote")
     */
    public function note_edit(Request $request, BoardGameNote $boardGameNote, BoardGameNoteRepository $boardGameNoteRepository, SerializerInterface $serializer): Response
    {
        $data = $request->request->all();

        $boardGameNote->setNote($data["note"]);
        $boardGameNote->setComment($data["comment"]);
        $boardGameNoteRepository->add($boardGameNote);
        return $this->json([
            'edit' => true,
            'boardGameNote' => $serializer->serialize(
                $boardGameNote,
                'json',
                ['groups' => 'note']
            ),
        ], 200);
    }

    /**
     * @Route("/board_game/note/{id}/delete", name="board_game_wish_delete", methods={"POST"})
     * @IsGranted("NOTE_DELETE", subject="boardGameNote")
     */
    public function note_delete(BoardGameNote $boardGameNote, BoardGameNoteRepository $boardGameNoteRepository): Response
    {
        if ($boardGameNoteRepository->remove($boardGameNote)) {
            return $this->json([
                'delete' => true,
            ], 200);
        }
        return $this->json([
            'delete' => false,
        ], 200);
    }
}
