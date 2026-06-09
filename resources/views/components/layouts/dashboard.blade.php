@props([
    'title' => 'Dashboard',
    'subtitle' => 'Monitoring praktikum Asas Black',
    'role' => 'Guru',
    'items' => [],
])

<x-layouts.app :title="$title">
    <div class="min-h-screen">
        <x-sidebar :role="$role" :items="$items" />

        <div data-dashboard-content class="min-w-0 transition-[margin] duration-300 lg:ml-64">
            <x-navbar :title="$title" :subtitle="$subtitle" :role="$role" />

            <main class="mx-auto flex w-full max-w-[1540px] flex-col gap-6 px-4 py-6 sm:px-6 lg:px-8">
                {{ $slot }}
            </main>
        </div>
    </div>
</x-layouts.app>
