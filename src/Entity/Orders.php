<?php

namespace App\Entity;

use App\Repository\OrdersRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrdersRepository::class)]
class Orders
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $amount = null;

    #[ORM\Column(length: 20)]
    private ?string $status = null;

    #[ORM\Column(options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\OneToMany(mappedBy: 'Orders', targetEntity: Orderslines::class)]
    private Collection $orderslines;

    #[ORM\Column]
    private ?int $userId = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function __construct()
    {
        $this->orderslines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeImmutable $created_at): self
    {
        if ($created_at != null) {

            $this->created_at = $created_at;
        } else {
            $this->created_at = new DateTimeImmutable();
        }

        return $this;
    }

    /**
     * @return Collection<int, Orderslines>
     */
    public function getOrderslines(): Collection
    {
        return $this->orderslines;
    }

    public function addOrdersline(Orderslines $ordersline): self
    {
        if (!$this->orderslines->contains($ordersline)) {
            $this->orderslines->add($ordersline);
            $ordersline->setOrders($this);
        }

        return $this;
    }

    public function removeOrdersline(Orderslines $ordersline): self
    {
        if ($this->orderslines->removeElement($ordersline)) {
            // set the owning side to null (unless already changed)
            if ($ordersline->getOrders() === $this) {
                $ordersline->setOrders(null);
            }
        }

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
