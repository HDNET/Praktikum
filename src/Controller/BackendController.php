<?php


namespace App\Controller;


use App\Service\HashService;
use App\Service\QueryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
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
     * @Route("/", name="Admin")
     */
    public function index() {
        // render template
        return $this->render('/backend/index.html.twig', [
            'user' => $this->getUser(), // get the current logged in user
            'generatedLink' => ''
        ]);
    }

    /**
     * @Route("/generateLink", name="generateLink")
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

        // create link
        $generatedLink = $this->baseUrl . '?' . self::HASH_IDENTIFIER . '=' . $hash;

        // render the template
        return $this->render('/backend/index.html.twig', ['user' => $this->getUser(), 'generatedLink' => $generatedLink]);
    }

    /**
     * @Route("/uploadCv", name="uploadCv", methods={"POST"})
     */
    public function uploadCV(Request $request, Filesystem $filesystem): Response
    {
        try {
            // Make sure a file was uploaded by looking into the request
            if (!$request->files->has('cvFile')) {
                throw new \Exception('Es muss eine Datei hochgeladen werden!');
            }

            // Set the destination path where the file should be moved to, so that one is later able to download the file
            $oldCvFilename = IndexController::CV_ASSETDIR . \DIRECTORY_SEPARATOR . IndexController::CV_ASSETFILENAME;
            if ($filesystem->exists($oldCvFilename)) {
                $filesystem->remove($oldCvFilename);
            }

            // Get the file from the request
            $file = $request->files->get('cvFile');

            // Make sure the uplaod was successful
            if (!$file instanceof UploadedFile || !$file->isValid()) {
                throw new \Exception('Die Datei konnte nicht hochgeladen werden!');
            }

            // Validate that the size is not bigger then 5 MB
            if ($file->getSize() > 500000) {
                throw new \Exception('Die hochgeladene Datei überschreitet die maximale Uploadgröße von 5 MB!');
            }

            // Validate that the file has the correct extension (.pdf)
            if ($file->getMimeType() != 'application/pdf') {
                throw new \Exception('Die hochgeladene Datei muss eine PDF Datei sein!');
            }

            // Move the file where it can be downloaded
            $file->move(IndexController::CV_ASSETDIR, IndexController::CV_ASSETFILENAME);
        } catch (\Exception $e) {
            // If an error occurs, show it to the user and send the result
            $this->addFlash('upload-danger', $e->getMessage());
            return $this->redirectToRoute('Admin');
        }

        // Tell the user that the cv was uploaded successfully
        $this->addFlash('upload-success', 'Der Steckbrief wurde erfolgreich hochgeladen!');
        return $this->redirectToRoute('Admin');
    }
}
