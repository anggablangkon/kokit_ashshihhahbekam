<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePayrollRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $payroll = $this->route('payroll');

        return [
            'employee_id' => [
                'required',
                'exists:users,id',
                Rule::unique('payrolls', 'employee_id')
                    ->ignore($payroll?->id)
                    ->where(fn ($query) => $query
                        ->where('period_month', $this->input('period_month'))
                        ->where('period_year', $this->input('period_year'))
                        ->whereNull('deleted_at')),
            ],
            'period_month' => ['required', 'string', Rule::in($this->monthOptions())],
            'period_year' => ['required', 'digits:4'],
            'basic_salary' => ['required', 'numeric', 'min:0'],
            'total_commission' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', Rule::in(['pending', 'paid'])],
            'payment_date' => ['nullable', 'date', 'required_if:status,paid'],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $periodMonth = $this->input('period_month');

        if ($periodMonth !== null && $periodMonth !== '') {
            $periodMonth = str_pad((string) $periodMonth, 2, '0', STR_PAD_LEFT);
        }

        $this->merge([
            'period_month' => $periodMonth,
            'period_year' => $this->input('period_year') !== null ? (string) $this->input('period_year') : null,
            'basic_salary' => $this->normalizeCurrency($this->input('basic_salary')),
            'total_commission' => $this->normalizeCurrency($this->input('total_commission')) ?? 0,
        ]);
    }

    public function attributes(): array
    {
        return [
            'employee_id' => 'pegawai',
            'period_month' => 'bulan periode',
            'period_year' => 'tahun periode',
            'basic_salary' => 'gaji pokok',
            'total_commission' => 'total komisi',
            'status' => 'status pembayaran',
            'payment_date' => 'tanggal pembayaran',
        ];
    }

    public function messages(): array
    {
        return [
            'employee_id.required' => 'Pegawai wajib dipilih.',
            'employee_id.exists' => 'Pegawai yang dipilih tidak ditemukan.',
            'employee_id.unique' => 'Payroll untuk pegawai pada periode tersebut sudah ada.',
            'period_month.required' => 'Bulan periode wajib dipilih.',
            'period_month.in' => 'Bulan periode yang dipilih tidak valid.',
            'period_year.required' => 'Tahun periode wajib diisi.',
            'period_year.digits' => 'Tahun periode harus terdiri dari 4 digit.',
            'basic_salary.required' => 'Gaji pokok wajib diisi.',
            'basic_salary.numeric' => 'Gaji pokok harus berupa angka.',
            'basic_salary.min' => 'Gaji pokok tidak boleh kurang dari 0.',
            'total_commission.numeric' => 'Total komisi harus berupa angka.',
            'total_commission.min' => 'Total komisi tidak boleh kurang dari 0.',
            'status.required' => 'Status pembayaran wajib dipilih.',
            'status.in' => 'Status pembayaran yang dipilih tidak valid.',
            'payment_date.required_if' => 'Tanggal pembayaran wajib diisi saat status payroll adalah paid.',
            'payment_date.date' => 'Tanggal pembayaran harus berupa tanggal yang valid.',
        ];
    }

    /**
     * @return array<int, string>
     */
    private function monthOptions(): array
    {
        return ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
    }

    private function normalizeCurrency(mixed $value): ?string
    {
        $normalized = preg_replace('/[^\d]/', '', (string) $value);

        return $normalized !== '' ? $normalized : null;
    }
}
