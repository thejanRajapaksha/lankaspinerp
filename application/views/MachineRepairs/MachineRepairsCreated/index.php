<div class="container-fluid mt-2">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h2 class="">Machine Repairs Created</h2>
                </div>
                <div class="col">
                </div>
            </div>
            <hr>
            <div id="messages"></div>

            <div class="row mb-4 ">
                <div class="col-sm-3 mb-2">
                    <label for="status_filter"> Status </label>
                    <select class="form-control form-control-sm select2" id="status_filter" name="status">
                        <option value="" disabled selected>Select...</option>
                        <option value="0">Pending</option>
                        <option value="1">Completed</option>
                    </select>
                </div>
                <div class="col-sm-3 mb-2">
                    <label for="repair_type_filter"> Repair Type </label>
                    <select class="form-control form-control-sm select2" id="repair_type_filter" name="repair_type">
                        <option value="" disabled selected>Select...</option>
                        <option value="inside">Inside</option>
                        <option value="outside">Outside</option>
                    </select>
                </div>
                <div class="col-sm-3 mb-2">
                    <label for="machine_type_filter"> Machine Type </label>
                    <select class="form-control form-control-sm" id="machine_type_filter" name="machine_type">
                        <option value="">Select...</option>
                    </select>
                </div>
                <div class="col-sm-3 mb-2">
                    <label for="s_no_filter"> Machine Serial No </label>
                    <select class="form-control form-control-sm" id="s_no_filter" name="s_no">
                        <option value="">Select...</option>
                    </select>
                </div>
                <div class="col-sm-3 mb-2">
                    <label>Date From</label>
                    <input type="date" class="form-control form-control-sm" id="date_from_filter" name="date_from" placeholder="Date From">
                </div>
                <div class="col-sm-3 mb-2">
                    <label>Date To</label>
                    <input type="date" class="form-control form-control-sm" id="date_to_filter" name="date_to" placeholder="Date To">
                </div>
                <div class="col-sm-3 mb-2">
                    <label>&nbsp;</label> <br>
                    <button type="button" class="btn btn-primary btn-sm" id="filter_button" style="min-width: 100px;">Filter</button>
                </div>

            </div>
            <hr>

            <div class="table-responsive">
                <table id="manageTable" class="table table-bordered table-striped table-sm">
                    <thead>
                    <tr>
                        <th>Machine Type</th>
                        <th>BarCode</th>
                        <th>Serial No</th>
                        <th>Repair Date</th>
                        <th>Repair Type</th>
                        <th>Sub Total</th>
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

<?php if (in_array('updateMachineRepairCreated', $user_permission)): ?>
    <!-- edit brand modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="editModal">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Repair Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>

                <div class="modal-body">

                    <div class="row mb-4">
                        <div class="col-sm-3">
                            <label for="repair_date">Machine Type :</label>
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
                                        <td align="right" id="sub_total"></td>
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
                                                   id="repair_type_inside" value="inside">
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

<div class="modal fade" tabindex="-1" role="dialog" id="viewModal">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">View Repair Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">

                <div class="row mb-4">
                    <div class="col-sm-3">
                        <label for="repair_date">Machine Type :</label>
                        <span id="view_machine_type_span"></span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <h5>Repair Detail</h5>
                        <hr>
                        <div id="modal_msg"></div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm" id="view_service_detail_table">
                                <thead>
                                <tr>
                                    <th>Service Item</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="3" align="right"><label> Sub Total</label></td>
                                    <td align="right" id="sub_total_span"></td>
                                </tfoot>
                            </table>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="repair_done_by">Repair Done By : </label>
                                    <span id="repair_done_by_span"></span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="repair_charge">Repair Charge : </label>
                                    <span id="repair_charge_span"></span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="transport_charge">Transport Charge : </label>
                                    <span id="transport_charge_span"></span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="repair_type">Repair Type : </label>
                                    <span id="repair_type_span"></span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="remarks">Remarks : </label>
                                    <span id="remarks_span"></span>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
            </div>


        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php if (in_array('deleteMachineRepair', $user_permission)): ?>
    <!-- remove brand modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Remove Machine Repair</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>

                <form role="form" action="<?php echo base_url('MachineRepairsCreated/remove') ?>" method="post"
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

    <!-- remove brand modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="completeModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Complete Machine Repair</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>

                <form role="form" action="<?php echo base_url('MachineRepairsCreated/complete') ?>" method="post"
                      id="completeForm">
                    <div class="modal-body">
                        <p>Do you really want to Complete?</p>

                        <label for="complete_remarks">Remarks : </label>
                        <textarea class="form-control" name="complete_remarks" id="complete_remarks" rows="3"></textarea>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm">Save changes</button>
                    </div>
                </form>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- remove brand modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="removeCompleteModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Remove Complete Status</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>

                <form role="form" action="<?php echo base_url('MachineRepairsCreated/removeComplete') ?>" method="post"
                      id="removeCompleteForm">
                    <div class="modal-body">
                        <p>Do you really want to Remove Complete Status?</p>

                        <label for="complete_remarks">Remarks : </label>
                        <textarea class="form-control" name="complete_remarks" id="remove_complete_remarks" rows="3"></textarea>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm">Save changes</button>
                    </div>
                </form>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->



