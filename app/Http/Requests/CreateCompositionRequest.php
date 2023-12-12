<?php

namespace App\Http\Requests;

use App\Models\Composition;
use App\Models\CompositionFile;
use Illuminate\Foundation\Http\FormRequest;
use Nette\Utils\Random;
use Storage;

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
            'description' => $this->description
        ]);
        $diskName = 'compositions';
        $disk = Storage::disk($diskName);
        foreach ($this->get('files') as $file) {
            $data = base64_decode($file['data']);
            $path = "$model->id/{$file['name']}";
            while ($disk->exists($path)) {
                $pattern = "/(.*)(\.\w+$)/";
                $random = Random::generate(4);
                $path = preg_replace($pattern, "$1_$random$2", $path);
            }
            if ($disk->put($path, $data)) {
                CompositionFile::create([
                    'disk' => $diskName,
                    'path' => $path,
                    'composition_id' => $model->id
                ]);
            }
        }
        return $model->load('files');
    }
}
