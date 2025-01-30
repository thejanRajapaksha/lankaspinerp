<div class="container-fluid mt-2">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h2 class="">Machine Operation Description</h2>
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
                        <th>Date Created</th>
                        <th>Created By</th>
                        <th>Approved By</th>
                        <th>Documents</th>
                        <th>Video</th>
                        <th>Remarks</th>
                        <th>Value</th>
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
        <div class="modal-dialog modal-xl" role="document">
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
                            <div class="col-md-12 row">

                                <div class="form-group col-md-3">
                                    <label for="operationId">Operation ID <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" id="operationId" name="operationId">
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="operationName">Operation Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" id="operationName" name="operationName">
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="description">Description <span class="text-danger">*</span></label>
                                    <textarea class="form-control form-control-sm" id="description" name="description" placeholder="Enter Desc" autocomplete="off"></textarea>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="criticality_id">Criticality <span class="text-danger">*</span></label>
                                    <select class="form-control form-control-sm select2" id="criticality_id" name="criticality_id">
                                        <option value="">Select..</option>
                                        <?php foreach ($criticalities as $cr) : ?>
                                            <option value="<?php echo $cr['id'] ?>"><?php echo $cr['name'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <div id="criticality_id_error"></div>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="machine_type_id">Machine Type <span class="text-danger">*</span> </label>
                                    <select name="machine_type_id" id="machine_type_id" class="select2 form-control form-control-sm">
                                        <option value="">Select Machine Type</option>
                                        <?php foreach ($machine_types as $machine_type) : ?>
                                            <option value="<?php echo $machine_type['id'] ?>"><?php echo $machine_type['name'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <div id="machine_type_id_error"></div>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="smv">SMV <span class="text-danger">*</span> </label>
                                    <input type="number" step="0.01" class="form-control form-control-sm" id="smv" name="smv" placeholder="Enter smv" autocomplete="off">
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="rate">Rate <span class="text-danger">*</span> </label>
                                    <input type="number" step="0.01" class="form-control form-control-sm" id="rate" name="rate" placeholder="Enter rate" autocomplete="off">
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="date_created">Date Created <span class="text-danger">*</span> </label>
                                    <input type="date" class="form-control form-control-sm" id="date_created" name="date_created" placeholder="Enter Date" autocomplete="off">
                                </div>

                                <div class="form-group col-sm-3 ">
                                    <label for="created_by"> Created By <span class="text-danger">*</span> </label>
                                    <select class="form-control form-control-sm" id="created_by" name="created_by">
                                        <option value="">Select...</option>
                                    </select>
                                    <div id="created_by_id_error"></div>
                                </div>

                                <div class="form-group col-sm-3 ">
                                    <label for="approved_by"> Approved By </label>
                                    <select class="form-control form-control-sm" id="approved_by" name="approved_by">
                                        <option value="">Select...</option>
                                    </select>
                                    <div id="approved_by_id_error"></div>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="documents">Documents </label>
                                    <input type="file" class="form-control form-control-sm" id="documents" name="documents" autocomplete="off">
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="video">Video  </label>
                                    <input type="file" class="form-control form-control-sm" id="video" name="video" autocomplete="off">
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="remarks">Remarks</label>
                                    <textarea class="form-control form-control-sm" id="remarks" name="remarks" placeholder="Enter Remarks" autocomplete="off"></textarea>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="value_id">Value <span class="text-danger">*</span></label>
                                    <select class="form-control form-control-sm select2" id="value_id" name="value_id">
                                        <option value="">Select..</option>
                                        <?php foreach ($values as $cr) : ?>
                                            <option value="<?php echo $cr['id'] ?>"><?php echo $cr['name'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <div id="value_id_error"></div>
                                </div>

                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-sm btn-submit float-right" id="addBtn">Add</button>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-sm table-striped" id="colorTable">
                                        <thead>
                                        <tr>
                                            <th>Operation ID</th>
                                            <th>Operation Name</th>
                                            <th>Description</th>
                                            <th>Criticality</th>
                                            <th>Machine</th>
                                            <th>SMV</th>
                                            <th>Rate</th>
                                            <th>Date Created</th>
                                            <th>Created By</th>
                                            <th>Approved By</th>
                                            <th>Documents</th>
                                            <th>Video</th>
                                            <th>Remarks</th>
                                            <th>Value</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary btn-sm" id="saveChanges">Save changes</button>
                    </div>

                </form>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<?php endif; ?>

<div class="modal fade" tabindex="-1" role="dialog" id="viewModal">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">View Machine Requirement : <strong> <span id="view_machine_requirements"></span></strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="viewMsg"></div>
                <div id="viewResponse"></div>

            </div>
            <div class="modal-footer">

                <?php if (in_array('createMachineRequest', $user_permission)): ?>
                    <button type="button" class="btn btn-secondary btn-sm float-left" id="request-btn">Create Machine Request</button>
                <?php endif; ?>

                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
            </div>


        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php if (in_array('createMachineRequest', $user_permission)): ?>

    <div class="modal fade" tabindex="-1" role="dialog" id="requestModal">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Machine Request </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="requestMsg"></div>
                    <div id="requestResponse"></div>

                </div>
                <div class="modal-footer">

                    <?php if (in_array('createMachineRequest', $user_permission)): ?>
                        <button type="button" class="btn btn-secondary btn-sm float-left" id="request-confirm-btn">Confirm</button>
                    <?php endif; ?>

                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                </div>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

<?php endif; ?>

