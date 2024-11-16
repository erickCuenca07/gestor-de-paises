<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CountryRepository::class)]
class Country
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string',length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: 'string',length: 255)]
    private ?string $capital = null;

    #[ORM\Column(type: 'string',length: 255)]
    private ?string $region = null;

    #[ORM\Column(type: 'string',length: 255)]
    private ?string $subregion = null;

    #[ORM\Column(type: 'float')]
    private ?string $population = null;

    #[ORM\Column(type: 'float')]
    private ?string $area = null;

    #[ORM\Column(type: 'string',length: 255)]
    private ?string $continent = null;

    #[ORM\Column(type: 'string',length: 255)]
    private ?string $flag = null;

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'capital' => $this->getCapital(),
            'region' => $this->getRegion(),
            'subregion' => $this->getSubregion(),
            'population' => $this->getPopulation(),
            'area' => $this->getArea(),
            'continent' => $this->getContinent(),
            'flag' => $this->getFlag(),
        ];
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getName(): ?string
    {
        return $this->name;
    }
    public function getCapital(): ?string
    {
        return $this->capital;
    }
    public function getRegion(): ?string
    {
        return $this->region;
    }
    public function getSubregion(): ?string
    {
        return $this->subregion;
    }
    public function getPopulation(): ?string
    {
        return $this->population;
    }
    public function getArea(): ?string
    {
        return $this->area;
    }
    public function getContinent(): ?string
    {
        return $this->continent;
    }
    public function getFlag(): ?string
    {
        return $this->flag;
    }
    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }
    public function setCapital(?string $capital): self
    {
        $this->capital = $capital;

        return $this;
    }
    public function setRegion(?string $region): self
    {
        $this->region = $region;

        return $this;
    }
    public function setSubregion(?string $subregion): self
    {
        $this->subregion = $subregion;

        return $this;
    }
    public function setPopulation(?string $population): self
    {
        $this->population = $population;

        return $this;
    }
    public function setArea(?string $area): self
    {
        $this->area = $area;

        return $this;
    }
    public function setContinent(?string $continent): self
    {
        $this->continent = $continent;

        return $this;
    }
    public function setFlag(?string $flag): self
    {
        $this->flag = $flag;

        return $this;
    }
}
