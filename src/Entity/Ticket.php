<?php

namespace App\Entity;

use App\Repository\TicketRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TicketRepository::class)]
class Ticket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $clientid = null;

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Event $eventid = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClientid(): ?Client
    {
        return $this->clientid;
    }

    public function setClientid(?Client $clientid): self
    {
        $this->clientid = $clientid;

        return $this;
    }

    public function getEventid(): ?Event
    {
        return $this->eventid;
    }

    public function setEventid(?Event $eventid): self
    {
        $this->eventid = $eventid;

        return $this;
    }
}
