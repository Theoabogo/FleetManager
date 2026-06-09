<?php

namespace App\Entity;

use App\Repository\AssignmentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AssignmentRepository::class)]
class Assignment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTime $assignedAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $returnedAt = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $comment = null;

    #[ORM\ManyToOne(inversedBy: 'assignments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Vehicle $vehicle = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Driver $driver = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAssignedAt(): ?\DateTime
    {
        return $this->assignedAt;
    }

    public function setAssignedAt(\DateTime $assignedAt): static
    {
        $this->assignedAt = $assignedAt;

        return $this;
    }

    public function getReturnedAt(): ?\DateTime
    {
        return $this->returnedAt;
    }

    public function setReturnedAt(?\DateTime $returnedAt): static
    {
        $this->returnedAt = $returnedAt;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    public function getVehicle(): ?Vehicle
    {
        return $this->vehicle;
    }

    public function setVehicle(?Vehicle $vehicle): static
    {
        $this->vehicle = $vehicle;

        return $this;
    }

    public function getDriver(): ?Driver
    {
        return $this->driver;
    }

    public function setDriver(?Driver $driver): static
    {
        $this->driver = $driver;

        return $this;
    }
}
