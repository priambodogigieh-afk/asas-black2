<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MqttControlController;
use App\Http\Controllers\PraktikumHistoryController;
use App\Http\Controllers\TeacherDashboardController;
use App\Support\Navigation;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

Route::get('/login', fn () => view('pages.auth.login'))->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register-siswa', fn () => view('pages.auth.register-student'))->name('student.register');
Route::post('/register-siswa', [AuthController::class, 'registerStudent'])->name('student.register.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/mqtt/connect', [MqttControlController::class, 'connect'])
    ->middleware('auth')
    ->name('mqtt.connect');

Route::prefix('guru')->name('teacher.')->middleware('auth')->group(function () {
    Route::get('/dashboard', [TeacherDashboardController::class, 'dashboard'])
        ->name('dashboard');

    Route::get('/monitoring-sensor', function () {
        if (auth()->user()?->role !== 'guru') {
            return redirect()->route('student.praktikum');
        }

        return view('pages.shared.monitoring', [
            'items' => Navigation::teacherItems(),
            'role' => 'Guru',
            'title' => 'Monitoring Sensor',
        ]);
    })->name('monitoring');

    Route::get('/data-siswa', [TeacherDashboardController::class, 'students'])->name('students');

    Route::get('/riwayat', [PraktikumHistoryController::class, 'teacherHistory'])->name('history');

    Route::patch('/riwayat/{history}/nilai', [PraktikumHistoryController::class, 'grade'])->name('history.grade');

    Route::delete('/riwayat/{history}/nilai', [PraktikumHistoryController::class, 'destroyGrade'])->name('history.grade.destroy');
});

Route::prefix('siswa')->name('student.')->middleware('auth')->group(function () {
    Route::get('/praktikum', function () {
        if (auth()->user()?->role !== 'siswa') {
            return redirect()->route('teacher.dashboard');
        }

        return view('pages.shared.praktikum', [
            'items' => Navigation::studentItems(),
            'role' => 'Siswa',
        ]);
    })->name('praktikum');

    Route::post('/praktikum/riwayat', [PraktikumHistoryController::class, 'store'])
        ->name('praktikum.history.store');

    Route::get('/materi', function () {
        if (auth()->user()?->role !== 'siswa') {
            return redirect()->route('teacher.dashboard');
        }

        return view('pages.shared.materi', [
            'items' => Navigation::studentItems(),
            'role' => 'Siswa',
        ]);
    })->name('materi');

    Route::get('/riwayat', [PraktikumHistoryController::class, 'studentHistory'])
        ->name('history');
});
