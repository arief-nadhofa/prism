@include('layouts.header', ['title' => $title])

<main class="flex-1 p-4 lg:p-8 space-y-6">

    <!-- Flash Message Notification -->
    @if (session('success'))
    <div class="flex items-center p-4 text-emerald-800 bg-emerald-50 border border-emerald-200 rounded-2xl shadow-xs">
        <i class="fa-solid fa-circle-check text-emerald-600 me-3 text-lg"></i>
        <div class="text-sm font-semibold">{{ session('success') }}</div>
    </div>
    @endif

    @if (session('error'))
    <div class="flex items-center p-4 text-rose-800 bg-rose-50 border border-rose-200 rounded-2xl shadow-xs">
        <i class="fa-solid fa-circle-exclamation text-rose-600 me-3 text-lg"></i>
        <div class="text-sm font-semibold">{{ session('error') }}</div>
    </div>
    @endif

    <!-- Top Navigation / Breadcrumbs -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Problem Report #{{ $problem->id }}</h2>
            <p class="text-xs text-slate-500 mt-1">Dibuat pada </p>
        </div>
        <div>
            <a href="{{ route('problem-log.index') }}" class="px-4 py-2 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-semibold inline-flex items-center gap-2 transition">
                <i class="fa-solid fa-arrow-left text-xs"></i> Kembali ke Daftar
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- KIRI: INFORMASI LAPORAN PROBLEM (Readonly) -->
        <div class="lg:col-span-7 space-y-6">
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 space-y-5">

                <!-- Status & Badge Info -->
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Status Penanganan</span>
                    @if ($problem->status == 1)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        <i class="fa-solid fa-check text-xs"></i> Solved / Closed
                    </span>
                    @else
                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-rose-600"></span>
                        </span>
                        Open / In Progress
                    </span>
                    @endif
                </div>

                <!-- Info Grid -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-100">
                        <span class="text-[11px] font-semibold uppercase tracking-wider text-slate-500">Line Produksi</span>
                        <p class="text-sm font-bold text-slate-800 mt-0.5">{{ $problem->lineDetail->line ?? $problem->line }}</p>
                    </div>

                    <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-100">
                        <span class="text-[11px] font-semibold uppercase tracking-wider text-slate-500">Kategori</span>
                        <p class="text-sm font-bold text-slate-800 mt-0.5">{{ $problem->categoryDetail->category ?? '-' }}</p>
                    </div>

                    <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-100">
                        <span class="text-[11px] font-semibold uppercase tracking-wider text-slate-500">Pelapor (NPK)</span>
                        <p class="text-sm font-bold text-slate-800 mt-0.5">
                            {{ $problem->created_by }}
                        </p>
                    </div>

                    <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-100">
                        <span class="text-[11px] font-semibold uppercase tracking-wider text-slate-500">Waktu Mulai Problem</span>
                        <p class="text-sm font-bold text-slate-800 mt-0.5">
                            {{ $problem->created_at }}

                        </p>
                    </div>
                </div>

                <!-- Deskripsi Problem -->
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">Deskripsi Problem</label>
                    <div class="p-4 bg-slate-50 rounded-xl border border-slate-100 text-sm text-slate-700 whitespace-pre-line leading-relaxed">
                        {{ $problem->problem }}
                    </div>
                </div>

                <!-- Lampiran / Attachment -->
                <div class="border-t border-slate-100 pt-4">
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-3">Lampiran Dokumen / Bukti</label>
                    <div class="space-y-2">
                        @php
                        $attachments = [
                        'Lampiran 1' => $problem->attachment_1,
                        'Lampiran 2' => $problem->attachment_2,
                        'Lampiran 3' => $problem->attachment_3,
                        ];
                        @endphp

                        @foreach($attachments as $label => $file)
                        @if($file)
                        <a href="{{ asset('storage/' . $file) }}" target="_blank" class="flex items-center justify-between p-3 rounded-xl border border-slate-200 hover:border-indigo-300 hover:bg-indigo-50/40 text-slate-700 text-xs font-medium transition">
                            <span class="flex items-center gap-2">
                                <i class="fa-solid fa-paperclip text-slate-400"></i> {{ $label }} ({{ basename($file) }})
                            </span>
                            <span class="text-indigo-600 font-semibold">Lihat File &rarr;</span>
                        </a>
                        @else
                        <div class="flex items-center p-3 rounded-xl border border-dashed border-slate-200 text-slate-400 text-xs">
                            <i class="fa-solid fa-file-circle-xmark me-2"></i> {{ $label }}: Tidak ada lampiran
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>

            </div>
        </div>

        <!-- KANAN: FORM PENYELESAIAN (CLOSE PROBLEM) -->
        <div class="lg:col-span-5">
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 sticky top-6">
                <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                    <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-sm">
                        <i class="fa-solid fa-wrench"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 text-sm">Tindakan Penanganan</h3>
                        <p class="text-xs text-slate-500">Penyelesaian & Close Problem</p>
                    </div>
                </div>

                @if ($problem->status == 1)
                <!-- Tampilan Jika Problem SUDAH di-close -->
                <div class="space-y-4 mt-5">
                    <div>
                        <span class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">Countermeasure / Tindakan</span>
                        <div class="p-3.5 bg-emerald-50/50 rounded-xl border border-emerald-100 text-sm text-slate-800">
                            {{ $problem->countermeasure }}
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3 pt-2">
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                            <span class="text-[11px] font-semibold uppercase text-slate-500 block">Selesai Problem</span>
                            <span class="text-xs font-bold text-slate-800">
                                {{ $problem->finish_problem ? $problem->finish_problem : '-' }}
                            </span>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                            <span class="text-[11px] font-semibold uppercase text-slate-500 block">Total Durasi</span>
                            <span class="text-xs font-bold text-indigo-600">{{ $problem->duration ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="pt-4 text-center">
                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-600">
                            <i class="fa-solid fa-circle-check"></i> Problem ini telah resmi ditutup
                        </span>
                    </div>
                </div>
                @else
                <!-- Form Input Jika Problem MASIH OPEN -->
                <form action="{{ route('problem-log.close', $problem->id) }}" method="POST" class="space-y-4 mt-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="finish_problem" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Waktu Selesai (Finish Problem) <span class="text-rose-500">*</span>
                        </label>
                        <input type="datetime-local"
                            name="finish_problem"
                            id="finish_problem"
                            value="{{ old('finish_problem', now('Asia/Jakarta')->format('Y-m-d\TH:i')) }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-4 focus:ring-indigo-600/10 focus:border-indigo-600 transition"
                            required />
                    </div>

                    <div>
                        <label for="countermeasure" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Countermeasure / Solusi Perbaikan <span class="text-rose-500">*</span>
                        </label>
                        <textarea name="countermeasure"
                            id="countermeasure"
                            rows="5"
                            placeholder="Jelaskan tindakan perbaikan atau root-cause fix yang telah dilakukan..."
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-4 focus:ring-indigo-600/10 focus:border-indigo-600 transition"
                            required>{{ old('countermeasure') }}</textarea>
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                            onclick="return confirm('Apakah Anda yakin ingin menyelesaikan dan menutup report problem ini?')"
                            class="w-full py-2.5 px-4 rounded-xl bg-indigo-600 hover:bg-indigo-700 active:scale-98 text-white text-xs font-bold shadow-md shadow-indigo-600/20 transition flex items-center justify-center gap-2">
                            <i class="fa-solid fa-check-double text-sm"></i>
                            Selesaikan & Close Problem
                        </button>
                    </div>
                </form>
                @endif

            </div>
        </div>

    </div>

</main>

@include('layouts.footer')