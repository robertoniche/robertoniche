<?php

namespace App\Controller;

use App\Entity\Email;
use App\Repository\EmailRepository;
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
    public function subscribe(Request $request, EmailRepository $emails): JsonResponse
    {

        $email = new Email();
        $email->setEmail($request->request->get('widget-subscribe-form-email'));
        $email->setTipo('subscribe');

        $emails->save($email);

        return new JsonResponse([
            "alert" => "success",
            "message" => "Recebemos seu e-mail <strong>".$request->request->get('widget-subscribe-form-email')."</strong>. Em breve estaremos entrando em contato. Obrigado"
        ]);
    }
    
    #[Route('/contact', name:'app_contact')]
    public function contact(Request $request, EmailRepository $emails): JsonResponse
    {
        //CHAVE DO SITE: 6LeUqBsqAAAAAEGGzPvowkn0PxB9zpPw9ghd4zrF --> UTILIZANDO PARA INTEGRAR NO PROPRIO SITE
        //CHAVE SECRETA: 6LeUqBsqAAAAACgwFZBheDVbk5539vLEGXAJ6eZC --> UTILIZADO PARA API

        $email = new Email();
        $email->setEmail($request->request->get('quick-contact-form-email'));
        $email->setMensagem($request->request->get('quick-contact-form-message'));
        $email->setNome($request->request->get('quick-contact-form-name'));
        $email->setFone($request->request->get('quick-contact-form-phone'));
        $email->setTipo('contact');

        $emails->save($email);

        return new JsonResponse([
            "alert" => "success",
            "message" => "Recebemos seu contato. Em breve estaremos entrando em contato no e-mail ". $request->get('quick-contact-form-email').". Obrigado."
        ]);
    }
}
