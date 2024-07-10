<?php

namespace App\Test\Integration\Category;

use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\Category;

class CategoryTest extends KernelTestCase
{
    private ?EntityManagerInterface $entityManager;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $connection = $this->entityManager->getConnection();
        $platform = $connection->getDatabasePlatform();
        $connection->executeStatement('SET FOREIGN_KEY_CHECKS=0;');
        $connection->executeStatement($platform->getTruncateTableSQL('category', true/* whether to cascade */));
        $connection->executeStatement('SET FOREIGN_KEY_CHECKS=1;');
    }

    public function testCategoryEntity(): void
    {
        $category = new Category();
        $category->setName("test slug");
        $category->setSlug("test-slug");

        $this->entityManager->persist($category);
        $this->entityManager->flush();

        $CategoryRepository = $this->entityManager->getRepository(Category::class);
        $category = $CategoryRepository->findOneBy(["name" => "test slug"]);
        $this->assertEquals("test slug", $category->getName());
        $this->assertEquals("test-slug", $category->getSlug());

    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
