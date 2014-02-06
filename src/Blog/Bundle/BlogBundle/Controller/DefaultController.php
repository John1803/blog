<?php

namespace Blog\Bundle\BlogBundle\Controller;

use Blog\Bundle\BlogBundle\Form\Type\CommentType;
use Blog\Bundle\BlogBundle\Form\Type\PostType;
use Pagerfanta\Adapter\DoctrineCollectionAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Blog\Bundle\BlogBundle\Entity\Message;
use Blog\Bundle\BlogBundle\Entity\MessageRepository;
use Blog\Bundle\BlogBundle\Form\Type\MessageType;
use Blog\Bundle\BlogBundle\Entity\Post;
use Blog\Bundle\BlogBundle\Entity\PostRepository;
use Blog\Bundle\BlogBundle\Entity\Comment;
use Blog\Bundle\BlogBundle\Entity\CommentRepository;
use Blog\Bundle\BlogBundle\Entity\Category;
use Symfony\Component\HttpFoundation\Request;
use Blog\Bundle\BlogBundle\Event\PostVisitedEvent;

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
        $posts = $this->get('blog_blog_bundle.post.repository');
        $popularPosts = $posts->mostPopularPosts();

        $lastPosts = $posts->getLastPosts();

        $tags = $posts->getTags();
        $tagWeights = $posts->getTagWeights($tags);

        return $this->render('BlogBlogBundle::sidebar.html.twig', array(
            'popularPosts' => $popularPosts,
            'lastPosts' => $lastPosts,
            'tags' => $tagWeights

        ));
    }

    public function showPostAction($id)
    {
        $postRepository = $this->container->get('blog_blog_bundle.post.repository');
        $post = $postRepository->find($id);

        if (!$post) {
            throw $this->createNotFoundException('The post is not found!');
        }
        $commentRepository = $this->container->get('blog_blog_bundle.comment.repository');
        $comments = $commentRepository->findCommentForPost($post->getId());

        $event = new PostVisitedEvent();
        $event->setPost($post);

        $eventDispatcher = $this->get('event_dispatcher');
        $eventDispatcher->dispatch('blog_blog_bundle.post_visited', $event);

        return $this->render('BlogBlogBundle:Default:showPost.html.twig', array(
            'post' => $post,
            'comments' => $comments,
        ));
    }

//    public function mostPopularArticle()
//    {
//        $posts = $this->container->get('blog_blog_bundle.post.repository');
//    }

    public function createPostAction()
    {
        $post = new Post();

        $form = $this->createForm(new PostType(), $post);

        $form->handleRequest($this->getRequest());
        if ($form->isValid()) {
            $om = $this->getDoctrine()->getManager();
            $om->persist($form->getData());
            $om->flush();

            return $this->redirect($this->generateUrl('home_page'));
        }

        return $this->render('BlogBlogBundle:Default:post.html.twig', array(
            'form' => $form->createView(),
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
