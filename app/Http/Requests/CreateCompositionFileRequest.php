<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $name
 * @property $data
 * @property int $composition_id
 */
class CreateCompositionFileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            '*.name' => ['required', 'string'],
            '*.data' => ['required']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
