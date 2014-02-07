<?php

namespace Blogger\BlogBundle\Controller;

use Blogger\BlogBundle\Entity\Enquiry;
use Blogger\BlogBundle\Form\EnquiryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $blogs = $em->getRepository('BloggerBlogBundle:Blog')->getLastestBlogs();
        
        return $this->render('BloggerBlogBundle:Page:index.html.twig',
                array('blogs' => $blogs)
        );
    }
    
    public function sidebarAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $tags = $em->getRepository('BloggerBlogBundle:Blog')->getTags();
        
        $tagWeights = $em->getRepository('BloggerBlogBundle:Blog')->getTagWeights($tags);
        
        $commentLimit = $this->container
                ->getParameter('blogger_blog.comments.lastest_comment_limit');
        
        $comment = $em->getRepository('BloggerBlogBundle:Comment')
                ->getLastestComments($commentLimit);
        
        
        return $this->render('BloggerBlogBundle:Page:sidebar.html.twig', array(
            'tags' => $tagWeights,
            'lastestComments' => $comment
        ));
    }
    
    public function aboutAction()
    {
        return $this->render('BloggerBlogBundle:Page:about.html.twig');
    }
    
    public function contactAction()
    {
        $enquiry = new Enquiry();
        $form = $this->createForm(new EnquiryType(), $enquiry);
        
        $request = $this->getRequest();
        if ($request->isMethod('POST')) {
            $form->submit($request);
            
            if ($form->isValid()) {
                $message = \Swift_Message::newInstance()
                        ->setSubject($enquiry->getSubject())
                        ->setFrom('Your@assistent.pl')
                        ->setTo($this->container->getParameter('blogger_blog.emails.contact_email'))
                        ->setBody(
                                $this->render('BloggerBlogBundle:Page:contactEmail.txt.twig',
                                array('enquiry' => $enquiry)
                        ))
                ;
                $this->get('mailer')->send($message);
                
                $this->get('session')->getFlashBag()->add('blogger-notice', 'Your contact enquiry was successfully sent. Thank you!!');
                
                return $this->redirect($this->generateUrl('BloggerBlogBundle_contact'));
            }
        }
        
        return $this->render('BloggerBlogBundle:Page:contact.html.twig', array(
            'form' => $form->createView()
        ));
    }

}
