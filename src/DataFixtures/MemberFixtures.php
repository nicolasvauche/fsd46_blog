<?php

namespace App\DataFixtures;

use App\Entity\Member;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class MemberFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;
    
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $member = new Member();
        $member->setPseudo("Member")
        ->setEmail('member@blog.com')
        ->setPassword($this->hasher->hashPassword($member, "member"))
        ->setFirstname('utilisateur')
        ->setLastname('test');
        $manager->persist($member);
        
        $manager->flush();
    }
    public function getOrder()
    {
        return 5;
    }
}
