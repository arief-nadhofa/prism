<?php

namespace App\Http\Controllers;

use App\Models\Line;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class LineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Configuration Line';
        $getLine = Line::latest('id')->paginate('10');
        return view('pages.line.index', compact('title', 'getLine'));
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
            $exists = Line::where('line', $request->line)->exists();

            if (!$exists) {

                Line::create([
                    'line' => $request->line,
                    'created_at' => Carbon::now('Asia/Jakarta'),
                ]);

                // Redirect dengan pesan sukses
                return redirect()->back()->with('success', 'Line berhasil disimpan!');
            } else {
                return redirect()->back()->with('error', 'Line sudah terdaftar');
            }
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
        //
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
        try {
            // 2. Cari data berdasarkan ID
            $line = Line::findOrFail($id);

            $line->update([
                'line' => $request->line,
            ]);

            // 4. Redirect kembali dengan flash message success
            return redirect()->back()->with('success', 'Line berhasil diperbarui!');
        } catch (Exception $e) {
            // Tangkap error jika database bermasalah
            return redirect()->back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $line = Line::findOrFail($id);
            $line->delete();

            return redirect()->back()->with('success', 'Line berhasil dihapus!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
