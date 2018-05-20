<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\BooksType;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Config\Definition\Exception\Exception;
use AppBundle\Entity\Books;
use Stripe;

class BooksController extends Controller
{
    /**
     * @Route("/", name="books_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        return $this->render('Books/index.html.twig');
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
            $checkschedule = $this->container->get('AppBundle.CheckSchedule');
            $x = $checkschedule->isFree($book);
            $checktype = $this->container->get('AppBundle.CheckPrice');
            $flash = $this->get('session')->getFlashBag();

            if ($x === true)
            {
                $flash->add('fullbookeddate', 'La date que vous avez séléctionnée n\'est plus disponible');
                return $this->redirectToRoute('AppBundle_books');
            }
            $checktype->amountType($book);
            $session->set('book', $book);
            return $this->redirectToRoute('AppBundle_pay');
        }
        return $this->render('Books/news.html.twig', array('book' => $book, 'form' => $form->createView()));
    }

    /**
     * @Route("/contact",name="books_contact")
     * @Method({"POST"})
     */
    public function contactAction(Request $request)
    {
        $form = $this->createForm('AppBundle\Form\Type\ContactType', null, array(
            'action' => $this->generateUrl('AppBundle_contact'),
            'method' => 'POST'
        ));

        if($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if($form->isValid())
            {
                if($this->sendEmail($form->getData()))
                {
                    return $this->redirectToRoute('AppBundle_homepage');
                }
                else
                {
                    var_dump("Erreur");
                }
            }
        }
        return $this->render('Books/contact.html.twig', array('form' => $form->createView()
        ));
    }

    private function sendEmail($data)
    {
        $session = new Session();
        $session->clear();

        $message = \Swift_Message::newInstance("Contact ". $data["subject"])
            ->setContentType("text/html")
            ->setFrom(array($data["email"] => "Message de ".$data["name"]))
            ->setTo('frey.francois68@gmail.com')
            ->setBody("Corps du message: <br>".$data["message"]." <br><br>Email du contact :<br>".$data["email"]);

        $mailer = $this->get('mailer');
        $mailer->send($message);
        $session->getFlashBag()->add('sucessBook', 'Votre E-mail à bien été envoyée, nous vous répondrons dans les plus brefs délais');
        return $this->redirectToRoute('AppBundle_contact');
    }

    /**
     * @Route("/pay",name="books_pay")
     */
    public function payAction(Request $request)
    {
        $session = new Session();
        $book = $session->get('book');

        return $this->render('Books/pay.html.twig', array('book' => $book));
    }

    public function chargeAction(Request $request)
    {
        Stripe\Stripe::setApiKey("sk_test_5Gt4c4qjUq2zAN7swepRgwat");

        $token = $_POST['stripeToken'];

        $session = new Session();
        $book = $session->get('book');
        $book->setSerial();
        $flash = $this->get('session')->getFlashBag();

        try
        {
            $charge = Stripe\Charge::create(array(
                "amount"      =>   $book->getAmount() * 100,
                "currency"    =>   "eur",
                "description" =>   "Billetterie du Louvre",
                "source"      =>   $token,
            ));
            if($book !== null)
            {
                $savebook = $this->container->get('AppBundle.SaveBook');
                $savebook->saveAll($book);
                $idBook = $book->getID();
                $session->set('idBook', $idBook);
            }
        }
        catch(\Stripe\Error\Card $e)
        {
            $body = $e->getJsonBody();
            $err = $body['error'];
            $flash->add('errorstripe', 'Votre carte a été déclinée, veuillez recommencer la saisie avec une carte valide.');
            return $this->redirectToRoute('AppBundle_pay');
        }
        catch(\Stripe\Error\Base $e)
        {
            $flash->add('errorstripe', 'Une erreure est survenu lors de votre paiement, nous vous invitons à recommencer.');
            return $this->redirectToRoute('AppBundle_pay');
        }
        catch(Exception $e)
        {
            $flash->add('errorstripe', 'Une erreure est survenu lors de votre paiement, nous vous invitons à réitérer votre commande ultérieurement.');
            return $this->redirectToRoute('AppBundle_pay');
        }

        return $this->redirectToRoute('AppBundle_validation');
    }


    public function validationAction(Request $request)
    {
        $session = new Session();
        $id = $session->get('idBook');
        $session->clear();
        $book = $this->getDoctrine()
            ->getRepository(Books::class)
            ->find($id);
        $message = (new \Swift_Message('Validation de votre commande'));
        $mail = $book->getMail();$image = 'https://projet4-site.fr/web/img/louvre.png';
        $message
            ->setFrom(['louvre@billeterie.com' => 'Billetterie du Louvre'])
            ->setTo($mail)
            ->setBody(
                $this->renderView(
                    'Books/Emails/mailer.html.twig', array('book' => $book, 'image' => $image)
                ),
                'text/html'
            );
        $mailer = $this->get('mailer');
        $mailer->send($message);
        $session->getFlashBag()->add('sucessBook', 'Votre commande à bien été enregistrée, un mail va vous être envoyé');
        return $this->render('Books/index.html.twig');
    }
}
