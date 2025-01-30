<div class="container-fluid mt-2">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h2 class="">Operations for Machines</h2>
                </div>
                <div class="col">
                    <?php if(in_array('createOperationsForMachine', $user_permission)): ?>
                        <button class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target="#addModal">Add Operation For Machine</button>
                    <?php endif; ?>
                </div>
            </div>
            <hr>
            <div id="messages"></div>
            <div class="table-responsive">
                <table id="manageTable" class="table table-bordered table-striped table-sm">
                    <thead>
                    <tr>
                        <th>Operation name</th>
                        <th>Type</th>
                        <th>Status</th>
                        <?php if(in_array('updateOperationsForMachine', $user_permission) || in_array('deleteOperationsForMachine', $user_permission)): ?>
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

<?php if(in_array('createOperationsForMachine', $user_permission)): ?>
<!-- create brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="addModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
	  	<h5 class="modal-title">Add Operation For Machine</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
      </div>

      <form role="form" action="<?php echo base_url('OperationsForMachines/create') ?>" method="post" id="createForm">

        <div class="modal-body">

          <div class="form-group">
            <label for="brand_name">Operation Name</label>
            <input type="text" class="form-control form-control-sm" id="operation_name" name="operation_name" placeholder="Enter Operation name" autocomplete="off">
          </div>

          <div class="form-group">
            <label for="operation_type_id">Operation Type</label>
            <select class="form-control form-control-sm" id="operation_type_id" name="operation_type_id">
              <option value="">Select Operation Type</option>
              <?php foreach ($operation_types as$v): ?>
                <option value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
              <?php endforeach ?>
            </select>
          </div>

          <div class="form-group">
            <label for="active">Status</label>
            <select class="form-control form-control-sm" id="active" name="active">
              <option value="1">Active</option>
              <option value="2">Inactive</option>
            </select>
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

<?php if(in_array('updateOperationsForMachine', $user_permission)): ?>
<!-- edit brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="editModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit Operation For Machine</h4>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
      </div>

      <form role="form" action="<?php echo base_url('OperationsForMachines/update') ?>" method="post" id="updateForm">

        <div class="modal-body">
          <div id="messages"></div>

          <div class="form-group">
            <label for="brand_name">Operation Name</label>
            <input type="text" class="form-control form-control-sm" id="edit_operation_name" name="edit_operation_name" placeholder="Enter Operation name" autocomplete="off">
          </div>

            <div class="form-group">
                <label for="edit_operation_type_id">Operation Type</label>
                <select class="form-control form-control-sm" id="edit_operation_type_id" name="edit_operation_type_id">
                    <option value="">Select Operation Type</option>
                    <?php foreach ($operation_types as$v): ?>
                        <option value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>

          <div class="form-group">
            <label for="active">Status</label>
            <select class="form-control form-control-sm" id="edit_active" name="edit_active">
              <option value="1">Active</option>
              <option value="2">Inactive</option>
            </select>
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

<?php if(in_array('deleteOperationsForMachine', $user_permission)): ?>
<!-- remove brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Remove Operation For Machine</h4>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
      </div>

      <form role="form" action="<?php echo base_url('OperationsForMachines/remove') ?>" method="post" id="removeForm">
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



