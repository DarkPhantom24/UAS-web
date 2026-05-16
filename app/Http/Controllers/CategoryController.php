<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        Gate::authorize('edit-pengguna'); // Hanya admin

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create($validated);

        return redirect()->route('admin.pengaturan')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function update(Request $request, Category $category)
    {
        Gate::authorize('edit-pengguna'); // Hanya admin

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        $category->update($validated);

        return redirect()->route('admin.pengaturan')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(Category $category)
    {
        Gate::authorize('destroy-pengguna'); // Hanya admin

        // Cek apakah kategori masih digunakan
        if ($category->ewasteRequests()->count() > 0) {
            return redirect()->route('admin.pengaturan')->with('error', 'Kategori tidak dapat dihapus karena masih digunakan!');
        }

        $category->delete();

        return redirect()->route('admin.pengaturan')->with('success', 'Kategori berhasil dihapus!');
    }
}
