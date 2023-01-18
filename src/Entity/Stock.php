<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StockRepository")
 */
class Stock
{

    final public const MOVEMENT = [
        'movement.in' => 'movement.in',
        'movement.out' => 'movement.out',
    ];
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Wine", inversedBy="stocks")
     */
    private ?\App\Entity\Wine $wine = null;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $quantity = null;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private string $movement = self::MOVEMENT['movement.out'];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $comment = null;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $oldQuantity = null;


    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getWine(): ?Wine
    {
        return $this->wine;
    }

    public function setWine(?Wine $wine): self
    {
        $this->wine = $wine;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getMovement(): ?string
    {
        return $this->movement;
    }

    public function setMovement(string $movement): self
    {
        $this->movement = $movement;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getOldQuantity(): ?int
    {
        return $this->oldQuantity;
    }

    public function setOldQuantity(?int $oldQuantity): self
    {
        $this->oldQuantity = $oldQuantity;

        return $this;
    }
}
