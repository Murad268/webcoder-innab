<?php

namespace Modules\About\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AboutRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'icon' => 'file|mimetypes:image/svg+xml'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages()
    {
        return [
            'icon.file' => 'İkon faylı düzgün yüklənməyib.',
            'icon.mimetypes' => 'İkon faylı yalnız SVG formatında olmalıdır.',
        ];
    }
}
