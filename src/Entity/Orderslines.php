<?php

namespace App\Entity;

use App\Repository\OrderslinesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderslinesRepository::class)]
class Orderslines
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\ManyToOne(inversedBy: 'orderslines')]
    private ?Articles $Article = null;

    #[ORM\ManyToOne(inversedBy: 'orderslines')]
    #[ORM\JoinColumn(onDelete:"CASCADE")] 
    private ?Orders $Orders = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getArticle(): ?articles
    {
        return $this->Article;
    }

    public function setArticle(?articles $Article): self
    {
        $this->Article = $Article;

        return $this;
    }

    public function getOrders(): ?Orders
    {
        return $this->Orders;
    }

    public function setOrders(?Orders $Orders): self
    {
        $this->Orders = $Orders;

        return $this;
    }
}
