<div class="modal fade" id="contactModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <form id="contactForm" enctype="multipart/form-data">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Add/Edit Contact</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body row">
              <input type="hidden" id="contact_id" name="contact_id">
              <div class="col-md-6">
                  <label>Name</label>
                  <input type="text" name="name" id="name" class="form-control mb-2" required>
              </div>
              <div class="col-md-6">
                  <label>Email</label>
                  <input type="email" name="email" id="email" class="form-control mb-2" required>
              </div>
              <div class="col-md-6">
                  <label>Phone</label>
                  <input type="text" name="phone" id="phone" class="form-control mb-2" required>
              </div>
              <div class="col-md-6">
                  <label>Gender</label><br>
                  <label><input type="radio" name="gender" value="Male"> Male</label>
                  <label><input type="radio" name="gender" value="Female"> Female</label>
              </div>
              <div class="col-md-6">
                  <label>Profile Image</label>
                  <input type="file" name="profile_image" class="form-control mb-2">
              </div>
              <div class="col-md-6">
                  <label>Additional File</label>
                  <input type="file" name="additional_file" class="form-control mb-2">
              </div>
              {{-- Dynamic custom fields will be inserted here --}}
              <div class="col-12" id="customFieldsContainer"></div>
             

          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save Contact</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  