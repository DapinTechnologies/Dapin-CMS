<!-- Raw HTML Delete Modal for Testing -->
<div class="modal fade" id="deleteModal-test" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="deleteModalLabel">TEST DELETE MODAL</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <h4><i class="fas fa-exclamation-triangle"></i> Testing Only</h4>
                    <p>This is a static test modal with no real functionality.</p>
                    <p>Would delete subject ID: <strong>TEST_ID</strong></p>
                </div>
                <p>Are you sure you want to remove this subject?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Cancel
                </button>
                
                <!-- Plain HTML form with no action -->
                <form>
                    <button type="button" class="btn btn-danger" onclick="alert('This would normally delete the item')">
                        <i class="fas fa-trash-alt"></i> Delete Subject
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Button to trigger the test modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#deleteModal-test">
    <i class="fas fa-vial"></i> Test Delete Modal
</button>