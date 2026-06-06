<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id',
    'massa_panas',
    'massa_dingin',
    'kalor_jenis',
    'suhu_panas',
    'suhu_dingin',
    'suhu_campuran',
    'q_lepas',
    'q_terima',
    'delta_q',
    'error_persen',
    'status',
    'nilai',
    'catatan_nilai',
    'status_penilaian',
    'dinilai_oleh',
    'dinilai_pada',
])]
class PraktikumHistory extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function grader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dinilai_oleh');
    }

    protected function casts(): array
    {
        return [
            'dinilai_pada' => 'datetime',
        ];
    }
}
