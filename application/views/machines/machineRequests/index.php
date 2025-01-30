<div class="container-fluid mt-2">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h2 class="">Machine Requests</h2>
                </div>
                <div class="col">
                    <?php if (in_array('createMachineRequest', $user_permission)): ?>
                        <button class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target="#addModal">
                            New Machine Request
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
                        <th>Request ID</th>
                        <th>Request Date</th>
                        <th>Total Requests</th>
                        <?php if (in_array('updateMachineRequest', $user_permission) || in_array('deleteMachineRequest', $user_permission)): ?>
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

<?php if (in_array('createMachineRequest', $user_permission)): ?>
    <!-- create brand modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="addModal">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Machine Requests</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>

                <form role="form" action="<?php echo base_url('MachineRequests/create') ?>" method="post" id="createForm">

                    <div class="modal-body">

                        <div id="msgCreate"></div>

                        <div class="row">
                            <div class="col-md-3">

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

                                <div class="form-group">
                                    <label for="machine_model_id">Machine Model <span class="text-danger">*</span></label>
                                    <select name="machine_model_id" id="machine_model_id" class="select2 form-control form-control-sm">
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
                                            <th>Machine Type</th>
                                            <th>Machine Model</th>
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

<?php if (in_array('updateMachineRequest', $user_permission)): ?>
    <!-- edit brand modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="editModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Style Color : <strong> <span id="edit_color_name"></span> </strong> </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>

                <div class="modal-body">
                    <div id="msgEdit"></div>
                    <div id="edit_html">

                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm" id="edit-btn">Save changes</button>
                </div>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<?php endif; ?>

<?php if (in_array('deleteMachineRequest', $user_permission)): ?>
    <!-- remove brand modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Remove Style Color</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>

                <form role="form" action="<?php echo base_url('MachineRequests/remove') ?>" method="post" id="removeForm">
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
                <h5 class="modal-title">View Machine Requests : <strong> <span id="view_machine_requests"></span></strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="viewMsg"></div>
                <div id="viewResponse"></div>

            </div>
            <div class="modal-footer">
                <?php if (in_array('createMachineRequestApprove', $user_permission)): ?>
                    <button type="button" class="btn btn-primary btn-sm float-left" id="approve-btn">Approve</button>
                <?php endif; ?>

                <?php if (in_array('createMachineRentRequest', $user_permission)): ?>
                    <button type="button" class="btn btn-secondary btn-sm float-left" id="rent-btn">Create Rent Request</button>
                <?php endif; ?>

                <?php if (in_array('createMachineOnLoanRequest', $user_permission)): ?>
                    <button type="button" class="btn btn-success btn-sm float-left" id="issue-released-btn">Create On Loan Request</button>
                <?php endif; ?>

                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
            </div>


        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php if (in_array('createMachineRentRequest', $user_permission)): ?>

    <div class="modal fade" tabindex="-1" role="dialog" id="rentModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Rent Request </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="rentMsg"></div>
                    <div id="rentResponse"></div>

                </div>
                <div class="modal-footer">

                    <?php if (in_array('createMachineRentRequest', $user_permission)): ?>
                        <button type="button" class="btn btn-secondary btn-sm float-left" id="rent-confirm-btn">Confirm</button>
                    <?php endif; ?>

                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                </div>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

<?php endif; ?>

<?php if (in_array('createMachineOnLoanRequest', $user_permission)): ?>

    <div class="modal fade" tabindex="-1" role="dialog" id="issueModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">On Loan Requests </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="issueMsg"></div>
                    <div id="issueResponse"></div>

                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary btn-sm float-left" id="issue-confirm-btn">Issue</button>

                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                </div>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

<?php endif; ?>

<?php if (in_array('createMachineRequestApprove', $user_permission)): ?>

    <div class="modal fade" tabindex="-1" role="dialog" id="approveModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Approve Requests </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="approveMsg"></div>
                    <div id="approveResponse"></div>

                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary btn-sm float-left" id="approve-confirm-btn">Approve</button>

                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                </div>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

<?php endif; ?>



