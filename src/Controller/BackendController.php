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

    public const HASH_IDENTIFIER = 'hash';
    public const HASH_FILES_BASE_URL = '../sharedLinks';

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
        $filesystem->mkdir(self::HASH_FILES_BASE_URL);

        // build hash
        $currentTime = time();
        $recipient = $params['recipient'];
        $hashString = $recipient . $currentTime;
        $hash = hash('sha256', $hashString);

        // create file with hash as filename
        $filesystem->touch(self::HASH_FILES_BASE_URL . '/' . $hash . '.txt');

        // build data for File
        $dayMultiplier = 60*60*24;
        $expireTime = $currentTime + $dayMultiplier * $params['expiresInDays'];
        // Syntax:
        //      currentTime;recipient;dayExpirationTime;callExpirationNumber;numberOfCalls
        $data = $currentTime . ';' . $recipient . ';' . $expireTime . ';' . $params['expiresInLinkCalls'] . ';0';

        // append data to file
        $filesystem->appendToFile(self::HASH_FILES_BASE_URL . '/' . $hash . '.txt', $data);

        // create link
        $generatedLink = 'http://localhost:8888?' . self::HASH_IDENTIFIER . '=' . $hash;

        return $this->render('/backend/index.html.twig', ['user' => $this->getUser(), 'generatedLink' => $generatedLink]);
    }

}