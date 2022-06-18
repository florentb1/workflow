<?php

namespace App\Entity;

use App\Repository\ToyRequestRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ToyRequestRepository::class)]
class ToyRequest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'toyRequests')]
    private $family_member;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'array')]
    private $status = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFamilyMember(): ?User
    {
        return $this->family_member;
    }

    public function setFamilyMember(?User $family_member): self
    {
        $this->family_member = $family_member;

        return $this;
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

    public function getStatus(): ?array
    {
        return $this->status;
    }

    public function setStatus(array $status): self
    {
        $this->status = $status;

        return $this;
    }
}
