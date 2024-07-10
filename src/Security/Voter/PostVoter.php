<?php

namespace App\Security\Voter;

use App\Entity\Post;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class PostVoter extends Voter
{
    public const EDIT = 'POST_EDIT';
    public const DELETE = 'POST_DELETE';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::EDIT, self::DELETE])
            && $subject instanceof Post;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        // if the user is anonymous, do not grant access
        if(!$user instanceof UserInterface) {
            return false;
        }

        // If the user is admin, grant access
        if(in_array('ROLE_ADMIN', $user->getRoles())) {
            return true;
        }

        $post = $subject;

        return match ($attribute) {
            self::EDIT, self::DELETE => $post->getAuthor() === $user,
            default => throw new \LogicException('This code should not be reached!'),
        };
    }
}
