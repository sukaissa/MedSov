<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="previewModalLabel">Preview Your Responses</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="previewBody">
                <!-- Update all preview field references to use the new field names, e.g. baby_first_name, pf_first_name, comm_1, gross_1, etc. -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Edit</button>
                <button type="button" class="btn btn-primary" id="modalSubmit">Submit</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('modalSubmit').addEventListener('click', function() {
        document.getElementById('asqForm').submit();
    });
</script>