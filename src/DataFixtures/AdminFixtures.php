<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminFixtures extends Fixture implements OrderedFixtureInterface
{
    private UserPasswordHasherInterface $hasher;
    
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new Admin();
        $admin->setPseudo("Administrateur")
        ->setEmail('admin@blog.com')
        ->setPassword($this->hasher->hashPassword($admin, "admin"))
        ->setRoles(["ROLE_ADMIN"]);
        $manager->persist($admin);
        
        $manager->flush();
    }
    public function getOrder()
    {
        return 4;
    }
}
