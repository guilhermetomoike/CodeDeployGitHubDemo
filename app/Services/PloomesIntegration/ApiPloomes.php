<?php

namespace App\Services\PloomesIntegration;

use Illuminate\Support\Facades\Http;

class ApiPloomes
{
    private \Illuminate\Http\Client\PendingRequest $http;

    public function __construct()
    {
        $this->http = Http
            ::withHeaders(['User-Key' => config('services.ploomes.key')])
            ->baseUrl(config('services.ploomes.url'));
    }

    public function getQuoteData(int $dealId)
    {
        $query = [
            '$filter' => "DealId+eq+$dealId",
            '$expand' => [
                'OtherProperties' => ['Field'],
                'Deal' => [
                    'Attachments',
                    'Updater',
                    'Person',
                    'OtherProperties' => ['Field'],
                ],
                'Contact' => [
                    'Phones',
                    'OtherProperties' => ['Field']
                ],
                'Products' => [
                    'OtherProperties' => ['Field']
                ],
            ]
        ];

        $response = $this->http->get('Quotes', $this->qualifyQuery($query))->json();
        return new PloomesQuoteDTO($response['value'][0]);
    }

    private function qualifyQuery(array $queries)
    {
        $qualifiedQuery = '';
        foreach ($queries as $key => $params) {
            if ($key === '$filter') {
                $qualifiedQuery .= "$key=$params&";
                continue;
            }

            if ($key === '$expand') {
                $subQuery = $this->qualifySubQuery($params);
                $qualifiedQuery .= "$key=$subQuery";
                continue;
            }
        }

        return $qualifiedQuery;
    }

    private function qualifySubQuery($params)
    {
        if (is_string($params)) return $params;
        if (is_array($params) && count($params) < 2 && !count(array_values($params))) return $params[0];

        $qualifiedSubParam = '';
        foreach ($params as $key => $param) {
            $sub = $this->qualifySubQuery($param);
            if (is_string($key)) {
                if ((is_array($params[$key]) && count(array_values($params)) > 1) && $key != array_key_first($params)) $qualifiedSubParam .= ',';
                $qualifiedSubParam .= "$key(\$expand=$sub)";
                continue;
            }
            if (end($params) != $key) $sub .= ',';
            $qualifiedSubParam .= "$sub";
        }
        return $qualifiedSubParam;
    }
}

//$query = '$filter=DealId+eq+' . $dealId . '&$expand=
//        OtherProperties($expand=Field),
//        Deal($expand=
//            Person,
//            OtherProperties(
//                $expand=Field
//            )
//        ),
//        Contact($expand=
//            OtherProperties(
//                $expand=Field
//            )
//        ),
//        Products($expand=
//            OtherProperties
//        )';
