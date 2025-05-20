<table class="table table-bordered">
    <thead>
        <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Gender</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($contacts as $contact)
        <tr>
            <td>
                @if($contact->profile_image)
                    <img src="{{ asset('storage/app/public/' . $contact->profile_image) }}" width="50" height="50" style="object-fit: cover; border-radius: 5px;">
                @else
                    N/A
                @endif
            </td>
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
        <tr>
            <td colspan="6">No contacts found.</td>
        </tr>
        @endforelse
    </tbody>
</table>
