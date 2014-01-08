<?php

namespace Blog\Bundle\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('BlogBlogBundle:Default:index.html.twig');
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
