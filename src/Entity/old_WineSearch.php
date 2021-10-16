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

    /**
     * @var int|null
     */
    private $maxPrice;

    /**
     * @var int|null
     * @Assert\Range(min=1950, max=2050)
     */
    private $minYear;

    /**
     * @var ArrayCollection
     */
    private $grapes;


    /**
     * @var ArrayCollection
     */
    private $features;


    /**
     * @var ArrayCollection
     */
    private $pairings;

    /**
     * @var Appellation
     */
    private $appellation;

    /**
     * @var string|null
     */
    private $color;

    /**
     * @var string|null
     */
    private $winegrowing;

    /**
     * @var string|null
     */
    private $name;


    public function __construct()
    {
        $this->grapes = new ArrayCollection();
        $this->features = new ArrayCollection();
        $this->pairings = new ArrayCollection();
    }


    /**
     * @return int|null
     */
    public function getMaxPrice(): ?int
    {
        return $this->maxPrice;
    }

    /**
     * @param int|null $maxPrice
     * @return oldWineSearch
     */
    public function setMaxPrice(?int $maxPrice): oldWineSearch
    {
        $this->maxPrice = $maxPrice;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMinYear(): ?int
    {
        return $this->minYear;
    }

    /**
     * @param int|null $minYear
     * @return oldWineSearch
     */
    public function setMinYear(?int $minYear): oldWineSearch
    {
        $this->minYear = $minYear;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getGrapes(): ArrayCollection
    {
        return $this->grapes;
    }

    /**
     * @param ArrayCollection $grapes
     * @return oldWineSearch
     */
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
     * @return oldWineSearch
     */
    public function setAppellation(?Appellation $appellation): oldWineSearch
    {
        $this->appellation = $appellation;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getColor(): ?string
    {
        return $this->color;
    }

    /**
     * @param string|null $color
     * @return oldWineSearch
     */
    public function setColor(?string $color): oldWineSearch
    {
        $this->color = $color;
        return $this;
    }
    /**
     * @return string|null
     */
    public function getWinegrowing(): ?string
    {
        return $this->winegrowing;
    }

    /**
     * @param string|null $winegrowing
     * @return oldWineSearch
     */
    public function setWinegrowing(?string $winegrowing): oldWineSearch
    {
        $this->winegrowing = $winegrowing;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return ArrayCollection
     */
    public function getFeatures(): ArrayCollection
    {
        return $this->features;
    }

    /**
     * @param ArrayCollection $features
     * @return oldWineSearch
     */
    public function setFeatures(ArrayCollection $features): oldWineSearch
    {
        $this->features = $features;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getPairings(): ArrayCollection
    {
        return $this->pairings;
    }

    /**
     * @param ArrayCollection $pairings
     * @return oldWineSearch
     */
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
     * @return oldWineSearch
     */
    public function setIsinStock($isinStock): oldWineSearch
    {
        $this->isinStock = $isinStock;
        return $this;
    }
}

