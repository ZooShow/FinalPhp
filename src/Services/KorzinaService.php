<?php

namespace App\Services;

use App\Entity\Korzina;
use App\Repository\KorzinaRepository;
use App\Repository\ShopItemsRepository;
use Doctrine\ORM\EntityManagerInterface;

class KorzinaService
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var ShopItemsRepository
     */
    private $shopItemsRepository;

    /**
     * @var KorzinaRepository
     */
    private $korzinaRepository;

    /**
     * @param EntityManagerInterface $em
     * @param ShopItemsRepository $shopItemsRepository
     * @param KorzinaRepository $korzinaRepository
     */
    public function __construct(
        EntityManagerInterface $em,
        ShopItemsRepository $shopItemsRepository,
        KorzinaRepository $korzinaRepository
    ) {
        $this->em = $em;
        $this->shopItemsRepository = $shopItemsRepository;
        $this->korzinaRepository = $korzinaRepository;
    }

    /**
     * @param int $itemId
     * @param int $sessionId
     * @return void
     */
    public function addItemToKorzina(int $itemId, int $sessionId)
    {
        $item = $this->shopItemsRepository->find($itemId);
        $korzina = (new Korzina())
            ->setItems($item)
            ->setCount(1)
            ->setSessionID($sessionId);
        $this->em->persist($korzina);
        $this->em->flush();
    }

    /**
     * @param int $sessionId
     * @return array
     */
    public function getKorzinaBySessionId(int $sessionId): array
    {
        return $this->korzinaRepository->findBy(['sessionID' => $sessionId]);
    }
}