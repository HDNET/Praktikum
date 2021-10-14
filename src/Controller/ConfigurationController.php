<?php

namespace App\Controller;

use App\Repository\ColorRepository;
use App\Repository\SizeRepository;
use App\Service\EmailService;
use App\Service\QueryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConfigurationController extends AbstractController
{
    private $queryService;
    private $emailService;
    private $colorRepository;
    private $sizeRepository;

    /**
     * ConfigurationController constructor.
     */
    public function __construct(
        QueryService $queryService,
        EmailService $emailService,
        ColorRepository $colorRepository,
        SizeRepository $sizeRepository)
    {
        $this->queryService = $queryService;
        $this->emailService = $queryService;
        $this->colorRepository = $colorRepository;
        $this->sizeRepository = $sizeRepository;
    }


    /**
     * @Route("/")
     * @return Response
     */
    public function index()
    {
        // TODO: Fetch data from repositories
        // $this->colorRepository->
        // $this->sizeRepository->

        // TODO: assign data as context to template
        $context = [];

        return $this->render('configuration/index.twig', $context);
    }

    /**
     * @Route("/form/submit")
     * @param Request $request
     * @return Response
     */
    public function submitForm(Request $request)
    {
        /*
         * Example of value of $queryParams
         * [
         *  'inputName1' => 'value1',
         *  'inputName2' => 'value2',
         *  'inputName3' => 'value3',
         * ]
         */
        $queryParams = $this->queryService->getQueryParameter($request);

        // TODO: prepare context for the email template
        /*
         The templates needs two information:
         size -> The size of the bike
         color -> The color of the bike
        */
        $context = [];

        // TODO: Set some Variables
        // TODO: Set a variable for the email address which is the receiving email address
        // TODO: Set a variable for the subject of the email
        /*
         * To send the email you can use the Email-Service
         * $this->emailService
         */

        // TODO: Send the user back to the start route
        /*
         * To send a user to an another rout is called redirecting.
         * The start route is simply '/'
         * You can use the RedirectResponse for this.
         */
        return new JsonResponse($queryParams);
        // return new RedirectResponse(); // Redirect to another route
    }

}