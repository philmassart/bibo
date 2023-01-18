<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WineSearchRepository")
 * @ORM\Table(name="wine_search")
 */
class WineSearch
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $isStock = null;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $maxPrice = null;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $minYear = null;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Grape", inversedBy="wineSearches")
     */
    private \Doctrine\Common\Collections\Collection|array $grapes;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Feature", inversedBy="wineSearches")
     */
    private \Doctrine\Common\Collections\Collection|array $features;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Pairing", inversedBy="wineSearches")
     */
    private \Doctrine\Common\Collections\Collection|array $pairings;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private ?string $color = null;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private ?string $winegrowing = null;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private ?string $name = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Appellation", inversedBy="wineSearches")
     */
    private ?\App\Entity\Appellation $appellation = null;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     */
    private ?\App\Entity\User $user = null;

    public function __construct()
    {
        $this->grapes = new ArrayCollection();
        $this->features = new ArrayCollection();
        $this->pairings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsStock(): ?bool
    {
        return $this->isStock;
    }

    public function setIsStock(?bool $isStock): self
    {
        $this->isStock = $isStock;

        return $this;
    }

    public function getMaxPrice(): ?int
    {
        return $this->maxPrice;
    }

    public function setMaxPrice(?int $maxPrice): self
    {
        $this->maxPrice = $maxPrice;

        return $this;
    }

    public function getMinYear(): ?int
    {
        return $this->minYear;
    }

    public function setMinYear(?int $minYear): self
    {
        $this->minYear = $minYear;

        return $this;
    }

    /**
     * @return Collection|Grape[]
     */
    public function getGrapes(): Collection
    {
        return $this->grapes;
    }

    public function addGrape(Grape $grape): self
    {
        if (!$this->grapes->contains($grape)) {
            $this->grapes[] = $grape;
        }

        return $this;
    }

    public function removeGrape(Grape $grape): self
    {
        if ($this->grapes->contains($grape)) {
            $this->grapes->removeElement($grape);
        }

        return $this;
    }

    /**
     * @return Collection|Feature[]
     */
    public function getFeatures(): Collection
    {
        return $this->features;
    }

    public function addFeature(Feature $feature): self
    {
        if (!$this->features->contains($feature)) {
            $this->features[] = $feature;
        }

        return $this;
    }

    public function removeFeature(Feature $feature): self
    {
        if ($this->features->contains($feature)) {
            $this->features->removeElement($feature);
        }

        return $this;
    }

    /**
     * @return Collection|Pairing[]
     */
    public function getPairings(): Collection
    {
        return $this->pairings;
    }

    public function addPairing(Pairing $pairing): self
    {
        if (!$this->pairings->contains($pairing)) {
            $this->pairings[] = $pairing;
        }

        return $this;
    }

    public function removePairing(Pairing $pairing): self
    {
        if ($this->pairings->contains($pairing)) {
            $this->pairings->removeElement($pairing);
        }

        return $this;
    }


    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getWinegrowing(): ?string
    {
        return $this->winegrowing;
    }

    public function setWinegrowing(?string $winegrowing): self
    {
        $this->winegrowing = $winegrowing;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAppellation(): ?Appellation
    {
        return $this->appellation;
    }

    public function setAppellation(?Appellation $appellation): self
    {
        $this->appellation = $appellation;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

}
