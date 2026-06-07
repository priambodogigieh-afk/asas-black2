<?php

namespace App\Support;

class Navigation
{
    public static function teacherItems(): array
    {
        return [
            ['label' => 'Dashboard', 'route' => 'teacher.dashboard', 'icon' => 'dashboard'],
            ['label' => 'Monitoring Sensor', 'route' => 'teacher.monitoring', 'icon' => 'sensors'],
            ['label' => 'Data Siswa', 'route' => 'teacher.students', 'icon' => 'group'],
            ['label' => 'Penilaian', 'route' => 'teacher.history', 'icon' => 'rate_review'],
            ['label' => 'Logout', 'route' => 'login', 'icon' => 'logout'],
        ];
    }

    public static function studentItems(): array
    {
        return [
            ['label' => 'Praktikum', 'route' => 'student.praktikum', 'icon' => 'calculate'],
            ['label' => 'Materi', 'route' => 'student.materi', 'icon' => 'menu_book'],
            ['label' => 'Riwayat', 'route' => 'student.history', 'icon' => 'history'],
            ['label' => 'Logout', 'route' => 'login', 'icon' => 'logout'],
        ];
    }
}
