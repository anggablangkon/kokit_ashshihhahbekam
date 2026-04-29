<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePayrollRequest;
use App\Http\Requests\Admin\UpdatePayrollRequest;
use App\Models\Payroll;
use App\Models\User;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payrolls = Payroll::query()
            ->with('employee')
            ->orderByDesc('period_year')
            ->orderByDesc('period_month')
            ->latest()
            ->get();

        return view('admin.payrolls.index', $this->formData() + compact('payrolls'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('payrolls.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePayrollRequest $request)
    {
        Payroll::create($this->payload($request->validated(), true));

        return redirect()
            ->route('payrolls.index')
            ->with('success', 'Data payroll berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payroll $payroll)
    {
        return redirect()->route('payrolls.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payroll $payroll)
    {
        return redirect()->route('payrolls.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePayrollRequest $request, Payroll $payroll)
    {
        $payroll->update($this->payload($request->validated()));

        return redirect()
            ->route('payrolls.index')
            ->with('success', 'Data payroll berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payroll $payroll)
    {
        $payroll->delete();

        return redirect()
            ->route('payrolls.index')
            ->with('success', 'Data payroll berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function payload(array $validated, bool $isNew = false): array
    {
        $validated['grand_total'] = (float) $validated['basic_salary'] + (float) ($validated['total_commission'] ?? 0);
        $validated['payment_date'] = $validated['status'] === 'paid'
            ? $validated['payment_date']
            : null;
        $validated['updated_by'] = auth()->id();

        if ($isNew) {
            $validated['created_by'] = auth()->id();
        }

        return $validated;
    }

    /**
     * @return array<string, mixed>
     */
    private function formData(): array
    {
        return [
            'employees' => User::query()->orderBy('name')->get(['id', 'name']),
            'monthOptions' => [
                '01' => 'Januari',
                '02' => 'Februari',
                '03' => 'Maret',
                '04' => 'April',
                '05' => 'Mei',
                '06' => 'Juni',
                '07' => 'Juli',
                '08' => 'Agustus',
                '09' => 'September',
                '10' => 'Oktober',
                '11' => 'November',
                '12' => 'Desember',
            ],
        ];
    }
}
