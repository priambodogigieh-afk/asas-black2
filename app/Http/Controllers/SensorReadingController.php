<?php

namespace App\Http\Controllers;

use App\Models\SensorReading;
use Illuminate\Http\JsonResponse;

class SensorReadingController extends Controller
{
    public function latest(): JsonResponse
    {
        $reading = SensorReading::query()->latest('id')->first();

        return response()->json([
            'suhu_panas' => $reading?->suhu_panas !== null ? (float) $reading->suhu_panas : 70.0,
            'suhu_dingin' => $reading?->suhu_dingin !== null ? (float) $reading->suhu_dingin : 28.0,
            'suhu_campuran' => $reading?->suhu_campuran !== null ? (float) $reading->suhu_campuran : 45.0,
            'updated_at' => $reading?->updated_at?->format('Y-m-d H:i:s'),
        ]);
    }
}
