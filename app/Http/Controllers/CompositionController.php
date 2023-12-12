<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCompositionRequest;
use App\Models\Composition;
use App\Models\CompositionFile;
use Illuminate\Http\Request;
use Storage;

class CompositionController extends Controller
{

    public function create(CreateCompositionRequest $request)
    {
        return $request->createComposition();
    }

    public function delete(Composition $composition)
    {
        $composition->deleteFiles();
        $composition->delete();
        return response()->noContent();
    }

    public function update(Composition $composition, Request $request)
    {
        $data = $request->validate([
            'name' => ['string'],
            'description' => ['string', 'nullable']
        ]);
        $composition->update($data);
        return $composition->load('files')->load('composers');
    }

    public function get(Composition $composition)
    {
        return $composition->load('files')->load('composers');
    }

    public function paging()
    {
        return Composition::with(['files', 'composers'])->paginate();
    }
}
