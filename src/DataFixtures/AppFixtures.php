<?php

namespace App\DataFixtures;

use App\Entity\User;
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
        $user1 = new User;
        $user1->setUsername('Admin');
        $user1->setEmail('admin@gmail.com');
        $user1->setPassword($this->hash->hashPassword($user1, 'Password20@'));
        $user1->setRoles(['ROLE_ADMIN']);
        $user1->setSlug($user1->getUsername());
        $manager->persist($user1);

        $user2 = new User;
        $user2->setUsername('Alex');
        $user2->setEmail('alex@gmail.com');
        $user2->setPassword($this->hash->hashPassword($user2, 'Password20@'));
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

   

        $manager->flush();
    }
}
