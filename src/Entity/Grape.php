<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GrapeRepository")
 */
class Grape
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
     * @ORM\ManyToMany(targetEntity="App\Entity\Wine", mappedBy="grapes")
     */
    private \Doctrine\Common\Collections\Collection|array $wines;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\WineSearch", inversedBy="grapes")
     */
    private ?\App\Entity\WineSearch $wineSearch = null;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\WineSearch", mappedBy="grapes")
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

    public function getWineSearch(): ?WineSearch
    {
        return $this->wineSearch;
    }

    public function setWineSearch(?WineSearch $wineSearch): self
    {
        $this->wineSearch = $wineSearch;

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
            $wineSearch->addGrape($this);
        }

        return $this;
    }

    public function removeWineSearch(WineSearch $wineSearch): self
    {
        if ($this->wineSearches->contains($wineSearch)) {
            $this->wineSearches->removeElement($wineSearch);
            $wineSearch->removeGrape($this);
        }

        return $this;
    }
}
