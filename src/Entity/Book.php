<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BookRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\ManyToMany(targetEntity: Author::class, inversedBy: 'books')]
    private $authors;

    #[ORM\ManyToOne(targetEntity: Publisher::class, inversedBy: 'books')]
    #[ORM\JoinColumn(nullable: false)]
    private $publisher;

    #[ORM\Column(type: 'float')]
    private $price;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $images;

    #[ORM\Column(type: 'string', length: 255)]
    private $description;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $publishDate;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $isbn;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'books')]
    private $categories;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $pageAmount;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $language;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $bookSize;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'books')]
    private $users;

    #[ORM\ManyToMany(targetEntity: Panier::class, mappedBy: 'books')]
    private $paniers;

    public function __construct()
    {
        $this->authors = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->paniers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection|Author[]
     */
    public function getAuthors(): Collection
    {
        return $this->authors;
    }

    public function addAuthor(Author $author): self
    {
        if (!$this->authors->contains($author)) {
            $this->authors[] = $author;
        }

        return $this;
    }

    public function removeAuthor(Author $author): self
    {
        $this->authors->removeElement($author);

        return $this;
    }

    public function getPublisher(): ?Publisher
    {
        return $this->publisher;
    }

    public function setPublisher(?Publisher $publisher): self
    {
        $this->publisher = $publisher;

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

    public function getImages(): ?string
    {
        return $this->images;
    }

    public function setImages(?string $images): self
    {
        $this->images = $images;

        return $this;
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

    public function getPublishDate(): ?\DateTime
    {
        return $this->publishDate;
    }

    public function setPublishDate(\DateTime $publishDate): self
    {
        $this->publishDate = $publishDate;

        return $this;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(?string $isbn): self
    {
        $this->isbn = $isbn;

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

    public function getPageAmount(): ?int
    {
        return $this->pageAmount;
    }

    public function setPageAmount(?int $pageAmount): self
    {
        $this->pageAmount = $pageAmount;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(?string $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getBookSize(): ?string
    {
        return $this->bookSize;
    }

    public function setBookSize(?string $bookSize): self
    {
        $this->bookSize = $bookSize;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addBook($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeBook($this);
        }

        return $this;
    }

    /**
     * @return Collection|Panier[]
     */
    public function getPaniers(): Collection
    {
        return $this->paniers;
    }

    public function addPanier(Panier $panier): self
    {
        if (!$this->paniers->contains($panier)) {
            $this->paniers[] = $panier;
            $panier->addBook($this);
        }

        return $this;
    }

    public function removePanier(Panier $panier): self
    {
        if ($this->paniers->removeElement($panier)) {
            $panier->removeBook($this);
        }

        return $this;
    }
}
