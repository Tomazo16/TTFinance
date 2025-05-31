<?php

namespace App\Entity;

use App\Repository\AccountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccountRepository::class)]
class Account
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 40)]
    private ?string $name = null;

    /**
     * @var Collection<int, Income>
     */
    #[ORM\OneToMany(targetEntity: Income::class, mappedBy: 'account')]
    private Collection $incomes;

    /**
     * @var Collection<int, Expense>
     */
    #[ORM\OneToMany(targetEntity: Expense::class, mappedBy: 'account')]
    private Collection $expenses;

    /**
     * @var Collection<int, Transfer>
     */
    #[ORM\OneToMany(targetEntity: Transfer::class, mappedBy: 'from_account')]
    private Collection $transfers;

    /**
     * @var Collection<int, Transfer>
     */
    #[ORM\OneToMany(targetEntity: Transfer::class, mappedBy: 'to_account')]
    private Collection $transfers_in;

    /**
     * @var Collection<int, Goal>
     */
    #[ORM\OneToMany(targetEntity: Goal::class, mappedBy: 'from_account')]
    private Collection $goals;

    /**
     * @var Collection<int, RecurringPAyment>
     */
    #[ORM\OneToMany(targetEntity: RecurringPayment::class, mappedBy: 'account')]
    private Collection $recurringPayments;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $img_src = null;

    public function __construct()
    {
        $this->incomes = new ArrayCollection();
        $this->expenses = new ArrayCollection();
        $this->transfers = new ArrayCollection();
        $this->transfers_in = new ArrayCollection();
        $this->goals = new ArrayCollection();
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

    /**
     * @return Collection<int, Income>
     */
    public function getIncomes(): Collection
    {
        return $this->incomes;
    }

    public function addIncome(Income $income): static
    {
        if (!$this->incomes->contains($income)) {
            $this->incomes->add($income);
            $income->setAccount($this);
        }

        return $this;
    }

    public function removeIncome(Income $income): static
    {
        if ($this->incomes->removeElement($income)) {
            // set the owning side to null (unless already changed)
            if ($income->getAccount() === $this) {
                $income->setAccount(null);
            }
        }

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
            $expense->setAccount($this);
        }

        return $this;
    }

    public function removeExpense(Expense $expense): static
    {
        if ($this->expenses->removeElement($expense)) {
            // set the owning side to null (unless already changed)
            if ($expense->getAccount() === $this) {
                $expense->setAccount(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Transfer>
     */
    public function getTransfers(): Collection
    {
        return $this->transfers;
    }

    public function addTransfer(Transfer $transfer): static
    {
        if (!$this->transfers->contains($transfer)) {
            $this->transfers->add($transfer);
            $transfer->setFromAccount($this);
        }

        return $this;
    }

    public function removeTransfer(Transfer $transfer): static
    {
        if ($this->transfers->removeElement($transfer)) {
            // set the owning side to null (unless already changed)
            if ($transfer->getFromAccount() === $this) {
                $transfer->setFromAccount(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Transfer>
     */
    public function getTransfersIn(): Collection
    {
        return $this->transfers_in;
    }

    public function addTransfersIn(Transfer $transfersIn): static
    {
        if (!$this->transfers_in->contains($transfersIn)) {
            $this->transfers_in->add($transfersIn);
            $transfersIn->setToAccount($this);
        }

        return $this;
    }

    public function removeTransfersIn(Transfer $transfersIn): static
    {
        if ($this->transfers_in->removeElement($transfersIn)) {
            // set the owning side to null (unless already changed)
            if ($transfersIn->getToAccount() === $this) {
                $transfersIn->setToAccount(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Goal>
     */
    public function getGoals(): Collection
    {
        return $this->goals;
    }

    public function addGoal(Goal $goal): static
    {
        if (!$this->goals->contains($goal)) {
            $this->goals->add($goal);
            $goal->setFromAccount($this);
        }

        return $this;
    }

    public function removeGoal(Goal $goal): static
    {
        if ($this->goals->removeElement($goal)) {
            // set the owning side to null (unless already changed)
            if ($goal->getFromAccount() === $this) {
                $goal->setFromAccount(null);
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
            $recurringPayment->setAccount($this);
        }

        return $this;
    }

    public function removeRecurringPayment(RecurringPayment $recurringPayment): static
    {
        if ($this->recurringPayments->removeElement($recurringPayment)) {
            // set the owning side to null (unless already changed)
            if ($recurringPayment->getAccount() === $this) {
                $recurringPayment->setAccount(null);
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
}
