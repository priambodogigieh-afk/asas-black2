<?php

namespace Tests\Feature;

use App\Models\PraktikumHistory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PraktikumGradingTest extends TestCase
{
    use RefreshDatabase;

    public function test_teacher_can_grade_and_student_can_see_the_grade(): void
    {
        $teacher = User::factory()->create([
            'role' => 'guru',
        ]);

        $student = User::factory()->create([
            'role' => 'siswa',
            'kelas' => 'XI IPA 1',
            'nis' => 'NIS-001',
            'jurusan' => 'IPA',
        ]);

        $history = PraktikumHistory::create([
            'user_id' => $student->id,
            'massa_panas' => 0.2,
            'massa_dingin' => 0.2,
            'kalor_jenis' => 4200,
            'suhu_panas' => 70,
            'suhu_dingin' => 28,
            'suhu_campuran' => 45,
            'q_lepas' => 21000,
            'q_terima' => 14280,
            'delta_q' => 6720,
            'error_persen' => 32,
            'status' => 'Belum Sesuai',
        ]);

        $this->actingAs($teacher)
            ->get(route('teacher.history', ['kelas' => 'XI IPA 1']))
            ->assertOk()
            ->assertSee('Penilaian Kelas XI IPA 1');

        $this->actingAs($teacher)
            ->patch(route('teacher.history.grade', ['history' => $history, 'kelas' => 'XI IPA 1']), [
                'nilai' => 88,
                'catatan_nilai' => 'Perhitungan sudah rapi.',
                'status_penilaian' => 'Lulus',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('praktikum_histories', [
            'id' => $history->id,
            'nilai' => 88,
            'catatan_nilai' => 'Perhitungan sudah rapi.',
            'status_penilaian' => 'Lulus',
            'dinilai_oleh' => $teacher->id,
        ]);

        $this->actingAs($student)
            ->get(route('student.history'))
            ->assertOk()
            ->assertSee('88')
            ->assertSee('Perhitungan sudah rapi.');
    }

    public function test_teacher_can_delete_a_grade(): void
    {
        $teacher = User::factory()->create([
            'role' => 'guru',
        ]);

        $student = User::factory()->create([
            'role' => 'siswa',
            'kelas' => 'XI IPA 2',
            'nis' => 'NIS-002',
        ]);

        $history = PraktikumHistory::create([
            'user_id' => $student->id,
            'massa_panas' => 0.2,
            'massa_dingin' => 0.2,
            'kalor_jenis' => 4200,
            'suhu_panas' => 70,
            'suhu_dingin' => 28,
            'suhu_campuran' => 45,
            'q_lepas' => 21000,
            'q_terima' => 14280,
            'delta_q' => 6720,
            'error_persen' => 32,
            'status' => 'Belum Sesuai',
            'nilai' => 76,
            'catatan_nilai' => 'Perlu perbaikan.',
            'status_penilaian' => 'Revisi',
            'dinilai_oleh' => $teacher->id,
            'dinilai_pada' => now(),
        ]);

        $this->actingAs($teacher)
            ->delete(route('teacher.history.grade.destroy', ['history' => $history, 'kelas' => 'XI IPA 2']))
            ->assertRedirect();

        $this->assertDatabaseHas('praktikum_histories', [
            'id' => $history->id,
            'nilai' => null,
            'catatan_nilai' => null,
            'status_penilaian' => null,
            'dinilai_oleh' => null,
            'dinilai_pada' => null,
        ]);
    }
}
