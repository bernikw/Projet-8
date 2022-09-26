<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{


    public function __construct(UserPasswordHasherInterface $hash)
    {
        $this->hash = $hash;
    }

    public function load(ObjectManager $manager): void
    {

        //users
        $user1 = new User;
        $user1->setUsername('Admin');
        $user1->setEmail('admin@gmail.com');
        $user1->setPassword($this->hash->hashPassword($user1, 'Password21@'));
        $user1->setRoles(['ROLE_ADMIN']);
        $user1->setSlug($user1->getUsername());
        $manager->persist($user1);

        $user2 = new User;
        $user2->setUsername('anonyme');
        $user2->setEmail('anonyme@gmail.com');
        $user2->setPassword($this->hash->hashPassword($user2, 'Password22@'));
        $user2->setRoles(['ROLE_USER']);
        $user2->setSlug($user2->getUsername());
        $manager->persist($user2);

        $user3 = new User;
        $user3->setUsername('Anna');
        $user3->setEmail('anna@gmail.com');
        $user3->setPassword($this->hash->hashPassword($user3, 'Password20@'));
        $user3->setRoles(['ROLE_USER']);
        $user3->setSlug($user3->getUsername());
        $manager->persist($user3);

        $user4 = new User;
        $user4->setUsername('Bill');
        $user4->setEmail('bill@gmail.com');
        $user4->setPassword($this->hash->hashPassword($user4, 'Password20@'));
        $user4->setRoles(['ROLE_USER']);
        $user4->setSlug($user4->getUsername());
        $manager->persist($user4);

        //tasks

        for ($l = 1; $l <= 5; $l++){
            $task = new Task;
            $task->setCreatedAt(new DateTimeImmutable());
            $task->setTitle('Task');
            $task->setContent('Donec tellus est, sodales quis semper a, 
            cursus ut massa. Curabitur at laoreet mauris. 
            In auctor quis libero eu consectetur. Cras tincidunt ullamcorper est at porta.
            Sed faucibus tristique cursus. Proin faucibus iaculis ipsum, sed pellentesque augue. 
            Maecenas a varius sem, vel molestie justo. Lorem ipsum dolor sit amet, consectetur 
            adipiscing elit. Nulla at ullamcorper massa, sit amet bibendum sem.');
            $task->setIsDone(false);
            $task->setSlug($task->getTitle());
            $task->setUser($user1); 
            $manager->persist($task);
            
        }

        for ($i = 1; $i <= 5; $i++){
            $task1 = new Task;
            $task1->setCreatedAt(new DateTimeImmutable());
            $task1->setTitle('Task1');
            $task1->setContent('Donec tellus est, sodales quis semper a, 
            cursus ut massa. Curabitur at laoreet mauris. 
            In auctor quis libero eu consectetur. Cras tincidunt ullamcorper est at porta.
            Sed faucibus tristique cursus. Proin faucibus iaculis ipsum, sed pellentesque augue. 
            Maecenas a varius sem, vel molestie justo. Lorem ipsum dolor sit amet, consectetur 
            adipiscing elit. Nulla at ullamcorper massa, sit amet bibendum sem.');
            $task1->setIsDone(false);
            $task1->setSlug($task1->getTitle());
            $task1->setUser($user2);            
            $manager->persist($task1);    

        } 

        for ($j = 6; $j <=10; $j++){
            $task2 = new Task;
            $task2->setCreatedAt(new DateTimeImmutable());
            $task2->setTitle('Task2');
            $task2->setContent('Donec tellus est, sodales quis semper a, 
            cursus ut massa. Curabitur at laoreet mauris. 
            In auctor quis libero eu consectetur. Cras tincidunt ullamcorper est at porta.
            Sed faucibus tristique cursus. Proin faucibus iaculis ipsum, sed pellentesque augue. 
            Maecenas a varius sem, vel molestie justo. Lorem ipsum dolor sit amet, consectetur 
            adipiscing elit. Nulla at ullamcorper massa, sit amet bibendum sem.');
            $task2->setIsDone(false);
            $task2->setSlug($task2->getTitle());
            $task2->setUser($user3);
            $manager->persist($task2);
        }

        for ($k = 11; $k <=15; $k++){
            $task3 = new Task;           
            $task3->setCreatedAt(new DateTimeImmutable());
            $task3->setTitle('Task3');
            $task3->setContent('Donec tellus est, sodales quis semper a, 
            cursus ut massa. Curabitur at laoreet mauris. 
            In auctor quis libero eu consectetur. Cras tincidunt ullamcorper est at porta.
            Sed faucibus tristique cursus. Proin faucibus iaculis ipsum, sed pellentesque augue. 
            Maecenas a varius sem, vel molestie justo. Lorem ipsum dolor sit amet, consectetur 
            adipiscing elit. Nulla at ullamcorper massa, sit amet bibendum sem.');
            $task3->setIsDone(false);
            $task3->setSlug($task3->getTitle());
            $task3->setUser($user4);
            $manager->persist($task3);
        }


        $manager->flush();
    }
}
