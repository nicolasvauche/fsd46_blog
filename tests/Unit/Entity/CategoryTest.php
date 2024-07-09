<?php

namespace App\Test\Unit\Entity;

use App\Entity\Category;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{
    public function testEntity()
    {
        $category = new Category();
        $category->setName("test");
        $this->assertEquals("test", $category->getName());
        
        $category->setSlug("mon-super-slug-test");
        $this->assertEquals("mon-super-slug-test", $category->getSlug());
    }
    
}