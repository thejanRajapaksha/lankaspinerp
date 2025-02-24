<div class="container-fluid mt-2">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h2 class="">Machine Repair Requests</h2>
                </div>
                <div class="col">
                    <?php if (in_array('createMachineRepairRequest', $user_permission)): ?>
                        <button class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target="#addModal">
                            Add Machine Repair Request
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
                        <th>BarCode</th>
                        <th>Serial No</th>
                        <th>Repair Request Date</th>
                        <?php if (in_array('updateMachineRepairRequest', $user_permission) || in_array('deleteMachineRepairRequest', $user_permission)): ?>
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

<?php if (in_array('createMachineRepairRequest', $user_permission)): ?>
    <!-- create brand modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="addModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Machine RepairRequest</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>

                <form role="form" action="<?php echo base_url('MachineRepairRequests/create') ?>" method="post"
                      id="createForm">

                    <div class="modal-body">

<!--                        <div class="form-group">-->
<!--                            <label for="service_no">RepairRequest No</label>-->
<!--                            <input type="text" class="form-control form-control-sm" id="service_no" name="service_no"-->
<!--                                   placeholder="Enter RepairRequest No" autocomplete="off" readonly>-->
<!--                        </div>-->

                        <div class="form-group">
                            <label for="machine_in_id">Machine</label>
                            <select class="form-control form-control-sm" id="machine_in_id" name="machine_in_id">
                                <option value="">Select...</option>
                            </select>
                            <div id="machine_in_id_error"></div>
                        </div>

                        <div class="form-group">
                            <label for="factory_code">Factory Code</label>
                            <input type="text" id="factory_code" readonly class="form-control form-control-sm"
                                   name="factory_code" placeholder="">
                        </div>

                        <div class="form-group">
                            <label for="repair_date">Repair Request Date</label>
                            <input type="date" class="form-control form-control-sm" id="repair_date"
                                   name="repair_date" placeholder="Enter Date" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="item_list">Request Item List</label>
                            <input type="textarea" class="form-control form-control-sm" id="item_list"
                                   name="item_list" placeholder="Request Ite List..." autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="comment">Comment</label>
                            <input type="textarea" class="form-control form-control-sm" id="comment"
                                   name="comment" placeholder="Comment..." autocomplete="off">
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

<?php if (in_array('updateMachineRepairRequest', $user_permission)): ?>
    <!-- edit brand modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="editModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Machine RepairRequest</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>

                <form role="form" action="<?php echo base_url('MachineRepairRequests/update') ?>" method="post"
                      id="updateForm">

                    <div class="modal-body">

                        <div class="form-group">
                            <label for="edit_machine_in_id">Machine</label>
                            <select class="form-control form-control-sm" id="edit_machine_in_id" name="edit_machine_in_id">
                                <option value="">Select...</option>
                            </select>
                            <div id="edit_machine_in_id_error"></div>
                        </div>

                        <div class="form-group">
                            <label for="edit_factory_code">Factory Code</label>
                            <input type="text" id="edit_factory_code" readonly class="form-control form-control-sm"
                                   name="factory_code" placeholder="">
                        </div>

                        <div class="form-group">
                            <label for="edit_service_date">Repair Request Date</label>
                            <input type="date" class="form-control form-control-sm" id="edit_repair_date"
                                   name="edit_repair_date" placeholder="Enter Date" autocomplete="off">
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

<?php if (in_array('deleteMachineRepairRequest', $user_permission)): ?>
    <!-- remove brand modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Remove Machine Repair Request</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>

                <form role="form" action="<?php echo base_url('MachineRepairRequests/remove') ?>" method="post"
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

<?php if (in_array('createMachineRepair', $user_permission)): ?>
    <!-- create brand modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="repairAddModal">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Repair Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>

                <div class="modal-body">

                    <div class="row mb-4">
<!--                        <div class="col-sm-3">-->
<!--                            <label for="service_date">Service No :</label>-->
<!--                            <span id="service_no_span"></span>-->
<!--                        </div>-->
                        <div class="col-sm-3">
                            <label for="service_date">Machine Type :</label>
                            <span id="machine_type_span"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-3">
                            <form method="post" id="service_item_add_form">
                                <div class="form-group">
                                    <label for="service_item_id">Service Item</label>
                                    <select class="form-control form-control-sm" id="service_item_id"
                                            name="service_item_id" required>
                                        <option value="">Select...</option>
                                    </select>
                                    <div id="service_item_id_error"></div>
                                </div>
                                <div class="form-group">
                                    <label for="quantity">Quantity</label>
                                    <input type="number" class="form-control form-control-sm" id="quantity"
                                           name="quantity" step="0.01"
                                           placeholder="Quantity" required>
                                </div>
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="number" class="form-control form-control-sm" id="price" name="price"
                                           step="0.01"
                                           placeholder="Price" required>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-sm btn-success float-right"
                                            id="btn_add_service_item">Add
                                    </button>
                                </div>
                            </form>

                        </div>
                        <div class="col-sm-9">
                            <h5>Repair Detail</h5>
                            <hr>
                            <div id="modal_msg"></div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm" id="service_detail_table">
                                    <thead>
                                    <tr>
                                        <th>Service Item</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="3" align="right"><label> Sub Total</label></td>
                                        <td id="sub_total"></td>
                                        <td></td>
                                    </tfoot>
                                </table>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="repair_done_by">Repair Done By</label>
                                        <select class="form-control form-control-sm" id="repair_done_by" name="repair_done_by"
                                                required>
                                            <option value="">Select...</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="repair_charge">Repair Charge</label>
                                        <input type="number" step="0.01" class="form-control form-control-sm"
                                               id="repair_charge"
                                               name="repair_charge" placeholder="">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="transport_charge">Transport Charge</label>
                                        <input type="number" step="0.01" class="form-control form-control-sm"
                                               id="transport_charge"
                                               name="transport_charge" placeholder="">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="repair_type">Repair Type</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="repair_type"
                                                   id="repair_type_inside" value="inside" checked>
                                            <label class="form-check-label" for="repair_type_inside">Inside</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="repair_type"
                                                   id="repair_type_outside" value="outside">
                                            <label class="form-check-label" for="repair_type_outside">Outside</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="remarks">Remarks</label>
                                        <textarea class="form-control form-control-sm" id="remarks" name="remarks"
                                                  placeholder="Remarks"></textarea>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-sm" id="save_btn">Save changes</button>
                </div>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<?php endif; ?>

<?php if (in_array('createMachineRepairPostpone', $user_permission)): ?>
    <!-- create brand modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="postponeModal">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Postpone Repair</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>

                <form method="post" id="postpone_repair_form">

                    <div class="modal-body">

                        <div class="row mb-4">
<!--                            <div class="col-sm-6">-->
<!--                                <label for="service_date">Service No :</label>-->
<!--                                <span id="postpone_service_no_span"></span>-->
<!--                            </div>-->
                            <div class="col-sm-12">
                                <label for="service_date">Machine Type :</label>
                                <span id="postpone_machine_type_span"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="repair_in_date">Repair In Date</label>
                            <input type="date" class="form-control form-control-sm" id="repair_in_date"
                                   name="repair_in_date"
                                   placeholder="Repair In Date" required>
                        </div>
                        <div class="form-group">
                            <label for="reason">Reason</label>
                            <textarea class="form-control form-control-sm" id="reason" name="reason"
                                      placeholder="Reason" required></textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm" id="postpne_save_btn">Save changes</button>
                    </div>

                </form>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<?php endif; ?>


