<?php

namespace App\Http\Requests\BerasPrice;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBerasPriceRequest extends FormRequest
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
            'price' => ['required', 'integer', 'min:1000'],
            'note' => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'price.required' => 'Harga beras wajib diisi.',
            'price.integer' => 'Harga beras harus berupa angka.',
            'price.min' => 'Harga beras minimal 1000.',
        ];
    }
}