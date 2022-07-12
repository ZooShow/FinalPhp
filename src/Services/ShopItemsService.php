<?php

namespace App\Services;

use App\Entity\ShopItems;
use App\Repository\ShopItemsRepository;

class ShopItemsService
{
    /**
     * @var ShopItemsRepository
     */
    private $shopItemsRepository;

    /**
     * @param ShopItemsRepository $shopItemsRepository
     */
    public function __construct(ShopItemsRepository $shopItemsRepository)
    {
        $this->shopItemsRepository = $shopItemsRepository;
    }

    /**
     * @return ShopItems[]
     */
    public function getAllItems(): array
    {
        return $this->shopItemsRepository->findAll();
    }

    public function getItemById(int $id): ShopItems
    {
        return $this->shopItemsRepository->find($id);
    }
}