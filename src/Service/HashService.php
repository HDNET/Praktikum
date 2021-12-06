<?php


namespace App\Service;


class HashService
{

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

}