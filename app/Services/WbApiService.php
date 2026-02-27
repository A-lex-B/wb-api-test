<?php

namespace App\Services;

use App\Enums\ApiResource;
use Carbon\Carbon;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class WbApiService
{
    protected const API_URL = 'http://109.73.206.144:6969/api/{resource}';
    protected int $limit = 500;
    protected PendingRequest $apiRequest;

    public function __construct()
    {
        $this->apiRequest = Http::baseUrl(static::API_URL)->withQueryParameters([
            'key' => env('WB_API_KEY')
        ]);
    }

    protected function makeApiRequest(string $dateFrom, string $dateTo, ?int $page = null, ?int $limit = null): Response
    {
        if ($dateFrom) {
            $query['dateFrom'] = $dateFrom;
        }
        if ($dateTo) {
            $query['dateTo'] = $dateTo;
        }
        if (isset($page)) {
            $query['page'] = $page;
        }
        if (isset($limit)) {
            $query['limit'] = $limit;
        }

        $response = $this->apiRequest->get('', $query);

        if ($response->successful()) {
            return $response;
        } else {
            throw new RequestException($response);
        }
    }

    public function store(
        ApiResource $resource, 
        ?Carbon $dateFrom = null, 
        ?Carbon $dateTo = null,
        bool $processSingleDateRange = false,
        bool $withoutDateTo = false
    ): void
    {
        $this->apiRequest->withUrlParameters(['resource' => $resource->value]);
        $modelClass = $resource->getModelClass();

        if ($dateFrom === null) {
            $dateFrom = now('+03:00')->subYearNoOverflow()->addDay();
        }
        $dateFrom->startOfDay();
        
        if ($processSingleDateRange && $withoutDateTo) {
            $dateTo = null;
        } elseif ($dateTo === null) {
            $dateTo = now('+03:00');
        }
        
        if (isset($dateTo)) {
            $dateRange = (int) $dateFrom->diffInDays($dateTo);
        }
        
        $page = 1;
        
        while (true) {
            $dateFromString = $resource->formatDateFrom($dateFrom);
            $dateToString = $dateTo ? $resource->formatDateTo($dateTo) : '';
            
            while (true) {
                $response = $this->makeApiRequest($dateFromString, $dateToString, $page, $this->limit);

                if (!data_get($response, 'meta.total')) break 2;

                $data = collect(data_get($response, 'data'));

                if ($data->isEmpty()) break;

                $data->map(function($attributes) use ($modelClass) {
                    $modelClass::create($attributes);
                });
                
                $page++;
            }

            if ($processSingleDateRange) break;
            
            $page = 1;
            $dateFrom = $dateFrom->subDays($dateRange + 1);
            $dateTo = $dateTo->endOfDay()->subDays($dateRange + 1);
        }
    }
}