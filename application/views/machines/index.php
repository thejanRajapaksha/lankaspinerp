<div class="container-fluid mt-2">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h2 class="">Machines List</h2>
                </div>
                <div class="col">
                    <?php if(in_array('createMachine', $user_permission)): ?>
                        <button class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target="#addModal">Add Machine</button>
                    <?php endif; ?>
                </div>
            </div>
            <hr>
            <div id="messages"></div>
            <div class="table-responsive">
                <table id="manageTable" class="table table-bordered table-striped table-sm">
                    <thead>
                    <tr>
                        <th>Machine name</th>
                        <th>Status</th>
                        <th>Section</th>
                        <?php if(in_array('updateMachine', $user_permission) || in_array('deleteMachine', $user_permission)): ?>
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

<?php if(in_array('createMachine', $user_permission)): ?>
<!-- create brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="addModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
	  	<h5 class="modal-title">Add Machine</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
      </div>

      <form role="form" action="<?php echo base_url('Machines/create') ?>" method="post" id="createForm">

        <div class="modal-body">

          <div class="form-group">
            <label for="brand_name">Machine Name</label>
            <input type="text" class="form-control form-control-sm" id="machine_name" name="machine_name" placeholder="Enter Machine name" autocomplete="off">
          </div>

          <div class="form-group">
            <label for="active">Status</label>
            <select class="form-control form-control-sm" id="active" name="active">
              <option value="1">Active</option>
              <option value="2">Inactive</option>
            </select>
          </div>
            <div class="form-group">
                <label for="department">Section</label>
                <select class="form-control form-control-sm" id="section" name="section">
                    <option value="">Select Section</option>
                    <?php foreach($sections as $section): ?>
                        <option value="<?php echo $section->id; ?>"><?php echo $section->name; ?></option>
                    <?php endforeach; ?>
                </select>
                <div id="error_section"></div>
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

<?php if(in_array('updateMachine', $user_permission)): ?>
<!-- edit brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="editModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit Machine</h4>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
      </div>

      <form role="form" action="<?php echo base_url('Machines/update') ?>" method="post" id="updateForm">

        <div class="modal-body">
          <div id="messages"></div>

          <div class="form-group">
            <label for="brand_name">Machine Name</label>
            <input type="text" class="form-control form-control-sm" id="edit_machine_name" name="edit_machine_name" placeholder="Enter Machine name" autocomplete="off">
          </div>

          <div class="form-group">
            <label for="active">Status</label>
            <select class="form-control form-control-sm" id="edit_active" name="edit_active">
              <option value="1">Active</option>
              <option value="2">Inactive</option>
            </select>
          </div>

            <div class="form-group">
                <label for="department">Section</label>
                <select class="form-control form-control-sm" id="edit_machine_section" name="edit_section">
                    <option value="">Select Department</option>
                    <?php foreach($sections as $section): ?>
                        <option value="<?php echo $section->id; ?>"><?php echo $section->name; ?></option>
                    <?php endforeach; ?>
                </select>
                <div id="edit_error_section"></div>
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

<?php if(in_array('deleteMachine', $user_permission)): ?>
<!-- remove brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Remove Machine</h4>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
      </div>

      <form role="form" action="<?php echo base_url('Machines/remove') ?>" method="post" id="removeForm">
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



