<?php

namespace App\Entity;

use App\Repository\ArticlesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticlesRepository::class)]
class Articles
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    # @Groups("article:read")
    private ?int $id = null;
    # @Groups("article:read")

    #[ORM\Column(length: 80)]
    private ?string $nameArticle = null;
    # @Groups("article:read")

    #[ORM\Column(length: 255)]
    private ?string $image = null;
    # @Groups("article:read")

    #[ORM\Column]
    private ?float $price = null;
    # @Groups("article:read")

    #[ORM\Column(length: 255)]
    private ?string $description = null;
    # @Groups("article:read")

    #[ORM\Column(length: 20)]
    private ?string $type = null;
    # @Groups("article:read")

    #[ORM\ManyToOne(inversedBy: 'articles')]
    private ?Categories $Category = null;
    # @Groups("article:read")

    #[ORM\OneToMany(mappedBy: 'Article', targetEntity: Orderslines::class)]
    private Collection $orderslines;
    # @Groups("article:read")

    #[ORM\Column]
    private ?int $rating = null;
    # @Groups("article:read")

    #[ORM\Column]
    private ?int $categoryId = null;

    public function __construct()
    {
        $this->orderslines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameArticle(): ?string
    {
        return $this->nameArticle;
    }

    public function setNameArticle(string $nameArticle): self
    {
        $this->nameArticle = $nameArticle;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

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
    public function setCategoryId(int $categoryId): self
    {
        $this->categoryId = $categoryId;

        return $this;
    }
    
    public function getCategoryId(): ?int
    {
        return $this->categoryId;
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCategory(): ?categories
    {
        return $this->Category;
    }

    public function setCategory(?categories $Category): self
    {
        $this->Category = $Category;

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
            $ordersline->setArticle($this);
        }

        return $this;
    }

    public function removeOrdersline(Orderslines $ordersline): self
    {
        if ($this->orderslines->removeElement($ordersline)) {
            // set the owning side to null (unless already changed)
            if ($ordersline->getArticle() === $this) {
                $ordersline->setArticle(null);
            }
        }

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }
}
