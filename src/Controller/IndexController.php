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
        // set some default variables
        $showDownloadButton = false;

        // create new empty contact object
        $contact = new Contact();

        // create new Form for ContactType (the ContactType defines the form fields)
        $form = $this->createForm(ContactType::class, $contact);

        // load form input from request if they are available
        $form->handleRequest($request);
        // check if form is submitted and if all values are syntactically correct
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                // send email with contact infos
                $this->emailService->sendMail(self::EMAIL_ADDRESS,
                    self::EMAIL_ADDRESS,
                    $contact->getSubject(),
                    'emails/contact.html.twig',
                    [
                        'name' => $contact->getName(),
                        'from' => $contact->getEmail(),
                        'message' => $contact->getMessage(),
                    ]);
                // add flash message to notice the user the success message sending
                $this->addFlash('contact-success', 'Ihre Nachricht wurde erfolgreich gesendet!');
            } catch (\Exception $e) {
                // add flash message to notice the user that something went wrong
                $this->addFlash('contact-danger', 'Ihre Nachricht kann derzeit nicht zugestellt werden!');

                // render template
                return $this->renderForm('landingpage/index.html.twig', [
                    'showDownloadButton' => $showDownloadButton,
                    'form' => $form,
                ]);
            }

            // redirect to home route
            return $this->redirectToRoute('home');
        }

        // check if an query is available
        if ($request->getQueryString()) {
            // parse query params
            $params = $queryService->getQueryParameter($request);
            // check if hash identifier is available in query params
            if (key_exists(BackendController::HASH_IDENTIFIER, $params)) {
                // get hash
                $hash = $params[BackendController::HASH_IDENTIFIER];
                // generate file path from hash
                $filePath = BackendController::HASH_FILES_BASE_URL . '/' . $hash . '.txt';
                // check if file exist. If not the hash is not valid.
                if (\file_exists($filePath)) {
                    // get content from file
                    $content = \file_get_contents($filePath);
                    // parse content to array
                    $content = explode(';', $content);
                    // check if link is expired
                    if (
                        time() < intval($content[2]) &&
                        intval($content[4]) + 1 <= intval($content[3])
                    ) {
                        // increase number of link calls
                        $content[4] = intval($content[4]) + 1;
                        // write new infos to file
                        $filesystem->dumpFile($filePath, implode(';', $content));
                        // activate download button
                        $showDownloadButton = true;
                    }
                }
            }
        }

        // render template
        return $this->renderForm('landingpage/index.html.twig', [
            'form' => $form,
            'showDownloadButton' => $showDownloadButton,
        ]);
    }
}
