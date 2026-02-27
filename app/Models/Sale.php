<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $guarded = [];
    protected $casts = [
        'is_supply' => 'boolean',
        'is_realization' => 'boolean',
        'is_storno' => 'boolean'
    ];

    protected function supplierArticle(): Attribute
    {
        return Attribute::make(
            get: fn(?string $value) => isset($value) ? bin2hex($value) : null,
            set: fn(?string $value) => isset($value) ? hex2bin($value) : null
        );
    }

    protected function techSize(): Attribute
    {
        return Attribute::make(
            get: fn(?string $value) => isset($value) ? bin2hex($value) : null,
            set: fn(?string $value) => isset($value) ? hex2bin($value) : null
        );
    }

    protected function subject(): Attribute
    {
        return Attribute::make(
            get: fn(?string $value) => isset($value) ? bin2hex($value) : null,
            set: fn(?string $value) => isset($value) ? hex2bin($value) : null
        );
    }

    protected function category(): Attribute
    {
        return Attribute::make(
            get: fn(?string $value) => isset($value) ? bin2hex($value) : null,
            set: fn(?string $value) => isset($value) ? hex2bin($value) : null
        );
    }

    protected function brand(): Attribute
    {
        return Attribute::make(
            get: fn(?string $value) => isset($value) ? bin2hex($value) : null,
            set: fn(?string $value) => isset($value) ? hex2bin($value) : null
        );
    }

    protected static function booted(): void
    {
        static::creating(function (Sale $model) {
            $numericFields = [
                'barcode',
                'discount_percent',
                'promo_code_discount',
                'income_id',
                'odid',
                'spp',
                'nm_id'
            ];

            foreach ($numericFields as $field) {
                $attribute = $model->attributes[$field];
                
                if (isset($attribute) && $attribute !== '') {
                    $model->attributes[$field] = abs((int) $attribute);
                } elseif ($attribute === '') {
                    $model->attributes[$field] = null;
                }
            }

            $decimalStrings = [
                'g_number',
                'total_price',
                'for_pay',
                'finished_price',
                'price_with_disc'
            ];

            foreach ($decimalStrings as $field) {
                if (isset($model->attributes[$field])) {
                    $model->attributes[$field] = ltrim($model->attributes[$field], '-');
                }
            }
        });
    }
}
