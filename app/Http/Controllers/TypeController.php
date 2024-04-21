<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    public function index(Request $request)
    {
        $types = Type::all();
        $selectedType = $request->type;
        return view('index', compact('types', 'selectedType'));
    }
}
