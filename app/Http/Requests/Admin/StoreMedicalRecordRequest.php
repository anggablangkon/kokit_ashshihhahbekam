<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreMedicalRecordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        // Bersihkan total_cost
        $this->merge([
            'total_cost' => $this->normalizeCurrency($this->input('total_cost')),
        ]);

        // Bersihkan harga & diskon di setiap item treatment
        if ($this->has('treatments')) {
            $treatments = collect($this->input('treatments'))->map(function ($item) {
                $item['price'] = $this->normalizeCurrency($item['price']);
                $item['discount'] = $this->normalizeCurrency($item['discount'] ?? 0) ?? 0;
                return $item;
            })->toArray();

            $this->merge(['treatments' => $treatments]);
        }
    }

    public function rules(): array
    {
        return [
            'patient_id'            => 'required|exists:patients,id',
            'employee_id'           => 'required|exists:users,id',
            'treatment_date'        => 'required|date',
            'complaint'             => 'nullable|string',
            'total_cost'            => 'required|numeric|min:0',
            'treatments'            => 'required|array|min:1',
            'treatments.*.name'     => 'required|string|max:255',
            'treatments.*.qty'      => 'required|integer|min:1',
            'treatments.*.price'    => 'required|numeric|min:0',
            'treatments.*.discount' => 'nullable|numeric|min:0',
        ];
    }

    private function normalizeCurrency(?string $value): ?string
    {
        $normalized = preg_replace('/[^\d]/', '', (string) $value);
        return $normalized !== '' ? $normalized : null;
    }
}