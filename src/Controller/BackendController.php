<?php


namespace App\Controller;


use App\Service\HashService;
use App\Service\QueryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BackendController extends AbstractController
{

    /**
     * The identifier in the query string
     */
    public const HASH_IDENTIFIER = 'hash';

    /**
     * The base path, where the hash files are located
     */
    public const HASH_FILES_BASE_URL = '../sharedLinks';

    /** @var string $baseUrl The base url/ base domain */
    protected $baseUrl;

    public function __construct(string $baseUrl)
    {
        // set given baseUrl
        $this->baseUrl = $baseUrl;
    }

    /**
     * @Route("/admin", name="Admin")
     */
    public function index() {
        // render template
        return $this->render('/backend/index.html.twig', [
            'user' => $this->getUser(), // get the current logged in user
            'generatedLink' => ''
        ]);
    }

    /**
     * @Route("/admin/generateLink", name="generateLink")
     * @param Request $request
     * @return Response
     */
    public function generateLink(Request $request, QueryService $queryService, Filesystem $filesystem, HashService $hashService) {

        // get params from request
        $params = $queryService->getQueryParameter($request);

        // generate Folder if not exist
        $filesystem->mkdir(self::HASH_FILES_BASE_URL);

        // build hash
        $currentTime = time();
        $hash = $hashService->generateHash($currentTime, $params['recipient']);

        // create file with hash as filename
        $filesystem->touch(self::HASH_FILES_BASE_URL . '/' . $hash . '.txt');

        // build data for File
        $dayMultiplier = 60*60*24;
        $expireTime = $currentTime + $dayMultiplier * $params['expiresInDays'];
        // Syntax:
        //      currentTime;recipient;dayExpirationTime;callExpirationNumber;numberOfCalls
        $data = $currentTime . ';' . $params['recipient'] . ';' . $expireTime . ';' . $params['expiresInLinkCalls'] . ';0';

        // append data to file
        $filesystem->appendToFile(self::HASH_FILES_BASE_URL . '/' . $hash . '.txt', $data);

        var_dump($request->server->getHeaders());

        // create link
        $generatedLink = $this->baseUrl . '?' . self::HASH_IDENTIFIER . '=' . $hash;

        // render the template
        return $this->render('/backend/index.html.twig', ['user' => $this->getUser(), 'generatedLink' => $generatedLink]);
    }

}