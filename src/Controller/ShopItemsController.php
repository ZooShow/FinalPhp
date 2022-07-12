<?php

namespace App\Controller;

use App\Services\ShopItemsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/shop")
 */
class ShopItemsController extends AbstractController
{
    /**
     * @var ShopItemsService
     */
    private $shopItemsService;

    /**
     * @param ShopItemsService $shopItemsService
     */
    public function __construct(ShopItemsService $shopItemsService)
    {
        $this->shopItemsService = $shopItemsService;
    }

    /**
     * @Route("/list", name="itemList")
     */
    public function itemList(): Response
    {
        $items = $this->shopItemsService->getAllItems();
        return $this->render('/shop_items/index.html.twig', [
            'title' => 'Товары',
            'items' => $items
        ]);
    }

    /**
     * @Route("item/{id<\d+>}", name="shop")
     * @param int $id
     * @return Response
     */
    public function shop(int $id): Response
    {
        $item = $this->shopItemsService->getItemById($id);
        return $this->render('/shop_items/itemPage.html.twig', [
            'item' => $item
        ]);
    }
}
