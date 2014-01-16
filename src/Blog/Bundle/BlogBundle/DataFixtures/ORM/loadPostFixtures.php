<?php

namespace Blog\Bundle\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Yaml\Yaml;
use Blog\Bundle\BlogBundle\Entity\Post;

class PostFixtures extends AbstractFixture implements OrderedFixtureInterface

{
    public function getOrder()
    {
        return 3;
    }

    public function load(ObjectManager $manager)
    {
        $posts = Yaml::parse(file_get_contents(__DIR__."/data/dataPost.yml"));

        foreach ($posts['posts'] as $key => $item) {
            $post = new Post();

            $post
                ->setTitle($item['title'])
                ->setImage($item['pictureName'])
                ->setAuthor($item['author'])
                ->setPost($item['post'])
                ->setVisitedIncrement($item['visited'])
                ->setCategory($this->getReference($item['category']));
//                ->setTags($this->getReferencesFromArray($item['tags']));

            $manager->persist($post);
        }

        $manager->flush();
    }

    protected function getReferencesFromArray(array $array)
    {
        $outputReferences = new ArrayCollection();

        foreach ($array as $reference) {
            $outputReferences->add($this->getReference($reference));
        }

        return $outputReferences;
    }
}

