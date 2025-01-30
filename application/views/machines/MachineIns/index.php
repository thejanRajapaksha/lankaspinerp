<div class="container-fluid mt-2">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h2 class="">Machine In</h2>
                </div>
                <div class="col">
                    <?php if (in_array('createMachineIn', $user_permission)): ?>
                        <button class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target="#addModal">
                            Add MachineIn
                        </button>
                    <?php endif; ?>
                </div>
            </div>
            <hr>
            <div id="messages"></div>
            <div class="table-responsive">
                <table id="manageTable" class="table table-bordered table-striped table-sm">
                    <thead>
                    <tr>
                        <th>Machine Type</th>
                        <th>Model</th>
                        <th>S NO</th>
                        <th>Bar Code</th>
                        <th>In Type</th>
                        <th>Next Service Date</th>
                        <th>Origin Date</th>
                        <th>Reference</th>
                        <th>Status</th>
                        <?php if (in_array('updateMachineIn', $user_permission) || in_array('deleteMachineIn', $user_permission)): ?>
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

<?php if (in_array('createMachineIn', $user_permission)): ?>
    <!-- create brand modal -->
    <div class="modal fade fullscreen" tabindex="-1" role="dialog" id="addModal">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Machine In</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form role="form" action="<?php echo base_url('MachineIns/create') ?>" method="post" id="createForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="machine_type_id">Machine Type <span class="text-danger">*</span></label>
                            <select name="machine_type_id" id="machine_type_id" class="select2 form-control-sm">
                                <option value="">Select Machine Type</option>
                                <?php foreach ($machine_types as $machine_type): ?>
                                    <option value="<?php echo $machine_type['id'] ?>"><?php echo $machine_type['name'] ?></option>
                                <?php endforeach ?>
                            </select>
                            <div id="machine_type_id_error"></div>
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="machine_model_id">Machine Model <span class="text-danger">*</span></label>
                            <select name="machine_model_id" id="machine_model_id" class="select2 form-control-sm">
                                <option value="">Select Machine Model</option>
                                <?php foreach ($machine_models as $machine_model): ?>
                                    <option value="<?php echo $machine_model['id'] ?>"><?php echo $machine_model['name'] ?></option>
                                <?php endforeach ?>
                            </select>
                            <div id="machine_model_id_error"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="s_no">S NO <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" id="s_no" name="s_no" placeholder="Enter S NO">
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="bar_code">Bar Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" id="bar_code" name="bar_code" placeholder="Enter Bar Code">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="in_type_id">In Type <span class="text-danger">*</span></label>
                            <select name="in_type_id" id="in_type_id" class="select2 form-control-sm">
                                <option value="">Select In Type</option>
                                <?php foreach ($in_types as $in_type): ?>
                                    <option value="<?php echo $in_type['id'] ?>"><?php echo $in_type['name'] ?></option>
                                <?php endforeach ?>
                            </select>
                            <div id="in_type_id_error"></div>
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="next_service_date">Next Service Date</label>
                            <input type="date" class="form-control form-control-sm" id="next_service_date" name="next_service_date" placeholder="Enter Next Service Date">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="origin_date">Origin Date</label>
                            <input type="date" class="form-control form-control-sm" id="origin_date" name="origin_date" placeholder="Enter Origin Date">
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="reference">Reference <span class="text-danger">*</span></label>
                            <textarea class="form-control form-control-sm" id="reference" name="reference" placeholder="Enter Reference"></textarea>
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="active">Status <span class="text-danger">*</span></label>
                            <select class="form-control form-control-sm" id="active" name="active">
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                        </div>
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

<?php if (in_array('updateMachineIn', $user_permission)): ?>
    <!-- edit brand modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="editModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Machine In</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>

                <form role="form" action="<?php echo base_url('MachineIns/update') ?>" method="post" id="updateForm">

                    <div class="modal-body">
                        <div id="messages"></div>

                        <div class="form-group">
                            <label for="edit_machine_type_id">Machine Type <span class="text-danger">*</span> </label>
                            <select name="machine_type_id" id="edit_machine_type_id" class="select2 form-control-sm">
                                <option value="">Select Machine Type</option>
                                <?php foreach ($machine_types as $machine_type): ?>
                                    <option value="<?php echo $machine_type['id'] ?>"><?php echo $machine_type['name'] ?></option>
                                <?php endforeach ?>
                            </select>
                            <div id="edit_machine_type_id_error"></div>
                        </div>

                        <div class="form-group">
                            <label for="edit_machine_model_id">Machine Model <span class="text-danger">*</span></label>
                            <select name="machine_model_id" id="edit_machine_model_id" class="select2 form-control-sm">
                                <option value="">Select Machine Model</option>
                                <?php foreach ($machine_models as $machine_model): ?>
                                    <option value="<?php echo $machine_model['id'] ?>"><?php echo $machine_model['name'] ?></option>
                                <?php endforeach ?>
                            </select>
                            <div id="edit_machine_model_id_error"></div>
                        </div>

                        <div class="form-group">
                            <label for="edit_s_no">S NO <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" id="edit_s_no" name="s_no" placeholder="Enter S NO">
                        </div>

                        <div class="form-group">
                            <label for="edit_bar_code">Bar Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" id="edit_bar_code" name="bar_code" placeholder="Enter Bar Code">
                        </div>

                        <div class="form-group">
                            <label for="in_type_id">In Type <span class="text-danger">*</span></label>
                            <select name="in_type_id" id="edit_in_type_id" class="select2 form-control-sm">
                                <option value="">Select In Type</option>
                                <?php foreach ($in_types as $in_type): ?>
                                    <option value="<?php echo $in_type['id'] ?>"><?php echo $in_type['name'] ?></option>
                                <?php endforeach ?>
                            </select>
                            <div id="edit_in_type_id_error"></div>
                        </div>

                        <div class="form-group">
                            <label for="next_service_date">Next Service Date</label>
                            <input type="date" class="form-control form-control-sm" id="edit_next_service_date" name="next_service_date" placeholder="Enter Next Service Date">
                        </div>

                        <div class="form-group">
                            <label for="edit_origin_date">Origin Date</label>
                            <input type="date" class="form-control form-control-sm" id="edit_origin_date" name="origin_date" placeholder="Enter Origin Date">
                        </div>


                        <div class="form-group">
                            <label for="edit_reference">Reference <span class="text-danger">*</span></label>
                            <textarea class="form-control form-control-sm" id="edit_reference" name="reference" placeholder="Enter Reference"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="edit_active">Status</label>
                            <select class="form-control form-control-sm" id="edit_active" name="active">
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

<?php if (in_array('deleteMachineIn', $user_permission)): ?>
    <!-- remove brand modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Remove Machine In</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>

                <form role="form" action="<?php echo base_url('MachineIns/remove') ?>" method="post" id="removeForm">
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



