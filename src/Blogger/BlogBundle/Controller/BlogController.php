<?php

namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlogController extends Controller
{
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $blog = $em->getRepository('BloggerBlogBundle:Blog')->find($id);
        
        if ( ! $blog) {
            throw $this->createNotFoundException('Unable to find Blog post.');
        }
        
        $comments = $em->getRepository('BloggerBlogBundle:Comment')->getCommentRepository($blog->getId());
        
        return $this->render('BloggerBlogBundle:Blog:show.html.twig', array(
            'blog'      => $blog,
            'comments'  => $comments
        ));
    }
}
