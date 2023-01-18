<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AppellationRepository")
 */
class Appellation
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
     * @ORM\OneToMany(targetEntity="App\Entity\Wine", mappedBy="appellation",  cascade={"persist"})
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private \Doctrine\Common\Collections\Collection|array $wines;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Region", inversedBy="appellations")
     */
    private ?\App\Entity\Region $region = null;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\WineSearch", mappedBy="appellation")
     */
    private \Doctrine\Common\Collections\Collection|array $wineSearches;


    public function __construct()
    {
        $this->wines = new ArrayCollection();
        $this->wineSearches = new ArrayCollection();
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

    /**
     * @return Collection|Wine[]
     */
    public function getWines(): Collection
    {
        return $this->wines;
    }

    public function addWine(Wine $wine): self
    {
        if (!$this->wines->contains($wine)) {
            $this->wines[] = $wine;
            $wine->setAppellation($this);
        }

        return $this;
    }

    public function removeWine(Wine $wine): self
    {
        if ($this->wines->contains($wine)) {
            $this->wines->removeElement($wine);
            // set the owning side to null (unless already changed)
            if ($wine->getAppellation() === $this) {
                $wine->setAppellation(null);
            }
        }

        return $this;
    }

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(?Region $region): self
    {
        $this->region = $region;

        return $this;
    }


    public function getTotalBottles()
    {
        $return = 0;
        foreach($this->getWines() as $wine)
        {
            $return += $wine->getStock();
        }

        return $return;
    }

    public function getTotalPrices(bool $byBottle = false)
    {
        $return = 0;
        foreach($this->getWines() as $wine)
        {
            if ($byBottle)
            {
                $return += $wine->getPrice() * $wine->getStock();
            }
            else
            {
                $return += $wine->getPrice();
            }

        }

        return $return;
    }

    /**
     * @return Collection|WineSearch[]
     */
    public function getWineSearches(): Collection
    {
        return $this->wineSearches;
    }

    public function addWineSearch(WineSearch $wineSearch): self
    {
        if (!$this->wineSearches->contains($wineSearch)) {
            $this->wineSearches[] = $wineSearch;
            $wineSearch->setAppellation($this);
        }

        return $this;
    }

    public function removeWineSearch(WineSearch $wineSearch): self
    {
        if ($this->wineSearches->contains($wineSearch)) {
            $this->wineSearches->removeElement($wineSearch);
            // set the owning side to null (unless already changed)
            if ($wineSearch->getAppellation() === $this) {
                $wineSearch->setAppellation(null);
            }
        }

        return $this;
    }

}
