<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class TestimonialController extends Controller
{
    // Tampilkan semua testimonial
    public function index()
    {
        $testimonials = Testimonial::orderBy('created_at', 'desc')->get();
        return view('admin.testimonial.index', compact('testimonials'));
    }

    // Tampilkan form tambah testimonial
    public function create()
    {
        return view('testimonial.create');
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'pesan' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'rating' => 'required|integer|min:1|max:5',  
        ]);


        if ($request->hasFile('foto')) {
            $imageFile = $request->file('foto');
            $img = Image::make($imageFile->getRealPath());
            $img->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $filename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            $webpName = $filename . '-' . time() . '.webp';
            $path = public_path('testimonial');
            // Pastikan folder testimonial ada, jika belum buat
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
            $img->encode('webp', 90)->save($path . '/' . $webpName);
            $validatedData['foto'] = 'testimonial/' . $webpName;
        } else {
            $validatedData['foto'] = null;
        }


        $validatedData['judul'] = '-';
        $validatedData['cby'] = Auth::id();
        $validatedData['mby'] = Auth::id();

        Testimonial::create($validatedData);

        return redirect()->route('testimoni.index')->with('success', 'Testimoni berhasil disimpan dengan gambar WebP');
    }


    // Tampilkan form edit testimonial
    public function edit($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        return view('testimonial.edit', compact('testimonial'));
    }

    // Update testimonial
    public function update(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'foto' => 'nullable|image|max:2048',
            'rating' => 'required|integer|min:1|max:5',
            'pesan' => 'required|string',
        ]);

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($testimonial->foto && Storage::disk('public')->exists($testimonial->foto)) {
                Storage::disk('public')->delete($testimonial->foto);
            }
            $path = $request->file('foto')->store('testimonial', 'public');
            $validated['foto'] = $path;
        }

        // Update kolom pengubah
        $validated['mby'] = Auth::id();

        $testimonial->update($validated);

        return redirect()->route('testimoni.index')->with('success', 'Testimoni berhasil diperbarui');
    }

    // Hapus testimonial (soft delete)
    public function destroy($id)
    {
        $testimonial = Testimonial::findOrFail($id);

        // Hapus file foto jika ada
        if ($testimonial->foto && Storage::disk('public')->exists($testimonial->foto)) {
            Storage::disk('public')->delete($testimonial->foto);
        }

        $testimonial->delete();

        return redirect()->route('testimoni.index')->with('success', 'Testimoni berhasil dihapus');
    }
}
