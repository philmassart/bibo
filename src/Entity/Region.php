<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RegionRepository")
 */
class Region
{
    const COUNTRY = [
        'region.country.france' => 'region.country.france',
        'region.country.italy' => 'region.country.italy',
        'region.country.spain' => 'region.country.spain',
        'region.country.chili' => 'region.country.chili',
        'region.country.greece' => 'region.country.greece',
        'region.country.czechia' => 'region.country.czechia',
        'region.country.hungary' => 'region.country.hungary'

    ];


    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     */
    private $country = self::COUNTRY['region.country.france'];

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Appellation", mappedBy="region", cascade={"persist"})
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $appellations;

    public function __construct()
    {
        $this->appellations = new ArrayCollection();
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

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

//    public function getCountryType(): string
//    {
//        return self::COUNTRY[$this->country];
//    }

    /**
     * @return Collection|Appellation[]
     */
    public function getAppellations(): Collection
    {
        return $this->appellations;
    }

    public function addAppellation(Appellation $appellation): self
    {
        if (!$this->appellations->contains($appellation)) {
            $this->appellations[] = $appellation;
            $appellation->setRegion($this);
        }

        return $this;
    }

    public function removeAppellation(Appellation $appellation): self
    {
        if ($this->appellations->contains($appellation)) {
            $this->appellations->removeElement($appellation);
            // set the owning side to null (unless already changed)
            if ($appellation->getRegion() === $this) {
                $appellation->setRegion(null);
            }
        }

        return $this;
    }

    public function getTotalBottles()
    {
        $return = 0;
        foreach ($this->getAppellations() as $appellation)
        {
            $return += $appellation->getTotalBottles();
        }

        return $return;
    }

    public function getTotalPrices(bool $byBottle = false)
    {
        $return = 0;
        foreach ($this->getAppellations() as $appellation)
        {
            $return += $appellation->getTotalPrices($byBottle);
        }

        return $return;
    }

    public function getWines()
    {
        $wines = [];

        foreach($this->getAppellations() as $appellation)
        {
            foreach ($appellation->getWines() as $wine) {
                $wines[] = $wine;
            }
        }

        return $wines;
    }

}
