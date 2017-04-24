<?php
namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

/**
     * @Route("/admin")
     */
    class AdminController extends Controller
    {
        /**
         * @Route("/admin")
         * @Security("has_role('ROLE_ADMIN')")
         */
        public function adminAction()
        {
            return new Response('<html><body>Admin page!</body></html>');
        }
    }