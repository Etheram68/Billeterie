<?php
namespace AppBundle\CheckSchedule;


class CheckSchedule
{
    private $repo;

    public function __construct(\AppBundle\Repository\ScheduleRepository $repo)
    {
        $this->repo = $repo;
    }

    public function isFree(\AppBundle\Entity\Books $book)
    {
        $date = $book->getDate();

        $count = count($book->getTicket());
        $oldcount;
        $repo = $this->repo;

        $scheduled = $repo->findDate($date);



        if ($scheduled)
        {
            $oldcount = $scheduled->getCount();
        }
        else
        {
            $oldcount = 0;
        }


        if( $oldcount + $count > 1000)
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