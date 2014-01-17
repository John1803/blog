<?php

namespace Blog\Bundle\BlogBundle\EventListener;

use Blog\Bundle\BlogBundle\Entity\PostRepository;
use Doctrine\ORM\EntityManager;
use Blog\Bundle\BlogBundle\Event\PostVisitedEvent;

class PostVisitedListener
{
    protected $repository;

    public function __construct(PostRepository $repository)
    {
        $this->repository = $repository;
    }

    public function onPostVisited(PostVisitedEvent $event)
    {
        $this->repository->visitedIncrement($event->getPost()->getId());


//        $em = $this->em->getManager();
//
//        /**
//         * @var \Doctrine\ORM\Query $query
//         */
//
//        $query = $em->createQuery(
//            'UPDATE BlogBlogBundle:Post p
//            SET p.visitedIncrement = p.visitedIncrement + 1
//            WHERE p.id = :post_id')
//            ->setParameter(':post_id', $event->getPost()->getId()
//            );
//
//        $query->execute();
//    }
    }
}