<?php

namespace App\Entity;

use App\Repository\LaptopRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LaptopRepository::class)]
class Laptop
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $madein;

    #[ORM\Column(type: 'integer')]
    private $price;

    #[ORM\Column(type: 'integer')]
    private $PriceDiscount;

    #[ORM\Column(type: 'string', length: 255)]
    private $image;

    #[ORM\ManyToOne(targetEntity: Brand::class, inversedBy: 'laptops')]
    private $brand;

    #[ORM\ManyToOne(targetEntity: CPU::class, inversedBy: 'laptops')]
    private $cPU;

    #[ORM\ManyToOne(targetEntity: RAM::class, inversedBy: 'laptops')]
    private $rAM;

    #[ORM\ManyToMany(targetEntity: Demand::class, mappedBy: 'laptops')]
    private $demands;

    #[ORM\ManyToOne(targetEntity: Size::class, inversedBy: 'laptops')]
    private $size;

    public function __construct()
    {
        $this->demands = new ArrayCollection();
    }

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

    public function getMadein(): ?string
    {
        return $this->madein;
    }

    public function setMadein(string $madein): self
    {
        $this->madein = $madein;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPriceDiscount(): ?int
    {
        return $this->PriceDiscount;
    }

    public function setPriceDiscount(int $PriceDiscount): self
    {
        $this->PriceDiscount = $PriceDiscount;

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

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getCPU(): ?CPU
    {
        return $this->cPU;
    }

    public function setCPU(?CPU $cPU): self
    {
        $this->cPU = $cPU;

        return $this;
    }

    public function getRAM(): ?RAM
    {
        return $this->rAM;
    }

    public function setRAM(?RAM $rAM): self
    {
        $this->rAM = $rAM;

        return $this;
    }

    /**
     * @return Collection|Demand[]
     */
    public function getDemands(): Collection
    {
        return $this->demands;
    }

    public function addDemand(Demand $demand): self
    {
        if (!$this->demands->contains($demand)) {
            $this->demands[] = $demand;
            $demand->addLaptop($this);
        }

        return $this;
    }

    public function removeDemand(Demand $demand): self
    {
        if ($this->demands->removeElement($demand)) {
            $demand->removeLaptop($this);
        }

        return $this;
    }

    public function getSize(): ?Size
    {
        return $this->size;
    }

    public function setSize(?Size $size): self
    {
        $this->size = $size;

        return $this;
    }
}
