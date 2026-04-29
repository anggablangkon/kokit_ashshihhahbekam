<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMedicalRecordRequest;
use App\Http\Requests\Admin\UpdateMedicalRecordRequest;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\User;

class MedicalRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medicalRecords = MedicalRecord::query()
            ->with(['patient', 'employee'])
            ->latest('treatment_date')
            ->latest()
            ->get();

        return view('admin.medical-records.index', $this->formData() + compact('medicalRecords'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('medical-records.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMedicalRecordRequest $request)
    {
        MedicalRecord::create($this->payload($request->validated()) + [
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

        return redirect()
            ->route('medical-records.index')
            ->with('success', 'Rekam medis berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(MedicalRecord $medicalRecord)
    {
        return redirect()->route('medical-records.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MedicalRecord $medicalRecord)
    {
        return redirect()->route('medical-records.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMedicalRecordRequest $request, MedicalRecord $medicalRecord)
    {
        $medicalRecord->update($this->payload($request->validated()) + [
            'updated_by' => auth()->id(),
        ]);

        return redirect()
            ->route('medical-records.index')
            ->with('success', 'Rekam medis berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MedicalRecord $medicalRecord)
    {
        $medicalRecord->delete();

        return redirect()
            ->route('medical-records.index')
            ->with('success', 'Rekam medis berhasil dihapus.');
    }

    /**
     * @return array<string, \Illuminate\Support\Collection<int, mixed>>
     */
    private function formData(): array
    {
        return [
            'patients' => Patient::query()->orderBy('name')->get(['id', 'name']),
            'employees' => User::query()->orderBy('name')->get(['id', 'name']),
        ];
    }

    /**
     * @param  array<string, mixed>  $validated
     * @return array<string, mixed>
     */
    private function payload(array $validated): array
    {
        $patient = Patient::withTrashed()->find($validated['patient_id']);
        $employee = User::find($validated['employee_id']);

        $validated['patient_name'] = $patient?->name;
        $validated['employee_name'] = $employee?->name;

        return $validated;
    }
}
