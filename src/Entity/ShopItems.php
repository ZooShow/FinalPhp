<?php

namespace App\Entity;

use App\Repository\ShopItemsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ShopItemsRepository::class)
 */
class ShopItems
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Korzina::class, mappedBy="items", orphanRemoval=true)
     */
    private $korzinas;

    public function __construct()
    {
        $this->korzinas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
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
     * @return Collection|Korzina[]
     */
    public function getKorzinas(): Collection
    {
        return $this->korzinas;
    }

    public function addKorzina(Korzina $korzina): self
    {
        if (!$this->korzinas->contains($korzina)) {
            $this->korzinas[] = $korzina;
            $korzina->setItems($this);
        }

        return $this;
    }

    public function removeKorzina(Korzina $korzina): self
    {
        if ($this->korzinas->removeElement($korzina)) {
            // set the owning side to null (unless already changed)
            if ($korzina->getItems() === $this) {
                $korzina->setItems(null);
            }
        }

        return $this;
    }
}
