<?php

namespace Blog\Bundle\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Blog\Bundle\BlogBundle\Entity\Post;
use Blog\Bundle\BlogBundle\Entity\Category;


class CategoryFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->getCategoryArray() as $title) {
            $category = new Category();
            $category->setTitle($title);
            $manager->persist($category);
            $this->addReference($title, $category);
        }

        $manager->flush();
    }

    protected function getCategoryArray()
    {
        return array(
            "Symfony",
            "JS",
            "Geekhub",
            "Literature",

        );
    }

    public function getOrder()
    {
        return 2;
    }
} 