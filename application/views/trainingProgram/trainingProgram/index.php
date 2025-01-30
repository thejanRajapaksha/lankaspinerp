<div class="container-fluid mt-2">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h2 class="">Training Programs</h2>
                </div>
                <div class="col">
                    <?php if(in_array('createTrainingProgram', $user_permission)): ?>
                        <button class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target="#addModal">Add Training Program</button>
                    <?php endif; ?>
                </div>
            </div>
            <hr>
            <div id="messages"></div>
            <div class="table-responsive">
                <table id="manageTable" class="table table-bordered table-striped table-sm">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Trainer</th>
                        <th>Location</th>
                        <th>Date</th>
                        <th>Remarks</th>
                        <th>No of Employees</th>
                        <?php if(in_array('updateTrainingProgram', $user_permission) || in_array('deleteTrainingProgram', $user_permission)): ?>
                            <th>Action</th>
                        <?php endif; ?>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php if(in_array('createTrainingProgram', $user_permission)): ?>
<!-- create brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="addModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
	  	<h5 class="modal-title">Add Training Program</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
      </div>

      <form role="form" action="<?php echo base_url('TrainingPrograms/create') ?>" method="post" id="createForm">

        <div class="modal-body">

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" class="form-control form-control-sm">
            </div>

            <div class="form-group">
                <label for="trainer_id">Trainer</label>
                <select class="form-control form-control-sm" id="trainer_id" name="trainer_id">
                    <option value="">Select Trainer</option>
                </select>
                <div id="trainer_id_error"></div>
            </div>

            <div class="form-group">
                <label for="location_id">Location</label>
                <select class="form-control form-control-sm" id="location_id" name="location_id">
                    <option value="">Select Location</option>
                    <?php
                    foreach ($locations as $loc){
                        echo '<option value = "'.$loc['id'].'"> '.$loc['name'].' </option> ';
                    }
                    ?>
                </select>
                <div id="location_id_error"></div>
            </div>

            <div class="form-group">
                <label for="date"> Date</label>
                <input type="date" id="date" name="date" class="form-control form-control-sm">
            </div>

            <div class="form-group">
                <label for="remarks"> Remarks</label>
                <textarea id="remarks" name="remarks" class="form-control form-control-sm"></textarea>
            </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary btn-sm">Save changes</button>
        </div>

      </form>


    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php endif; ?>

<?php if(in_array('updateTrainingProgram', $user_permission)): ?>
<!-- edit brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="editModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit Training Program</h4>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
      </div>

      <form role="form" action="<?php echo base_url('TrainingPrograms/update') ?>" method="post" id="updateForm">

        <div class="modal-body">
          <div id="messages"></div>

            <div class="form-group">
                <label for="edit_name">Name</label>
                <input type="text" id="edit_name" name="edit_name" class="form-control form-control-sm">
            </div>

            <div class="form-group">
                <label for="edit_trainer_id">Trainer</label>
                <select class="form-control form-control-sm" id="edit_trainer_id" name="edit_trainer_id">
                    <option value="">Select Trainer</option>
                </select>
                <div id="edit_trainer_id_error"></div>
            </div>

            <div class="form-group">
                <label for="edit_location_id">Location</label>
                <select class="form-control form-control-sm" id="edit_location_id" name="edit_location_id">
                    <option value="">Select Location</option>
                    <?php
                    foreach ($locations as $loc){
                        echo '<option value = "'.$loc['id'].'"> '.$loc['name'].' </option> ';
                    }
                    ?>
                </select>
                <div id="edit_location_id_error"></div>
            </div>

            <div class="form-group">
                <label for="edit_date"> Date</label>
                <input type="date" id="edit_date" name="edit_date" class="form-control form-control-sm">
            </div>

            <div class="form-group">
                <label for="edit_remarks"> Remarks</label>
                <textarea id="edit_remarks" name="edit_remarks" class="form-control form-control-sm"></textarea>
            </div>


        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary btn-sm">Save changes</button>
        </div>

      </form>


    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php endif; ?>

<div class="modal fade" tabindex="-1" role="dialog" id="viewModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">View Skill Requirement : <strong> <span id="skill_view"></span></strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="viewMsg"></div>
                <div id="viewResponse"></div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
            </div>


        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php if(in_array('deleteTrainingProgram', $user_permission)): ?>
<!-- remove brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Remove Skill Requirement</h4>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
      </div>

      <form role="form" action="<?php echo base_url('TrainingPrograms/remove') ?>" method="post" id="removeForm">
        <div class="modal-body">
          <p>Do you really want to remove?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary btn-sm">Save changes</button>
        </div>
      </form>


    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php endif; ?>



