<?php

namespace App\Entity;

use App\Repository\KorzinaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=KorzinaRepository::class)
 */
class Korzina
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sessionID;

    /**
     * @ORM\ManyToOne(targetEntity=ShopItems::class, inversedBy="korzinas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $items;

    /**
     * @ORM\Column(type="integer")
     */
    private $count;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSessionID(): ?string
    {
        return $this->sessionID;
    }

    public function setSessionID(string $sessionID): self
    {
        $this->sessionID = $sessionID;

        return $this;
    }

    public function getItems(): ?ShopItems
    {
        return $this->items;
    }

    public function setItems(?ShopItems $items): self
    {
        $this->items = $items;

        return $this;
    }

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function setCount(int $count): self
    {
        $this->count = $count;

        return $this;
    }
}
