@extends('layouts.app')
@section('content')
<div class="container">
    <h4>Manage Custom Fields</h4>
    <form method="POST" action="{{ route('custom-fields.store') }}">
        @csrf
        <input type="text" name="name" placeholder="Field Name" required>
        <select name="type">
            <option value="text">Text</option>
            <option value="number">Number</option>
            <option value="date">Date</option>
        </select>
        <button type="submit">Add Field</button>
    </form>

    <ul>
        @foreach ($fields as $field)
            <li>{{ $field->name }} ({{ $field->type }})</li>
        @endforeach
    </ul>
</div>

@endsection
