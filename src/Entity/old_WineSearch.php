<?php

namespace App\Entity;

use App\Form\WineSearchType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

class oldWineSearch
{

    /**
     * @var boolean|null
     */
    private $isinStock;

    private ?int $maxPrice = null;

    /**
     * @Assert\Range(min=1950, max=2050)
     */
    private ?int $minYear = null;

    private \Doctrine\Common\Collections\ArrayCollection $grapes;


    private \Doctrine\Common\Collections\ArrayCollection $features;


    private \Doctrine\Common\Collections\ArrayCollection $pairings;

    private ?\App\Entity\Appellation $appellation = null;

    private ?string $color = null;

    private ?string $winegrowing = null;

    private ?string $name = null;


    public function __construct()
    {
        $this->grapes = new ArrayCollection();
        $this->features = new ArrayCollection();
        $this->pairings = new ArrayCollection();
    }


    public function getMaxPrice(): ?int
    {
        return $this->maxPrice;
    }

    public function setMaxPrice(?int $maxPrice): oldWineSearch
    {
        $this->maxPrice = $maxPrice;
        return $this;
    }

    public function getMinYear(): ?int
    {
        return $this->minYear;
    }

    public function setMinYear(?int $minYear): oldWineSearch
    {
        $this->minYear = $minYear;
        return $this;
    }

    public function getGrapes(): ArrayCollection
    {
        return $this->grapes;
    }

    public function setGrapes(ArrayCollection $grapes): oldWineSearch
    {
        $this->grapes = $grapes;
        return $this;
    }

    /**
     * @return Appellation
     */
    public function getAppellation(): ?Appellation
    {
        return $this->appellation;
    }

    /**
     * @param Appellation $appellation
     */
    public function setAppellation(?Appellation $appellation): oldWineSearch
    {
        $this->appellation = $appellation;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): oldWineSearch
    {
        $this->color = $color;
        return $this;
    }
    public function getWinegrowing(): ?string
    {
        return $this->winegrowing;
    }

    public function setWinegrowing(?string $winegrowing): oldWineSearch
    {
        $this->winegrowing = $winegrowing;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getFeatures(): ArrayCollection
    {
        return $this->features;
    }

    public function setFeatures(ArrayCollection $features): oldWineSearch
    {
        $this->features = $features;
        return $this;
    }

    public function getPairings(): ArrayCollection
    {
        return $this->pairings;
    }

    public function setPairings(ArrayCollection $pairings): oldWineSearch
    {
        $this->pairings = $pairings;
        return $this;
    }



    /**
     * @return bool
     */
    public function getIsinStock(): ?bool
    {
        return $this->isinStock;
    }

    /**
     * @param bool|null $isinStock
     */
    public function setIsinStock($isinStock): oldWineSearch
    {
        $this->isinStock = $isinStock;
        return $this;
    }
}

