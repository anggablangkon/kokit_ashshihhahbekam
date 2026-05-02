<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMedicalRecordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'total_cost' => $this->normalizeCurrency($this->input('total_cost')),
        ]);

        if ($this->has('treatments')) {
            $treatments = collect($this->input('treatments'))->map(function ($item) {
                $item['price'] = $this->normalizeCurrency($item['price'] ?? null);
                $item['discount'] = $this->normalizeCurrency($item['discount'] ?? 0) ?? 0;

                return $item;
            })->toArray();

            $this->merge(['treatments' => $treatments]);
        }
    }

    public function rules(): array
    {
        return [
            'patient_id' => ['required', 'exists:patients,id'],
            'employee_id' => ['required', 'exists:users,id'],
            'treatment_date' => ['required', 'date'],
            'complaint' => ['nullable', 'string'],
            'total_cost' => ['required', 'numeric', 'min:0'],
            'treatments' => ['required', 'array', 'min:1'],
            'treatments.*.name' => ['required', 'string', 'max:255'],
            'treatments.*.qty' => ['required', 'integer', 'min:1'],
            'treatments.*.price' => ['required', 'numeric', 'min:0'],
            'treatments.*.discount' => ['nullable', 'numeric', 'min:0'],
        ];
    }

    public function attributes(): array
    {
        return [
            'patient_id' => 'pasien',
            'employee_id' => 'pegawai',
            'complaint' => 'keluhan',
            'total_cost' => 'total biaya',
            'treatment_date' => 'tanggal treatment',
            'treatments' => 'detail layanan',
        ];
    }

    public function messages(): array
    {
        return [
            'patient_id.required' => 'Pasien wajib dipilih.',
            'patient_id.exists' => 'Pasien yang dipilih tidak ditemukan.',
            'employee_id.required' => 'Pegawai wajib dipilih.',
            'employee_id.exists' => 'Pegawai yang dipilih tidak ditemukan.',
            'complaint.string' => 'Keluhan harus berupa teks.',
            'total_cost.required' => 'Total biaya wajib diisi.',
            'total_cost.numeric' => 'Total biaya harus berupa angka.',
            'total_cost.min' => 'Total biaya tidak boleh kurang dari 0.',
            'treatment_date.required' => 'Tanggal treatment wajib diisi.',
            'treatment_date.date' => 'Tanggal treatment harus berupa tanggal yang valid.',
            'treatments.required' => 'Minimal satu layanan wajib diisi.',
        ];
    }

    private function normalizeCurrency(mixed $value): ?string
    {
        $normalized = preg_replace('/[^\d]/', '', (string) $value);

        return $normalized !== '' ? $normalized : null;
    }
}
