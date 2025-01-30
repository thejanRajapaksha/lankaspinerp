<div class="container-fluid mt-2">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h2 class="">Machine Requirements</h2>
                </div>
                <div class="col">
                    <?php if (in_array('createMachineRequirement', $user_permission)): ?>
                        <button class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target="#addModal">
                            New Machine Requirement
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
                        <th>Forecast</th>
                        <th>Factory</th>
                        <th>Department</th>
                        <th>Section</th>
                        <th>Line</th>
                        <th>Requirement ID</th>
                        <th>Required Date</th>
                        <th>Total Requests</th>
                        <?php if (in_array('updateMachineRequirement', $user_permission) || in_array('deleteMachineRequirement', $user_permission)): ?>
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

<?php if (in_array('createMachineRequirement', $user_permission)): ?>
    <!-- create brand modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="addModal">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Machine Requirement</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>

                <form role="form" action="<?php echo base_url('MachineRequirements/create') ?>" method="post" id="createForm">

                    <div class="modal-body">

                        <div id="msgCreate"></div>

                        <div class="row">
                            <div class="col-md-3">

                                <div class="form-group">
                                    <label for="forecast">Forecast</label>
                                    <input type="text" class="form-control form-control-sm" id="forecast" name="forecast">
                                </div>

                                <div class="form-group">
                                    <label for="factory_id">Factory</label>
                                    <select class="form-control form-control-sm" id="factory_id" name="factory_id">
                                        <option value="">Select factory</option>
                                    </select>
                                    <div id="factory_id_error"></div>
                                </div>

                                <div class="form-group">
                                    <label for="department_id">Department</label>
                                    <select class="form-control form-control-sm" id="department_id" name="department_id">
                                        <option value="">Select department</option>
                                    </select>
                                    <div id="department_id_error"></div>
                                </div>

                                <div class="form-group">
                                    <label for="section_id">Section</label>
                                    <select class="form-control form-control-sm" id="section_id" name="section_id">
                                        <option value="">Select section</option>
                                    </select>
                                    <div id="section_id_error"></div>
                                </div>

                                <div class="form-group">
                                    <label for="line_id">Line</label>
                                    <select class="form-control form-control-sm" id="line_id" name="line_id">
                                        <option value="">Select Line</option>
                                    </select>
                                    <div id="line_id_error"></div>
                                </div>

                                <div class="form-group">
                                    <label for="machine_type_id">Machine Type <span class="text-danger">*</span> </label>
                                    <select name="machine_type_id" id="machine_type_id" class="select2 form-control form-control-sm">
                                        <option value="">Select Machine Type</option>
                                        <?php foreach ($machine_types as $machine_type) : ?>
                                            <option value="<?php echo $machine_type['id'] ?>"><?php echo $machine_type['name'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <div id="machine_type_id_error"></div>
                                </div>

<!--                                <div class="form-group">-->
<!--                                    <label for="machine_model_id">Machine Model <span class="text-danger">*</span></label>-->
<!--                                    <select name="machine_model_id" id="machine_model_id" class="select2 form-control form-control-sm">-->
<!--                                        <option value="">Select Machine Model</option>-->
<!--                                        --><?php //foreach ($machine_models as $machine_model) : ?>
<!--                                            <option value="--><?php //echo $machine_model['id'] ?><!--">--><?php //echo $machine_model['name'] ?><!--</option>-->
<!--                                        --><?php //endforeach ?>
<!--                                    </select>-->
<!--                                    <div id="machine_model_id_error"></div>-->
<!--                                </div>-->

                                <div class="form-group">
                                    <label for="from_date">From Date <span class="text-danger">*</span> </label>
                                    <input type="date" class="form-control form-control-sm" id="from_date" name="from_date" placeholder="Enter From Date">
                                </div>

                                <div class="form-group">
                                    <label for="to_date">To Date <span class="text-danger">*</span> </label>
                                    <input type="date" class="form-control form-control-sm" id="to_date" name="to_date" placeholder="Enter To Date">
                                </div>

                                <div class="form-group">
                                    <label for="quantity">Quantity <span class="text-danger">*</span> </label>
                                    <input type="number" class="form-control form-control-sm" id="quantity" name="quantity" placeholder="Enter Quantity" autocomplete="off">
                                </div>

                                <div class="form-group">
                                    <label for="brand_name">Remarks</label>
                                    <textarea class="form-control form-control-sm" id="remarks" name="remarks" placeholder="Enter Remarks" autocomplete="off"></textarea>
                                </div>

                                <div class="form-group">
                                    <button type="button" class="btn btn-primary btn-sm btn-submit float-right" id="addBtn">Add</button>
                                </div>

                            </div>
                            <div class="col-md-9">
                                <div class="table-responsive">
                                    <table class="table table-sm table-striped" id="colorTable">
                                        <thead>
                                        <tr>
                                            <th>Forecast</th>
                                            <th>Factory</th>
                                            <th>Department</th>
                                            <th>Section</th>
                                            <th>Line</th>
                                            <th>Machine Type</th>
                                            <th>From Date</th>
                                            <th>To Date</th>
                                            <th>Quantity</th>
                                            <th>Remarks</th>
                                            <th>Action</th>
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

