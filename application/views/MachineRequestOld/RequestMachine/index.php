<div class="container-fluid mt-2">
  <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col">
          <h2 class="">Machine Request</h2>
        </div>
        <div class="col">
          <?php if (in_array('createMachineRequest', $user_permission)) : ?>
            <button class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target="#addModal">Add Machine Request</button>
          <?php endif; ?>
        </div>
      </div>
      <hr>
      <div id="messages"></div>
      <div class="table-responsive">
        <table id="manageTable" class="table table-bordered table-striped table-sm">
          <thead>
            <tr>
              <th>Request by</th>
              <th>Request Date</th>
              <th>Status</th>
              <?php if (in_array('updateMachineRequest', $user_permission) || in_array('deleteMachineRequest', $user_permission)) : ?>
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

<div class="modal fade" tabindex="-1" role="dialog" id="viewModal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">View Machine Request</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <table style="width: 100%;" id="viewTable" class="table table-bordered table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">Machine Type</th>
              <th scope="col">Machine Model</th>
              <th scope="col">From Date </th>
              <th scope="col">To Date</th>
              <th scope="col">Quantity</th>
              <th scope="col">Remark</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<?php if (in_array('createMachineRequest', $user_permission)) : ?>
  <!-- create brand modal -->
  <div class="modal fade" tabindex="-1" role="dialog" id="addModal">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Machine Request</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="row mr-2 ">
          <div class="col-md-4">
            <!-- <form role="form" action="<?php echo base_url('MachineRequest/create') ?>" method="post" id="createForm"> -->
            <form role="form" action="<?php echo base_url('MachineRequest/create') ?>" method="post" id="createnewForm">
              <div class="modal-body">
                <div class="form-group">
                  <label for="machine_type_id">Machine Type <span class="text-danger">*</span> </label>
                  <select name="machine_type_id" id="machine_type_id" class="select2 form-control-sm">
                    <option value="">Select Machine Type</option>
                    <?php foreach ($machine_types as $machine_type) : ?>
                      <option value="<?php echo $machine_type['id'] ?>"><?php echo $machine_type['name'] ?></option>
                    <?php endforeach ?>
                  </select>
                  <div id="machine_type_id_error"></div>
                </div>

                <div class="form-group">
                  <label for="machine_model_id">Machine Model <span class="text-danger">*</span></label>
                  <select name="machine_model_id" id="machine_model_id" class="select2 form-control-sm">
                    <option value="">Select Machine Model</option>
                    <?php foreach ($machine_models as $machine_model) : ?>
                      <option value="<?php echo $machine_model['id'] ?>"><?php echo $machine_model['name'] ?></option>
                    <?php endforeach ?>
                  </select>
                  <div id="machine_model_id_error"></div>
                </div>

                <div class="form-group">
                  <label for="from_date">From Date <span class="text-danger">*</span> </label>
                  <input type="date" class="form-control form-control-sm" id="from_date" name="from_date" placeholder="Enter From Date">
                </div>

                <div class="form-group">
                  <label for="to_date">To Date</label>
                  <input type="date" class="form-control form-control-sm" id="to_date" name="to_date" placeholder="Enter To Date">
                </div>

                <div class="form-group">
                  <label for="quantity">Quantity <span class="text-danger">*</span> </label>
                  <input type="number" class="form-control form-control-sm" id="quantity" name="quantity" placeholder="Enter Quantity" autocomplete="off">
                </div>

                <div class="form-group">
                  <label for="brand_name">Remark</label>
                  <input type="text" class="form-control form-control-sm" id="remark" name="remark" placeholder="Enter Remark" autocomplete="off">
                </div>

                <button type="submit" class="btn btn-success btn-sm text-right">Request Machine</button>
              </div>
            </form>
          </div>
          <div class="col-md-8 mt-4">
            <div class="table-responsive">
              <table style="width: 100%;" id="tempTable" class="table table-bordered table-striped table-sm">
                <thead>
                  <tr>
                    <th scope="col">Machine Type id</th>
                    <th scope="col">Machine Type</th>
                    <th scope="col">Machine Model id</th>
                    <th scope="col">Machine Model</th>
                    <th scope="col">From Date </th>
                    <th scope="col">To Date</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Remark</th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
              </table>
              <button type="button" id="create" onclick="create_js();" class="btn btn-primary btn-sm">Create Request</button>
            </div>
          </div>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
<?php endif; ?>


