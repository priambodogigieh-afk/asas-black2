@props(['role' => 'Guru', 'items' => []])

@php
    $homeRoute = $role === 'Siswa' ? 'student.praktikum' : 'teacher.dashboard';
    $user = auth()->user();
    $displayName = $user?->name ?? ($role === 'Siswa' ? 'Siswa' : 'Guru');
    $displayInitial = collect(explode(' ', $displayName))
        ->filter()
        ->map(fn ($part) => mb_substr($part, 0, 1))
        ->take(2)
        ->implode('');
    $accountMeta = $role === 'Siswa'
        ? collect([$user?->kelas, $user?->nis])->filter()->implode(' / ')
        : ($user?->email ?? 'Akun guru');
    $isStudent = $role === 'Siswa';
    $brandText = $isStudent ? 'text-[#006c4e] dark:text-[#05c793]' : 'text-[#006c4e] dark:text-[#cdfef1]';
    $brandBg = $isStudent ? 'bg-[#006c4e] dark:bg-[#05c793] dark:text-[#013225]' : 'bg-[#006c4e] dark:bg-[#cdfef1] dark:text-[#013225]';
    $activeClass = $isStudent ? 'bg-[#006c4e] text-white shadow-sm dark:bg-[#05c793] dark:text-[#013225]' : 'bg-[#006c4e] text-white shadow-sm dark:bg-[#cdfef1] dark:text-[#013225]';
@endphp

<aside data-sidebar class="fixed left-0 top-0 z-40 hidden h-screen w-64 shrink-0 flex-col border-r border-[#cdfef1]/60 bg-[#ffffff]/92 p-2 shadow-md backdrop-blur-xl transition-transform duration-300 dark:border-[#03634a]/30 dark:bg-[#013225]/92 lg:flex">
    <div class="flex items-start justify-between gap-3 px-4 py-6">
        <a href="{{ route($homeRoute) }}" class="flex min-w-0 flex-col gap-1">
            <span class="font-sans text-2xl font-black tracking-tight {{ $brandText }}">Asas Black</span>
            <span class="font-mono text-xs font-bold uppercase tracking-[0.18em] text-[#191c1e] dark:text-[#e6fef8]">Thermodynamics Lab</span>
        </a>
        <button type="button" data-sidebar-hide class="grid h-9 w-9 shrink-0 place-items-center rounded-lg border border-[#cdfef1] bg-white text-[#013225] transition hover:bg-[#e6fef8] dark:border-[#03634a]/40 dark:bg-[#013225] dark:text-white" aria-label="Sembunyikan sidebar" title="Sembunyikan sidebar">
            <span class="material-symbols-outlined text-[20px]">left_panel_close</span>
        </button>
    </div>

    <div class="mx-2 rounded-lg border border-[#cdfef1]/70 bg-[#e6fef8]/80 px-3 py-3 text-xs text-[#191c1e] backdrop-blur dark:border-[#03634a]/30 dark:bg-[#013225]/45 dark:text-[#ffffff]">
        <div class="flex items-center justify-between">
            <span class="font-mono font-bold uppercase tracking-[0.16em]">Mode {{ $role }}</span>
            <span class="h-2 w-2 rounded-full bg-[#006c4e] shadow-[0_0_14px_rgba(60,132,195,.75)]"></span>
        </div>
        <p class="mt-1">{{ $user?->email ?? 'Belum login' }}</p>
    </div>

    <nav class="mt-5 flex flex-col gap-1 px-2">
        @foreach ($items as $item)
            @php
                $active = request()->routeIs($item['route']);
                $isLogout = strtolower($item['label']) === 'logout';
            @endphp

            @if ($isLogout)
                <form method="POST" action="{{ route('logout') }}" data-logout-form>
                    @csrf
                    <button
                        type="submit"
                        class="group flex w-full items-center gap-3 rounded-lg px-4 py-3 text-left text-sm font-bold text-[#191c1e] transition duration-200 hover:scale-[1.02] hover:bg-[#e6fef8] dark:text-[#e6fef8] dark:hover:bg-[#013225]"
                    >
                        <span class="material-symbols-outlined text-[22px]">
                            {!! $item['icon'] !!}
                        </span>
                        <span class="font-mono text-xs uppercase tracking-[0.08em]">{{ $item['label'] }}</span>
                    </button>
                </form>
            @else
                <a
                    href="{{ route($item['route']) }}"
                    class="group flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-bold transition duration-200 {{ $active ? $activeClass : 'text-[#191c1e] hover:scale-[1.02] hover:bg-[#e6fef8] dark:text-[#e6fef8] dark:hover:bg-[#013225]' }}"
                >
                    <span class="material-symbols-outlined text-[22px]">
                        {!! $item['icon'] !!}
                    </span>
                    <span class="font-mono text-xs uppercase tracking-[0.08em]">{{ $item['label'] }}</span>
                </a>
            @endif
        @endforeach
    </nav>

    <div class="absolute inset-x-2 bottom-4 rounded-xl border border-[#cdfef1]/70 bg-[#e6fef8]/82 p-3 dark:border-[#03634a]/30 dark:bg-[#013225]/50">
        <div class="flex items-center gap-3">
            <div class="grid h-10 w-10 place-items-center rounded-full text-xs font-black text-white {{ $brandBg }}">{{ $displayInitial ?: ($role === 'Siswa' ? 'SW' : 'GR') }}</div>
            <div class="min-w-0">
                <p class="truncate text-sm font-black text-[#013225] dark:text-[#ffffff]">{{ $displayName }}</p>
                <p class="truncate text-xs text-[#191c1e] dark:text-[#e6fef8]">{{ $accountMeta ?: ($user?->email ?? 'Akun aktif') }}</p>
            </div>
        </div>
    </div>
