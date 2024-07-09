<?php

namespace App\Test\Integration\Category;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\Category;

class CategoryTest extends KernelTestCase
{
    private ?EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }
    public function testCategoryEntity(): void
    {
        $category = new Category();
        $category->setName("test slug");
        $category->setSlug("test-slug");

        $this->entityManager->persist($category);
        $this->entityManager->flush();

        $CategoryRepository = $this->entityManager->getRepository(Category::class);
        $category = $CategoryRepository->findOneBy(["name"=> "test slug"]);
        $this->assertEquals("test slug", $category->getName());
        $this->assertEquals("test-slug", $category->getSlug());

    }

    public function tearDown(): void
    {
        parent::tearDown();
        $connection = $this->entityManager->getConnection();
        $platform = $connection->getDatabasePlatform();
        $connection->executeStatement($platform->getTruncateTableSQL('category', true/* whether to cascade */));    
        
        $this->entityManager->close();
        $this->entityManager = null;
    }
}