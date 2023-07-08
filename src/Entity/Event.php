<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $nbplaces = null;



    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $gif = null;

    #[ORM\ManyToOne(inversedBy: 'events')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $clientid = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $event_type = null;

    #[ORM\Column(nullable: true)]
    private ?float $longitude = null;

    #[ORM\Column(nullable: true)]
    private ?float $latitude = null;

    // #[ORM\OneToMany(mappedBy: 'eventid', targetEntity: Ticket::class)]
    // private Collection $tickets;

    public function __construct()
    {
        // $this->tickets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getNbplaces(): ?string
    {
        return $this->nbplaces;
    }

    public function setNbplaces(string $nbplaces): self
    {
        $this->nbplaces = $nbplaces;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getGif(): ?string
    {
        return $this->gif;
    }

    public function setGif(?string $gif): self
    {
        $this->gif = $gif;

        return $this;
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
    //         $ticket->setEventid($this);
    //     }

    //     return $this;
    // }

    // public function removeTicket(Ticket $ticket): self
    // {
    //     if ($this->tickets->removeElement($ticket)) {
    //         // set the owning side to null (unless already changed)
    //         if ($ticket->getEventid() === $this) {
    //             $ticket->setEventid(null);
    //         }
    //     }

    //     return $this;
    // }

    public function getEventType(): ?string
    {
        return $this->event_type;
    }

    public function setEventType(?string $EventType): self
    {
        $this->event_type = $EventType;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }
}
