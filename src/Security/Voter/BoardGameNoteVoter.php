<?php

namespace App\Security\Voter;

use App\Entity\BoardGameNote;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class BoardGameNoteVoter extends Voter
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['NOTE_EDIT', 'NOTE_DELETE'])
            && $subject instanceof \App\Entity\BoardGameNote;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof User) {
            return false;
        }

        /** @var BoardGameNote $quote */
        $boardGameNote = $subject;

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'NOTE_EDIT':
                return $this->canEdit($boardGameNote, $user);
            case 'NOTE_DELETE':
                return $this->canDelete($boardGameNote, $user);
        }
        throw new \LogicException('This code should not be reached!');
    }

    private function canEdit(BoardGameNote $boardGameNote, User $user): bool
    {
        return $boardGameNote->getUser() === $user;
    }

    private function canDelete(BoardGameNote $boardGameNote, User $user): bool
    {
        return $boardGameNote->getUser() === $user or $this->security->isGranted('ROLE_ADMIN');
    }
}
