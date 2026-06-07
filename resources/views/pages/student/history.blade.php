<x-layouts.dashboard
    title="Riwayat Praktikum"
    subtitle="Catatan hasil praktikum yang tersimpan di database untuk akun mahasiswa/siswa yang sedang login."
    role="Siswa"
    :items="$items"
>
    <div class="space-y-6">
        <section class="grid gap-4 md:grid-cols-3">
            <article class="metric-card rounded-2xl p-5">
                <p class="font-mono text-xs font-black uppercase tracking-[0.12em] text-[#191c1e] dark:text-[#e6fef8]">Total Riwayat</p>
                <p class="mt-3 font-mono text-4xl font-bold text-[#013225] dark:text-[#ffffff]">{{ $histories->count() }}</p>
                <p class="mt-2 text-xs font-bold text-[#006c4e] dark:text-[#cdfef1]">Data dari MySQL</p>
            </article>
            <article class="metric-card rounded-2xl p-5">
                <p class="font-mono text-xs font-black uppercase tracking-[0.12em] text-[#191c1e] dark:text-[#e6fef8]">Rata-rata Error</p>
                <p class="mt-3 font-mono text-4xl font-bold text-[#013225] dark:text-[#ffffff]">{{ $histories->count() ? number_format($histories->avg('error_persen'), 2) : '0.00' }}%</p>
                <p class="mt-2 text-xs font-bold text-[#006c4e] dark:text-[#05c793]">Semua percobaan</p>
            </article>
            <article class="metric-card rounded-2xl p-5">
                <p class="font-mono text-xs font-black uppercase tracking-[0.12em] text-[#191c1e] dark:text-[#e6fef8]">Sesuai Asas Black</p>
                <p class="mt-3 font-mono text-4xl font-bold text-[#006c4e]">{{ $histories->filter(fn ($history) => in_array($history->status, ['SESUAI HUKUM ASAS BLACK', 'Sesuai Asas Black'], true))->count() }}</p>
                <p class="mt-2 text-xs font-bold text-[#006c4e]">Status valid</p>
            </article>
        </section>

        <section class="metric-card overflow-hidden rounded-2xl">
            <div class="border-b border-[#cdfef1]/70 px-6 py-4 dark:border-[#03634a]/30">
                <h2 class="font-sans text-xl font-black text-[#013225] dark:text-[#ffffff]">Riwayat Saya</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[980px] text-left text-sm">
                    <thead class="bg-[#ffffff] font-mono text-xs uppercase tracking-[0.08em] text-[#191c1e] dark:bg-[#013225]/70 dark:text-[#e6fef8]">
                        <tr>
                            <th class="px-5 py-3">Waktu</th>
                            <th class="px-5 py-3">m panas</th>
                            <th class="px-5 py-3">m dingin</th>
                            <th class="px-5 py-3">Qlepas</th>
                            <th class="px-5 py-3">Qterima</th>
                            <th class="px-5 py-3">Delta Q</th>
                            <th class="px-5 py-3">Error</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3">Nilai Guru</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#cdfef1]/50 dark:divide-[#03634a]/20">
                        @forelse ($histories as $history)
                            <tr class="transition hover:bg-[#ffffff]/60 dark:hover:bg-[#013225]/60">
                                <td class="px-5 py-4 font-semibold">{{ $history->created_at->format('d M Y H:i') }}</td>
                                <td class="px-5 py-4 font-mono font-semibold">{{ $history->massa_panas }} kg</td>
                                <td class="px-5 py-4 font-mono font-semibold">{{ $history->massa_dingin }} kg</td>
                                <td class="px-5 py-4 font-mono font-semibold text-[#006c4e]">{{ number_format($history->q_lepas, 0, ',', '.') }} J</td>
                                <td class="px-5 py-4 font-mono font-semibold text-[#006c4e]">{{ number_format($history->q_terima, 0, ',', '.') }} J</td>
                                <td class="px-5 py-4 font-mono font-semibold">{{ number_format($history->delta_q, 0, ',', '.') }} J</td>
                                <td class="px-5 py-4 font-mono font-semibold">{{ number_format($history->error_persen, 2) }}%</td>
                                <td class="px-5 py-4">
                                    <span class="rounded-full px-2.5 py-1 text-xs font-black {{ in_array($history->status, ['SESUAI HUKUM ASAS BLACK', 'Sesuai Asas Black'], true) ? 'bg-[#e6fef8] text-[#004d36]' : 'bg-[#e6fef8] text-[#006c4e]' }}">
                                        {{ $history->status }}
                                    </span>
                                </td>
                                <td class="px-5 py-4">
                                    @if ($history->nilai !== null)
                                        <div class="font-mono text-2xl font-bold text-[#006c4e]">{{ $history->nilai }}</div>
                                        <div class="mt-1 max-w-[220px] text-xs font-semibold text-[#191c1e] dark:text-[#e6fef8]">{{ $history->catatan_nilai ?: 'Tanpa catatan' }}</div>
                                        @if ($history->status_penilaian)
                                            <div class="mt-1 inline-flex rounded-full {{ $history->status_penilaian === 'Lulus' ? 'bg-[#e6fef8] text-[#004d36]' : 'bg-[#e6fef8] text-[#006c4e]' }} px-2 py-1 text-[10px] font-black uppercase">{{ $history->status_penilaian }}</div>
                                        @endif
                                    @else
                                        <span class="rounded-full bg-[#ffffff] px-2.5 py-1 text-xs font-black text-[#191c1e] dark:bg-[#013225] dark:text-[#e6fef8]">Belum dinilai</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-5 py-10 text-center font-bold text-[#191c1e] dark:text-[#e6fef8]">
                                    Belum ada riwayat. Buka Praktikum, isi massa air, lalu tekan Hitung Asas Black.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</x-layouts.dashboard>
