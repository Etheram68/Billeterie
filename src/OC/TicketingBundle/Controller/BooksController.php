<?php

namespace OC\TicketingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BooksController extends Controller
{
    public function indexAction()
    {
        return $this->render('OCTicketingBundle:Books:index.html.twig');
    }

    public function newsAction()
    {
        return $this->render('OCTicketingBundle:Books:news.html.twig');
    }

    public function contactAction()
    {
        return $this->render('OCTicketingBundle:Books:contact.html.twig');
    }

    public function chargeAction()
    {
        return $this->render('OCTicketingBundle:Books:charge.html.twig');
    }

    public function payAction()
    {
        return $this->render('OCTicketingBundle:Books:pay.html.twig');
    }

    public function validationAction()
    {
        return $this->render('OCTicketingBundle:Books:validation.html.twig');
    }

    Public function mailAction()
    {
        return $this->render('OCTicketingBundle:Books:mail.html.twig');
    }
}
