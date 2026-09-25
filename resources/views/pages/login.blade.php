<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    <body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex items-center justify-center p-4">

        <div class="w-full max-w-md">
            <!-- Card Container -->
            <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/60 border border-slate-100 p-8">

                <!-- Header / Logo -->
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-600/30 mb-4">
                        PRISM
                    </div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Problem Issue & Incident Management</h1>
                    <p class="text-sm text-slate-500 mt-1">Masuk dengan akun laptop/PC anda</p>
                </div>

                @if (session('success'))
                <div class="mb-5 flex items-center p-4 text-emerald-800 bg-emerald-50 border border-emerald-200 rounded-xl shadow-xs" role="alert">
                    <svg class="w-5 h-5 me-3 shrink-0 text-emerald-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="text-sm font-medium">
                        {{ session('success') }}
                    </div>
                </div>
                @endif

                <!-- Alert Gagal / Exception (Error) -->
                @if (session('error'))
                <div class="mb-5 flex items-center p-4 text-rose-800 bg-rose-50 border border-rose-200 rounded-xl shadow-xs" role="alert">
                    <svg class="w-5 h-5 me-3 shrink-0 text-rose-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="text-sm font-medium">
                        {{ session('error') }}
                    </div>
                </div>
                @endif

                <!-- Form -->
                <form method="POST" action="{{ route('proses-login') }}" class="space-y-5">
                    @csrf

                    <!-- Email Input -->
                    <div>
                        <label for="username" class="block text-sm font-medium text-slate-700 mb-1.5">Username</label>
                        <input
                            type="text"
                            name="username"
                            id="username"
                            value="{{ old('username') }}"
                            required
                            autofocus
                            placeholder="arief.nadhofa"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-blue-600 focus:ring-blue-600/20 bg-slate-50/50 text-slate-900 text-sm focus:outline-none focus:ring-4 transition duration-200">

                    </div>

                    <!-- Password Input -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-sm font-medium text-slate-700">Kata Sandi</label>
                            @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs font-medium text-blue-600 hover:text-blue-500 transition">
                                Lupa sandi?
                            </a>
                            @endif
                        </div>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            required
                            placeholder="••••••••"
                            class="w-full px-4 py-2.5 rounded-xl border @error('password') border-rose-500 focus:ring-rose-500 @else border-slate-300 focus:border-blue-600 focus:ring-blue-600/20 @enderror bg-slate-50/50 text-slate-900 text-sm focus:outline-none focus:ring-4 transition duration-200">
                        @error('password')
                        <p class="text-xs text-rose-600 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="w-full py-2.5 px-4 bg-blue-600 hover:bg-blue-700 active:scale-[0.99] text-white font-medium text-sm rounded-xl shadow-md shadow-blue-600/20 hover:shadow-lg hover:shadow-blue-600/30 transition duration-200 focus:outline-none focus:ring-4 focus:ring-blue-600/30">
                        Masuk ke Akun
                    </button>
                </form>

                <!-- Register / Footer Note -->
                @if (Route::has('register'))
                <p class="text-center text-xs text-slate-500 mt-8">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-semibold text-blue-600 hover:text-blue-500 transition">
                        Daftar sekarang
                    </a>
                </p>
                @endif

            </div>
        </div>

    </body>

</html>