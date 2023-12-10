<?php

namespace App\Http\Controllers;

use App\Models\Composition;
use Illuminate\Http\Request;

class CompositionController extends Controller
{
    public function index()
    {
        return Composition::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required'],
            'description' => ['required'],
        ]);

        return Composition::create($data);
    }

    public function show(Composition $composition)
    {
        return $composition;
    }

    public function update(Request $request, Composition $composition)
    {
        $data = $request->validate([
            'name' => ['required'],
            'description' => ['required'],
        ]);

        $composition->update($data);

        return $composition;
    }

    public function destroy(Composition $composition)
    {
        $composition->delete();

        return response()->json();
    }
}
