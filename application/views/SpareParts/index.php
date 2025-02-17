<div class="container-fluid mt-2">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h2 class="">Spare Parts</h2>
                </div>
                <div class="col">
                    <?php if(in_array('createSparePart', $user_permission)): ?>
                        <button class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target="#addModal">Add SparePart</button>
                    <?php endif; ?>
                </div>
            </div>
            <hr>
            <div id="messages"></div>
            <div class="table-responsive">
                <table id="manageTable" class="table table-bordered table-striped table-sm" width="100%">
                    <thead>
                    <tr>
                        <th>Spare Part name</th>
                        <th>Model</th>
                        <th>Type</th>
                        <th>Supplier</th>
                        <th>Part No</th>
                        <th>Rack No</th>
                        <th>Unit Price</th>
                        <th>Status</th>
                        <?php if(in_array('updateSparePart', $user_permission) || in_array('deleteSparePart', $user_permission)): ?>
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

<?php if(in_array('createSparePart', $user_permission)): ?>
<!-- create brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="addModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
	  	<h5 class="modal-title">Add SparePart</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
      </div>

      <form role="form" action="<?php echo base_url('SpareParts/create') ?>" method="post" id="createForm">

        <div class="modal-body">

          <div class="form-group">
            <label for="name">Name <span class="text-danger">*</span> </label>
            <input type="text" class="form-control form-control-sm" id="name" name="name" placeholder="Enter SparePart name" autocomplete="off">
          </div>

        <div class="form-group">
            <label for="machine_type_id">Machine Type <span class="text-danger">*</span></label>
            <select class="form-control form-control-sm" name="machine_type_id" id="machine_type_id">
                <option value="">Select Machine</option>
            </select>
            <div id="machine_type_id_error"></div>
        </div>

            <div class="form-group">
                <label for="machine_model_id">Machine Model <span class="text-danger">*</span></label>
                <select class="form-control form-control-sm" name="machine_model_id" id="machine_model_id">
                    <option value="">Select Machine</option>
                </select>
                <div id="machine_model_id_error"></div>
            </div>

            <div class="form-group">
                <label for="part_no">Part No <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-sm" id="part_no" name="part_no" placeholder="Enter Part No" autocomplete="off">
            </div>

            <div class="form-group">
                <label for="rack_no">Rack No </label>
                <input type="text" class="form-control form-control-sm" id="rack_no" name="rack_no" placeholder="Enter Rack No" autocomplete="off">
            </div>

            <div class="form-group">
                <label for="unit_price">Unit Price <span class="text-danger">*</span></label>
                <input type="number" step="0.01" class="form-control form-control-sm" id="unit_price" name="unit_price" placeholder="Enter Unit Price" autocomplete="off">
            </div>

            <div class="form-group">
                <label for="supplier_id">Supplier <span class="text-danger">*</span></label>
                <select class="form-control form-control-sm" name="supplier_id[]" id="supplier_id">
                </select>
                <div id="supplier_id_error"></div>
            </div>

          <div class="form-group">
            <label for="active">Status <span class="text-danger">*</span></label>
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

<?php if(in_array('updateSparePart', $user_permission)): ?>
<!-- edit brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="editModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit SparePart</h4>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
      </div>

      <form role="form" action="<?php echo base_url('SpareParts/update') ?>" method="post" id="updateForm">

        <div class="modal-body">
          <div id="messages"></div>

          <div class="form-group">
            <label for="edit_name">Spare Part Name</label>
            <input type="text" class="form-control form-control-sm" id="edit_name" name="edit_name" placeholder="Enter SparePart name" autocomplete="off">
          </div>

            <div class="form-group">
                <label for="edit_machine_type_id">Machine Type <span class="text-danger">*</span></label>
                <select class="form-control form-control-sm" name="edit_machine_type_id" id="edit_machine_type_id">
                    <option value="">Select Machine</option>
                </select>
                <div id="edit_machine_type_id_error"></div>
            </div>

            <div class="form-group">
                <label for="edit_machine_model_id">Machine Model <span class="text-danger">*</span></label>
                <select class="form-control form-control-sm" name="edit_machine_model_id" id="edit_machine_model_id">
                    <option value="">Select Machine</option>
                </select>
                <div id="edit_machine_model_id_error"></div>
            </div>

            <div class="form-group">
                <label for="edit_part_no">Part No <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-sm" id="edit_part_no" name="edit_part_no" placeholder="Enter Part No" autocomplete="off">
            </div>

            <div class="form-group">
                <label for="edit_rack_no">Rack No </label>
                <input type="text" class="form-control form-control-sm" id="edit_rack_no" name="edit_rack_no" placeholder="Enter Rack No" autocomplete="off">
            </div>

            <div class="form-group">
                <label for="edit_unit_price">Unit Price <span class="text-danger">*</span></label>
                <input type="number" step="0.01" class="form-control form-control-sm" id="edit_unit_price" name="edit_unit_price" placeholder="Enter Unit Price" autocomplete="off">
            </div>

            <div class="form-group">
                <label for="edit_supplier_id">Supplier <span class="text-danger">*</span></label>
                <select class="form-control form-control-sm" name="edit_supplier_id[]" id="edit_supplier_id">
                </select>
                <div id="edit_supplier_id_error"></div>
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

<?php if(in_array('deleteSparePart', $user_permission)): ?>
<!-- remove brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Remove SparePart</h4>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
      </div>

      <form role="form" action="<?php echo base_url('SpareParts/remove') ?>" method="post" id="removeForm">
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