<?php if (in_array('updateMachineRequest', $user_permission)) : ?>
  <!-- create brand modal -->
  <div class="modal fade" tabindex="-1" role="dialog" id="editModal">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Machine Request</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="row mr-2 ">
          <div class="col-md-4">
          <div class="form-group" hidden>
            <label for="edit_remark">id</label>
            <input type="text" class="form-control form-control-sm" id="id" name="id" disabled>
          </div>
            <!-- <form role="form" action="<?php echo base_url('MachineRequest/create') ?>" method="post" id="createForm"> -->
            <form role="form" action="<?php echo base_url('MachineRequest/update') ?>" method="post" id="updateForm">
              <div class="modal-body">
                <div id="messages"></div>
                <div class="form-group">
                  <label for="edit_machine_type_id">Machine Type <span class="text-danger">*</span> </label>
                  <select name="edit_machine_type_id" id="edit_machine_type_id" class="select2 form-control-sm">
                    <option value="">Select Machine Type</option>
                    <?php foreach ($machine_types as $machine_type) : ?>
                      <option value="<?php echo $machine_type['id'] ?>"><?php echo $machine_type['name'] ?></option>
                    <?php endforeach ?>
                  </select>
                  <div id="edit_machine_type_id_error"></div>
                </div>
                <div class="form-group">
                  <label for="edit_machine_model_id">Machine Model <span class="text-danger">*</span></label>
                  <select name="edit_machine_model_id" id="edit_machine_model_id" class="select2 form-control-sm">
                    <option value="">Select Machine Model</option>
                    <?php foreach ($machine_models as $machine_model) : ?>
                      <option value="<?php echo $machine_model['id'] ?>"><?php echo $machine_model['name'] ?></option>
                    <?php endforeach ?>
                  </select>
                  <div id="edit_machine_model_id_error"></div>
                </div>
                <div class="form-group">
                  <label for="edit_from_date">From Date <span class="text-danger">*</span> </label>
                  <input type="date" class="form-control form-control-sm" id="edit_from_date" name="edit_from_date" placeholder="Enter From Date">
                </div>
                <div class="form-group">
                  <label for="edit_to_date">To Date <span class="text-danger">*</span> </label>
                  <input type="date" class="form-control form-control-sm" id="edit_to_date" name="edit_to_date" placeholder="Enter To Date">
                </div>
                <div class="form-group">
                  <label for="edit_quantity">Quantity <span class="text-danger">*</span> </label>
                  <input type="number" class="form-control form-control-sm" id="edit_quantity" name="edit_quantity" placeholder="Enter Quantity" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="edit_remark">Remark</label>
                  <input type="text" class="form-control form-control-sm" id="edit_remark" name="edit_remark" placeholder="Enter Remark" autocomplete="off">
                </div>
                
                <!-- <div class="form-group">
                  <label for="edit_active">Status <span class="text-danger">*</span> </label>
                  <select class="form-control form-control-sm" id="edit_active" name="edit_active">
                    <option value="1">Active</option>
                    <option value="2">Inactive</option>
                  </select>
                </div> -->
              </div>
              <div class="modal-footer">
                <!-- <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button> -->
                <button type="submit" id="update" class="btn btn-primary btn-sm">Save changes</button>
              </div>
            </form>
          </div>
          <div class="col-md-8 mt-4">
            <div class="table-responsive">
              <table style="width: 100%;" id="edit_tempTable" class="table table-bordered table-striped table-sm">
                <thead>
                  <tr>
                    <th scope="col">Machine Type id</th>
                    <th scope="col">Machine Type</th>
                    <th scope="col">Machine Model id</th>
                    <th scope="col">Machine Model</th>
                    <th scope="col">From Date </th>
                    <th scope="col">To Date</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Remark</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
              </table>
              <div id="edit_messages"></div>
              <!-- <button type="button" id="create" onclick="create_js();" class="btn btn-primary btn-sm">Create Request</button> -->
            </div>
          </div>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
<?php endif; ?>

<?php if (in_array('updateMachineRequest', $user_permission)) : ?>
  <!-- edit brand modal -->
  <div class="modal fade" tabindex="-1" role="dialog" id="">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Machine Request</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>

      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
<?php endif; ?>

<?php if (in_array('deleteMachineRequest', $user_permission)) : ?>
  <!-- remove brand modal -->
  <div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Remove MachineRequest</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <form role="form" action="<?php echo base_url('MachineRequest/remove') ?>" method="post" id="removeForm">
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