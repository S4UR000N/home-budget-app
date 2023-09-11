<?php

namespace App\Entity;

use App\Repository\WalletRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WalletRepository::class)]
class Wallet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $balance = null;

    #[ORM\OneToMany(mappedBy: 'wallet', targetEntity: Revenue::class)]
    private Collection $revenue;

    #[ORM\OneToMany(mappedBy: 'wallet', targetEntity: Expense::class, orphanRemoval: true)]
    private Collection $expense;

    #[ORM\OneToOne(mappedBy: 'wallet', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    public function __construct()
    {
        $this->revenue = new ArrayCollection();
        $this->expense = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBalance(): ?int
    {
        return $this->balance;
    }

    public function setBalance(int $balance): static
    {
        $this->balance = $balance;

        return $this;
    }

    /**
     * @return Collection<int, Revenue>
     */
    public function getRevenue(): Collection
    {
        return $this->revenue;
    }

    public function addRevenue(Revenue $revenue): static
    {
        if (!$this->revenue->contains($revenue)) {
            $this->revenue->add($revenue);
            $revenue->setWallet($this);
        }

        return $this;
    }

    public function removeRevenue(Revenue $revenue): static
    {
        if ($this->revenue->removeElement($revenue)) {
            // set the owning side to null (unless already changed)
            if ($revenue->getWallet() === $this) {
                $revenue->setWallet(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Expense>
     */
    public function getExpense(): Collection
    {
        return $this->expense;
    }

    public function addExpense(Expense $expense): static
    {
        if (!$this->expense->contains($expense)) {
            $this->expense->add($expense);
            $expense->setWallet($this);
        }

        return $this;
    }

    public function removeExpense(Expense $expense): static
    {
        if ($this->expense->removeElement($expense)) {
            // set the owning side to null (unless already changed)
            if ($expense->getWallet() === $this) {
                $expense->setWallet(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        // set the owning side of the relation if necessary
        if ($user->getWallet() !== $this) {
            $user->setWallet($this);
        }

        $this->user = $user;

        return $this;
    }
}
