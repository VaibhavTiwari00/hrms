<div id="create_project" class="modal custom-modal fade" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Create Task</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="addTask1">
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label>Task Name<span class="text-danger">*</span></label>
								<input class="form-control" id="task_name" name="task_name" type="text">
							</div>
						</div>

					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label>Start Date<span class="text-danger">*</span></label>
								<input name="task_start_date" id="start_date" class="form-control" required type="datetime-local">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>End Date<span class="text-danger">*</span></label>
								<input name="task_end_date" id="end_date" class="form-control" required type="datetime-local">
							</div>
						</div>
					</div>
					<div class="row">

						<div class="col-sm-6">
							<div class="form-group">
								<label>Priority<span class="text-danger">*</span></label>
								<select class="select" name="task_priority">
									<option value="">Select Priority</option>
									<option value="1">High</option>
									<option value="2">Medium</option>
									<option value="3">Low</option>
								</select>
							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group">
								<label>Assign User<span class="text-danger">*</span></label>
								<select class="select" name="task_assign_to">
									<option value="">Select User</option>
									<?php
									$all_dept_user_data = get_list_of_all_employess($DB);

									foreach ($all_dept_user_data as $row) {
									?>
										<option value="<?= $row['user_unique_id'] ?>"><?= $row['first_name'] . ' ' . $row['last_name'] ?></option>

									<?php } ?>
								</select>
							</div>
						</div>
					</div>

					<div class="row">


					</div>
					<div class="form-group">
						<label>Description</label>
						<textarea rows="4" class="form-control summernote" placeholder="Enter your message here"></textarea>
					</div>
					<div class="form-group">
						<label>Upload Files</label>
						<p class="mt-1">
							<label for="attachment_task">
								<a class="btn btn-primary text-light" role="button" aria-disabled="false">+ Add Files</a>
							</label>
							<input type="file" name="files[]" id="attachment_task" style="visibility: hidden; position: absolute;" multiple />

						</p>
						<p id="files-area">
							<span id="filesList">
								<span id="files-names-task"></span>
							</span>
						</p>
					</div>
					<div class="submit-section">
						<button class="btn btn-primary submit-btn" id="sub_task1">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>