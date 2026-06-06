<?php

namespace App\Console\Commands;

use App\Models\SensorReading;
use Illuminate\Console\Command;
use PhpMqtt\Client\Facades\MQTT;

class MqttSubscribeCommand extends Command
{
    protected $signature = 'mqtt:subscribe';

    protected $description = 'Subscribe ke topic suhu IoTKita dan simpan data sensor DS18B20 ke database.';

    private const TOPICS = [
        'asasblack/suhu/panas' => 'suhu_panas',
        'asasblack/suhu/dingin' => 'suhu_dingin',
        'asasblack/suhu/campuran' => 'suhu_campuran',
    ];

    public function handle(): int
    {
        $this->info(sprintf(
            '[MQTT] Connecting to %s:%s',
            config('mqtt-client.connections.default.host'),
            config('mqtt-client.connections.default.port'),
        ));

        $mqtt = MQTT::connection();

        foreach (self::TOPICS as $topic => $column) {
            $mqtt->subscribe($topic, function (string $topic, string $message) use ($column): void {
                $temperature = $this->normalizeTemperature($message);

                if ($temperature === null) {
                    $this->warn("[MQTT] Payload tidak valid pada {$topic}: {$message}");

                    return;
                }

                $latest = SensorReading::query()->latest('id')->first();

                SensorReading::create([
                    'suhu_panas' => $column === 'suhu_panas' ? $temperature : $latest?->suhu_panas,
                    'suhu_dingin' => $column === 'suhu_dingin' ? $temperature : $latest?->suhu_dingin,
                    'suhu_campuran' => $column === 'suhu_campuran' ? $temperature : $latest?->suhu_campuran,
                ]);

                $this->line(sprintf('[MQTT] %s : %.2f', $column, $temperature));
            });

            $this->info("[MQTT] Subscribed: {$topic}");
        }

        $mqtt->loop(true);

        return self::SUCCESS;
    }

    private function normalizeTemperature(string $payload): ?float
    {
        $payload = trim($payload);

        if (! is_numeric($payload)) {
            return null;
        }

        return round((float) $payload, 2);
    }
}
