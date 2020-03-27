<?php
namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class WineSearch {

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



}

