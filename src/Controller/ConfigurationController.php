<?php

namespace App\Controller;

use App\Service\QueryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConfigurationController extends AbstractController
{
    /**
     * ConfigurationController constructor.
     */
    public function __construct(private QueryService $queryService)
    {
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
        $queryParams = $this->queryService->getQueryParameter($request);
        // do some things
        return new JsonResponse($queryParams);
    }

}