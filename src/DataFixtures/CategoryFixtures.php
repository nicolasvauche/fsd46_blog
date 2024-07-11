<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Gedmo\Translatable\Entity\Translation;

class CategoryFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $repository = $manager->getRepository(Translation::class);

        $category = new Category();
        $category->setName('musique');
        $repository->translate($category, 'name', 'en', 'music')
            ->translate($category, 'slug', 'en', 'music');
        $manager->persist($category);
        $this->addReference('category', $category);

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 2;
    }
}
