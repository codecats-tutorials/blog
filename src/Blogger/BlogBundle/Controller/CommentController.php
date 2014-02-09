<?php

namespace Blogger\BlogBundle\Controller;

use Blogger\BlogBundle\Entity\Comment;
use Blogger\BlogBundle\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CommentController extends Controller
{
    public function newAction($blogId)
    {
        $blog = $this->getBlog($blogId);
        
        $comment = new Comment();
        $comment->setBlog($blog);
        
        $form = $this->createForm(new CommentType(), $comment);
        
        return $this->render('BloggerBlogBundle:Comment:form.html.twig', array(
            'comment' => $comment,
            'form'      => $form->createView()
        ));
    }

    public function createAction($blog_id)
    {
        $blog = $this->getBlog($blog_id);
        
        $comment = new Comment();
        $comment->setBlog($blog);
        
        $request = $this->getRequest();
        $form = $this->createForm(new CommentType(), $comment);
        $form->submit($request);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();
            
            return $this->redirect($this->generateUrl('BloggerBlogBundle_blog_show', array(
                'id' => $comment->getBlog()->getId().'#comment-'.$comment->getId(),
                'slug' => $comment->getBlog()->getSlug()
            )));
        }
        
        return $this->render('BloggerBlogBundle:Comment:new.html.twig', array(
            'comment'   => $comment,
            'form'      => $form
        ));
    }

    protected function getBlog($blogId) 
    {
        $em = $this->getDoctrine()->getManager();
        
        $blog = $em->getRepository('BloggerBlogBundle:Blog')->find($blogId);
        
        if ( ! $blog) {
            throw $this->createNotFoundException('Unable to find Blog post.');
        }
        
        return $blog;
    }
}
