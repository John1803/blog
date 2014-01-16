<?php

namespace Blog\Bundle\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="Blog\Bundle\BlogBundle\Entity\CategoryRepository")
 */
class Category
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     *
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(type="string", length=100, unique=true)
     */
    protected $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="posts")
     * @ORM\OneToMany(targetEntity="Post", mappedBy="category")
     */
    private $posts;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Category
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set posts
     *
     * param ArrayCollection $posts
     * @return $this
     */
    public function setPosts(ArrayCollection $posts)
    {
        $this->posts = $posts;

        return $this;
    }

    /**
     * Get posts
     *
     * @return $this
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }


}
