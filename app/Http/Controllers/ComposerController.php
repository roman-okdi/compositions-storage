<?php

namespace App\Http\Controllers;

use App\Models\Composer;
use Illuminate\Http\Request;

class ComposerController extends Controller
{
    public function index()
    {
        return Composer::with(['compositions'])->paginate();
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'description' => ['string', 'nullable'],
            'compositions' => ['array'],
            'compositions.*' => ['int']
        ]);
        $composer = Composer::create($data);
        if ($compositions = $request->compositions) {
            $composer->compositions()->sync($compositions, false);
        }
        $composer->load('compositions');
        return $composer;
    }

    public function get(Composer $composer)
    {
        return $composer->with('compositions');
    }

    public function update(Request $request, Composer $composer)
    {
        $data = $request->validate([
            'name' => ['string'],
            'description' => ['string', 'nullable'],
            'compositions' => ['array'],
            'compositions.*' => ['int'],
            'detach' => ['array'],
            'detach.*' => ['int'],
        ]);
        $composer->update($data);
        if ($compositions = $request->compositions) {
            $composer->compositions()->sync($compositions, false);
        }
        if ($detach = $request->detach) {
            $composer->compositions()->detach($detach);
        }
        $composer->load('compositions');
        return $composer;
    }

    public function delete(Composer $composer)
    {
        $composer->delete();
        return response()->noContent();
    }
}
