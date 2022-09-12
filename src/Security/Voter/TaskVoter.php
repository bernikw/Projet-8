<?php

namespace App\Security\Voter;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class TaskVoter extends Voter
{

    public const TASK_EDIT = 'TASK_EDIT';
    public const TASK_DELETE = 'TASK_DELETE';
    
    private $security;

    public function __construct(Security $security)
    {

        $this->security = $security;
    }

    protected function supports(string $attribute, $task): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [ self::TASK_EDIT, self::TASK_DELETE])
            && $task instanceof \App\Entity\Task;
    }

    protected function voteOnAttribute(string $attribute, $task, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        } 
        

        if(null === $task->getUser()) return false;

        if ($task->getUser()->getUsername() === "anonyme" && $this->security->isGranted('ROLE_ADMIN')) {
    
            return true;
       
        }
        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {

            case self::TASK_EDIT:
                
                return $this->canEdit($task, $user);
       
                break;

            case self::TASK_DELETE:
                
                return $this->canDelete($task, $user);
       
                break;
           
        }

        return false;
    }

    private function canEdit(Task $task, User $user){

        return $user === $task->getUser();

    }

    private function canDelete(Task $task, User $user){

 
        return $user === $task->getUser(); 
   
    }
}
