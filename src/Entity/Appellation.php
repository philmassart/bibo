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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Wine", mappedBy="appellation",  cascade={"persist"})
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $wines;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Region", inversedBy="appellations")
     */
    private $region;

    public function __construct()
    {
        $this->wines = new ArrayCollection();
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
}
