<x-layouts.app title="Register Siswa - Asas Black Smart Lab">
    <main class="flex min-h-screen items-center bg-emerald-50 px-4 py-10 text-[#111827] sm:px-6">
        <div class="mx-auto grid w-full max-w-7xl items-center gap-8 lg:grid-cols-[420px_1fr] lg:gap-12">
            <div class="auth-entrance flex justify-center lg:justify-start">
                <img
                    src="{{ asset('images/illustrations/lab-technician.png') }}"
                    alt="Ilustrasi teknisi laboratorium"
                    class="auth-illustration h-auto max-h-64 w-full max-w-xs object-contain sm:max-h-80 lg:max-h-[620px] lg:max-w-lg"
                >
            </div>

            <section class="auth-card auth-entrance w-full max-w-2xl justify-self-center rounded-md border border-emerald-200 bg-white p-6 shadow-sm sm:p-8 lg:justify-self-end">
            <div class="auth-field mb-6 text-center">
                <h1 class="text-2xl font-bold text-[#111827]">Register Siswa</h1>
                <p class="mt-2 text-sm text-[#111827]">Isi data berikut untuk membuat akun siswa.</p>
            </div>

            @if ($errors->any())
                <div class="mb-5 rounded-md border border-bubblegum-pink-200 bg-bubblegum-pink-50 px-4 py-3 text-sm font-semibold text-bubblegum-pink-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <form class="space-y-5" method="POST" action="{{ route('student.register.store') }}">
                @csrf

                <div class="grid gap-5 sm:grid-cols-2">
                    <label class="auth-field block">
                        <span class="text-sm font-semibold text-[#111827]">Nama Lengkap</span>
                        <input
                            name="name"
                            type="text"
                            value="{{ old('name') }}"
                            autocomplete="name"
                            required
                            class="mt-2 w-full rounded-md border border-emerald-300 bg-white px-4 py-3 text-sm text-[#111827] outline-none transition placeholder:text-[#6b7280] focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100"
                            placeholder="Nama siswa"
                        >
                    </label>

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
                </div>

                <div class="grid gap-5 sm:grid-cols-3">
                    <label class="auth-field block">
                        <span class="text-sm font-semibold text-[#111827]">Kelas</span>
                        <select
                            name="kelas"
                            required
                            class="mt-2 w-full rounded-md border border-emerald-300 bg-white px-4 py-3 text-sm text-[#111827] outline-none transition focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100"
                        >
                            <option value="">Pilih kelas</option>
                            @foreach (['XI IPA 1', 'XI IPA 2', 'XI IPA 3', 'XII IPA 1'] as $kelas)
                                <option value="{{ $kelas }}" @selected(old('kelas') === $kelas)>{{ $kelas }}</option>
                            @endforeach
                        </select>
                    </label>

                    <label class="auth-field block">
                        <span class="text-sm font-semibold text-[#111827]">NIS</span>
                        <input
                            name="nis"
                            type="text"
                            value="{{ old('nis') }}"
                            required
                            inputmode="numeric"
                            class="mt-2 w-full rounded-md border border-emerald-300 bg-white px-4 py-3 text-sm text-[#111827] outline-none transition placeholder:text-[#6b7280] focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100"
                            placeholder="NIS"
                        >
                    </label>

                    <label class="auth-field block">
                        <span class="text-sm font-semibold text-[#111827]">Jurusan</span>
                        <select
                            name="jurusan"
                            required
                            class="mt-2 w-full rounded-md border border-emerald-300 bg-white px-4 py-3 text-sm text-[#111827] outline-none transition focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100"
                        >
                            <option value="">Pilih jurusan</option>
                            @foreach (['IPA', 'IPS', 'Teknik Komputer', 'Rekayasa Perangkat Lunak'] as $jurusan)
                                <option value="{{ $jurusan }}" @selected(old('jurusan') === $jurusan)>{{ $jurusan }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <label class="auth-field block">
                        <span class="text-sm font-semibold text-[#111827]">Password</span>
                        <input
                            name="password"
                            type="password"
                            autocomplete="new-password"
                            required
                            minlength="6"
                            class="mt-2 w-full rounded-md border border-emerald-300 bg-white px-4 py-3 text-sm text-[#111827] outline-none transition placeholder:text-[#6b7280] focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100"
                            placeholder="Minimal 6 karakter"
                        >
                    </label>

                    <label class="auth-field block">
                        <span class="text-sm font-semibold text-[#111827]">Konfirmasi Password</span>
                        <input
                            name="password_confirmation"
                            type="password"
                            autocomplete="new-password"
                            required
                            minlength="6"
                            class="mt-2 w-full rounded-md border border-emerald-300 bg-white px-4 py-3 text-sm text-[#111827] outline-none transition placeholder:text-[#6b7280] focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100"
                            placeholder="Ulangi password"
                        >
                    </label>
                </div>

                <button
                    type="submit"
                    class="auth-button auth-field w-full rounded-md bg-emerald-700 px-5 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-200 focus:ring-offset-2"
                >
                    Register
                </button>
            </form>

            <p class="auth-field mt-6 text-center text-sm text-[#111827]">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-semibold text-[#111827] transition hover:underline">
                    Login
                </a>
            </p>
            </section>
        </div>
    </main>
</x-layouts.app>
