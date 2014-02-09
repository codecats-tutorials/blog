<?php

namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlogController extends Controller
{
    public function showAction($id, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        
        $blog = $em->getRepository('BloggerBlogBundle:Blog')->find($id);
        
        if ( ! $blog) {
            throw $this->createNotFoundException('Unable to find Blog post.');
        }
        
        $comments = $blog->getComments();
        
        return $this->render('BloggerBlogBundle:Blog:show.html.twig', array(
            'blog'      => $blog,
            'comments'  => $comments
        ));
    }
}
