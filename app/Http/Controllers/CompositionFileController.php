<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCompositionFileRequest;
use App\Models\Composition;
use App\Models\CompositionFile;
use Storage;

class CompositionFileController extends Controller
{
    public function index(CompositionFile $file)
    {
        return Storage::disk($file->disk)->get($file->path);
    }

    public function getAll(Composition $composition) {
        return $composition->files;
    }

    public function create(Composition $composition, CreateCompositionFileRequest $request)
    {
        $files = [];
        foreach ($request->toArray() as $file) {
            if ($file = $composition->saveFile($file['name'], base64_decode($file['data']))) {
                $files []= $file;
            }
        }
        return $files;
    }

    public function delete(CompositionFile $file)
    {
        Storage::disk($file->disk)->delete($file->path);
        $file->delete();
        return response()->noContent();
    }
}
