<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\CustomField;
use App\Models\CustomFieldValue;
use Illuminate\Support\Facades\Storage;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::with('customFieldValues.customField')->get();
        $customFields = CustomField::all();

        return view('contacts.index', compact('contacts', 'customFields'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|in:Male,Female,Other',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png',
            'additional_file' => 'nullable|file|max:2048',
        ]);

        $data = $request->only(['name', 'email', 'phone', 'gender']);

        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $request->file('profile_image')->store('uploads');
        }

        if ($request->hasFile('additional_file')) {
            $data['additional_file'] = $request->file('additional_file')->store('uploads');
        }

        $contact = Contact::create($data);

        // Handle Custom Fields
        if ($request->custom_fields) {
            foreach ($request->custom_fields as $field_id => $value) {
                CustomFieldValue::create([
                    'contact_id' => $contact->id,
                    'custom_field_id' => $field_id,
                    'value' => $value,
                ]);
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
            $data['profile_image'] = $request->file('profile_image')->store('uploads');
        }

        if ($request->hasFile('additional_file')) {
            $data['additional_file'] = $request->file('additional_file')->store('uploads');
        }

        $contact->update($data);

        // Update Custom Fields
        if ($request->custom_fields) {
            foreach ($request->custom_fields as $field_id => $value) {
                CustomFieldValue::updateOrCreate(
                    ['contact_id' => $contact->id, 'custom_field_id' => $field_id],
                    ['value' => $value]
                );
            }
        }

        return response()->json(['success' => true, 'message' => 'Contact updated successfully']);
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return response()->json(['success' => true, 'message' => 'Contact deleted successfully']);
    }
}
