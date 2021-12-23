<?php


namespace App\Controller;


use App\Service\HashService;
use App\Service\QueryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
    public const HASH_FILES_BASE_URL = '../uploads/sharedLinks';

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
        /*
         * Hier soll wieder ein Template mit Daten gerendert werden.
         * Template Name: /backend/index.html.twig
         * Contexts:
         *  - Der aktuelle User ('user') --> hier kannst du die Funktion 'getUser' verwenden welche von dieser Klasse bereitgestellt wird
         *  - 'generatedLink' --> aktuell noch ein leerer String
         */
    }

    /**
     * @Route("/generateLink", name="generateLink")
     * @param Request $request
     * @return Response
     */
    public function generateLink(Request $request, QueryService $queryService, Filesystem $filesystem, HashService $hashService) {

        // get params from request
        /*
         * Die Informationen, welche wir zum Generieren des Links brauchen, befinden sich ebenfalls in dem request.
         * Verwende den QueryService und die Funktion 'getQueryParameter', um die benötigten Daten aus dem Parameter
         * herauszulesen.
         *
         * Weise das Ergebnis dieses Aufrufs in eine Variable, die 'params' heißt.
         */

        // generate Folder if not exist
        $filesystem->mkdir(self::HASH_FILES_BASE_URL);

        // build hash
        $currentTime = time();
        /*
         * Die Hash Generierung:
         * Mithilfe des 'hashService' und der Funktion 'generateHash' kannst du dir einen Hash generieren lassen.
         * Speichere diesen in eine Variable ('hash')
         */

        // create file with hash as filename
        $filesystem->touch(self::HASH_FILES_BASE_URL . '/' . $hash . '.txt');

        // build data for File
        /*
         * Erstelle eine Variable mit dem Namen 'dayMultiplier'. Diese soll einen ganzzahligen Wert enthalten. Dieser
         * Wert ist die Anzahl an Sekunden, die ein Tag besitzt.
         */

        /*
         * Nun soll der Zeitpunkt berechnet werden, an dem der Link nicht mehr gültig ist. Zuerst betrachten wir nur die
         * zeitliche Komponente.
         *
         * Der Zeitpunkt wird mit folgender Formel berechnet:
         * [Zeitpunkt der Ungültigkeit] = [aktueller Zeitpunkt] + [Anzahl an Sekunden pro Tag] * [Die Anzahl an Tage die der Link gültig ist]
         *
         * Das Ergebnis dieser Rechnung soll in einer Variable gespeichert werden, welche 'expireTime' heißt
         *
         */

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
            $oldCvFilename = IndexController::CV_ASSET_DIR . \DIRECTORY_SEPARATOR . IndexController::CV_ASSET_FILENAME;
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
            $file->move(IndexController::CV_ASSET_DIR, IndexController::CV_ASSET_FILENAME);
        } catch (\Exception $e) {
            // If an error occurs, show it to the user and send the result
            $this->addFlash('upload-danger', $e->getMessage());
            return $this->redirectToRoute('Admin');
        }

        // Tell the user that the cv was uploaded successfully
        $this->addFlash('upload-success', 'Der Steckbrief wurde erfolgreich hochgeladen!');
        return $this->redirectToRoute('Admin');
    }

    /**
     * @Route("/removeCV", name="removeCV")
     * @param Filesystem $filesystem
     * @return Response
     */
    public function removeUploadedCV(Filesystem $filesystem): Response
    {
        //  build the filename
        /*
         * Da wir den Dateinamen des hochgeladenen Dokumentes mehrfach verwenden, bauen wir uns ihn einmal zusammen.
         * Dazu gibt es in der Klasse IndexController eine Konstante, die 'CV_ASSET_DIR' heist. In dieser Konstante ist
         * der Pfad zum Ordner, indem die Datei liegt gespeichert. Als Nächstes benötigen wir noch die Konstante
         * 'DIRECTORY_SEPARATOR'. Diese enthält je nach Betriebssystem das Zeichen, mit welchem ein Pfad getrennt ist.
         * Zuletzt befindet sich im IndexController noch eine weitere Konstante. Die Konstante mit dem Namen:
         * 'CV_ASSET_FILENAME'.
         *
         * Verbinde diese drei Konstanten miteinander und speichere sie in eine Variable ('filename')
         */
        // check if file with filename exists
        /*
         * Der Service Filesystem spiegelt unser Dateisystem auf dem Rechner/ Server wider. Mithilfe des Filesystems
         * können wir überprüfen, ob die Datei überhaupt existiert. Dazu verwende die Funktion 'exist' der du den
         * filename übergibst.
         *
         * Das Ergebnis wird in einer If-Bedingung überprüft.
         *
         * Ist die Datei vorhanden, hilft uns die Funktion 'remove' von dem Filesystem Service die Datei zu löschen.
         */
        // redirect to backend
        return $this->redirectToRoute('Admin');
    }

}
