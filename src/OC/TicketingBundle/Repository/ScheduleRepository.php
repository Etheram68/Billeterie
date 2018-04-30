<?php

namespace OC\TicketingBundle\Repository;

/**
 * ScheduleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ScheduleRepository extends \Doctrine\ORM\EntityRepository
{
    public function findDate($date)
    {
        $qb = $this->createQueryBuilder('p')
            ->select('p')
            ->where('p.date = :date')
            ->setParameter(':date', $date);
        return $qb->getQuery()
            ->getOneOrNullResult();
    }
    public function update($scheduled, $count, $date)
    {
        $em = $this->_em;
        if(is_null($scheduled))
        {
            $schedule = new \OC\TicketingBundle\Entity\Schedule();
            $schedule->setDate($date);
            $schedule->setCount($count);
            $em->persist($schedule);
            $em->fluch();
        }
        else
        {
            $oldcount = $scheduled->getCount();
            $scheduled->setCount($oldcount + $count);
            $scheduled = $em->merge($scheduled);
            $em->fluch();
        }
    }
}
