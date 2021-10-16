<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PairingRepository")
 */
class Pairing
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
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Wine", mappedBy="pairings")
     */
    private $wines;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\WineSearch", mappedBy="pairings")
     */
    private $wineSearches;

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
        }

        return $this;
    }

    public function removeWine(Wine $wine): self
    {
        if ($this->wines->contains($wine)) {
            $this->wines->removeElement($wine);
        }

        return $this;
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
            $wineSearch->addPairing($this);
        }

        return $this;
    }

    public function removeWineSearch(WineSearch $wineSearch): self
    {
        if ($this->wineSearches->contains($wineSearch)) {
            $this->wineSearches->removeElement($wineSearch);
            $wineSearch->removePairing($this);
        }

        return $this;
    }
}
