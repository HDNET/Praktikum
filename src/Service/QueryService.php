<?php


namespace App\Service;


use Symfony\Component\HttpFoundation\Request;

/**
 * Class QueryService
 *
 * Works with the query string and params of a given request.
 *
 * @package App\Service
 */
class QueryService
{
    /**
     * Extract the query params from the request.
     *
     * @param Request $request
     * @return array
     */
    public function getQueryParameter(Request $request): array
    {
        // set empty array as default return value
        $queryParams = [];

        // get the query string from the given request
        $queryString = $request->getQueryString();
        // query params are separated by the '&' char.
        // split the string and put them in an array
        $queries = explode('&', $queryString);

        // go through all parts of the query string and split them into key => value pairs
        foreach ($queries as $query) {
            // split by the char '=' and put the parts in an array
            $splittedQuery = explode('=', $query);
            // set the first element (index 0) as the key and the second part (index 1) as the value
            // if the value is evaluate as false a empty string will be set
            $queryParams[$splittedQuery[0]] = $splittedQuery[1] ? $splittedQuery[1] : '';
        }

        // return the parsed query params
        return $queryParams;
    }
}