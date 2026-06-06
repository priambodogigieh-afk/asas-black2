<?php

namespace App\Http\Controllers;

use App\Models\PraktikumHistory;
use App\Models\User;
use App\Support\Navigation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeacherDashboardController extends Controller
{
    public function dashboard(Request $request): View|RedirectResponse
    {
        if ($request->user()?->role !== 'guru') {
            return redirect()->route('student.praktikum');
        }

        $students = User::query()
            ->where('role', 'siswa')
            ->latest()
            ->get();

        $histories = PraktikumHistory::query()
            ->with('user')
            ->latest()
            ->get();

        return view('pages.teacher.dashboard', [
            'items' => Navigation::teacherItems(),
            'students' => $students,
            'histories' => $histories,
            'averageError' => $histories->avg('error_persen') ?? 0,
            'successCount' => $histories->filter(fn (PraktikumHistory $history): bool => in_array($history->status, ['SESUAI HUKUM ASAS BLACK', 'Sesuai Asas Black'], true))->count(),
            'gradedCount' => $histories->whereNotNull('nilai')->count(),
        ]);
    }

    public function students(Request $request): View|RedirectResponse
    {
        if ($request->user()?->role !== 'guru') {
            return redirect()->route('student.praktikum');
        }

        $students = User::query()
            ->where('role', 'siswa')
            ->latest()
            ->get();

        return view('pages.teacher.students', [
            'items' => Navigation::teacherItems(),
            'students' => $students,
        ]);
    }
}
