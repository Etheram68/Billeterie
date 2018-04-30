<?php
namespace OC\TicketingBundle\CheckPrice;
class CheckPrice
{
    private $repo;
    public function __construct(\OC\TicketingBundle\Repository\PriceRepository $repo)
    {
        $this->repo = $repo;
    }

    public function amoutType(\OC\TicketingBundle\Entity\Books $book)
    {
        $tickets = $book->getTicket();
        $today = new \DateTime('today');
        $totalAmout = 0;

        if($tickets !== null)
        {
            foreach($tickets as $ticket)
            {
                $repo = $this->repo;

                $birthdate = $ticket->getBirthDate();
                $Interval = $today->diff($birthdate);
                $Interval = $Interval->format('%Y');

                $amount = $book->getAmount();

                if($Interval <4)
                {
                    $type = "4";
                }
                elseif($ticket->getDiscount() === true)
                {
                    $type = 'true';
                }
                else
                {
                    switch(true)
                    {
                        case $Interval<12:
                            $type = "12";
                            break;
                        case $Interval<60:
                            $type = "60";
                            break;
                        case $Interval>=60:
                            $type = "+60";
                            break;
                    }
                }
                $ticketprice = $repo->findPrice($type);
                $book->setAmount($amount + $ticketprice);
            }
        }
    }
}