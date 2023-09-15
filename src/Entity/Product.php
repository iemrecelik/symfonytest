<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotNull(message: 'Bu değer boş olamaz')]
    #[Assert\Length(
        min: 10,
        max: 100,
    )]
    private ?string $prodName = null;

    #[ORM\Column]
    #[Assert\NotNull(message: 'Bu değer boş olamaz')]
    #[Assert\Positive(message: 'This value should be positive.')]
    private ?int $proStock = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $prodDescription = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: true, onDelete: "SET NULL")]
    private ?Category $categoty = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProdName(): ?string
    {
        return $this->prodName;
    }

    public function setProdName(string|null $prodName): static
    {
        $this->prodName = $prodName;

        return $this;
    }

    public function getProStock(): ?int
    {
        return $this->proStock;
    }

    public function setProStock(int $proStock): static
    {
        $this->proStock = $proStock;

        return $this;
    }

    public function getProdDescription(): ?string
    {
        return $this->prodDescription;
    }

    public function setProdDescription(?string $prodDescription): static
    {
        $this->prodDescription = $prodDescription;

        return $this;
    }

    public function getCategoty(): ?Category
    {
        return $this->categoty;
    }

    public function setCategoty(?Category $categoty): static
    {
        $this->categoty = $categoty;

        return $this;
    }
}
