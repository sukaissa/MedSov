   <!-- update -->
   <div class="modal fade" id="updateItem" tabindex="-1" aria-labelledby="updateItem" aria-hidden="true">
       <div class="modal-dialog modal-dialog-scrollable">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLabel">Update Procedure</h5>
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                   </button>
               </div>
               <div class="modal-body">
                   <form method='POST'>
                       <input type="hidden" name="id" id="id" value="">

                       <div class="form-group">
                           <label for="name">Name</label>
                           <input type="text" class="form-control" name="name" id="name">
                       </div>

                       <div class="form-group">
                           <label for="code">Code</label>
                           <input type="text" class="form-control" name="code" id="code">
                       </div>

                       <div class="form-group">
                           <label for="price">Price</label>
                           <input type="price" class="form-control" name="price" id="price">
                       </div>

                       <div class="form-group">
                           <label for="status">Insurance Status</label>
                           <select class="form-control" id="status" name="status">
                               <option value="">Select status</option>
                               <option value="Active">Active</option>
                               <option value="Inactive">Inactive</option>
                           </select>
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