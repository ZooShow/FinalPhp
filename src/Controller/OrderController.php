<?php

namespace App\Controller;

use App\Entity\ShopOrder;
use App\Form\FormType;
use App\Services\OrderService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/order", name="order")
 */
class OrderController extends AbstractController
{
    /**
     * @var OrderService
     */
    private $orderService;

    /**
     * @param OrderService $orderService
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }


    /**
     * @Route(name="See")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function shopOrder(Request $request, EntityManagerInterface $em): Response
    {
        $shopOrder = new ShopOrder();
        $user = $this->getUser()->getUserIdentifier();
        $form = $this->createForm(FormType::class, $shopOrder);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $this->orderService->addShopOrder(
                $user,
                $data->getUserName(),
                $data->getUserEmail(),
                $data->getUserPhone(),
                $this->get('session')->get('name')
            );
            return $this->redirectToRoute('index');
        }

        return $this->render('order/index.html.twig', [
            'title' => 'Оформление заказа',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route ("/history", name = "History")
     * @return Response
     */
    public function getHistory(): Response
    {
        $orders = $this->orderService->getShopOrderHistory(
            $this->getUser()->getUserIdentifier()
        );
//        dd($orders);
        return $this->render('order/history.html.twig', [
           'title' => 'История заказов',
           'orders' => $orders
        ]);
    }
}
