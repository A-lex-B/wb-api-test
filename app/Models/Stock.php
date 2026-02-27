<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $guarded = [];
    protected $casts = [
        'is_supply' => 'boolean',
        'is_realization' => 'boolean'
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
        static::creating(function (Stock $model) {
            $numericFields = [
                'barcode',
                'quantity',
                'quantity_full',
                'in_way_to_client',
                'in_way_from_client',
                'nm_id',
                'sc_code',
                'discount'
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
                'price'
            ];

            foreach ($decimalStrings as $field) {
                if (isset($model->attributes[$field])) {
                    $model->attributes[$field] = ltrim($model->attributes[$field], '-');
                }
            }
        });
    }
}
