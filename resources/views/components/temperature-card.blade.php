@props([
    'label',
    'value',
    'unit' => 'C',
    'tone' => 'cyan',
    'sensor' => 'DS18B20',
    'change' => '+0.4',
    'sensorKey' => null,
])

@php
    $tones = [
        'red' => ['text' => 'text-[#006c4e] dark:text-[#cdfef1]', 'soft' => 'bg-[#e6fef8] text-[#03634a] dark:bg-[#006c4e]/20 dark:text-[#cdfef1]', 'icon' => 'thermostat', 'color' => '#006c4e'],
        'blue' => ['text' => 'text-[#05c793] dark:text-[#9cfce3]', 'soft' => 'bg-[#e6fef8] text-[#03634a] dark:bg-[#05c793]/20 dark:text-[#9cfce3]', 'icon' => 'ac_unit', 'color' => '#05c793'],
        'orange' => ['text' => 'text-[#ffb300] dark:text-[#ffd166]', 'soft' => 'bg-[#fff7e5] text-[#996b00] dark:bg-[#ffb300]/22 dark:text-[#ffd166]', 'icon' => 'waves', 'color' => '#ffb300'],
        'cyan' => ['text' => 'text-[#006c4e] dark:text-[#cdfef1]', 'soft' => 'bg-[#e6fef8] text-[#004d36] dark:bg-[#006c4e]/20 dark:text-[#cdfef1]', 'icon' => 'sensors', 'color' => '#006c4e'],
    ];
    $toneData = $tones[$tone] ?? $tones['cyan'];
@endphp

<article class="metric-card group relative overflow-hidden rounded-2xl p-6 transition hover:shadow-md" @if($sensorKey) data-sensor-card="{{ $sensorKey }}" @endif>
    <div class="absolute right-4 top-4 opacity-20">
        <span class="material-symbols-outlined text-7xl {{ $toneData['text'] }}">{{ $toneData['icon'] }}</span>
    </div>

    <div class="relative flex items-start justify-between gap-4">
        <div>
            <p class="flex items-center gap-2 font-mono text-xs font-bold uppercase tracking-[0.12em] text-[#191c1e] dark:text-[#e6fef8]">
                <span class="h-2 w-2 rounded-full" style="background: {{ $toneData['color'] }}"></span>
                {{ $label }}
            </p>
            <div class="mt-3 flex items-end gap-1">
                <span class="font-mono text-4xl font-bold tracking-tight {{ $toneData['text'] }}" data-temp-value data-base="{{ $value }}" @if($sensorKey) data-sensor-value="{{ $sensorKey }}" @endif>{{ $value }}</span>
                <span class="pb-1 text-2xl font-bold text-[#191c1e] dark:text-[#e6fef8]">&deg;{{ $unit }}</span>
            </div>
        </div>
    </div>

    <div class="relative mt-6 h-2.5 w-full overflow-hidden rounded-full bg-[#e6fef8] dark:bg-[#e6fef8]">
        <div class="h-full rounded-full transition-all duration-1000" @if($sensorKey) data-sensor-bar="{{ $sensorKey }}" @endif style="width: {{ min(100, max(8, $value)) }}%; background: {{ $toneData['color'] }}"></div>
    </div>

    <div class="relative mt-5 flex items-center justify-between gap-3">
        <span class="rounded-full px-2.5 py-1 font-mono text-xs font-bold {{ $toneData['soft'] }}">{{ $sensor }}</span>
        <span class="text-xs font-bold text-[#191c1e] dark:text-[#e6fef8]" @if($sensorKey) data-sensor-drift="{{ $sensorKey }}" @endif>Drift {{ $change }}&deg;C</span>
    </div>
</article>
