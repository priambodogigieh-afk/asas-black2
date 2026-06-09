@props(['title' => 'Dashboard', 'subtitle' => '', 'role' => 'Guru'])

@php
    $user = auth()->user();
    $accent = $role === 'Siswa' ? 'text-[#006c4e] dark:text-[#05c793]' : 'text-[#006c4e] dark:text-[#cdfef1]';
@endphp

<header class="sticky top-0 z-30 border-b border-[#cdfef1]/50 bg-[#e6fef8]/80 px-4 py-3 shadow-sm backdrop-blur-xl dark:border-[#03634a]/30 dark:bg-[#013225]/72 sm:px-6 lg:px-8">
    <div class="mx-auto flex max-w-[1540px] flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <p class="font-mono text-xs font-bold uppercase tracking-[0.22em] {{ $accent }}">{{ $role }} Physics Portal</p>
            <h1 class="mt-1 font-sans text-2xl font-black text-[#013225] dark:text-[#ffffff]">{{ $title }}</h1>
            @if ($subtitle)
                <p class="mt-1 max-w-3xl text-sm text-[#191c1e] dark:text-[#e6fef8]">{{ $subtitle }}</p>
            @endif
        </div>

        <div class="flex flex-wrap items-center gap-2">
            @if ($user)
                <span class="hidden max-w-[220px] truncate rounded-full bg-[#ffffff] px-3 py-2 text-xs font-black text-[#191c1e] shadow-sm dark:bg-[#013225] dark:text-[#e6fef8] sm:inline-block">
                    {{ $user->name }}
                </span>
            @endif
        </div>
    </div>
</header>