</aside>

<button type="button" data-sidebar-show class="fixed left-4 top-4 z-50 hidden h-11 w-11 place-items-center rounded-xl border border-[#cdfef1] bg-white text-[#013225] shadow-lg transition hover:bg-[#e6fef8] dark:border-[#03634a]/40 dark:bg-[#013225] dark:text-white" aria-label="Tampilkan sidebar" title="Tampilkan sidebar">
    <span class="material-symbols-outlined text-[22px]">menu</span>
</button>

<div class="border-b border-[#cdfef1]/70 bg-[#e6fef8]/95 px-4 py-3 backdrop-blur-xl dark:border-[#03634a]/30 dark:bg-[#013225]/90 lg:hidden">
    <div class="flex items-center justify-between">
        <a href="{{ route($homeRoute) }}" class="flex items-center gap-3">
            <span class="grid h-10 w-10 place-items-center rounded-full text-xs font-black text-white {{ $brandBg }}">AB</span>
            <span class="text-sm font-black {{ $brandText }}">Asas Black Lab</span>
        </a>
        <div class="flex items-center gap-2">
        <select class="rounded-lg border border-[#cdfef1] bg-[#ffffff] px-3 py-2 text-sm dark:border-[#03634a]/40 dark:bg-[#013225]" onchange="if (this.value) window.location.href = this.value">
            @foreach ($items as $item)
                @unless (strtolower($item['label']) === 'logout')
                    <option value="{{ route($item['route']) }}" @selected(request()->routeIs($item['route']))>{{ $item['label'] }}</option>
                @endunless
            @endforeach
        </select>
        <form method="POST" action="{{ route('logout') }}" data-logout-form>
            @csrf
            <button type="submit" class="grid h-10 w-10 place-items-center rounded-lg border border-[#cdfef1] bg-white text-[#013225] dark:border-[#03634a]/40 dark:bg-[#013225] dark:text-white" aria-label="Logout">
                <span class="material-symbols-outlined text-[20px]">logout</span>
            </button>
        </form>
        </div>
    </div>
</div>
