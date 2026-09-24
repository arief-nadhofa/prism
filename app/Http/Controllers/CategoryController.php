<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Configuration Category';
        $getCategory = Category::latest('id')->paginate('10');
        return view('pages.category.index', compact('title', 'getCategory'));
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
            Category::create([
                'category'        => $request->category,
                'created_at' => Carbon::now('Asia/Jakarta'),
            ]);

            // Redirect dengan pesan sukses
            return redirect()->back()->with('success', 'Category berhasil disimpan!');
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
            $category = Category::findOrFail($id);

            // 3. Update data kolom category
            $category->update([
                'category' => $request->category,
            ]);

            // 4. Redirect kembali dengan flash message success
            return redirect()->back()->with('success', 'Data kategori berhasil diperbarui!');
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
            $category = Category::findOrFail($id);
            $category->delete();

            return redirect()->back()->with('success', 'Data kategori berhasil dihapus!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
