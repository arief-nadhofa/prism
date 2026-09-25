<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Line;
use App\Models\LogProblem;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use App\Exports\ProblemLogExport;
use Maatwebsite\Excel\Facades\Excel;

class ProblemLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = 'Problem Log';

        $request->validate([
            'search' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $query = LogProblem::with([
            'lineDetail',
            'categoryDetail'
        ]);

        // SEARCH
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('problem', 'like', "%{$search}%")

                    ->orWhereHas('lineDetail', function ($q) use ($search) {
                        $q->where('line', 'like', "%{$search}%");
                    })

                    ->orWhereHas('categoryDetail', function ($q) use ($search) {
                        $q->where('category', 'like', "%{$search}%");
                    });
            });
        }

        // FILTER TANGGAL AWAL
        if ($request->filled('start_date')) {

            $query->whereDate(
                'start_problem',
                '>=',
                $request->start_date
            );
        }

        // FILTER TANGGAL AKHIR
        if ($request->filled('end_date')) {

            $query->whereDate(
                'start_problem',
                '<=',
                $request->end_date
            );
        }

        $getProblem = $query
            ->orderByDesc('start_problem')
            ->paginate(10)
            ->withQueryString();




        $getCategory = Category::all();
        $getLine = Line::all();


        return view('pages.problem-log.index', compact('title', 'getProblem', 'getCategory', 'getLine'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // $exists = LogProblem::where('line', $request->line)->exists();
            $username = session('username');
            $name = session('name');
            $npk = session('npk');

            LogProblem::create([
                'npk' => $npk,
                'problem' => $request->problem,
                'category' => $request->category,
                'line' => $request->line,
                'status' => 0,
                'start_problem' => $request->start_problem,
                'created_by' => $npk,
                'created_at' => Carbon::now('Asia/Jakarta'),
            ]);

            // Redirect dengan pesan sukses
            return redirect()->back()->with('success', 'Problem berhasil di record!');
        } catch (Exception $e) {
            // Redirect dengan pesan error jika database/proses gagal
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $problem = LogProblem::with(['lineDetail', 'categoryDetail'])->findOrFail($id);
        $title = 'Detail & Penyelesaian Problem #' . $problem->id;

        return view('pages.problem-log.show', compact('problem', 'title'));
    }

    public function closeProblem(Request $request, $id)
    {
        $request->validate([
            'countermeasure' => 'required|string',
            'finish_problem' => 'required|date',
        ], [
            'countermeasure.required' => 'Tindakan penanganan (countermeasure) wajib diisi.',
            'finish_problem.required' => 'Waktu selesai problem wajib diisi.',
        ]);

        try {
            $problem = LogProblem::findOrFail($id);

            // Waktu mulai (gunakan start_problem jika ada, jika tidak pakai created_at)
            $startTime = $problem->start_problem ? Carbon::parse($problem->start_problem) : Carbon::parse($problem->created_at);
            $finishTime = Carbon::parse($request->finish_problem);

            // Hitung durasi (Contoh: "1 jam 20 menit" atau "45 menit")
            $durationMinutes = $startTime->diffInMinutes($finishTime);
            $hours = intdiv($durationMinutes, 60);
            $mins = $durationMinutes % 60;
            $durationString = ($hours > 0 ? "{$hours} Jam " : "") . "{$mins} Menit";

            $problem->update([
                'countermeasure' => $request->countermeasure,
                'finish_problem' => $finishTime,
                'duration'       => $durationString,
                'status'         => 1, // Status 1 = Solved / Closed
            ]);

            return redirect()->route('problem-log.show', $problem->id)
                ->with('success', 'Problem report berhasil diselesaikan dan di-close!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Gagal menutup problem: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }


    public function export(Request $request)
    {
        $filters = $request->validate([
            'search' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $filename = 'Problem_Log_' .
            now('Asia/jakarta')->format('Ymd_His') .
            '.xlsx';

        return Excel::download(
            new ProblemLogExport($filters),
            $filename
        );
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $problem = LogProblem::findOrFail($id);
            $problem->delete();

            return redirect()->back()->with('success', 'Log Problem berhasil dihapus!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
