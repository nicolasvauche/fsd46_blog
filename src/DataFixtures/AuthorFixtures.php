<?php

namespace App\DataFixtures;

use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AuthorFixtures extends Fixture implements OrderedFixtureInterface
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
        $this->addReference('author', $author);

        $author = new Author();
        $author->setPseudo("Wonder Woman")
            ->setEmail('author2@blog.com')
            ->setPassword($this->hasher->hashPassword($author, "author"))
            ->setRoles(["ROLE_AUTHOR"]);
        $manager->persist($author);
        $this->addReference('author2', $author);
        
        $manager->flush();
    }
    public function getOrder()
    {
        return 1;
    }
}
