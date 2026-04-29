<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMedicalRecordRequest extends FormRequest
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
        return [
            'patient_id' => ['required', 'exists:patients,id'],
            'employee_id' => ['required', 'exists:users,id'],
            'complaint' => ['required', 'string'],
            'action_details' => ['required', 'string'],
            'total_cost' => ['required', 'numeric', 'min:0'],
            'treatment_date' => ['required', 'date'],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'total_cost' => $this->normalizeCurrency($this->input('total_cost')),
        ]);
    }

    public function attributes(): array
    {
        return [
            'patient_id' => 'pasien',
            'employee_id' => 'pegawai',
            'complaint' => 'keluhan',
            'action_details' => 'tindakan',
            'total_cost' => 'total biaya',
            'treatment_date' => 'tanggal treatment',
        ];
    }

    public function messages(): array
    {
        return [
            'patient_id.required' => 'Pasien wajib dipilih.',
            'patient_id.exists' => 'Pasien yang dipilih tidak ditemukan.',
            'employee_id.required' => 'Pegawai wajib dipilih.',
            'employee_id.exists' => 'Pegawai yang dipilih tidak ditemukan.',
            'complaint.required' => 'Keluhan wajib diisi.',
            'complaint.string' => 'Keluhan harus berupa teks.',
            'action_details.required' => 'Tindakan wajib diisi.',
            'action_details.string' => 'Tindakan harus berupa teks.',
            'total_cost.required' => 'Total biaya wajib diisi.',
            'total_cost.numeric' => 'Total biaya harus berupa angka.',
            'total_cost.min' => 'Total biaya tidak boleh kurang dari 0.',
            'treatment_date.required' => 'Tanggal treatment wajib diisi.',
            'treatment_date.date' => 'Tanggal treatment harus berupa tanggal yang valid.',
        ];
    }

    private function normalizeCurrency(mixed $value): ?string
    {
        $normalized = preg_replace('/[^\d]/', '', (string) $value);

        return $normalized !== '' ? $normalized : null;
    }
}
