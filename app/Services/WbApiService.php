<?php

namespace App\Services;

use App\Models\Income;
use App\Models\Order;
use App\Models\Sale;
use App\Models\Stock;
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

    protected function makeApiRequest( 
        string $dateFrom, 
        string $dateTo, 
        int $page,
        int $limit = 100
    ): Response
    {
        $response = $this->apiRequest->get('', [
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'page' => $page,
            'limit' => $limit,
        ]);

        if ($response->successful()) {
            return $response;
        } else {
            throw new RequestException($response);
        }
    }

    protected function store(string $resource, ?Carbon $dateFrom = null, ?Carbon $dateTo = null, bool $processSingleDateRange = false): void
    {
        $this->apiRequest->withUrlParameters(['resource' => $resource]);

        if ($dateFrom === null) {
            $dateFrom = now()->subYear()->addDay();
        }

        if ($dateTo === null) {
            $dateTo = now();
        }

        $dateFrom->startOfDay();
        $dateTo->startOfDay();
        $dateRange = (int) $dateFrom->diffInDays($dateTo);
        $page = 1;

        $modelClass = match ($resource) {
            'incomes' => Income::class,
            'sales' => Sale::class,
            'orders' => Order::class,
            'stocks' => Stock::class
        };
        
        while (true) {
            while (true) {
                $response = $this->makeApiRequest(
                    $dateFrom->toDateString(), 
                    $dateTo->toDateString(), 
                    $page, 
                    $this->limit
                );

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
            $dateTo = $dateTo->subDays($dateRange + 1);
            $dateFrom = $dateFrom->subDays($dateRange + 1);
        }
    }

    public function storeIncomes()
    {
        $this->store('incomes');
    }

    public function storeSales()
    {
        $this->store('sales');
    }

    public function storeOrders()
    {
        $this->store('orders');
    }

    public function storeStocks()
    {
        $this->store('stocks', now(), null, true);
    }
}