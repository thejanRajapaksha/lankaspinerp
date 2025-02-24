<div class="container-fluid mt-2">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h2 class="">Machine Services</h2>
                </div>
                <div class="col">
                    <?php if (in_array('createMachineService', $user_permission)): ?>
                        <button class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target="#addModal">
                            Add Machine Service
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
                        <th>Service No</th>
                        <th>Job Type</th>
                        <th>Machine Type</th>
                        <th>Machine Serial No</th>
                        <th>Service Date From</th>
                        <th>Service Date To</th>
                        <th>Estimated Service Hours</th>
                        <?php if (in_array('updateMachineService', $user_permission) || in_array('deleteMachineService', $user_permission)): ?>
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

<?php if (in_array('createMachineService', $user_permission)): ?>
    <!-- create brand modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="addModal">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Machine Service</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>

                <form role="form" action="<?php echo base_url('MachineServices/create') ?>" method="post"
                      id="createForm">

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="service_no">Service No</label>
                                    <input type="text" class="form-control form-control-sm" id="service_no" name="service_no"
                                           placeholder="Enter Service No" autocomplete="off" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="service_no">Job Type</label>
                                    <br>
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="is_repair" value="0">Service
                                        </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="is_repair" value="1">Repair
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="machine_in_id">Machine</label>
                                    <select class="form-control form-control-sm" id="machine_in_id" name="machine_in_id">
                                        <option value="">Select...</option>
                                    </select>
                                    <div id="machine_in_id_error"></div>
                                </div>

                                <div class="form-group">
                                    <label for="employee_id">Employee</label>
                                    <select class="form-control form-control-sm" id="employee_id" name="employee_id">
                                        <option value="">Select...</option>
                                    </select>
                                    <div id="employee_id_error"></div>
                                </div>

                                <div class="form-group">
                                    <label for="factory_code">Factory Code</label>
                                    <input type="text" id="factory_code" readonly class="form-control form-control-sm"
                                           name="factory_code" placeholder="">
                                </div>

                                <div class="form-group">
                                    <label for="service_date_from">Service Date From</label>
                                    <input type="datetime-local" class="form-control form-control-sm" id="service_date_from"
                                           name="service_date_from" placeholder="Enter Date" autocomplete="off">
                                </div>

                                <div class="form-group">
                                    <label for="service_date_to">Service Date To</label>
                                    <input type="datetime-local" class="form-control form-control-sm" id="service_date_to"
                                           name="service_date_to" placeholder="Enter Date" autocomplete="off">
                                </div>

                                <div class="form-group">
                                    <label for="estimated_service_hours">Estimated Hours</label>
                                    <input type="number" step="0.01" class="form-control form-control-sm" id="estimated_service_hours"
                                           name="estimated_service_hours" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-6">

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="estimated_service_items">Estimated Service Items</label>
                                            <select class="form-control form-control-sm" id="estimated_service_items" name="estimated_service_items">
                                            </select>
                                            <div id="estimated_service_items_error"></div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="qty">QTY</label>
                                            <input type="number" id="qty" class="form-control form-control-sm" />
                                        </div>
                                    </div>
                                    <button class="btn btn-primary btn-sm mt-2 mb-2 float-right" id="addBtn"> Add </button>
                                </div>

                                <div class="form-group table-responsive">
                                    <table class="table table-sm" id="colorTable">
                                        <thead>
                                            <tr>
                                                <th> Spare Part </th>
                                                <th> Quantity </th>
                                                <th>  </th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>


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

<?php if (in_array('updateMachineService', $user_permission)): ?>
    <!-- edit brand modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="editModal">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit MachineService</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>

                <form role="form" action="<?php echo base_url('MachineServices/update') ?>" method="post"
                      id="updateForm">

                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_service_no">Service No</label>
                                    <input type="text" class="form-control form-control-sm" id="edit_service_no" name="edit_service_no"
                                           placeholder="Enter Service No" autocomplete="off" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="service_no">Job Type</label>
                                    <br>
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" id="service" name="is_repair" value="0">Service
                                        </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" id="repair" name="is_repair" value="1">Repair
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="edit_machine_in_id">Machine</label>
                                    <select class="form-control form-control-sm" id="edit_machine_in_id" name="edit_machine_in_id">
                                        <option value="">Select...</option>
                                    </select>
                                    <div id="edit_machine_in_id_error"></div>
                                </div>

                                <div class="form-group">
                                    <label for="edit_employee_id">Employee</label>
                                    <select class="form-control form-control-sm" id="edit_employee_id" name="edit_employee_id">
                                        <option value="">Select...</option>
                                    </select>
                                    <div id="edit_employee_id_error"></div>
                                </div>

                                <div class="form-group">
                                    <label for="edit_factory_code">Factory Code</label>
                                    <input type="text" id="edit_factory_code" readonly class="form-control form-control-sm"
                                           name="factory_code" placeholder="">
                                </div>

                                <div class="form-group">
                                    <label for="edit_service_date_from">Service Date From</label>
                                    <input type="datetime-local" class="form-control form-control-sm" id="edit_service_date_from"
                                           name="edit_service_date_from" placeholder="Enter Date" autocomplete="off">
                                </div>

                                <div class="form-group">
                                    <label for="edit_service_date_to">Service Date To</label>
                                    <input type="datetime-local" class="form-control form-control-sm" id="edit_service_date_to"
                                           name="edit_service_date_to" placeholder="Enter Date" autocomplete="off">
                                </div>

                                <div class="form-group">
                                    <label for="edit_estimated_service_hours">Estimated Hours</label>
                                    <input type="number" step="0.01" class="form-control form-control-sm" id="edit_estimated_service_hours"
                                           name="edit_estimated_service_hours" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="edit_estimated_service_items">Estimated Service Items</label>
                                            <select class="form-control form-control-sm" id="edit_estimated_service_items" name="edit_estimated_service_items">
                                            </select>
                                            <div id="edit_estimated_service_items"></div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="edit_qty">QTY</label>
                                            <input type="number" id="edit_qty" class="form-control form-control-sm" />
                                        </div>
                                    </div>
                                    <button class="btn btn-primary btn-sm mt-2 mb-2 float-right" id="edit_addBtn"> Add </button>
                                </div>

                                <div class="form-group table-responsive">
                                    <table class="table table-sm" id="edit_colorTable">
                                        <thead>
                                        <tr>
                                            <th> Spare Part </th>
                                            <th> Quantity </th>
                                            <th>  </th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
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

<?php if (in_array('deleteMachineService', $user_permission)): ?>
    <!-- remove brand modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Remove Machine Service</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>

                <form role="form" action="<?php echo base_url('MachineServices/remove') ?>" method="post"
                      id="removeForm">
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

<div class="modal fade" tabindex="-1" role="dialog" id="viewModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">View Estimated Service Items : <strong> <span id="machine_type_name"></span></strong></h5>
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



