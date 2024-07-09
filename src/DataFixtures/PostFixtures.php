<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class PostFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
    
        $post = new Post();
        $post->setTitle($faker->realTextBetween(10, 20))
                ->setContent($faker->realTextBetween(50, 300))
                ->setCover("post.jpg")
                ->setActive(true)
                ->setAuthor($this->getReference('author'))
                ->addCategory($this->getReference('category'));
        $manager->persist($post);

        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}
