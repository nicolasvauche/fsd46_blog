<?php

namespace App\Test\Unit\Entity;

use App\Entity\Author;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class AuthorTest extends TestCase
{
    public function testEntity()
    {
        $author = new Author();
        $this->assertInstanceOf(User::class, $author);
        $author->setEmail("test@test.test");
        $this->assertEquals("test@test.test", $author->getEmail());
        $author->setPassword("test");
        $this->assertEquals("test", $author->getPassword());
        $author->setRoles(["ROLE_TEST"]);
        $this->assertContains("ROLE_TEST", $author->getRoles());
    }
}