<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
<<<<<<< HEAD
=======
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
>>>>>>> 50ec0615f45b65cf1eb4b58f6530eee7522c93a5

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
<<<<<<< HEAD
=======
    #[Assert\NotBlank]
>>>>>>> 50ec0615f45b65cf1eb4b58f6530eee7522c93a5
    private ?string $bkName = null;

    #[ORM\ManyToMany(targetEntity: Author::class, mappedBy: 'books')]
    private Collection $authors;

    #[ORM\Column(length: 255)]
    private ?string $imageFileName = null;

<<<<<<< HEAD
=======
    #[Assert\Image()]
    private $imageFile = null;

>>>>>>> 50ec0615f45b65cf1eb4b58f6530eee7522c93a5
    public function __construct()
    {
        $this->authors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBkName(): ?string
    {
        return $this->bkName;
    }

    public function setBkName(string $bkName): static
    {
        $this->bkName = $bkName;

        return $this;
    }

    /**
     * @return Collection<int, Author>
     */
    public function getAuthors(): Collection
    {
        return $this->authors;
    }

    public function addAuthor(Author $author): static
    {
        if (!$this->authors->contains($author)) {
            $this->authors->add($author);
            $author->addBook($this);
        }
<<<<<<< HEAD

=======
>>>>>>> 50ec0615f45b65cf1eb4b58f6530eee7522c93a5
        return $this;
    }

    public function removeAuthor(Author $author): static
    {
        if ($this->authors->removeElement($author)) {
            $author->removeBook($this);
        }

        return $this;
    }

    public function getImageFileName(): ?string
    {
        return $this->imageFileName;
    }

    public function setImageFileName(string $imageFileName): static
    {
        $this->imageFileName = $imageFileName;

        return $this;
    }
<<<<<<< HEAD
=======

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImageFile($imageFile): static
    {
        $this->imageFile = $imageFile;

        return $this;
    }

    public function removeWithAuthors($authors)
    {
        foreach ($this->authors as $existAuthor) {
            if (!$authors->contains($existAuthor)) {
                $this->removeAuthor($existAuthor);
            }
        }
    }
>>>>>>> 50ec0615f45b65cf1eb4b58f6530eee7522c93a5
}
