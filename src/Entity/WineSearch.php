<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
     * @var ArrayCollection
     */
    private $grapes;

    /**
     * @var ArrayCollection
     */
    private $appellations;


    public function __construct()
    {
        $this->grapes = new ArrayCollection();
        $this->appellations = new ArrayCollection();


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
     * @return ArrayCollection
     */
    public function getAppellations(): ArrayCollection
    {
        return $this->appellations;
    }

    /**
     * @param ArrayCollection $appellations
     * @return WineSearch
     */
    public function setAppellations(ArrayCollection $appellations): WineSearch
    {
        $this->appellations = $appellations;
        return $this;
    }


}
