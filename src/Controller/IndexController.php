<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Contact;
use App\FormType\ContactType;
use App\Service\EmailService;
use App\Service\QueryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
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
    public function index(Request $request, QueryService $queryService, Filesystem $filesystem): Response
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

        // check if hash is present
        $showDownloadButton = false;
        if($request->getQueryString()) {
            $params = $queryService->getQueryParameter($request);
            if(key_exists(BackendController::HASH_IDENTIFIER, $params)) {
                $hash = $params[BackendController::HASH_IDENTIFIER];
                $filePath = BackendController::HASH_FILES_BASE_URL . '/' . $hash . '.txt';
                if(\file_exists($filePath)) {
                    $content = \file_get_contents($filePath);
                    $content = explode(';', $content);
                    if(
                        time() < intval($content[2]) &&
                        intval($content[4])+1 <=  intval($content[3])
                    ){
                        $content[4] = intval($content[4])+1;
                        $filesystem->dumpFile($filePath, implode(';', $content));
                        $showDownloadButton = true;
                    }
                }
            }
        }

        return $this->renderForm('landingpage/index.html.twig', [
            'form' => $form,
            'showDownloadButton' => $showDownloadButton,
        ]);
    }
}
