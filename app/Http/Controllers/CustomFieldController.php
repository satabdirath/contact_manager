<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomFieldController extends Controller
{
      public function index()
    {
        $fields = CustomField::all();
        return view('custom fields.index', compact('fields'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:text,number,date,textarea',
        ]);

        CustomField::create([
            'name' => $request->name,
            'type' => $request->type,
        ]);

        return redirect()->route('custom-fields.index')->with('success', 'Custom field added successfully.');
    }
}
