<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\CustomField;
use App\Models\CustomFieldValue;
use Illuminate\Support\Facades\Storage;

class ContactController extends Controller
{
 public function index(Request $request)
{
    $query = Contact::query();

    if ($request->has('name')) {
        $query->where('name', 'like', '%' . $request->name . '%');
    }
    if ($request->has('email')) {
        $query->where('email', 'like', '%' . $request->email . '%');
    }
    if ($request->has('gender') && $request->gender != '') {
        $query->where('gender', $request->gender);
    }

    $contacts = $query->with('customFieldValues.customField')->latest()->get();

    if ($request->ajax()) {
        return view('contacts.partials.list', compact('contacts'))->render();
    }

    return view('contacts.index', compact('contacts'));
}

    public function store(Request $request)
    {
        $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'nullable|email',
            'phone'             => 'nullable|string|max:20',
            'gender'            => 'nullable|in:Male,Female',
            'profile_image'     => 'nullable|image|mimes:jpg,jpeg,png',
            'additional_file'   => 'nullable|file|max:2048',
        ]);

        $data = $request->only(['name', 'email', 'phone', 'gender']);

        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $request->file('profile_image')->store('uploads', 'public');
        }

        if ($request->hasFile('additional_file')) {
            $data['additional_file'] = $request->file('additional_file')->store('uploads', 'public');
        }

        $contact = Contact::create($data);

        // Handle Custom Fields
        if ($request->custom_fields) {
            foreach ($request->custom_fields as $fieldId => $value) {
                CustomFieldValue::updateOrCreate(
                    ['contact_id' => $contact->id, 'custom_field_id' => $fieldId],
                    ['value' => $value]
                );
            }
        }

        return response()->json(['success' => true, 'message' => 'Contact created successfully']);
    }

    public function edit($id)
    {
        $contact = Contact::with('customFieldValues')->findOrFail($id);
        return response()->json($contact);
    }

    public function update(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);

        $data = $request->only(['name', 'email', 'phone', 'gender']);

        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $request->file('profile_image')->store('uploads', 'public');
        }

        if ($request->hasFile('additional_file')) {
            $data['additional_file'] = $request->file('additional_file')->store('uploads', 'public');
        }

        $contact->update($data);

        // Update Custom Fields
        if ($request->custom_fields) {
            foreach ($request->custom_fields as $fieldId => $value) {
                CustomFieldValue::updateOrCreate(
                    ['contact_id' => $contact->id, 'custom_field_id' => $fieldId],
                    ['value' => $value]
                );
            }
        }

        return response()->json(['success' => true, 'message' => 'Contact updated successfully']);
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);

        // Optional: delete files from storage
        if ($contact->profile_image) {
            Storage::disk('public')->delete($contact->profile_image);
        }

        if ($contact->additional_file) {
            Storage::disk('public')->delete($contact->additional_file);
        }

        $contact->delete();

        return response()->json(['success' => true, 'message' => 'Contact deleted successfully']);
    }

public function table(Request $request)
{
    $query = Contact::with('customFieldValues.customField');

    if ($request->filled('name')) {
        $query->where('name', 'like', '%' . $request->name . '%');
    }

    if ($request->filled('email')) {
        $query->where('email', 'like', '%' . $request->email . '%');
    }

    if ($request->filled('gender')) {
        $query->where('gender', $request->gender);
    }

    $contacts = $query->get();

    return view('contacts.partials.list', compact('contacts'));
}


}