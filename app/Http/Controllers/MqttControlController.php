<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MqttControlController extends Controller
{
    public function connect(Request $request): JsonResponse
    {
        abort_unless($request->user(), 403);

        $logPath = storage_path('logs/mqtt-subscriber.log');

        if (! is_dir(dirname($logPath))) {
            mkdir(dirname($logPath), 0775, true);
        }

        $this->startSubscriber($logPath);

        return response()->json([
            'message' => 'Perintah php artisan mqtt:subscribe sudah dijalankan di background.',
            'log' => $logPath,
        ]);
    }

    private function startSubscriber(string $logPath): void
    {
        $php = PHP_BINARY;
        $artisan = base_path('artisan');

        if (PHP_OS_FAMILY === 'Windows') {
            $command = sprintf(
                'cmd /C start /B "" %s %s mqtt:subscribe >> %s 2>&1',
                escapeshellarg($php),
                escapeshellarg($artisan),
                escapeshellarg($logPath),
            );

            pclose(popen($command, 'r'));

            return;
        }

        $command = sprintf(
            '%s %s mqtt:subscribe >> %s 2>&1 &',
            escapeshellcmd($php),
            escapeshellarg($artisan),
            escapeshellarg($logPath),
        );

        exec($command);
    }
}
