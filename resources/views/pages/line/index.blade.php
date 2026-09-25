@include('layouts.header',['title'=>$title])
<!-- MAIN BODY / CONTENT -->
<main class="flex-1 p-4 lg:p-8 space-y-6">
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
    <!-- TABLE / DATA SECTION -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <div>
                <h3 class="font-bold text-slate-900 text-base">List Line</h3>
            </div>
            <button onclick="toggleModal('modal-tambah')" class="inline-flex items-center px-2 py-2 bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white text-xs font-medium rounded-md shadow-sm transition duration-150 ease-in-out" title="Detail">
                <i class="fa-solid fa-plus text-xs"></i>
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50/75 border-b border-slate-100 text-xs uppercase font-semibold text-slate-500 tracking-wider">
                    <tr>
                        <th class="px-6 py-3.5">No.</th>
                        <th class="px-6 py-3.5">Line</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($getLine as $l)
                    <tr class="hover:bg-slate-50/60 transition">
                        <td class="px-6 py-4 font-semibold text-slate-900">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 font-medium text-slate-800">{{$l->line}}</td>
                        <td class="px-6 py-4 text-right">

                            <button type="button"
                                onclick="toggleModal('modal-edit-{{$l->id}}')"
                                class="inline-flex items-center px-3 py-1.5 bg-green-50 text-green-600 hover:bg-green-100 hover:text-green-700 border border-green-200 rounded-lg text-xs font-semibold transition"
                                title="Edit">
                                <i class="fa-solid fa-pen text-xs"></i>
                            </button>
                            <form action="{{ route('line.destroy', $l->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');" class="inline">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-rose-50 text-rose-600 hover:bg-rose-100 hover:text-rose-700 border border-rose-200 rounded-lg text-xs font-semibold transition">
                                    <i class="fa-solid fa-trash text-xs"></i>

                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Modal Container -->
                    <div id="modal-edit-{{$l->id}}" class="fixed inset-0 z-50 hidden items-center justify-center p-4">

                        <div onclick="toggleModal('modal-edit-{{$l->id}}')" class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs transition-opacity"></div>
                        <div class="relative bg-white rounded-2xl shadow-xl border border-slate-100 w-full max-w-lg max-h-[90vh] flex flex-col overflow-hidden transform transition-all">

                            <!-- Header -->
                            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                                <h3 class="font-bold text-slate-800 text-base">Tambah Data Baru</h3>
                                <button
                                    type="button"
                                    onclick="toggleModal('modal-tambah')"
                                    class="p-1.5 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition">
                                    <i class="fa-solid fa-xmark text-sm w-4 h-4 flex items-center justify-center"></i>
                                </button>
                            </div>

                            <!-- Body / Form -->
                            <form method="POST" action="{{ route('line.update',$l->id) }}" enctype="multipart/form-data" class="flex flex-col flex-1 overflow-y-auto">
                                @csrf
                                @method('PUT')
                                <div class="p-6 space-y-4">
                                    <div>
                                        <label for="line" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Line Name</label>
                                        <input name="line" id="line" value="{{ old('line', $l->line) }}"
                                            class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-4 focus:ring-indigo-600/10 focus:border-indigo-600 transition" required />
                                    </div>

                                </div>

                                <!-- Footer Action -->
                                <div class="flex items-center justify-end px-6 py-4 bg-slate-50 border-t border-slate-100 mt-auto">
                                    <button
                                        type="submit"
                                        class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-medium shadow-sm transition">
                                        Simpan Data
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-6 flex justify-center">
                {{ $getLine->withQueryString()->links() }}
            </div>

            <!-- Modal Container -->
            <div id="modal-tambah" class="fixed inset-0 z-50 hidden items-center justify-center p-4">

                <div onclick="toggleModal('modal-tambah')" class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs transition-opacity"></div>
                <div class="relative bg-white rounded-2xl shadow-xl border border-slate-100 w-full max-w-lg max-h-[90vh] flex flex-col overflow-hidden transform transition-all">

                    <!-- Header -->
                    <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                        <h3 class="font-bold text-slate-800 text-base">Tambah Data Baru</h3>
                        <button
                            type="button"
                            onclick="toggleModal('modal-tambah')"
                            class="p-1.5 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition">
                            <i class="fa-solid fa-xmark text-sm w-4 h-4 flex items-center justify-center"></i>
                        </button>
                    </div>

                    <!-- Body / Form -->
                    <form method="POST" action="{{ route('line.store') }}" enctype="multipart/form-data" class="flex flex-col flex-1 overflow-y-auto">
                        @csrf
                        <div class="p-6 space-y-4">
                            <div>
                                <label for="line" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Line</label>
                                <input name="line" id="line" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-4 focus:ring-indigo-600/10 focus:border-indigo-600 transition" placeholder="Contoh: AS-0100/Delivery" required />
                            </div>


                        </div>

                        <!-- Footer Action -->
                        <div class="flex items-center justify-end gap-3 px-6 py-4 bg-slate-50 border-t border-slate-100 mt-auto">
                            <button
                                type="button"
                                onclick="toggleModal('modal-tambah')"
                                class="px-4 py-2 rounded-xl border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 text-xs font-medium transition">
                                Batal
                            </button>
                            <button
                                type="submit"
                                class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-medium shadow-sm transition">
                                Simpan Data
                            </button>
                        </div>
                    </form>

                </div>
            </div>

            <!-- JavaScript Handler -->
            <script>
                function toggleModal(id) {
                    const modal = document.getElementById(id);
                    if (!modal) return;

                    const isHidden = modal.classList.contains('hidden');
                    if (isHidden) {
                        modal.classList.remove('hidden');
                        modal.classList.add('flex');
                        document.body.classList.add('overflow-hidden');
                    } else {
                        modal.classList.add('hidden');
                        modal.classList.remove('flex');
                        document.body.classList.remove('overflow-hidden');
                    }
                }

                // Menutup modal dengan tombol ESC
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape') {
                        const openModal = document.querySelector('[id^="modal-"]:not(.hidden)');
                        if (openModal) {
                            toggleModal(openModal.id);
                        }
                    }
                });
            </script>
        </div>
    </div>

</main>

@include('layouts.footer')