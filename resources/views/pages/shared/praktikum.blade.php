<x-layouts.dashboard
    title="Praktikum Asas Black"
    subtitle="Input massa air, hitung kalor, dan simpan riwayat praktikum."
    :role="$role"
    :items="$items"
>
    <div class="space-y-6" data-page="student-dashboard" data-realtime-sensor-dashboard>
        @if ($role === 'Siswa' && auth()->user())
            <section class="metric-card rounded-2xl p-5">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div class="flex items-center gap-4">
                        <div class="grid h-14 w-14 place-items-center rounded-full bg-[#006c4e] text-sm font-black text-white">
                            {{ collect(explode(' ', auth()->user()->name))->filter()->map(fn ($part) => mb_substr($part, 0, 1))->take(2)->implode('') }}
                        </div>
                        <div>
                            <p class="font-mono text-xs font-black uppercase tracking-[0.12em] text-[#006c4e] dark:text-[#cdfef1]">Akun Mahasiswa/Siswa</p>
                            <h2 class="mt-1 font-sans text-xl font-black text-[#013225] dark:text-[#ffffff]">{{ auth()->user()->name }}</h2>
                            <p class="mt-1 text-sm font-semibold text-[#191c1e] dark:text-[#e6fef8]">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                    <div class="grid gap-3 sm:grid-cols-3">
                        <div class="rounded-xl border border-[#cdfef1] bg-[#e6fef8] px-4 py-3 text-[#013225]">
                            <p class="font-mono text-[10px] font-black uppercase tracking-[0.12em] text-[#191c1e] dark:text-[#e6fef8]">Kelas</p>
                            <p class="mt-1 font-black">{{ auth()->user()->kelas ?? '-' }}</p>
                        </div>
                        <div class="rounded-xl border border-[#cdfef1] bg-[#e6fef8] px-4 py-3 text-[#013225]">
                            <p class="font-mono text-[10px] font-black uppercase tracking-[0.12em] text-[#191c1e] dark:text-[#e6fef8]">NIS</p>
                            <p class="mt-1 font-black">{{ auth()->user()->nis ?? '-' }}</p>
                        </div>
                        <div class="rounded-xl border border-[#cdfef1] bg-[#fff7e5] px-4 py-3 text-[#664700]">
                            <p class="font-mono text-[10px] font-black uppercase tracking-[0.12em] text-[#191c1e] dark:text-[#e6fef8]">Jurusan</p>
                            <p class="mt-1 font-black">{{ auth()->user()->jurusan ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <section class="grid grid-cols-1 gap-6 md:grid-cols-3">
            <x-temperature-card label="T1: Air Panas" value="70" tone="red" sensor-key="suhu_panas" />
            <x-temperature-card label="T2: Air Dingin" value="28" tone="blue" sensor-key="suhu_dingin" />
            <x-temperature-card label="Tc: Air Campuran" value="45" tone="orange" sensor-key="suhu_campuran" />
        </section>

        <section class="grid gap-6">
            <article class="metric-card rounded-2xl p-5">
                <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="font-mono text-xs font-black uppercase tracking-[0.12em] text-[#006c4e] dark:text-[#cdfef1]">Koneksi MQTT</p>
                        <button type="button" data-mqtt-connect-button class="mt-3 inline-flex items-center gap-2 rounded-xl bg-[#006c4e] px-5 py-3 font-mono text-sm font-black uppercase tracking-[0.08em] text-white shadow-lg shadow-[#006c4e]/30 transition hover:bg-[#006c4e] active:scale-[0.98]">
                            <span class="material-symbols-outlined text-[20px]">sensors</span>
                            Konek MQTT
                        </button>
                        <p class="mt-3 text-sm font-bold text-[#191c1e] dark:text-[#e6fef8]" data-mqtt-connect-message data-sensor-status>Menunggu koneksi MQTT</p>
                    </div>
                    <p class="rounded-full bg-[#013225] px-4 py-2 font-mono text-xs font-black text-[#cdfef1]" data-sensor-updated>Updated: -</p>
                </div>
            </article>
        </section>

        <section class="grid gap-6 xl:grid-cols-[.9fr_1.1fr]">
            <article class="metric-card rounded-2xl p-6">
                <h2 class="font-sans text-2xl font-black text-[#013225] dark:text-[#ffffff]">Input Data Percobaan</h2>
                @if (session('success'))
                    <div class="mt-5 rounded-lg bg-[#e6fef8] px-4 py-3 text-sm font-bold text-[#004d36]">
                        {{ session('success') }}
                    </div>
                @endif

                <form
                    class="mt-6 space-y-4"
                    data-asas-form
                    @if ($role === 'Siswa')
                        data-save-url="{{ route('student.praktikum.history.store') }}"
                    @endif
                >
                    <div class="grid gap-4 sm:grid-cols-2">
                        <label class="block">
                            <span class="font-mono text-xs font-black uppercase tracking-[0.10em] text-[#191c1e] dark:text-[#e6fef8]">Massa Air Panas (kg)</span>
                            <input name="hotMass" type="number" min="0.01" step="0.01" value="0.25" inputmode="decimal" required class="mt-2 w-full rounded-lg border border-[#cdfef1] bg-[#ffffff] px-4 py-3 font-mono text-base font-bold outline-none focus:border-[#006c4e] focus:ring-4 focus:ring-[#e6fef8] dark:border-[#03634a]/40 dark:bg-[#013225]">
                        </label>
                        <label class="block">
                            <span class="font-mono text-xs font-black uppercase tracking-[0.10em] text-[#191c1e] dark:text-[#e6fef8]">Massa Air Dingin (kg)</span>
                            <input name="coldMass" type="number" min="0.01" step="0.01" value="0.35" inputmode="decimal" required class="mt-2 w-full rounded-lg border border-[#cdfef1] bg-[#ffffff] px-4 py-3 font-mono text-base font-bold outline-none focus:border-[#006c4e] focus:ring-4 focus:ring-[#e6fef8] dark:border-[#03634a]/40 dark:bg-[#013225]">
                        </label>
                    </div>
                    <input name="suhuPanas" type="hidden" value="70" data-suhu-panas-input>
                    <input name="suhuDingin" type="hidden" value="28" data-suhu-dingin-input>
                    <input name="suhuCampuran" type="hidden" value="45" data-suhu-campuran-input>
                    <div class="grid gap-3 sm:grid-cols-[1fr_auto]">
                        <button type="submit" class="rounded-xl bg-[#006c4e] px-5 py-4 font-black text-white shadow-md transition active:scale-95">
                            Hitung Asas Black
                        </button>
                        <button type="button" data-reset-asas class="rounded-xl border border-[#cdfef1] bg-[#ffffff] px-5 py-4 font-black text-[#013225] transition hover:bg-[#ffffff] dark:border-[#03634a]/40 dark:bg-[#013225] dark:text-[#ffffff]">
                            Reset
                        </button>
                    </div>
                </form>

                <div class="mt-6 grid gap-3 sm:grid-cols-2">
                    <div class="rounded-xl bg-[#e6fef8] p-4">
                        <p class="font-mono text-xs font-black uppercase tracking-[0.10em] text-[#03634a]">Qlepas</p>
                        <p class="mt-1 font-mono text-2xl font-bold text-[#006c4e]" data-q-release>0 J</p>
                    </div>
                    <div class="rounded-xl bg-[#e6fef8] p-4">
                        <p class="font-mono text-xs font-black uppercase tracking-[0.10em] text-[#004d36]">Qterima</p>
                        <p class="mt-1 font-mono text-2xl font-bold text-[#006c4e]" data-q-accept>0 J</p>
                    </div>
                    <div class="rounded-xl bg-[#ffffff] p-4 dark:bg-[#013225]">
                        <p class="font-mono text-xs font-black uppercase tracking-[0.10em] text-[#191c1e] dark:text-[#e6fef8]">Delta Q</p>
                        <p class="mt-1 font-mono text-2xl font-bold" data-delta-q>0 J</p>
                    </div>
                    <div class="rounded-xl bg-[#ffffff] p-4 dark:bg-[#013225]">
                        <p class="font-mono text-xs font-black uppercase tracking-[0.10em] text-[#191c1e] dark:text-[#e6fef8]">Error Persen</p>
                        <p class="mt-1 font-mono text-2xl font-bold" data-error-percent>0%</p>
                    </div>
                </div>
                <div class="mt-4 inline-flex items-center gap-3 rounded-full border border-[#cdfef1] bg-[#e6fef8] px-5 py-3 font-black text-[#004d36]" data-asas-status-pill>
                    <span class="material-symbols-outlined text-[#006c4e]" style="font-variation-settings: 'FILL' 1;">verified</span>
                    <span data-asas-status>SESUAI HUKUM ASAS BLACK</span>
                </div>
                <p class="mt-4 rounded-lg bg-[#ffffff] px-4 py-3 text-xs font-bold text-[#191c1e] dark:bg-[#013225] dark:text-[#e6fef8]" data-asas-note>
                    Hasil dihitung otomatis berdasarkan massa air panas dan massa air dingin.
                </p>
                @if ($role === 'Siswa')
                    <p class="mt-3 rounded-lg bg-[#e6fef8] px-4 py-3 text-xs font-bold text-[#004d36]" data-save-status>
                        Tekan Hitung Asas Black untuk menyimpan riwayat praktikum
                    </p>
                @endif
            </article>

            <section class="space-y-6">
                <article class="metric-card rounded-2xl p-6">
                    <h2 class="font-sans text-2xl font-black text-[#013225] dark:text-[#ffffff]">Grafik Percobaan</h2>
                    <div class="chart-shell mt-5 h-[340px] rounded-xl border border-[#cdfef1]/60 bg-[#e6fef8]/80 p-4 dark:border-[#03634a]/30 dark:bg-[#013225]/45">
                        <canvas id="studentRealtimeChart"></canvas>
                    </div>
                </article>

            </section>
        </section>
    </div>
</x-layouts.dashboard>
