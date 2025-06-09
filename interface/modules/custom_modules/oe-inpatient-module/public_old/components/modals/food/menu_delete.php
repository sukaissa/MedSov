 <!-- delete -->
 <div class="modal fade" id="itemDelete" tabindex="-1" aria-labelledby="itemDelete" aria-hidden="true">
     <div class="modal-dialog modal-dialog-scrollable">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="itemDeleteModal">Confirm Delete</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body">
                 <p>Are you sure you want to delete queue?</p>
                 <form method='POST' action="<?php echo $_SERVER['PHP_SELF']; ?>">
                     <input type="hidden" name="deleteId" id="deleteId" value="">

                     <div class="modal-footer">
                         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                         <button type="submit" class="btn btn-danger">Delete</button>
                     </div>
                 </form>

             </div>
         </div>
     </div>
 </div>