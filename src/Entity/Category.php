<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $budget = null;

    /**
     * @var Collection<int, Expense>
     */
    #[ORM\OneToMany(targetEntity: Expense::class, mappedBy: 'category')]
    private Collection $expenses;

    /**
     * @var Collection<int, RecurringPayment>
     */
    #[ORM\OneToMany(targetEntity: RecurringPayment::class, mappedBy: 'category')]
    private Collection $recurringPayments;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $img_src = null;

    public function __construct()
    {
        $this->expenses = new ArrayCollection();
        $this->recurringPayments = new ArrayCollection();
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

    public function getBudget(): ?string
    {
        return $this->budget;
    }

    public function setBudget(?string $budget): static
    {
        $this->budget = $budget;

        return $this;
    }

    /**
     * @return Collection<int, Expense>
     */
    public function getExpenses(): Collection
    {
        return $this->expenses;
    }

    public function addExpense(Expense $expense): static
    {
        if (!$this->expenses->contains($expense)) {
            $this->expenses->add($expense);
            $expense->setCategory($this);
        }

        return $this;
    }

    public function removeExpense(Expense $expense): static
    {
        if ($this->expenses->removeElement($expense)) {
            // set the owning side to null (unless already changed)
            if ($expense->getCategory() === $this) {
                $expense->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RecurringPayment>
     */
    public function getRecurringPayments(): Collection
    {
        return $this->recurringPayments;
    }

    public function addRecurringPayment(RecurringPayment $recurringPayment): static
    {
        if (!$this->recurringPayments->contains($recurringPayment)) {
            $this->recurringPayments->add($recurringPayment);
            $recurringPayment->setCategory($this);
        }

        return $this;
    }

    public function removeRecurringPayment(RecurringPayment $recurringPayment): static
    {
        if ($this->recurringPayments->removeElement($recurringPayment)) {
            // set the owning side to null (unless already changed)
            if ($recurringPayment->getCategory() === $this) {
                $recurringPayment->setCategory(null);
            }
        }

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

    public function __toString(): string
    {
        return $this->name;
    }
}
