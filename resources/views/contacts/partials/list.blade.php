<table class="table table-bordered">
    <thead>
        <tr>
            <th>Name</th><th>Email</th><th>Phone</th><th>Gender</th><th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($contacts as $contact)
        <tr>
            <td>{{ $contact->name }}</td>
            <td>{{ $contact->email }}</td>
            <td>{{ $contact->phone }}</td>
            <td>{{ $contact->gender }}</td>
            <td>
                <button class="btn btn-sm btn-info editBtn" data-id="{{ $contact->id }}">Edit</button>
                <button class="btn btn-sm btn-danger deleteBtn" data-id="{{ $contact->id }}">Delete</button>
            </td>
        </tr>
        @empty
        <tr><td colspan="5">No contacts found.</td></tr>
        @endforelse
    </tbody>
</table>
