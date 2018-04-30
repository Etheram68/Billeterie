<?php

namespace OC\TicketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use OC\TicketingBundle\Entity\Books;

/**
 * Tickets
 *
 * @ORM\Table(name="bil_tickets")
 * @ORM\Entity(repositoryClass="OC\TicketingBundle\Repository\TicketsRepository")
 */
class Tickets
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthDate", type="date")
     */
    private $birthDate;

    /**
     * @var bool
     *
     * @ORM\Column(name="discount", type="boolean")
     */
    private $discount;
    /**
     * @ORM\ManyToOne(targetEntity="OC\TicketingBundle\Entity\Books", inversedBy="tickets", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $books;

    /**
     * @var \DateTime
     * @ORM\Column(name="dateBook",type="date")
     */
    private $date;

    /**
     * @var type int
     */
    private $book_id;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="username", type="string", length=255)
     */
    private $username;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Tickets
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set birthDate
     *
     * @param \DateTime $birthDate
     *
     * @return Tickets
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Get birthDate
     *
     * @return \DateTime
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * Set discount
     *
     * @param boolean $discount
     *
     * @return Tickets
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * Get discount
     *
     * @return bool
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Tickets
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Tickets
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return Tickets
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set books
     *
     * @param \OC\TicketingBundle\Entity\Books $books
     *
     * @return Tickets
     */
    public function setBooks(\OC\TicketingBundle\Entity\Books $books)
    {
        $this->books = $books;

        return $this;
    }

    /**
     * Get books
     *
     * @return \OC\TicketingBundle\Entity\Books
     */
    public function getBooks()
    {
        return $this->books;
    }
}
