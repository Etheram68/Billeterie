<?php
namespace AppBundle\SaveBook;
use AppBundle\Entity\Books;

class SaveBook
{
    private $em;

    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }

    public function saveAll(Books $book)
    {
        $em = $this->em;
        $formticket = clone $book->getTicket();

        $book->getTicket()->clear();
        foreach ($formticket as $ticket)
        {
            $ticket->setBooks($book);
            $ticket->setDate($book->getDate());
            $book->addTicket($ticket);
            $em->persist($ticket);
        }
        $em->persist($book);
        $em->flush();
    }
}