<?php

namespace App\Entity;

use App\Repository\GoalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GoalRepository::class)]
class Goal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 40)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $value = null;

    /**
     * @var Collection<int, transfer>
     */
    #[ORM\OneToMany(targetEntity: transfer::class, mappedBy: 'goal')]
    private Collection $transfers;

    #[ORM\ManyToOne(inversedBy: 'goals')]
    private ?account $from_account = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $img_src = null;

    public function __construct()
    {
        $this->transfers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): static
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return Collection<int, transfer>
     */
    public function getTransfers(): Collection
    {
        return $this->transfers;
    }

    public function addTransfer(transfer $transfer): static
    {
        if (!$this->transfers->contains($transfer)) {
            $this->transfers->add($transfer);
            $transfer->setGoal($this);
        }

        return $this;
    }

    public function removeTransfer(transfer $transfer): static
    {
        if ($this->transfers->removeElement($transfer)) {
            // set the owning side to null (unless already changed)
            if ($transfer->getGoal() === $this) {
                $transfer->setGoal(null);
            }
        }

        return $this;
    }

    public function getFromAccount(): ?account
    {
        return $this->from_account;
    }

    public function setFromAccount(?account $from_account): static
    {
        $this->from_account = $from_account;

        return $this;
    }

    public function getImgSrc(): ?string
    {
        return $this->img_src;
    }

    public function setImgSrc(?string $img_src): static
    {
        $this->img_src = $img_src;

        return $this;
    }
}
