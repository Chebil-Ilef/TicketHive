<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $username = null;

    #[ORM\Column(length: 100)]
    private ?string $email = null;

    #[ORM\Column(length: 50)]
    private ?string $password = null;

    // #[ORM\OneToMany(mappedBy: 'clientid', targetEntity: Ticket::class)]
    // private Collection $tickets;

    // #[ORM\OneToMany(mappedBy: 'clientid', targetEntity: Event::class)]
    // private Collection $events;

    // #[ORM\OneToMany(mappedBy: 'clientid', targetEntity: Feedback::class)]
    // private Collection $feedback;

    public function __construct()
    {
        // $this->feedback = new ArrayCollection();
        // $this->events = new ArrayCollection();
        // $this->tickets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    // /**
    //  * @return Collection<int, Feedback>
    //  */
    // public function getFeedback(): Collection
    // {
    //     return $this->feedback;
    // }

    // public function addFeedback(Feedback $feedback): self
    // {
    //     if (!$this->feedback->contains($feedback)) {
    //         $this->feedback->add($feedback);
    //         $feedback->setClientid($this);
    //     }

    //     return $this;
    // }

    // public function removeFeedback(Feedback $feedback): self
    // {
    //     if ($this->feedback->removeElement($feedback)) {
    //         // set the owning side to null (unless already changed)
    //         if ($feedback->getClientid() === $this) {
    //             $feedback->setClientid(null);
    //         }
    //     }

    //     return $this;
    // }

    // /**
    //  * @return Collection<int, Event>
    //  */
    // public function getEvents(): Collection
    // {
    //     return $this->events;
    // }

    // public function addEvent(Event $event): self
    // {
    //     if (!$this->events->contains($event)) {
    //         $this->events->add($event);
    //         $event->setClientid($this);
    //     }

    //     return $this;
    // }

    // public function removeEvent(Event $event): self
    // {
    //     if ($this->events->removeElement($event)) {
    //         // set the owning side to null (unless already changed)
    //         if ($event->getClientid() === $this) {
    //             $event->setClientid(null);
    //         }
    //     }

    //     return $this;
    // }

    // /**
    //  * @return Collection<int, Ticket>
    //  */
    // public function getTickets(): Collection
    // {
    //     return $this->tickets;
    // }

    // public function addTicket(Ticket $ticket): self
    // {
    //     if (!$this->tickets->contains($ticket)) {
    //         $this->tickets->add($ticket);
    //         $ticket->setClientid($this);
    //     }

    //     return $this;
    // }

    // public function removeTicket(Ticket $ticket): self
    // {
    //     if ($this->tickets->removeElement($ticket)) {
    //         // set the owning side to null (unless already changed)
    //         if ($ticket->getClientid() === $this) {
    //             $ticket->setClientid(null);
    //         }
    //     }

    //     return $this;
    // }
}
