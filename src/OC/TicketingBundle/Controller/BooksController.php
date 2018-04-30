<?php

namespace OC\TicketingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use OC\TicketingBundle\Form\BooksType;
use OC\TicketingBundle\Entity\Tickets;
use OC\TicketingBundle\Form\TicketsType;
use OC\TicketingBundle\Entity\Books;

class BooksController extends Controller
{

    public function indexAction()
    {
        return $this->render('OCTicketingBundle:Books:index.html.twig');
    }

    public function newsAction(Request $request)
    {
        $book = new Books();
        $form = $this->get('form.factory')->create('BooksType::class,$book');

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $book->getTicket()->clear();
            $em = $this->getDoctrine()->getManager();
            $em->persist($book);
            $em->flush();
            foreach( $formticket as $ticket)
            {
                $ticket->setBook($book);
                $book->addTicket($ticket);
                $em->persist($ticket);
            }
        }
        $em->fluch();
        return $this->render('OCTicketingBundle:Books:news.html.twig', array('book' => 'form' => $form->createView()));
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
