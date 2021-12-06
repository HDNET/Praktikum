<?php


namespace App\Controller;


use App\Service\QueryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BackendController extends AbstractController
{

    protected const COOKIE_IDENTIFIER = 'BE_LOGIN';

    /**
     * @Route("/admin", name="Admin")
     */
    public function index() {
        return $this->render('/backend/index.html.twig', ['user' => $this->getUser(), 'generatedLink' => '']);
    }

    /**
     * @Route("/admin/generateLink", name="generateLink")
     * @param Request $request
     * @return Response
     */
    public function generateLink(Request $request, QueryService $queryService, Filesystem $filesystem) {

        $params = $queryService->getQueryParameter($request);
        var_dump($params);

        // generate Folder if not exist
        $filesystem->mkdir('../shardLinks');

        $currentTime = time();
        $recipient = $params['recipient'];





        $generatedLink = 'hammer krasser link';

        return $this->render('/backend/index.html.twig', ['user' => $this->getUser(), 'generatedLink' => $generatedLink]);
    }

}