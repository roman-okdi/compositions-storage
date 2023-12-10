<?php

namespace App\Http\Controllers;

use App\Models\Composer;
use Illuminate\Http\Request;

class ComposerController extends Controller
{
    public function index()
    {
        return Composer::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required'],
            'description' => ['required'],
        ]);

        return Composer::create($data);
    }

    public function show(Composer $composer)
    {
        return $composer;
    }

    public function update(Request $request, Composer $composer)
    {
        $data = $request->validate([
            'name' => ['required'],
            'description' => ['required'],
        ]);

        $composer->update($data);

        return $composer;
    }

    public function destroy(Composer $composer)
    {
        $composer->delete();

        return response()->json();
    }
}
