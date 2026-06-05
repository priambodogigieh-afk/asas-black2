# Asas Black IoT Dashboard

Dashboard Laravel untuk monitoring alat peraga Hukum Asas Black menggunakan 3 sensor DS18B20 berbasis NodeMCU ESP8266.

## Fitur

- Login guru dan siswa berbasis database.
- Dashboard guru untuk monitoring sensor dan penilaian praktikum.
- Praktikum siswa dengan kalkulasi Asas Black.
- MQTT subscriber IoTKita untuk topic:
  - `asasblack/suhu/panas`
  - `asasblack/suhu/dingin`
  - `asasblack/suhu/campuran`
- API realtime `GET /api/sensor/latest`.
- Card suhu realtime, LCD virtual 16x2, dan Chart.js realtime.
- Penilaian guru: nilai, komentar, status `Lulus` atau `Revisi`.

## Setup

```bash
composer install
npm install
php artisan migrate
npm run build
php artisan serve
```

Jalankan subscriber MQTT pada terminal terpisah:

```bash
php artisan mqtt:subscribe
```

## Environment MQTT

Isi nilai berikut di `.env` lokal. Jangan commit file `.env`.

```env
MQTT_HOST=mqtt.iotkita.com
MQTT_PORT=1883
MQTT_USERNAME=...
MQTT_PASSWORD=...
MQTT_CLIENT_ID=laravel_asas_black_dashboard
IOTKITA_API_KEY=...
```

## Struktur Utama

- `config/mqtt-client.php` konfigurasi MQTT Laravel.
- `app/Console/Commands/MqttSubscribeCommand.php` subscriber MQTT.
- `app/Models/SensorReading.php` model pembacaan sensor.
- `app/Http/Controllers/SensorReadingController.php` endpoint data realtime.
- `database/migrations/*sensor_readings*` tabel data sensor.
- `resources/js/app.js` fetch realtime, LCD virtual, Chart.js, kalkulasi Asas Black.
- `resources/views/pages/shared/praktikum.blade.php` dashboard praktikum siswa.
- `resources/views/pages/shared/monitoring.blade.php` monitoring sensor.
- `resources/views/pages/teacher/dashboard.blade.php` dashboard monitoring guru.
