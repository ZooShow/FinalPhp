<?php

namespace App\Controller;

use App\Form\FormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ShopItemsRepository;
use App\Repository\ShopOrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;

use App\Repository\KorzinaRepository;
use App\Entity\Korzina;
use App\Entity\ShopItems;
use App\Entity\User;
use App\Entity\ShopOrder;


class Controller extends AbstractController
{

    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {

        return $this->render('/index.html.twig', [
            'controller_name' => 'Controller',
        ]);
    }


    /**
     * @Route("/shop/list", name="itemList")
     */
    public function itemList(ShopItemsRepository $itemsRepository): Response
    {

        $items = $itemsRepository->findAll();
        
        
        return $this->render('/listItem.html.twig', [
            'title' => 'Товары',
            'items' => $items
        ]);
    }

    /**
     * @Route("/shop/item/{id<\d+>}", name="shop")
     * @param $item
     * @return Response
     */
    public function shop(ShopItems $item): Response
    {
        return $this->render('/shop.html.twig', [
            'title' => $item->getName(),
            'price' => $item->getPrice(),
            'id' => $item->getID()           
        ]);
    }


    /**
     * @Route("/shop/korzina/add/{id<\d+>}", name="addKorzina")
     * @param ShopItems $items
     * @return Response
     */
    public function addKorzina(ShopItems $items, EntityManagerInterface $em):Response 
    {
        $sessionID = 2;
        $korzina = (new Korzina())
            ->setItems($items)
            ->setCount(1)
            ->setSessionID($sessionID);
        
            $em->persist($korzina);
            $em->flush();
        return $this->redirectToRoute('shop', ['id' => $items->getId()]);
    }

    /**
     * @Route("/shop/korzina/{id<\d+>}", name="korzina")
     * @param ShopItems $items
     * @return Response
     */
    public function seeKorzina(KorzinaRepository $items):Response 
    {
        $sessionID = "2";
        $korzina = $items->findBy(['sessionID' => $sessionID]);
        
        return $this->render('/korzina.html.twig', [
            'title' => 'Корзина',
            'items' => $korzina
        ]);
    }


    /**
     * @Route("/shop/order", name="order")
     * @param ShopItems $items
     * @return Response
     */
    public function shopOrder(Request $request, EntityManagerInterface $em): Response
    {
        
        $shopOrder = new ShopOrder();

        $form = $this->createForm(FormType::class, $shopOrder);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $shopOrder = $form->getData();

            if ($shopOrder instanceof ShopOrder) {
                $sessionId = 2;
                $shopOrder->setStatus(ShopOrder::STATUS_NEW_ORDER);
                $shopOrder->setSessionId($sessionId);
                $em->persist($shopOrder);
                $em->flush();
                
            }

            return $this->redirectToRoute('index');
        }


        return $this->render(
            'shopOrder.html.twig',
            [
                'title' => 'Оформление заказа',
                'form' => $form->createView(),
            ]
        );
        
    }

    
}
