<?php

namespace App\Entity;

use App\Repository\BookCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookCategoryRepository::class)]
class BookCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $bkCatName = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'bookCategories')]
    private ?self $bookCategory = null;

    #[ORM\OneToMany(mappedBy: 'bookCategory', targetEntity: self::class)]
    private Collection $bookCategories;

    public function __construct()
    {
        $this->bookCategories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBkCatName(): ?string
    {
        return $this->bkCatName;
    }

    public function setBkCatName(string $bkCatName): static
    {
        $this->bkCatName = $bkCatName;

        return $this;
    }

    public function getBookCategory(): ?self
    {
        return $this->bookCategory;
    }

    public function setBookCategory(?self $bookCategory): static
    {
        $this->bookCategory = $bookCategory;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getBookCategories(): Collection
    {
        return $this->bookCategories;
    }

    public function addBookCategory(self $bookCategory): static
    {
        if (!$this->bookCategories->contains($bookCategory)) {
            $this->bookCategories->add($bookCategory);
            $bookCategory->setBookCategory($this);
        }

        return $this;
    }

    public function removeBookCategory(self $bookCategory): static
    {
        if ($this->bookCategories->removeElement($bookCategory)) {
            // set the owning side to null (unless already changed)
            if ($bookCategory->getBookCategory() === $this) {
                $bookCategory->setBookCategory(null);
            }
        }

        return $this;
    }
}
