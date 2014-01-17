<?php
//
//namespace Blog\Bundle\BlogBundle\Entity;
//
//use Doctrine\ORM\Mapping as ORM;
//use Symfony\Component\Validator\Constraints as Assert;
//use Doctrine\Common\Collections\ArrayCollection;
//
///**
// * Tag
// *
// * @ORM\Table(name="tag")
// * @ORM\Entity(repositoryClass="Blog\Bundle\BlogBundle\Entity\TagRepository")
// */
//class Tag
//{
//    /**
//     * @var integer
//     *
//     * @ORM\Column(name="id", type="integer")
//     * @ORM\Id
//     * @ORM\GeneratedValue(strategy="AUTO")
//     */
//    private $id;
//
//    /**
//     * @var string
//     *
//     * @ORM\Column(name="title", type="string", length=17)
//     */
//    private $title;
//
//    /**
//     *
//     * @Gedmo\Slug(fields={"title"})
//     * @ORM\Column(type="string", length=100, unique=true)
//     */
//    protected $slug;
//
//    /**
//     * @ORM\ManyToMany(targetEntity="Post", inversedBy="tags")
//     */
//    private $posts;
//
//    public function __construct()
//    {
//        $this->posts = new ArrayCollection();
//    }
//
//    /**
//     * Get id
//     *
//     * @return integer
//     */
//    public function getId()
//    {
//        return $this->id;
//    }
//
//    /**
//     * Set title
//     *
//     * @param string $title
//     * @return Tag
//     */
//    public function setTitle($title)
//    {
//        $this->title = $title;
//
//        return $this;
//    }
//
//    /**
//     * Get title
//     *
//     * @return string
//     */
//    public function getTitle()
//    {
//        return $this->title;
//    }
//
//    /**
//     *
//     * @param ArrayCollection $posts
//     * @return $this
//     */
//    public function setPosts(ArrayCollection $posts)
//    {
//        $this->posts = $posts;
//
//        return $this;
//    }
//
//    /**
//     * @return ArrayCollection
//     */
//    public function getPosts()
//    {
//        return $this->posts;
//    }
//
//    /**
//     * @param mixed $slug
//     */
//    public function setSlug($slug)
//    {
//        $this->slug = $slug;
//    }
//
//    /**
//     * @return mixed
//     */
//    public function getSlug()
//    {
//        return $this->slug;
//    }
//
//
//}
