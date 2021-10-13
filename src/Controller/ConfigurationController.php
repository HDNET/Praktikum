<?php

namespace App\Controller;

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

    /**
     * ConfigurationController constructor.
     */
    public function __construct(QueryService $queryService, EmailService $emailService)
    {
        $this->queryService = $queryService;
        $this->emailService = $queryService;
    }


    /**
     * @Route("/")
     * @return Response
     */
    public function index()
    {
        // do some things
        return $this->render('configuration/index.twig');
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

        return new JsonResponse($queryParams);
        // return new RedirectResponse('/'); // Redirect to another route
    }

}