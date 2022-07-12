<?php

namespace App\Services;

use App\Entity\ShopOrder;
use App\Repository\KorzinaRepository;
use App\Repository\ShopOrderRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class OrderService
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var ShopOrderRepository
     */
    private $shopOrderRepository;

    /**
     * @var KorzinaRepository
     */
    private $korzinaRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param UserRepository $userRepository
     * @param ShopOrderRepository $shopOrderRepository
     * @param KorzinaRepository $korzinaRepository
     * @param EntityManagerInterface
     */
    public function __construct(
        UserRepository $userRepository,
        ShopOrderRepository $shopOrderRepository,
        KorzinaRepository $korzinaRepository,
        EntityManagerInterface $entityManager
    )
    {
        $this->userRepository = $userRepository;
        $this->shopOrderRepository = $shopOrderRepository;
        $this->korzinaRepository = $korzinaRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $username
     * @param string $userEmail
     * @param string $userPhone
     * @param string $sessionId
     * @return void
     */
    public function addShopOrder(
        string $username,
        string $userLog,
        string $userEmail,
        string $userPhone,
        string $sessionId
    )
    {
        $user = $this->userRepository->findOneBy(['username' => $username]);
        $shopOrder = new ShopOrder();
        $shopOrder->setUser($user);
        $shopOrder->setUserName($userLog);
        $shopOrder->setUserEmail($userEmail);
        $shopOrder->setUserPhone($userPhone);
        $shopOrder->setSessionId($sessionId);
        $shopOrder->setStatus(ShopOrder::STATUS_NEW_ORDER);
        $this->entityManager->persist($shopOrder);
        $this->entityManager->flush();
    }

    /**
     * @param string $username
     * @return array
     */
    public function getShopOrderHistory(string $username): array
    {
        $user = $this->userRepository->findOneBy(['username' => $username]);
        $orders = $this->shopOrderRepository->findBy(['user'=>$user]);
        $tmp = [];
        foreach ($orders as $order) {
            $items = $this->korzinaRepository->findBy(['sessionID' => $order->getSessionId()]);
            $shopItems = [];
            foreach ($items as $item) {
                $shopItems[] = [
                    'name' => $item->getItems()->getName(),
                    'cost' => $item->getItems()->getPrice(),
                    'img' => $item->getItems()->getImgSrc(),
                    'count' => $item->getCount()
                ];
            }
            $tmp[] = [
                'date' => date('d-m-Y', $order->getSessionId()),
                'items' => $shopItems
            ];
        }
        return $tmp;
    }
}