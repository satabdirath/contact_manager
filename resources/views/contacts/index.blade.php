@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Contacts</h4>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#contactModal" id="addContactBtn">
            Add Contact
        </button>
    </div>

    <!-- Filter Form (Above Contact Table) -->
    <div class="card mb-3">
        <div class="card-body">
            <form id="filterForm" class="row g-2">
                <div class="col-md-3">
                    <input type="text" name="name" class="form-control" placeholder="Filter by Name">
                </div>
                <div class="col-md-3">
                    <input type="text" name="email" class="form-control" placeholder="Filter by Email">
                </div>
                <div class="col-md-3">
                    <select name="gender" class="form-select">
                        <option value="">All Genders</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Contact List -->
    <div id="contactList">
        @include('contacts.partials.list')
    </div>
</div>

@include('contacts.partials.contact-modal')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    const BASE_URL = "{{ url('/') }}"; // Laravel base URL

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Submit Contact Form (Add/Update)
    $('#contactForm').on('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(this);
        let contactId = $('#contact_id').val();
        let method = 'POST';
        let url = contactId ? `${BASE_URL}/contacts/${contactId}` : `${BASE_URL}/contacts`;

        if (contactId) {
            formData.append('_method', 'PUT'); // For Laravel PUT spoofing
        }

        $.ajax({
            url: url,
            type: method,
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                $('#contactModal').modal('hide');
                alert(res.message);
                loadContacts(); // Reload contacts partial dynamically
            },
            error: function(err) {
                let msg = err.responseJSON?.message || 'Error occurred';
                alert(msg);
            }
        });
    });

    // Edit Contact - Open Modal with Prefilled Data
    $(document).on('click', '.editBtn', function() {
        let id = $(this).data('id');

        $.get(`${BASE_URL}/contacts/${id}/edit`, function(res) {
            $('#contact_id').val(res.id);
            $('#name').val(res.name);
            $('#email').val(res.email);
            $('#phone').val(res.phone);
            $('input[name="gender"][value="' + res.gender + '"]').prop('checked', true);

            if (res.custom_field_values) {
                res.custom_field_values.forEach(field => {
                    $('#custom_field_' + field.custom_field_id).val(field.value);
                });
            }

            $('#contactModal').modal('show');
        });
    });

    // Delete Contact
    $(document).on('click', '.deleteBtn', function() {
        if (!confirm('Are you sure you want to delete this contact?')) return;

        let id = $(this).data('id');

        $.ajax({
            url: `${BASE_URL}/contacts/${id}`,
            type: 'DELETE',
            success: function(res) {
                alert(res.message);
                loadContacts(); // Refresh contacts list dynamically
            },
            error: function(err) {
                let msg = err.responseJSON?.message || 'Delete failed';
                alert(msg);
            }
        });
    });

    // Filter Form submit
    $('#filterForm').on('submit', function(e) {
        e.preventDefault();
        loadContacts();
    });

    // Load contacts partial via AJAX (initial load & after any action)
    function loadContacts() {
        let filters = $('#filterForm').serialize();

        $.get(`${BASE_URL}/contacts/table?${filters}`, function(data) {
            $('#contactList').html(data);
        });
    }

    // Reset form when clicking Add button
    $('#addContactBtn').on('click', function() {
        $('#contactForm')[0].reset();
        $('#contact_id').val('');
        $('.custom-field').val('');
    });

    // Initial load on page ready
    $(document).ready(function() {
        loadContacts();
    });
</script>


@endsection
