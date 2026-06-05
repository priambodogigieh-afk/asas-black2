<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'suhu_panas',
    'suhu_dingin',
    'suhu_campuran',
])]
class SensorReading extends Model
{
    protected function casts(): array
    {
        return [
            'suhu_panas' => 'decimal:2',
            'suhu_dingin' => 'decimal:2',
            'suhu_campuran' => 'decimal:2',
        ];
    }
}
