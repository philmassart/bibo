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

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $name = null;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Appellation", mappedBy="region", cascade={"persist"})
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private \Doctrine\Common\Collections\Collection|array $appellations;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Country", inversedBy="regions")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?\App\Entity\Country $country = null;

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

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

}
