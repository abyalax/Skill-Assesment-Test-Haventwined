<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyProfileUpdateRequest extends FormRequest {
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array {
        return [
            'name' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'email' => [
                'nullable',
                'string',
                'lowercase',
                'max:255',
                Rule::unique('company_profiles', 'email')->ignore($this->route('companyProfile'))
            ],
            'whatsapp' => ['nullable', 'string', 'max:20', 'regex:/^\+?[0-9]+$/'],
            'banner' => ['nullable', 'array'],
            'banner.*' => ['string', 'url'], // Pastikan URL yang valid
            'banner_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // Opsional jika banner berupa gambar
        ];
    }
}
