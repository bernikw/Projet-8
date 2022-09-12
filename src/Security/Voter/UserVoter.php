<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class UserVoter extends Voter
{
    public const ROLE_ADMIN = 'ROLE_ADMIN';

    private $security;

    public function __construct(Security $security){
        
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::ROLE_ADMIN])
            && $subject instanceof \App\Entity\User;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
              // the user must be logged in; if not, deny access
            return false;
        }
        
        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {

            case self::ROLE_ADMIN:

        
                if ($subject->getUsername() === "anonyme" && $this->security->isGranted('ROLE_ADMIN'))
                {
                    //only admin user can delete tasks assigned to the anonymous author
                    return true;
                }
                break;
        }

        return false;
    }
}
