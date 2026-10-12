<?php

namespace App\Http\Requests\Kalkulator;

use Illuminate\Foundation\Http\FormRequest;

class ZakatFitrahRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'jumlah_jiwa' => ['required', 'integer', 'min:1'],
            'harga_beras_override' => ['nullable', 'integer', 'min:1'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'jumlah_jiwa.required' => 'Jumlah jiwa wajib diisi.',
            'jumlah_jiwa.integer' => 'Jumlah jiwa harus berupa angka.',
            'jumlah_jiwa.min' => 'Jumlah jiwa minimal 1.',
            'harga_beras_override.integer' => 'Harga beras harus berupa angka.',
            'harga_beras_override.min' => 'Harga beras minimal 1.',
        ];
    }
}