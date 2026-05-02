<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMedicalRecordRequest;
use App\Http\Requests\Admin\UpdateMedicalRecordRequest;
use App\Models\MedicalRecord;
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
                $this->saveMedicalRecord(null, $validated);
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
        DB::transaction(function () use ($medicalRecord, $request) {
            $this->saveMedicalRecord($medicalRecord, $request->validated());
        });

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
            'patients' => Patient::query()->orderBy('name')->get(['id', 'name', 'phone']),
            'employees' => User::query()->orderBy('name')->get(['id', 'name']),
        ];
    }

    /**
     * @param  array<string, mixed>  $validated
     * @return array<string, mixed>
     */
    private function saveMedicalRecord(?MedicalRecord $medicalRecord, array $validated): MedicalRecord
    {
        $payload = [
            'patient_id' => $validated['patient_id'],
            'employee_id' => $validated['employee_id'],
            'treatment_date' => $validated['treatment_date'],
            'complaint' => $validated['complaint'] ?? null,
            'total_cost' => $validated['total_cost'],
            'updated_by' => auth()->id(),
        ];

        if ($medicalRecord) {
            $medicalRecord->update($payload);
            $medicalRecord->items()->delete();
        } else {
            $medicalRecord = MedicalRecord::create($payload + [
                'created_by' => auth()->id(),
            ]);
        }

        foreach ($validated['treatments'] as $item) {
            $originalName = trim($item['name']);
            $searchName = strtolower($originalName);
            $treatment = Treatment::whereRaw('LOWER(treatment_name) = ?', [$searchName])->first();
            $discount = $item['discount'] ?? 0;
            $subtotal = max(0, ($item['qty'] * $item['price']) - $discount);

            $medicalRecord->items()->create([
                'treatment_id' => $treatment?->id,
                'treatment_name' => $originalName,
                'qty' => $item['qty'],
                'price' => $item['price'],
                'commission' => $treatment?->employee_commission ?? 0,
                'discount' => $discount,
                'subtotal' => $subtotal,
                'created_by' => auth()->id(),
            ]);
        }

        return $medicalRecord;
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
