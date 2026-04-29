<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreTreatmentRequest extends FormRequest
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
            'treatment_name' => ['required', 'string', 'max:150'],
            'price' => ['required', 'numeric', 'min:0'],
            'employee_commission' => ['required', 'numeric', 'min:0', 'lte:price'],
            'description' => ['nullable', 'string'],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'price' => $this->normalizeCurrency($this->input('price')),
            'employee_commission' => $this->normalizeCurrency($this->input('employee_commission')),
        ]);
    }

    public function attributes(): array
    {
        return [
            'treatment_name' => 'nama treatment',
            'price' => 'harga treatment',
            'employee_commission' => 'komisi pegawai',
            'description' => 'deskripsi',
        ];
    }

    public function messages(): array
    {
        return [
            'treatment_name.required' => 'Nama treatment wajib diisi.',
            'treatment_name.string' => 'Nama treatment harus berupa teks.',
            'treatment_name.max' => 'Nama treatment maksimal 150 karakter.',
            'price.required' => 'Harga treatment wajib diisi.',
            'price.numeric' => 'Harga treatment harus berupa angka.',
            'price.min' => 'Harga treatment tidak boleh kurang dari 0.',
            'employee_commission.required' => 'Komisi pegawai wajib diisi.',
            'employee_commission.numeric' => 'Komisi pegawai harus berupa angka.',
            'employee_commission.min' => 'Komisi pegawai tidak boleh kurang dari 0.',
            'employee_commission.lte' => 'Komisi pegawai tidak boleh lebih besar dari harga treatment.',
            'description.string' => 'Deskripsi treatment harus berupa teks.',
        ];
    }

    private function normalizeCurrency(mixed $value): ?string
    {
        $normalized = preg_replace('/[^\d]/', '', (string) $value);

        return $normalized !== '' ? $normalized : null;
    }
}
