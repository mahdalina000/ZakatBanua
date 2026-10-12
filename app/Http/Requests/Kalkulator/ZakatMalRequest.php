<?php

namespace App\Http\Requests\Kalkulator;

use Illuminate\Foundation\Http\FormRequest;

class ZakatMalRequest extends FormRequest
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
            'total_harta' => ['required', 'integer', 'min:0'],
            'harga_emas_per_gram' => ['nullable', 'integer', 'min:1'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'total_harta.required' => 'Total harta wajib diisi.',
            'total_harta.integer' => 'Total harta harus berupa angka.',
            'total_harta.min' => 'Total harta tidak boleh negatif.',
            'harga_emas_per_gram.integer' => 'Harga emas harus berupa angka.',
            'harga_emas_per_gram.min' => 'Harga emas minimal 1.',
        ];
    }
}