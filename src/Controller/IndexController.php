<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Contact;
use App\FormType\ContactType;
use App\Service\EmailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    protected const EMAIL_ADDRESS = 'florian.patruck@hdnet.de';
    protected EmailService $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    /**
     * @Route("/", name="home")
     */
    public function index(Request $request): Response
    {
        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->emailService->sendMail(self::EMAIL_ADDRESS,
                    self::EMAIL_ADDRESS,
                    $contact->getSubject(),
                    'emails/contact.html.twig',
                    [
                        'username' => 'Peter der Praktikant',
                        'name' => $contact->getName(),
                        'from' => $contact->getEmail(),
                        'message' => $contact->getMessage(),
                    ]);
                $this->addFlash('contact-success', 'Ihre Nachricht wurde erfolgreich gesendet!');
            } catch (\Exception $e) {
                $this->addFlash('contact-danger', 'Ihre Nachricht kann derzeit nicht zugestellt werden!');
                return $this->renderForm('landingpage/index.html.twig', [
                    'form' => $form,
                ]);
            }

            return $this->redirectToRoute('home');
        }

        return $this->renderForm('landingpage/index.html.twig', [
            'form' => $form,
        ]);
    }
}
