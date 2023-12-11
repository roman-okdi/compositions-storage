<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCompositionRequest;
use App\Models\Composition;
use Illuminate\Http\Request;

class CompositionController extends Controller
{

    public function create(CreateCompositionRequest $request)
    {
        return $request->createComposition();
    }
}
