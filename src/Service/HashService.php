<?php


namespace App\Service;


use App\Controller\BackendController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class HashService
 * @package App\Service
 */
class HashService
{
    /**
     * Filesystem service to interact with the local filesystem
     *
     * @var Filesystem $filesystem
     */
    protected Filesystem $filesystem;

    /**
     * QueryService to extract query params from the request
     *
     * @var QueryService $queryService
     */
    protected QueryService $queryService;

    public function __construct(Filesystem $filesystem, QueryService $queryService)
    {
        $this->filesystem = $filesystem;
        $this->queryService = $queryService;
    }

    /**
     * @param int $currentTime
     * @param string $recipient
     * @param string $hashAlgo
     * @return string
     */
    public function generateHash(int $currentTime, string $recipient, string $hashAlgo = 'sha256') {
        // build hash string
        $hashString = $recipient . $currentTime;
        // return the hashed string
        return \hash($hashAlgo, $hashString);
    }

    public function validateHash(Request $request): bool
    {
        // get hash from request
        $hash = $this->getHash($request);

        // if hash is not set, hash is also invalid
        if (null === $hash) {
            return false;
        }

        // generate file path from hash
        $filePath = BackendController::HASH_FILES_BASE_URL . '/' . $hash . '.txt';
        // check if file exist. If not the hash is not valid.
        if (\file_exists($filePath)) {
            // get content from file
            $content = \file_get_contents($filePath);
            // parse content to array
            $content = explode(';', $content);
            // check if link is expired
            if (
                time() < intval($content[2]) &&
                intval($content[4]) + 1 <= intval($content[3])
            ) {
                // increase number of link calls
                $content[4] = intval($content[4]) + 1;
                // write new infos to file
                $this->filesystem->dumpFile($filePath, implode(';', $content));
                // activate download button
                return true;
            }
        }

        // return default value false
        return false;
    }

    public function getHash(Request $request): ?string
    {
        // check if an query is available
        if ($request->getQueryString()) {
            // parse query params
            $params = $this->queryService->getQueryParameter($request);
            // check if hash identifier is available in query params
            if (key_exists(BackendController::HASH_IDENTIFIER, $params)) {
                // get hash
                $hash = $params[BackendController::HASH_IDENTIFIER];
                return $hash;
            }
        }

        return null;
    }
}
