<?php

namespace Blog\Bundle\BlogBundle\EventListener;

use Doctrine\ORM\EntityManager;
use Blog\Bundle\BlogBundle\Event\PostVisitedEvent;

class PostVisitedListener
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

        public function onPostVisited(PostVisitedEvent $event)
    {
        $om = $this->em->getManager();

        /**
         * @var \Doctrine\ORM\Query $query
         */

        $query = $om->createQuery(
            'UPDATE BlogBlogBundle:Post p
            SET p.visitedIncrement = p.visitedIncrement + 1
            WHERE p.id = :post_id')
            ->setParameter(':post_id', $event->getPost()->getId()
            );

        $query->execute();
    }
    }