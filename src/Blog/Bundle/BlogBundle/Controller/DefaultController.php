<?php

namespace Blog\Bundle\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Blog\Bundle\BlogBundle\Entity\Message;
use Blog\Bundle\BlogBundle\Entity\MessageRepository;
use Blog\Bundle\BlogBundle\Form\Type\MessageType;
use Blog\Bundle\BlogBundle\Entity\Post;
use Blog\Bundle\BlogBundle\Entity\PostRepository;
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

    public function postAction()
    {
        return $this->render('BlogBlogBundle:Default:post.html.twig');
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
