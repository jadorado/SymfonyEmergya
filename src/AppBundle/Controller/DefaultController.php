<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ]);
    }
    /**
     * @Route("/paginator", name="paginator_sample")
     */
    public function paginatorAction(Request $request)
    {   
        $breadcrumbs = $this->get("white_october_breadcrumbs");        
        $breadcrumbs->addItem("Home", $this->get("router")->generate("homepage"));        
        $breadcrumbs->addItem("Sample section");        

        $sampleData=[];
        for($i=0;$i<300;$i++)
            $sampleData[]="Lorem ipsum ".$i;
        
        
        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT a FROM AppBundle:User a";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            //$sampleData, /* query NOT result */
            $query,
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );
        
        return $this->render('AppBundle:Default:paginator.html.twig', array('pagination' => $pagination));

    }
    
    /**
     * @Route("/tinyMCE-example", name="tmce_sample")
     */
    public function tinyMCEAction(Request $request)
    {   
        $breadcrumbs = $this->get("white_october_breadcrumbs");        
        $breadcrumbs->addItem("Home", $this->get("router")->generate("homepage"));        
        $breadcrumbs->addItem("TinyMCE Example");        
        
        return $this->render('AppBundle:Default:tinymce.html.twig');

    }
    
    /**
     * @Route("/contact", name="contact")
     */
    public function mailAction(Request $request) {
        $emailService = $this->get('symfonyzero.email');
            $email = [];                    
            $email['from'] = $this->getParameter('email_address');                    
            $email['to'] = "jadorado@emergya.com";
            $email['subject'] = $this->getParameter('contact_subject');                
            $email['template'] = 'AppBundle:Templates:mailTemplate.html.twig';
            $email['url'] = null;
            $emailService->sendEmail($email['subject'], $email['from'], $email['to'], $email['template'], $email);
            
            return true;
    }
    
}
