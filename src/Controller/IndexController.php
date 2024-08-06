<?php

namespace App\Controller;

use App\Entity\Email;
use App\Repository\EmailRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email as SymfonyEmail;

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
    public function subscribe(Request $request, EmailRepository $emails, MailerInterface $mailer): JsonResponse
    {
        $email = new Email();
        $email->setEmail($request->request->get('widget-subscribe-form-email'));
        $email->setTipo('subscribe');

        $emails->save($email);


        $sendMail = (new SymfonyEmail())
            ->from('robertoniche@robertoniche.com.br')
            ->to('robertoniche@robertoniche.com.br')
            ->subject('New subscribe!')
            ->text('Possivel cliente entrando pelo subscribe!')
            ->html('<p>Possivel cliente entrando pelo subscribe!</p><p>'.$email->getEmail().'</p>');

        $mailer->send($sendMail);

        return new JsonResponse([
            "alert" => "success",
            "message" => "Recebemos seu e-mail <strong>".$request->request->get('widget-subscribe-form-email')."</strong>. Em breve estaremos entrando em contato. Obrigado"
        ]);
    }
    
    #[Route('/contact', name:'app_contact')]
    public function contact(Request $request, EmailRepository $emails, MailerInterface $mailer): JsonResponse
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

        $sendMail = (new SymfonyEmail())
            ->from('robertoniche@robertoniche.com.br')
            ->to('robertoniche@robertoniche.com.br')
            ->subject('New subscribe!')
            ->text('Possivel cliente entrando pelo subscribe!')
            ->html('<p>Possivel cliente entrando pelo subscribe!</p>
                            <p>email: '.$email->getEmail().'</p>
                            <p>Nome: '.$email->getNome().'</p>
                            <p>Fone:'.$email->getFone().'</p>
                            <p>Mensagem:'.$email->getMensagem().'</p>');

        $mailer->send($sendMail);

        return new JsonResponse([
            "alert" => "success",
            "message" => "Recebemos seu contato. Em breve estaremos entrando em contato no e-mail ". $request->get('quick-contact-form-email').". Obrigado."
        ]);
    }
}
