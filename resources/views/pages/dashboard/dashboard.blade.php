@include('layouts.header')
<!-- MAIN BODY / CONTENT -->
<main class="flex-1 p-4 lg:p-8 space-y-6">

    <!-- STATS CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-2 gap-4">

        <!-- Card 4 -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Problem</p>
                <p class="text-2xl font-bold text-slate-900 mt-1">14</p>

            </div>
            <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
                <i class="fa-solid fa-triangle-exclamation text-lg"></i>
            </div>
        </div>
        <!-- Card 4 -->

        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Problem Selesai</p>
                <p class="text-2xl font-bold text-slate-900 mt-1">14</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-green-100 text-green-400 flex items-center justify-center">
                <i class="fa-solid fa-check text-base w-5 text-center"></i>
            </div>

        </div>
        <!-- Card 4 -->


    </div>

    <!-- TABLE / DATA SECTION -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <div>
                <h3 class="font-bold text-slate-900 text-base">Log Problem Terbaru</h3>
                <p class="text-xs text-slate-500 mt-0.5">Daftar transaksi yang baru saja diproses sistem</p>
            </div>
            <button class="px-3.5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-medium transition shadow-sm">
                Unduh Rekap
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50/75 border-b border-slate-100 text-xs uppercase font-semibold text-slate-500 tracking-wider">
                    <tr>
                        <th class="px-6 py-3.5">No.</th>
                        <th class="px-6 py-3.5">Line</th>
                        <th class="px-6 py-3.5">Problem</th>
                        <th class="px-6 py-3.5">Status</th>
                        <th class="px-6 py-3.5">Created</th>
                        <th class="px-6 py-3.5">Solved</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">

                    <tr class="hover:bg-slate-50/60 transition">
                        <td class="px-6 py-4 font-semibold text-slate-900">1</td>
                        <td class="px-6 py-4 font-medium text-slate-800">Budi Pratama</td>
                        <td class="px-6 py-4">Rp 850.000</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-rose-50 text-rose-700 border border-rose-200">
                                Gagal
                            </span>
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-500">3 Jam lalu</td>
                        <td class="px-6 py-4 text-xs text-slate-500">3 Jam lalu</td>
                        <td class="px-6 py-4 text-right">

                            <a href="#" class="inline-flex items-center px-2 py-2 bg-green-600 hover:bg-green-700 active:scale-95 text-white text-xs font-medium rounded-md shadow-sm transition duration-150 ease-in-out" title="Detail">
                                <i class="fa-solid fa-check text-xs"></i>
                            </a>
                            <a href="#" class="inline-flex items-center px-2 py-2 bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white text-xs font-medium rounded-md shadow-sm transition duration-150 ease-in-out" title="Detail">
                                <i class="fa-solid fa-eye text-xs"></i>
                            </a>
                            <a href="#" class="inline-flex items-center px-2 py-2 bg-red-600 hover:bg-red-700 active:scale-95 text-white text-xs font-medium rounded-md shadow-sm transition duration-150 ease-in-out" title="Delete">
                                <i class="fa-solid fa-trash text-xs"></i>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</main>

@include('layouts.footer')