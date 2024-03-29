<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;
use App\Traits\SoftDeleteable;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * @ORM\Entity(repositoryClass="App\Repository\WineRepository")
 * @Vich\Uploadable()
 * * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Wine
{
    use SoftDeleteable;

    final public const COLOR = [
        'wine.color.red' => 'wine.color.red',
        'wine.color.white' => 'wine.color.white',
        'wine.color.rose' => 'wine.color.rose'
    ];

    final public const WINEGROWING = [
        'wine.growing.trad' => 'wine.growing.trad',
        'wine.growing.bio' => 'wine.growing.bio',
        'wine.growing.biodyn' => 'wine.growing.biodyn'
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $filename = null;

    /**
     * @Assert\Image(
     *     mimeTypes="image/jpeg"
     *
     * )
     * @Vich\UploadableField(mapping="wine_image", fileNameProperty="filename")
     * )
     * @Vich\UploadableField(mapping="wine_image", fileNameProperty="filename")
     */
    private ?\Symfony\Component\HttpFoundation\File\File $imageFile = null;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $name = null;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $description = null;


    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $year = null;


    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    private string $color = self::COLOR['wine.color.white'];

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $stock = null;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $price = null; //decimal ?

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTime|\DateTimeInterface $created_at;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Grape", inversedBy="wines")
     */
    private \Doctrine\Common\Collections\Collection|array $grapes;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private \DateTime|\DateTimeInterface|null $updated_at = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Appellation", inversedBy="wines",  cascade={"persist"})
     */
    private ?\App\Entity\Appellation $appellation = null;

    /**
     * @ORM\Column(type="decimal", precision=3, scale=1, nullable=true)
     */
    private ?string $alcohol = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Container", inversedBy="wines")
     */
    private ?\App\Entity\Container $container = null;


    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Feature", inversedBy="wines")
     */
    private \Doctrine\Common\Collections\Collection|array $features;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Pairing", inversedBy="wines")
     */
    private \Doctrine\Common\Collections\Collection|array $pairings;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $location = null;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private ?string $winegrowing = self::WINEGROWING['wine.growing.trad'];

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Stock", mappedBy="wine", cascade={"remove", "persist"})
     */
    private \Doctrine\Common\Collections\Collection|array $stocks;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="wines")
     */
    private ?\App\Entity\User $user = null;

    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->grapes = new ArrayCollection();
        $this->features = new ArrayCollection();
        $this->pairings = new ArrayCollection();
        $this->stocks = new ArrayCollection();
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

    public function getSlug(): string
    {
        return (new Slugify())->slugify($this->name);
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }


    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(?int $year): self
    {
        $this->year = $year;

        return $this;
    }


    public function getColor(): ?string
    {
        return $this->color;
    }

    /**
     * @return $this
     */
    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }
    public function getWinegrowing(): ?string
    {
        return $this->winegrowing;
    }
    /**
     * @param string $winegrowing
     * @return $this
     */
    public function setWinegrowing(?string $winegrowing): self
    {
        $this->winegrowing = $winegrowing;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(?int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getFormattedPrice(): string
    {
        return number_format($this->price, 0, '', ' ');
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

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
            $grape->addWine($this);
        }

        return $this;
    }

    public function removeGrape(Grape $grape): self
    {
        if ($this->grapes->contains($grape)) {
            $this->grapes->removeElement($grape);
            $grape->removeWine($this);
        }

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

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(?string $filename): Wine
    {
        $this->filename = $filename;
        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @throws \Exception
     */
    public function setImageFile(?File $imageFile): Wine
    {
        $this->imageFile = $imageFile;
        if ($this->imageFile instanceof UploadedFile) {
            $this->updated_at = new \DateTime('now');
        }
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }


    public function getAlcohol(): ?string
    {
        return $this->alcohol;
    }

    public function setAlcohol(?string $alcohol): self
    {
        $this->alcohol = $alcohol;

        return $this;
    }

    public function getContainer(): ?Container
    {
        return $this->container;
    }

    public function setContainer(?Container $container): self
    {
        $this->container = $container;

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
            $feature->addWine($this);
        }

        return $this;
    }

    public function removeFeature(Feature $feature): self
    {
        if ($this->features->contains($feature)) {
            $this->features->removeElement($feature);
            $feature->removeWine($this);
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
            $pairing->addWine($this);
        }

        return $this;
    }

    public function removePairing(Pairing $pairing): self
    {
        if ($this->pairings->contains($pairing)) {
            $this->pairings->removeElement($pairing);
            $pairing->removeWine($this);
        }

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return Collection|Stock[]
     */
    public function getStocks(): Collection
    {
        return $this->stocks;
    }

    public function addStock(Stock $stock): self
    {
        if (!$this->stocks->contains($stock)) {
            $this->stocks[] = $stock;
            $stock->setWine($this);
        }

        return $this;
    }

    public function removeStock(Stock $stock): self
    {
        if ($this->stocks->contains($stock)) {
            $this->stocks->removeElement($stock);
            // set the owning side to null (unless already changed)
            if ($stock->getWine() === $this) {
                $stock->setWine(null);
            }
        }

        return $this;
    }

    public function getTotalBottles()
    {
        $return = 0;

        $return += $this->getStock();


        return $return;
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
