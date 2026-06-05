# Pembagian Tugas: Asas Black IoT Dashboard

Dokumen ini berisi pembagian tugas proyek untuk pengembangan **Asas Black IoT Dashboard** yang dibagi kepada tiga anggota tim: **Gigieh**, **Adit**, dan **Maheswara**.

---

## 📋 Gigieh (Backend & IoT Integration)
Fokus pada setup database, integrasi protokol MQTT untuk IoT, dan penyediaan API endpoint realtime.

- [ ] **Setup Database & Migrations**
  - [ ] Membuat migrasi tabel `users` (dengan pembedaan role Guru/Siswa).
  - [ ] Membuat tabel `sensor_readings` untuk menyimpan data suhu dari 3 sensor (panas, dingin, campuran).
  - [ ] Membuat tabel `praktikum_submissions` untuk menyimpan hasil praktikum dan nilai siswa.
- [ ] **MQTT Integration**
  - [ ] Konfigurasi client MQTT pada [config/mqtt-client.php](file:///c:/laragon/www/asas-black/config/mqtt-client.php).
  - [ ] Implementasi daemon subscriber MQTT pada [MqttSubscribeCommand.php](file:///c:/laragon/www/asas-black/app/Console/Commands/MqttSubscribeCommand.php) untuk subscribe ke topic `asasblack/suhu/#`.
- [ ] **API Development**
  - [ ] Membuat API endpoint realtime `GET /api/sensor/latest` di [SensorReadingController.php](file:///c:/laragon/www/asas-black/app/Http/Controllers/SensorReadingController.php).
- [ ] **Environment & Server Setup**
  - [ ] Mengatur konfigurasi lokal pada `.env` dan memastikan konektivitas ke broker MQTT (mqtt.iotkita.com).

---

## 🎨 Adit (Frontend & Realtime Visualization)
Fokus pada tampilan antarmuka (UI/UX), visualisasi data sensor secara realtime, dan implementasi komponen interaktif.

- [ ] **Desain Dashboard Monitoring**
  - [ ] Menyusun layout dashboard guru di [dashboard.blade.php](file:///c:/laragon/www/asas-black/resources/views/pages/teacher/dashboard.blade.php).
  - [ ] Menyusun layout halaman monitoring umum di [monitoring.blade.php](file:///c:/laragon/www/asas-black/resources/views/pages/shared/monitoring.blade.php).
- [ ] **Realtime Frontend Integration**
  - [ ] Integrasi Chart.js untuk menampilkan grafik perkembangan suhu realtime pada [app.js](file:///c:/laragon/www/asas-black/resources/js/app.js).
  - [ ] Membuat tampilan Card Suhu Dinamis yang terupdate secara realtime.
- [ ] **Virtual LCD Component**
  - [ ] Membuat tiruan (simulasi) LCD 16x2 virtual pada halaman web untuk menampilkan status sensor terkini.
- [ ] **Premium Styling**
  - [ ] Menulis CSS vanilla untuk memastikan tampilan web modern (glassmorphism/dark mode, responsive, micro-animations).

---

## 🧠 Maheswara (Auth, Business Logic & Grading System)
Fokus pada autentikasi pengguna, logika fisika perhitungan Asas Black, serta alur penilaian guru.

- [ ] **Sistem Autentikasi & Multi-role**
  - [ ] Membuat sistem login untuk Guru dan Siswa.
  - [ ] Membatasi hak akses halaman (Teacher Dashboard hanya untuk Guru, Praktikum untuk Siswa).
- [ ] **Logika Perhitungan Asas Black**
  - [ ] Menyusun form praktikum siswa di [praktikum.blade.php](file:///c:/laragon/www/asas-black/resources/views/pages/shared/praktikum.blade.php).
  - [ ] Mengimplementasikan formula Asas Black ($Q_{lepas} = Q_{terima}$) pada frontend/backend untuk memvalidasi input praktikum siswa terhadap data sensor.
- [ ] **Sistem Penilaian Guru (Grading System)**
  - [ ] Membuat form penilaian di dashboard guru (input nilai, kolom komentar, dan dropdown status `Lulus` / `Revisi`).
  - [ ] Mengintegrasikan penyimpanan nilai tersebut kembali ke database.
- [ ] **Testing & Quality Assurance**
  - [ ] Melakukan testing fungsionalitas keseluruhan alur (dari sensor masuk -> kalkulasi siswa -> penilaian guru).
