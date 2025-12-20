<?php

namespace App\Console\Commands;

use App\Services\WbApiService;
use Illuminate\Console\Command;

class StoreSales extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'store:sales';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Получение всех продаж по wb-api и сохранение их в базе данных';

    /**
     * Execute the console command.
     */
    public function handle(WbApiService $service)
    {
        $this->line('Обработка данных...');
        $service->storeSales();
        $this->line('Данные успешно сохранены!');
    }
}
