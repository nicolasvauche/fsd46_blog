<?php

namespace App\Test\Controller;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoryControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/categorie/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Category::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Category index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
//        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snouvelle', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'category[name]' => 'Testing',
            'category[slug]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);
        $this->client->followRedirect();

        self::assertSame(1, $this->repository->count([]));
        $this->assertSelectorTextContains('body > table > tbody > tr > td:nth-child(2)', 'Testing');
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Category();
        $fixture->setName('My Title');
        $fixture->setSlug('My Title');
        $fixture->setPosts('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Category');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Category();
        $fixture->setName('Value');
        $fixture->setSlug('Value');
        $fixture->setPosts('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'category[name]' => 'Something New',
            'category[slug]' => 'Something New',
            'category[posts]' => 'Something New',
        ]);

        self::assertResponseRedirects('/category/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getSlug());
        self::assertSame('Something New', $fixture[0]->getPosts());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Category();
        $fixture->setName('Value');
        $fixture->setSlug('Value');
        $fixture->setPosts('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/category/');
        self::assertSame(0, $this->repository->count([]));
    }
}
