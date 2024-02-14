<?php

namespace App\Entity;

use App\Repository\PasteRepository;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PasteRepository::class)]
class Paste
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $unique_id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $date = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $language = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $file = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUniqueId(): ?string
    {
        return $this->unique_id;
    }

    public function setUniqueId(string $unique_id): static
    {
        $this->unique_id = $unique_id;

        return $this;
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

    public function getDate(): ?int
    {
        return $this->date;
    }

    public function setDate(int $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(string $language): static
    {
        $this->language = $language;

        return $this;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(string $file): static
    {
        $this->file = $file;

        return $this;
    }
}
