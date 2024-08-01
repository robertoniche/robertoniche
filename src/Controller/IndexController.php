<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }
    
    #[Route('/subscribe', name:'app_subscribe')]
    public function subscribe(Request $request): JsonResponse
    {
        return new JsonResponse([
            "alert" => "success",
            "message" => "You have been <strong>successfully</strong> subscribed to our Email List." . $request->request->get('widget-subscribe-form-email')
        ]);
    }
    
    #[Route('/contact', name:'app_contact')]
    public function contact(Request $request): JsonResponse
    {
        //CHAVE DO SITE: 6LeUqBsqAAAAAEGGzPvowkn0PxB9zpPw9ghd4zrF --> UTILIZANDO PARA INTEGRAR NO PROPRIO SITE
        //CHAVE SECRETA: 6LeUqBsqAAAAACgwFZBheDVbk5539vLEGXAJ6eZC --> UTILIZADO PARA API

        return new JsonResponse([

        ]);
    }
}
