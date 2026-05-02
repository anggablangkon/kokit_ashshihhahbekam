<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMedicalRecordRequest;
use App\Http\Requests\Admin\UpdateMedicalRecordRequest;
use App\Models\MedicalRecord;
use App\Models\MedicalRecordItem;
use App\Models\Patient;
use App\Models\Treatment;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class MedicalRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Menggunakan Eager Loading untuk 'items', 'patient', dan 'employee'
        // agar pengambilan data detail layanan tidak memperberat database.
        $medicalRecords = MedicalRecord::query()
            ->with([
                'patient', 
                'employee', 
                'items' // Tambahkan ini agar ringkasan layanan bisa muncul di tabel
            ])
            ->latest('treatment_date')
            ->latest()
            ->get();

        // Data treatments untuk datalist pada modal tambah/edit
        $treatments = Treatment::select('id', 'treatment_name as name', 'price')
            ->orderBy('name')
            ->get();

        return view('admin.medical-records.index', array_merge(
            $this->formData(), 
            compact('medicalRecords', 'treatments')
        ));
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
        $validated = $request->validated();

        try {
            DB::transaction(function () use ($validated) {
                // 1. Simpan Header
                $medicalRecord = MedicalRecord::create([
                    'patient_id'     => $validated['patient_id'],
                    'employee_id'    => $validated['employee_id'],
                    'treatment_date' => $validated['treatment_date'],
                    'complaint'      => $validated['complaint'],
                    'total_cost'     => $validated['total_cost'],
                    'created_by'     => auth()->id(),
                    'updated_by'     => auth()->id(),
                ]);

                // 2. Simpan Detail Items
                foreach ($validated['treatments'] as $item) {
                    $medicalRecord->items()->create([
                        'treatment_name' => $item['name'],
                        'qty'            => $item['qty'],
                        'price'          => $item['price'],
                        'discount'       => $item['discount'],
                        'subtotal'       => ($item['qty'] * $item['price']) - $item['discount'],
                        'created_by'     => auth()->id(),
                    ]);
                }
            });

            return redirect()
                ->route('medical-records.index')
                ->with('success', 'Rekam medis berhasil ditambahkan.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
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

    public function downloadInvoice($id)
    {
        $medicalRecord = MedicalRecord::with(['patient', 'employee', 'items'])
            ->findOrFail($id);

        $pdf = Pdf::loadView('admin.medical-records.invoice', compact('medicalRecord'))
                ->setPaper('a4', 'portrait');

        return $pdf->stream('Invoice-' . $medicalRecord->id . '.pdf');
    }
}
