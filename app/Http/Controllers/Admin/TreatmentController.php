<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTreatmentRequest;
use App\Http\Requests\Admin\UpdateTreatmentRequest;
use App\Models\Treatment;

class TreatmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $treatments = Treatment::query()
            ->latest()
            ->get();

        return view('admin.treatments.index', compact('treatments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('treatments.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTreatmentRequest $request)
    {
        Treatment::create($request->validated() + [
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

        return redirect()
            ->route('treatments.index')
            ->with('success', 'Data treatment berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Treatment $treatment)
    {
        return redirect()->route('treatments.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Treatment $treatment)
    {
        return redirect()->route('treatments.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTreatmentRequest $request, Treatment $treatment)
    {
        $treatment->update($request->validated() + [
            'updated_by' => auth()->id(),
        ]);

        return redirect()
            ->route('treatments.index')
            ->with('success', 'Data treatment berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Treatment $treatment)
    {
        $treatment->delete();

        return redirect()
            ->route('treatments.index')
            ->with('success', 'Data treatment berhasil dihapus.');
    }
}
