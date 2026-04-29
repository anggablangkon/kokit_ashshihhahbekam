<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePatientRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:150'],
            'phone' => ['required', 'digits_between:8,20'],
            'address' => ['nullable', 'string'],
            'birth_date' => ['required', 'date', 'before_or_equal:today'],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $phone = preg_replace('/\D+/', '', (string) $this->input('phone'));

        $this->merge([
            'phone' => $phone !== '' ? $phone : null,
        ]);
    }

    public function attributes(): array
    {
        return [
            'name' => 'nama pasien',
            'phone' => 'nomor telepon',
            'address' => 'alamat',
            'birth_date' => 'tanggal lahir',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama pasien wajib diisi.',
            'name.string' => 'Nama pasien harus berupa teks.',
            'name.max' => 'Nama pasien maksimal 150 karakter.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.digits_between' => 'Nomor telepon harus berisi 8 sampai 20 digit angka.',
            'address.string' => 'Alamat harus berupa teks yang valid.',
            'birth_date.required' => 'Tanggal lahir wajib diisi.',
            'birth_date.date' => 'Tanggal lahir harus berupa tanggal yang valid.',
            'birth_date.before_or_equal' => 'Tanggal lahir tidak boleh melebihi hari ini.',
        ];
    }
}
