<?php


namespace App\Service;


use Symfony\Component\HttpFoundation\Request;

class QueryService
{
    public function getQueryParameter(Request $request): array
    {
        $queryParams = [];

        $queryString = $request->getQueryString();
        $queries = explode('&', $queryString);

        foreach ($queries as $query) {
            $splittedQuery = explode('=', $query);
            $queryParams[$splittedQuery[0]] = $splittedQuery[1] ? $splittedQuery[1] : '';
        }

        return $queryParams;
    }
}