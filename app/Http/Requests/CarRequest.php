<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CarRequest extends FormRequest
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
        if ($this->method() === 'POST') {
            return $this->store();
        }
        return $this->update();
    }

    private function store(): array
    {
        return [
            'merk' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'photo' => 'max:100|string|nullable',
            'plat_number' => 'required|string|unique:cars,plat_number',
            'rental_fee' => 'integer|min:0',
            'is_rent' => 'integer|min:0',
        ];
    }
    private function update(): array
    {
        return [
            'merk' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'photo' => 'max:100|string|nullable',
            'plat_number' => 'required|string|unique:cars,plat_number,' . $this->car,
            'rental_fee' => 'integer|min:0',
            'is_rent' => 'integer|min:0',
        ];
    }
}
