  <!-- new Modal -->
  <div class="modal fade" id="newTheater" tabindex="-1" aria-labelledby="newTheater" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Theater Form</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <form method='POST'>
                      <input type="hidden" name="new" value="new">

                      <div class="form-group">
                          <label for="name">Name</label>
                          <input type="text" class="form-control" name="name" id="name">
                      </div>

                      <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary">Save</button>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>