<?php

namespace App\Http\Requests;

use App\Models\Composition;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $name
 * @property ?string $description
 * @property ?array files
 */
class CreateCompositionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'description' => ['string'],
            'files' => ['array'],
            'files.*.name' => ['required', 'string'],
            'files.*.data' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function createComposition(): Composition
    {
        $model = Composition::create([
            'name' => $this->name,
            'description' => $this->description,
        ]);
        $model->composers->append(3);
        if ($files = $this->get('files')) {
            foreach ($files as $file) {
                $model->saveFile($file['name'], base64_decode($file['data']));
            }
        }
        return $model->loadAllDependencies();
    }
}
