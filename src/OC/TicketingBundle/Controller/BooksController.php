<?php

namespace OC\TicketingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use OC\TicketingBundle\Form\Type\BooksType;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Config\Definition\Exception\Exception;
use OC\TicketingBundle\Entity\Books;
use Stripe;

/**
 * Class BooksController
 * @Route("books")
 */
class BooksController extends Controller
{
    /**
     * @Route("/", name="books_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        return $this->render('OCTicketingBundle:Books:index.html.twig');
    }

    /**
     * @Route("/book",name="books_new")
     * @Method({"POST"})
     */
    public function newsAction(Request $request)
    {
        $session = new Session();
        $book = new Books();
        $form = $this->get('form.factory')->create(BooksType::class, $book);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $checkschedule = $this->container->get('oc_ticketing.CheckSchedule');
            $x = $checkschedule->isFree($book);
            $checktype = $this->container->get('oc_ticketing.CheckPrice');
            $flash = $this->get('session')->getFlashBag();

            if ($x === true)
            {
                $flash->add('fullbookeddate', 'La date que vous avez séléctionnée n\'est plus disponible');
                return $this->redirectToRoute('oc_ticketing_books');
            }
            $checktype->amountType($book);
            $session->set('book', $book);
            return $this->redirectToRoute('oc_ticketing_pay');
        }
        return $this->render('OCTicketingBundle:Books:news.html.twig', array('book' => $book, 'form' => $form->createView()));
    }

    public function contactAction()
    {
        return $this->render('OCTicketingBundle:Books:contact.html.twig');
    }

    public function payAction()
    {
        $session = new Session();
        $book = $session->get('book');

        return $this->render('OCTicketingBundle:Books:pay.html.twig', array('book' => $book));
    }

    public function chargeAction()
    {
        return $this->render('OCTicketingBundle:Books:charge.html.twig');
    }

    public function validationAction(Request $request)
    {
        $session = new Session();
        $id = $session->get('idBook');

        $session->clear();

        $book = $this->getDoctrine()
                    ->getRepository(Books::class)
                    ->find($id);

        $message = (new \Swift_Message('Validation'));
        $mail = $book->getMail();$image = 'http://localhost/Billeterie/web/img/louvre.png';
        $message
            ->setForm(['frey.francois68@gmail.com' => 'Billeterie du Louvre'])
            ->setTo($mail)
            ->setBody(
                $this->renderView(
                    'OCTicketingBundle:Books:Emails/mailer.html.twig', array('book' => $book, 'image' => $image)
                ),
                'text/html'
            );
        $mailer = $this->get('mailer');
        $mailer->send($message);
        $session->getFlashBag()->add('sucessBook', 'Votre commande à bien été enregistrée');
        return $this->redirectToRoute('oc_ticketing_homepage');
    }

    Public function mailAction()
    {
        return $this->render('OCTicketingBundle:Books:mail.html.twig');
    }
}
