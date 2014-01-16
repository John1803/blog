<?php

namespace Blog\Bundle\BlogBundle\Controller;

use Blog\Bundle\BlogBundle\Form\Type\CommentType;
use Pagerfanta\Adapter\DoctrineCollectionAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Blog\Bundle\BlogBundle\Entity\Message;
use Blog\Bundle\BlogBundle\Entity\MessageRepository;
use Blog\Bundle\BlogBundle\Form\Type\MessageType;
use Blog\Bundle\BlogBundle\Entity\Post;
use Blog\Bundle\BlogBundle\Entity\PostRepository;
use Blog\Bundle\BlogBundle\Entity\Comment;
use Blog\Bundle\BlogBundle\Entity\Category;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $om = $this->getDoctrine()->getManager();
        $repository = $om->getRepository('BlogBlogBundle:Post');
        $posts = $repository->findAllByNewest();

        return $this->render('BlogBlogBundle:Default:index.html.twig', array(
            'posts' => $posts,
        ));
    }

    public function aboutAction()
    {
        return $this->render('BlogBlogBundle:Default:about.html.twig');
    }

    public function showByCategoryAction($slug)
    {
        $om = $this->getDoctrine()->getManager();
        $category = $om->getRepository('BlogBlogBundle:Category')->findOneBySlug($slug);
        $categoryTitle = $category->getTitle();
        $posts = $category->getPosts();
//        $adapter = new DoctrineCollectionAdapter($posts);
//        $pagerPost = new Pagerfanta($adapter);
//        $pagerPost->setMaxPerPage(7);
        return $this->render('BlogBlogBundle:Default:index.html.twig', array(
           'posts' => $posts,
           'category' => $categoryTitle,
        ));

    }


    public function sidebarAction()
    {
        $om = $this->getDoctrine()->getManager();
        $tags = $om->$this->getRepository('BlogBlogBundle:Tag')->getTags();
        $tagWeights = $om->$this->getRepository('BlogBlogBundle:Tag')->getTagWeights($tags);

        return $this->render('BlogBlogBundle:Default:sidebar.html.twig', array(
            'tags' => $tagWeights,
        ));
    }

    public function showPostAction($id)
    {
        $om = $this->getDoctrine()->getManager();
        $post = $om->getRepository('BlogBlogBundle:Post')->find($id);

        if (!$post) {
            throw $this->createNotFoundException('The post is not found!');
        }

        $comments = $om->getRepository('BlogBlogBundle:Comment')
            ->findCommentForPost($post->getId());

        return $this->render('BlogBlogBundle:Default:showPost.html.twig', array(
            'post' => $post,
            'comments' => $comments,
        ));
    }

    public function createCommentAction($post_id)
    {
        $post = $this->getPost($post_id);
        $comment = new Comment();
        $comment->setPost($post);
        $form = $this->createForm(new CommentType(), $comment);

        $form->handleRequest($this->getRequest());
        if ($form->isValid()) {
            $om = $this->getDoctrine()->getManager();
            $om->persist($form->getData());
            $om->flush();

            return $this->redirect($this->generateUrl('show_post_page', array(
                'id' => $comment->getPost()->getId())) .
                '#comment-' . $comment->getId());
        }

        return $this->render('BlogBlogBundle:Default:createComment.html.twig', array(
            'comment' => $comment,
            'form' => $form->createView(),
        ));


    }

    public function getPost($post_id)
    {
        $om = $this->getDoctrine()->getManager();
        $post = $om->getRepository('BlogBlogBundle:Post')->find($post_id);

        if (!$post) {
            throw $this->createNotFoundException('The post is not found!');
        }

        return $post;

    }

    public function guestbookAction()
    {
        $message = max(1, (int) $this->getRequest()->query->get('message'));
        $messages = $this->get('blog.pagination')->pagination($message);
        $form = $this->createForm('message');

        $form->handleRequest($this->getRequest());
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($form->getData());
            $em->flush();

            return $this->redirect($this->generateUrl('guestbook'));
        }

        return $this->render('BlogBlogBundle:Default:guestbook.html.twig', array(
            'form' => $form->createView(),
            'messages' => $messages,
        ));
    }
}
