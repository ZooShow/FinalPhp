<?php

namespace App\Controller;

use App\Services\KorzinaService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/korzina", name="korzina")
 */
class KorzinaController extends AbstractController
{

    /**
     * @var KorzinaService
     */
    private $korzinaService;

    /**
     * @param KorzinaService $korzinaService
     */
    public function __construct(KorzinaService $korzinaService)
    {
        $this->korzinaService = $korzinaService;
    }

    public function index(): Response
    {
        return $this->render('korzina/index.html.twig', [
            'controller_name' => 'KorzinaController',
        ]);
    }

    /**
     * @Route("/add/{id<\d+>}", name="Add")
     * @param $id
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function addKorzina($id): Response
    {
        $sessionId = $this->get('session')->get('name');

        $this->korzinaService->addItemToKorzina($id, $sessionId);
        return $this->redirectToRoute('shop', [
            'id' => $id
        ]);
    }

    /**
     * @Route(name="See")
     * @return Response
     */
    public function seeKorzina(): Response
    {
        $sessionId = $this->get('session')->get('name');

        return $this->render('/korzina/index.html.twig', [
            'title' => 'Корзина',
            'items' => $this->korzinaService->getKorzinaBySessionId($sessionId)
        ]);
    }
}
