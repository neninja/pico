<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArtifactRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'catalog_id' => ['required', 'exists:catalogs,id'],
            'title' => ['required', 'string', 'max:20'],
            'order' => ['required', 'integer', 'gt:0'],
        ];
    }
}
