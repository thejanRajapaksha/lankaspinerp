<div class="container-fluid mt-2">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h2 class="">Machine Operations</h2>
                </div>
                <div class="col">
                    <?php if (in_array('createMachineOperationDesc', $user_permission)): ?>
                        <button class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target="#addModal">
                            New Operation
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
                        <th>Operation ID</th>
                        <th>Operation Name</th>
                        <th>Description</th>
                        <th>Criticality</th>
                        <th>Machine</th>
                        <th>SMV</th>
                        <th>Rate</th>
                        <th>Documents</th>
                        <th>Video</th>
                        <th>Remarks</th>
                        <th>Value</th>
                        <th>Is Approved</th>
                        <?php if (in_array('updateMachineOperationDesc', $user_permission) || in_array('deleteMachineOperationDesc', $user_permission)): ?>
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

<?php if (in_array('createMachineOperationDesc', $user_permission)): ?>
    <!-- create brand modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="addModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Machine Operation Desc</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>

                <form role="form" action="<?php echo base_url('MachineOperationDesc/create') ?>" enctype='multipart/form-data' method="post" id="createForm">

                    <div class="modal-body">

                        <div id="msgCreate"></div>

                        <div class="row">

                                <div class="form-group col-md-6">
                                    <label for="operationName">Operation Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" id="operationName" name="operationName">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="description">Description <span class="text-danger">*</span></label>
                                    <textarea class="form-control form-control-sm" id="description" name="description" placeholder="Enter Desc" autocomplete="off"></textarea>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="criticality_id">Criticality <span class="text-danger">*</span></label>
                                    <select class="form-control form-control-sm select2" id="criticality_id" name="criticality_id">
                                        <option value="">Select..</option>
                                        <?php foreach ($criticalities as $cr) : ?>
                                            <option value="<?php echo $cr['id'] ?>"><?php echo $cr['name'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <div id="criticality_id_error"></div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="machine_type_id">Machine Type <span class="text-danger">*</span> </label>
                                    <select name="machine_type_id" id="machine_type_id" class="select2 form-control form-control-sm">
                                        <option value="">Select Machine Type</option>
                                        <?php foreach ($machine_types as $machine_type) : ?>
                                            <option value="<?php echo $machine_type['id'] ?>"><?php echo $machine_type['name'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <div id="machine_type_id_error"></div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="smv">SMV <span class="text-danger">*</span> </label>
                                    <input type="number" step="0.01" class="form-control form-control-sm" id="smv" name="smv" placeholder="Enter smv" autocomplete="off">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="rate">Rate  </label>
                                    <input type="number" step="0.01" class="form-control form-control-sm" id="rate" name="rate" placeholder="Enter rate" autocomplete="off">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="documents">Documents </label>
                                    <input type="file" class="form-control form-control-sm" id="documents" name="documents" autocomplete="off">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="video">Video  </label>
                                    <input type="file" class="form-control form-control-sm" id="video" name="video" autocomplete="off">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="remarks">Remarks</label>
                                    <textarea class="form-control form-control-sm" id="remarks" name="remarks" placeholder="Enter Remarks" autocomplete="off"></textarea>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="value_id">Value </label>
                                     <input type="text" class="form-control form-control-sm" name="value_id" >
                                    <div id="value_id_error"></div>
                                </div>

                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm" id="saveChanges">Save changes</button>
                    </div>

                </form>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<?php endif; ?>


<?php if(in_array('updateMachineOperationDesc', $user_permission)): ?>
    <!-- edit brand modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="editModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Machine Operation Desc</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>

                <form role="form" action="<?php echo base_url('MachineOperationDesc/update') ?>" method="post" id="updateForm" enctype="multipart/form-data">

                    <div class="modal-body">

                        <div class="row">

                            <div class="form-group col-md-6">
                                <label for="edit_operationId">Operation ID <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" id="edit_operationId" name="edit_operationId" readonly>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="edit_operationName">Operation Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" id="edit_operationName" name="edit_operationName">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="edit_description">Description <span class="text-danger">*</span></label>
                                <textarea class="form-control form-control-sm" id="edit_description" name="edit_description" placeholder="Enter Desc" autocomplete="off"></textarea>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="edit_criticality_id">Criticality <span class="text-danger">*</span></label>
                                <select class="form-control form-control-sm select2" id="edit_criticality_id" name="edit_criticality_id">
                                    <option value="">Select..</option>
                                    <?php foreach ($criticalities as $cr) : ?>
                                        <option value="<?php echo $cr['id'] ?>"><?php echo $cr['name'] ?></option>
                                    <?php endforeach ?>
                                </select>
                                <div id="edit_criticality_id_error"></div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="edit_machine_type_id">Machine Type <span class="text-danger">*</span> </label>
                                <select name="edit_machine_type_id" id="edit_machine_type_id" class="select2 form-control form-control-sm">
                                    <option value="">Select Machine Type</option>
                                    <?php foreach ($machine_types as $machine_type) : ?>
                                        <option value="<?php echo $machine_type['id'] ?>"><?php echo $machine_type['name'] ?></option>
                                    <?php endforeach ?>
                                </select>
                                <div id="edit_machine_type_id_error"></div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="edit_smv">SMV <span class="text-danger">*</span> </label>
                                <input type="number" step="0.01" class="form-control form-control-sm" id="edit_smv" name="edit_smv" placeholder="Enter smv" autocomplete="off">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="edit_rate">Rate </label>
                                <input type="number" step="0.01" class="form-control form-control-sm" id="edit_rate" name="edit_rate" placeholder="Enter rate" autocomplete="off">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="edit_documents">Documents </label>
                                <input type="file" class="form-control form-control-sm" id="edit_documents" name="edit_documents" autocomplete="off">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="edit_video">Video  </label>
                                <input type="file" class="form-control form-control-sm" id="edit_video" name="edit_video" autocomplete="off">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="edit_remarks">Remarks</label>
                                <textarea class="form-control form-control-sm" id="edit_remarks" name="edit_remarks" placeholder="Enter Remarks" autocomplete="off"></textarea>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="edit_value_id">Value <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" id="edit_value_id" name="edit_value_id">
                                <div id="edit_value_id_error"></div>
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

<?php if(in_array('deleteMachineOperationDesc', $user_permission)): ?>
    <!-- remove brand modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Remove Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>

                <form role="form" action="<?php echo base_url('MachineOperationDesc/remove') ?>" method="post" id="removeForm">
                    <div class="modal-body">
                        <p>Do you really want to remove?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<?php endif; ?>


