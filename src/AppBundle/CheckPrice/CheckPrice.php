<?php
namespace AppBundle\CheckPrice;

class CheckPrice
{
    private $repo;

    public function __construct(\AppBundle\Repository\PriceRepository $repo)
    {
        $this->repo = $repo;
    }

    public function amountType(\AppBundle\Entity\Books $book)
    {
        $tickets = $book->getTicket();
        $today = new \DateTime('today');
        $totalAmount = 0;

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

                if($Interval <4 AND $ticket->getDiscount() === true)
                {
                    $type = "4";
                    $ticket->setDiscount('0');
                }

                if($Interval <12 AND $ticket->getDiscount() === true)
                {
                    $type = "12";
                    $ticket->setDiscount('0');
                }

                if($ticket->getType() == false)
                {
                    $ticketprice = $repo->findPrice($type) / 2;
                }
                else
                {
                $ticketprice = $repo->findPrice($type);
                }
                $ticket->setTicketPrice($ticketprice);
                $book->setAmount($amount + $ticketprice);
            }
        }
    }
}