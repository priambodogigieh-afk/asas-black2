<x-layouts.dashboard
    :title="$title"
    subtitle="Monitoring realtime data sensor DS18B20 dari broker MQTT IoTKita."
    :role="$role"
    :items="$items"
>
    <div class="space-y-6" data-page="monitoring" data-realtime-sensor-dashboard>
        <section class="grid gap-4 lg:grid-cols-3">
            <x-temperature-card label="Suhu Panas" value="70" tone="red" sensor="DS18B20 A" change="+0.5" sensor-key="suhu_panas" />
            <x-temperature-card label="Suhu Dingin" value="28" tone="blue" sensor="DS18B20 B" change="-0.2" sensor-key="suhu_dingin" />
            <x-temperature-card label="Suhu Campuran" value="45" tone="orange" sensor="DS18B20 C" change="+0.3" sensor-key="suhu_campuran" />
        </section>

        <section class="grid gap-6">
            <article class="metric-card rounded-md p-5">
                <p class="font-mono text-xs font-black uppercase tracking-[0.12em] text-[#006c4e] dark:text-[#cdfef1]">Koneksi MQTT</p>
                <button type="button" data-mqtt-connect-button class="mt-3 inline-flex items-center gap-2 rounded-xl bg-[#006c4e] px-5 py-3 font-mono text-sm font-black uppercase tracking-[0.08em] text-white shadow-lg shadow-[#006c4e]/30 transition hover:bg-[#006c4e] active:scale-[0.98]">
                    <span class="material-symbols-outlined text-[20px]">sensors</span>
                    Konek MQTT
                </button>
                <p class="mt-3 text-sm font-bold text-[#191c1e] dark:text-[#e6fef8]" data-mqtt-connect-message data-sensor-status>Menunggu koneksi MQTT</p>
                <p class="mt-1 text-xs font-bold text-[#191c1e] dark:text-[#e6fef8]" data-sensor-updated>Updated: -</p>
            </article>
        </section>

        <section>
            <div class="metric-card rounded-md p-5">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-lg font-black text-[#013225] dark:text-[#ffffff]">Grafik Suhu</h2>
                        <p class="mt-1 text-sm text-[#191c1e] dark:text-[#e6fef8]">Simulasi pergerakan suhu lokal.</p>
                    </div>
                </div>
                <div class="chart-shell mt-5 h-[380px]">
                    <canvas id="monitoringChart"></canvas>
                </div>
            </div>
        </section>
    </div>
</x-layouts.dashboard>
