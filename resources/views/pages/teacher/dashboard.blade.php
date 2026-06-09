<x-layouts.dashboard
    title="Thermodynamics Monitoring"
    subtitle="Portal guru untuk memantau akun siswa dan riwayat praktikum yang tersimpan di MySQL."
    role="Guru"
    :items="$items"
>
    <div class="space-y-6" data-page="teacher-dashboard" data-realtime-sensor-dashboard>
        <div class="flex flex-col justify-between gap-4 md:flex-row md:items-end">
            <div>
                <span class="font-mono text-xs font-bold uppercase tracking-[0.22em] text-[#006c4e] dark:text-[#cdfef1]">Physics Faculty Portal</span>
                <h2 class="mt-1 font-sans text-3xl font-black text-[#013225] dark:text-[#ffffff]">Monitoring Praktikum Guru</h2>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('teacher.history') }}" class="flex items-center gap-2 rounded-lg bg-[#006c4e] px-5 py-2 font-mono text-xs font-bold uppercase tracking-[0.08em] text-white shadow-md transition hover:opacity-90">
                    <span class="material-symbols-outlined text-[18px]">rate_review</span>
                    Kelola Nilai
                </a>
            </div>
        </div>

        @php
            $stats = [
                ['icon' => 'group', 'label' => 'Total Siswa', 'value' => $students->count(), 'suffix' => '', 'badge' => 'MySQL Users', 'tone' => 'blue'],
                ['icon' => 'science', 'label' => 'Riwayat Praktikum', 'value' => $histories->count(), 'suffix' => '', 'badge' => 'Database', 'tone' => 'red'],
                ['icon' => 'rate_review', 'label' => 'Sudah Dinilai', 'value' => $gradedCount, 'suffix' => '', 'badge' => $histories->count() - $gradedCount . ' Pending', 'tone' => 'blue'],
                ['icon' => 'error', 'label' => 'Avg. Error Rate', 'value' => number_format($averageError, 2), 'suffix' => '%', 'badge' => $successCount . ' Sesuai', 'tone' => 'orange'],
            ];
        @endphp

        <section class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">
            @foreach ($stats as $stat)
                <article class="metric-card flex min-h-44 flex-col justify-between rounded-2xl p-6 transition hover:shadow-md">
                    <div class="flex items-start justify-between">
                        <div class="grid h-11 w-11 place-items-center rounded-xl {{ $stat['tone'] === 'blue' ? 'bg-[#e6fef8] text-[#006c4e]' : ($stat['tone'] === 'red' ? 'bg-[#006c4e] text-white' : 'bg-[#fff0cc] text-[#7e5700]') }}">
                            <span class="material-symbols-outlined">{{ $stat['icon'] }}</span>
                        </div>
                    <span class="rounded-full {{ $stat['tone'] === 'red' ? 'bg-[#e6fef8] text-[#006c4e]' : ($stat['tone'] === 'orange' ? 'bg-[#fff0cc] text-[#7e5700]' : 'bg-[#e6fef8] text-[#004d36]') }} px-2 py-1 text-xs font-black">{{ $stat['badge'] }}</span>
                    </div>
                    <div class="mt-6">
                        <p class="font-mono text-xs font-bold uppercase tracking-[0.12em] text-[#191c1e] dark:text-[#e6fef8]">{{ $stat['label'] }}</p>
                        <p class="mt-1 font-mono text-4xl font-bold text-[#013225] dark:text-[#ffffff]">{{ $stat['value'] }}<span class="text-2xl font-normal text-[#191c1e] dark:text-[#e6fef8]">{{ $stat['suffix'] }}</span></p>
                    </div>
                </article>
            @endforeach
        </section>

        <section class="grid grid-cols-1 gap-6 md:grid-cols-3">
            <x-temperature-card label="Suhu Air Panas" value="70" tone="red" sensor="DS18B20 A" sensor-key="suhu_panas" />
            <x-temperature-card label="Suhu Air Dingin" value="28" tone="blue" sensor="DS18B20 B" sensor-key="suhu_dingin" />
            <x-temperature-card label="Suhu Campuran" value="45" tone="orange" sensor="DS18B20 C" sensor-key="suhu_campuran" />
        </section>

        <section class="grid gap-6">
            <article class="metric-card rounded-2xl p-5">
                <p class="font-mono text-xs font-black uppercase tracking-[0.12em] text-[#006c4e] dark:text-[#cdfef1]">Koneksi MQTT</p>
                <button type="button" data-mqtt-connect-button class="mt-3 inline-flex items-center gap-2 rounded-xl bg-[#006c4e] px-5 py-3 font-mono text-sm font-black uppercase tracking-[0.08em] text-white shadow-lg shadow-[#006c4e]/30 transition hover:bg-[#006c4e] active:scale-[0.98]">
                    <span class="material-symbols-outlined text-[20px]">sensors</span>
                    Konek MQTT
                </button>
                <p class="mt-3 text-sm font-bold text-[#191c1e] dark:text-[#e6fef8]" data-mqtt-connect-message data-sensor-status>Menunggu koneksi MQTT</p>
                <p class="mt-1 text-xs font-bold text-[#191c1e] dark:text-[#e6fef8]" data-sensor-updated>Updated: -</p>
            </article>
        </section>

        <section class="metric-card rounded-2xl p-6">
            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="font-mono text-xs font-black uppercase tracking-[0.12em] text-[#006c4e] dark:text-[#cdfef1]">Realtime Chart</p>
                    <h3 class="font-sans text-2xl font-black text-[#013225] dark:text-[#ffffff]">Grafik Suhu Sensor</h3>
                </div>
            </div>
            <div class="chart-shell mt-5 h-[340px] rounded-xl border border-[#cdfef1]/60 bg-[#e6fef8]/80 p-4 dark:border-[#03634a]/30 dark:bg-[#013225]/45">
                <canvas id="teacherRealtimeChart"></canvas>
            </div>
        </section>

        <section class="space-y-4">
            <div class="flex items-center justify-between gap-4">
                <h3 class="font-sans text-2xl font-black text-[#013225] dark:text-[#ffffff]">Akun Siswa Terdaftar</h3>
            </div>
            <div class="grid grid-cols-2 gap-4 md:grid-cols-4 xl:grid-cols-6">
                @forelse ($students->take(6) as $student)
                    @php $latest = $histories->firstWhere('user_id', $student->id); @endphp
                    <article class="glass-panel cursor-pointer rounded-xl p-4 transition hover:border-[#006c4e]/50">
                        <div class="flex items-center justify-between gap-3">
                            <span class="truncate text-xs font-black text-[#191c1e] dark:text-[#e6fef8]">{{ $student->name }}</span>
                            <span class="material-symbols-outlined text-[18px] text-[#006c4e]">person</span>
                        </div>
                        <p class="mt-1 truncate text-[10px] font-bold text-[#191c1e] dark:text-[#e6fef8]">{{ $student->kelas ?? '-' }} / {{ $student->nis ?? '-' }}</p>
                        <div class="mt-3 grid grid-cols-3 gap-1">
                            <div class="rounded bg-[#e6fef8] p-1.5 text-center dark:bg-[#013225]">
                                <p class="text-[10px] font-black text-[#191c1e] dark:text-[#e6fef8]">T1</p>
                                <p class="text-xs font-black text-[#006c4e]">{{ $latest?->suhu_panas ? number_format($latest->suhu_panas, 0) : '-' }}&deg;</p>
                            </div>
                            <div class="rounded bg-[#e6fef8] p-1.5 text-center dark:bg-[#013225]">
                                <p class="text-[10px] font-black text-[#191c1e] dark:text-[#e6fef8]">T2</p>
                                <p class="text-xs font-black text-[#006c4e]">{{ $latest?->suhu_dingin ? number_format($latest->suhu_dingin, 0) : '-' }}&deg;</p>
                            </div>
                            <div class="rounded bg-[#e6fef8] p-1.5 text-center dark:bg-[#013225]">
                                <p class="text-[10px] font-black text-[#191c1e] dark:text-[#e6fef8]">Tc</p>
                                <p class="text-xs font-black text-[#006c4e]">{{ $latest?->suhu_campuran ? number_format($latest->suhu_campuran, 0) : '-' }}&deg;</p>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full rounded-xl border border-[#cdfef1] bg-[#e6fef8]/80 p-6 text-center font-bold text-[#191c1e] dark:border-[#03634a]/30 dark:bg-[#013225]/45 dark:text-[#e6fef8]">
                        Belum ada akun siswa di database.
                    </div>
                @endforelse
            </div>
        </section>

        <section class="metric-card overflow-hidden rounded-2xl">
            <div class="border-b border-[#cdfef1]/70 p-6 dark:border-[#03634a]/30">
                <h3 class="font-sans text-2xl font-black text-[#013225] dark:text-[#ffffff]">Data Praktikum Terbaru</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[1180px] border-collapse text-left text-sm">
                    <thead class="bg-[#ffffff] dark:bg-[#013225]/70">
                        <tr>
                            @foreach (['Nama Siswa','m1 (g)','m2 (g)','T1 (C)','T2 (C)','Tc (C)','Qlepas (J)','Qterima (J)','Error %','Status','Nilai','Aksi'] as $header)
                                <th class="px-5 py-4 text-center font-mono text-xs font-black uppercase tracking-[0.08em] text-[#191c1e] first:text-left last:text-right dark:text-[#e6fef8]">{{ $header }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#cdfef1]/50 dark:divide-[#03634a]/20">
                        @forelse ($histories->take(10) as $history)
                            <tr class="group transition hover:bg-[#ffffff]/60 dark:hover:bg-[#013225]/60">
                                <td class="px-5 py-4 font-black text-[#013225] dark:text-[#ffffff]">{{ $history->user->name }}</td>
                                <td class="px-5 py-4 text-center font-mono font-semibold">{{ $history->massa_panas * 1000 }}</td>
                                <td class="px-5 py-4 text-center font-mono font-semibold">{{ $history->massa_dingin * 1000 }}</td>
                                <td class="px-5 py-4 text-center font-mono font-semibold text-[#006c4e]">{{ number_format($history->suhu_panas, 1) }}</td>
                                <td class="px-5 py-4 text-center font-mono font-semibold text-[#006c4e]">{{ number_format($history->suhu_dingin, 1) }}</td>
                                <td class="px-5 py-4 text-center font-mono font-semibold text-[#006c4e]">{{ number_format($history->suhu_campuran, 1) }}</td>
                                <td class="px-5 py-4 text-center font-mono font-semibold">{{ number_format($history->q_lepas, 0, ',', '.') }}</td>
                                <td class="px-5 py-4 text-center font-mono font-semibold">{{ number_format($history->q_terima, 0, ',', '.') }}</td>
                                <td class="px-5 py-4 text-center font-mono font-semibold">{{ number_format($history->error_persen, 2) }}%</td>
                                <td class="px-5 py-4 text-center">
                                    <span class="rounded-full px-2 py-1 text-[10px] font-black uppercase {{ in_array($history->status, ['SESUAI HUKUM ASAS BLACK', 'Sesuai Asas Black'], true) ? 'bg-[#e6fef8] text-[#004d36]' : 'bg-[#e6fef8] text-[#006c4e]' }}">{{ $history->status }}</span>
                                </td>
                                <td class="px-5 py-4 text-center">
                                    @if ($history->nilai !== null)
                                        <span class="font-mono text-lg font-black text-[#006c4e]">{{ $history->nilai }}</span>
                                    @else
                                        <span class="rounded-full bg-[#ffffff] px-2 py-1 text-[10px] font-black text-[#191c1e] dark:bg-[#013225] dark:text-[#e6fef8]">Pending</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-right">
                                    <div class="flex justify-end gap-2 opacity-100 transition md:opacity-0 md:group-hover:opacity-100">
                                        <a href="{{ route('teacher.history') }}" class="rounded p-1.5 hover:bg-[#e6fef8] dark:hover:bg-[#013225]" title="Kelola Nilai"><span class="material-symbols-outlined text-[18px]">rate_review</span></a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="px-5 py-10 text-center font-bold text-[#191c1e] dark:text-[#e6fef8]">Belum ada riwayat praktikum di database.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="border-t border-[#cdfef1]/70 bg-[#ffffff] p-4 text-center dark:border-[#03634a]/30 dark:bg-[#013225]/70">
                <a href="{{ route('teacher.history') }}" class="font-mono text-xs font-black uppercase tracking-[0.12em] text-[#006c4e] hover:underline dark:text-[#05c793]">Kelola semua data</a>
            </div>
        </section>

    </div>
</x-layouts.dashboard>
