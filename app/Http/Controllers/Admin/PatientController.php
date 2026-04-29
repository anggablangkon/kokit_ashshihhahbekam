<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePatientRequest;
use App\Http\Requests\Admin\UpdatePatientRequest;
use App\Models\Patient;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = Patient::query()
            ->withCount('medicalRecords')
            ->latest()
            ->get();

        return view('admin.patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('patients.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePatientRequest $request)
    {
        Patient::create($request->validated() + [
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

        return redirect()
            ->route('patients.index')
            ->with('success', 'Data pasien berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        return redirect()->route('patients.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        return redirect()->route('patients.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePatientRequest $request, Patient $patient)
    {
        $patient->update($request->validated() + [
            'updated_by' => auth()->id(),
        ]);

        return redirect()
            ->route('patients.index')
            ->with('success', 'Data pasien berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()
            ->route('patients.index')
            ->with('success', 'Data pasien berhasil dihapus.');
    }
}
