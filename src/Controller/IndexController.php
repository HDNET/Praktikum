<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Contact;
use App\FormType\ContactType;
use App\Service\EmailService;
use App\Service\HashService;
use App\Service\QueryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    public const CV_ASSETDIR = '../assets';
    public const CV_ASSETFILENAME = 'Steckbrief.pdf';
    protected const EMAIL_ADDRESS = 'florian.patruck@hdnet.de';
    protected EmailService $emailService;
    protected HashService $hashService;

    public function __construct(EmailService $emailService, HashService $hashService)
    {
        $this->emailService = $emailService;
        $this->hashService = $hashService;
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

        $showDownloadButton = $this->hashService->validateHash($request);

        // render template
        return $this->renderForm('landingpage/index.html.twig', [
            'form' => $form,
            'showDownloadButton' => $showDownloadButton,
            'hash' => $this->hashService->getHash($request),
        ]);
    }

    /**
     * @Route("/downloadCv", name="downloadCv")
     */
    public function getUploadedCv(Filesystem $filesystem, Request $request): Response
    {
        if (!$this->hashService->validateHash($request)) {
            return new Response('Not authorized', Response::HTTP_FORBIDDEN);
        }

        $filename = self::CV_ASSETDIR.\DIRECTORY_SEPARATOR.self::CV_ASSETFILENAME;
        if (!$filesystem->exists($filename)) {
            return new Response('File not set yet!', Response::HTTP_NOT_FOUND);
        }
        return new BinaryFileResponse($filename);
    }
}
