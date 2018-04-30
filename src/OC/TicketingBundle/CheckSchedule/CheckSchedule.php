<?php
namespace OC\TicketingBundle\CheckSchedule;
class CheckSchedule
{
    private $repo;

    public function __construct(\OC\TicketingBundle\Repository\ScheduleRepository $repo)
    {
        $repo->repo = $repo;
    }

    public function isFree(\OC\TicketingBundle\Entity\Books $book)
    {
        $date = $book->getDate();

        $count = count($book->getTicket());
        $oldcount;
        $repo = $this->repo;
        scheduled = $repo->findDate($date);

        if ($scheduled)
        {
            $oldcount = $scheduled->getCount();
        }
        else
        {
            $oldcount = 0;
        }
        if ( $oldcount + $count > 1000)
        {
            return true;
        }
        else
        {
            $repo->update($scheduled, $count, $date);
            return false;
        }
    }
}