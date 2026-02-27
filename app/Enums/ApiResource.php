<?php

namespace App\Enums;

use Carbon\Carbon;

enum ApiResource: string
{
    case Income = 'incomes';
    case Sale = 'sales';
    case Order = 'orders';
    case Stock = 'stocks';

    public function formatDateFrom(Carbon $date): string
    {
        return match($this) {
            default => $date->toDateString()
        };
    }

    public function formatDateTo(Carbon $date): string
    {
        return match($this) {
            ApiResource::Order => $date->toDateTimeString(),
            default => $date->toDateString()
        };
    }

    public function getModelClass(): string
    {
        return "\App\Models\\$this->name";
    }
}