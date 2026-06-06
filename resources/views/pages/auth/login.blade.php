<x-layouts.app title="Login - Asas Black Smart Lab">
    <main class="flex min-h-screen items-center bg-emerald-50 px-4 py-10 text-[#111827] sm:px-6">
        <div class="mx-auto grid w-full max-w-6xl items-center gap-8 lg:grid-cols-[1fr_440px] lg:gap-12">
            <div class="auth-entrance flex justify-center lg:justify-start">
                <img
                    src="{{ asset('images/illustrations/lab-technician.png') }}"
                    alt="Ilustrasi teknisi laboratorium"
                    class="auth-illustration h-auto max-h-72 w-full max-w-sm object-contain sm:max-h-80 lg:max-h-[620px] lg:max-w-2xl"
                >
            </div>

            <section class="auth-card auth-entrance w-full max-w-md justify-self-center rounded-md border border-emerald-200 bg-white p-6 shadow-sm sm:p-8 lg:justify-self-end">
            <div class="auth-field mb-6 text-center">
                <h1 class="text-2xl font-bold text-[#111827]">Login</h1>
                <p class="mt-2 text-sm text-[#111827]">Masuk menggunakan email dan password akun Anda.</p>
            </div>

            @if ($errors->any())
                <div class="mb-5 rounded-md border border-bubblegum-pink-200 bg-bubblegum-pink-50 px-4 py-3 text-sm font-semibold text-bubblegum-pink-700">
                    {{ $errors->first() }}
                </div>
            @endif

            @if (session('success'))
                <div class="mb-5 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            <form class="space-y-5" method="POST" action="{{ route('login.submit') }}">
                @csrf

                <label class="auth-field block">
                    <span class="text-sm font-semibold text-[#111827]">Email</span>
                    <input
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        autocomplete="email"
                        required
                        class="mt-2 w-full rounded-md border border-emerald-300 bg-white px-4 py-3 text-sm text-[#111827] outline-none transition placeholder:text-[#6b7280] focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100"
                        placeholder="nama@email.com"
                    >
                </label>

                <label class="auth-field block">
                    <span class="text-sm font-semibold text-[#111827]">Password</span>
                    <input
                        name="password"
                        type="password"
                        autocomplete="current-password"
                        required
                        class="mt-2 w-full rounded-md border border-emerald-300 bg-white px-4 py-3 text-sm text-[#111827] outline-none transition placeholder:text-[#6b7280] focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100"
                        placeholder="Masukkan password"
                    >
                </label>

                <div class="auth-field flex flex-col gap-3 text-sm sm:flex-row sm:items-center sm:justify-between">
                    <label class="inline-flex items-center gap-2 text-[#111827]">
                        <input
                            name="remember"
                            type="checkbox"
                            value="1"
                            class="h-4 w-4 rounded border-emerald-300 text-emerald-600 focus:ring-emerald-500"
                        >
                        <span>Remember me</span>
                    </label>

                    <a href="#" class="font-semibold text-[#111827] transition hover:underline">
                        Lupa password?
                    </a>
                </div>

                <button
                    type="submit"
                    class="auth-button auth-field w-full rounded-md bg-emerald-700 px-5 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-200 focus:ring-offset-2"
                >
                    Login
                </button>
            </form>

            <p class="auth-field mt-6 text-center text-sm text-[#111827]">
                Belum punya akun siswa?
                <a href="{{ route('student.register') }}" class="font-semibold text-[#111827] transition hover:underline">
                    Daftar
                </a>
            </p>
            </section>
        </div>
    </main>
</x-layouts.app>
