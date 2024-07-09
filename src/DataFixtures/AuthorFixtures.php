<?php

namespace App\DataFixtures;

use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AuthorFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;
    
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $author = new Author();
        $author->setPseudo("Bob Marley")
        ->setEmail('author@blog.com')
        ->setPassword($this->hasher->hashPassword($author, "author"))
        ->setRoles(["ROLE_AUTHOR"]);
        $manager->persist($author);

        $manager->flush();
    }
}
