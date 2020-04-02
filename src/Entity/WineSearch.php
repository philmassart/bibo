<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

class WineSearch
{

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
    private $name;


    public function __construct()
    {
        $this->grapes = new ArrayCollection();
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
     * @return WineSearch
     */
    public function setMaxPrice(int $maxPrice): WineSearch
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
     * @return WineSearch
     */
    public function setMinYear(int $minYear): WineSearch
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
     * @return WineSearch
     */
    public function setGrapes(ArrayCollection $grapes): WineSearch
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
     * @return WineSearch
     */
    public function setAppellation(?Appellation $appellation): WineSearch
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
     * @return WineSearch
     */
    public function setColor(string $color): WineSearch
    {
        $this->color = $color;
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


}

