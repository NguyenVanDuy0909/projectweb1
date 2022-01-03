<?php

namespace App\Entity;

use App\Repository\SizeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SizeRepository::class)]
class Size
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $description;

    #[ORM\OneToMany(mappedBy: 'size', targetEntity: Laptop::class)]
    private $laptops;

    public function __construct()
    {
        $this->laptops = new ArrayCollection();
    }

    // #[ORM\OneToOne(targetEntity: Laptop::class, cascade: ['persist', 'remove'])]
    // private $laptop;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getLaptop(): ?Laptop
    {
        return $this->laptop;
    }

    public function setLaptop(?Laptop $laptop): self
    {
        $this->laptop = $laptop;

        return $this;
    }

    /**
     * @return Collection|Laptop[]
     */
    public function getLaptops(): Collection
    {
        return $this->laptops;
    }

    public function addLaptop(Laptop $laptop): self
    {
        if (!$this->laptops->contains($laptop)) {
            $this->laptops[] = $laptop;
            $laptop->setSize($this);
        }

        return $this;
    }

    public function removeLaptop(Laptop $laptop): self
    {
        if ($this->laptops->removeElement($laptop)) {
            // set the owning side to null (unless already changed)
            if ($laptop->getSize() === $this) {
                $laptop->setSize(null);
            }
        }

        return $this;
    }
}
