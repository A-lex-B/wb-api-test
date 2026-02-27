<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $guarded = [];

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

    protected static function booted(): void
    {
        static::creating(function (Income $model) {
            $numericFields = [
                'income_id',
                'number',
                'barcode',
                'quantity',
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
                'total_price'
            ];

            foreach ($decimalStrings as $field) {
                if (isset($model->attributes[$field])) {
                    $model->attributes[$field] = ltrim($model->attributes[$field], '-');
                }
            }
        });
    }
}
