<div id="follow_up_reason" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Complete Task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="follow_up_form">
                    <input class="form-control" type="text" id="task_id" name="task_id" hidden>

                    <div class="form-group">
                        <label>Remarks <span class="text-danger">*</span></label>
                        <textarea name="task_reason" id="task_reason" class="form-control" rows="4"></textarea>
                    </div>

                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div id="complete_reason" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reassign Task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="col-auto m-auto">

                <!-- <button class="btn add-btn mt-3" id="form_toggle_btn"><i class="fa fa-plus"></i> Reassign Task</button> -->
                <!-- <button class="btn add-btn mr-2 mt-3" id="final_complete">Complete Task</button> -->

                <div class="view-icons">

                </div>
            </div>
            <div class="modal-body">
                <form id="reassign_form">
                    <input class="form-control" type="text" id="task_reassign_id" name="task_reassign_id" hidden>

                    <div class="form-group">
                        <label>Remarks <span class="text-danger">*</span></label>
                        <textarea name="task_reassign_reason" id="task_reassign_reason" class="form-control" rows="4"></textarea>
                    </div>

                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>