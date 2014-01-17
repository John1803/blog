<?php

namespace Blog\Bundle\BlogBundle\Event;

use Blog\Bundle\BlogBundle\Entity\Post;
use Symfony\Component\EventDispatcher\Event;


class PostVisitedEvent extends Event
{
    protected $post;

    /**
     * @param Post $post
     */
    public function setPost(Post $post)
    {
        return $this->post;
    }


    /**
     * @return Post
     */
    public function getPost()
    {
        return $this->post;
    }

} 