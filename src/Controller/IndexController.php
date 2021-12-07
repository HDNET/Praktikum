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
    /**
     * Path where to store the uploaded cv
     */
    public const CV_ASSET_DIR = '../uploads/assets';
    /**
     * Filename of the uploaded cv
     */
    public const CV_ASSET_FILENAME = 'Steckbrief.pdf';
    /**
     * The email address where the emails will send to from the contact form
     */
    protected $reciverEmailAddress;

    /**
     * EmailService used to send emails
     *
     * @var EmailService $emailService
     */
    protected EmailService $emailService;

    /**
     * HashService to generate and validate hashes
     * @var HashService $hashService
     */
    protected HashService $hashService;

    /**
     * IndexController constructor.
     * @param EmailService $emailService
     * @param HashService $hashService
     */
    public function __construct(EmailService $emailService, HashService $hashService, $reciverEmailAddress)
    {
        $this->emailService = $emailService;
        $this->hashService = $hashService;
        $this->reciverEmailAddress = $reciverEmailAddress;
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
                $this->emailService->sendMail($this->reciverEmailAddress,
                    $this->reciverEmailAddress,
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

        $filename = self::CV_ASSET_DIR.\DIRECTORY_SEPARATOR.self::CV_ASSET_FILENAME;
        if (!$filesystem->exists($filename)) {
            return new Response('File not set yet!', Response::HTTP_NOT_FOUND);
        }
        return new BinaryFileResponse($filename);
    }
}
