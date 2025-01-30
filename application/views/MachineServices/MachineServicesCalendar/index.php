<style>
    .fc-daygrid-event {
        text-align: center;
    }
</style>

<div class="container-fluid mt-2">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h2 class="">Machine Services Calendar</h2>
                </div>
                <div class="col">
                </div>
            </div>
            <hr>
            <div id="messages"></div>
            <div class="row">
                <div class="col">
                    <div id='calendar'></div>

                    <div class="mt-2">
                        <button class="btn btn-default btn-sm" style="background-color: #00b7eb"></button>
                        New &nbsp;
                        <button class="btn btn-default btn-sm" style="background-color: #77dd77"></button>
                        Service Created &nbsp;
                        <button class="btn btn-default btn-sm" style="background-color: #33ffbd"></button>
                        Current &nbsp;
                        <button class="btn btn-default btn-sm" style="background-color: #ff6347"></button>
                        Postponed &nbsp;
                        <button class="btn btn-default btn-sm" style="background-color: #ff0000"></button>
                        Overdue &nbsp;
                        <button class="btn btn-default btn-sm" style="background-color: #560319"></button>
                        Postponed & Overdue &nbsp;
                    </div>

                    <div class="card mt-3">
                        <div class="card-body">
                            <h2 class=""> Service Event Details </h2>
                            <div id="service_res"></div>
                        </div>
                    </div>

                </div>
                <div class="col">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="">Required Spare Parts for today (<?= date('Y-m-d') ?>) </h2>
                                    <table class="table table-sm">
                                        <thead>
                                        <tr>
                                            <th>Spare Part</th>
                                            <th>Quantity</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        foreach ($sp as $s) {
                                            echo '<tr>';
                                            echo '<td> ' . $s['name'] . ' </td>';
                                            echo '<td> ' . $s['total_rec'] . ' </td>';
                                            echo '</tr>';
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">

                        </div>
                    </div>

                </div>
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
                    <h5 class="modal-title">Service Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>

                <div class="modal-body">

                    <div class="row mb-4">
                        <div class="col-sm-3">
                            <label for="service_date">Service No :</label>
                            <span id="service_no_span"></span>
                            <input type="hidden" id="service_id_span">
                        </div>
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
                            <h5>Service Detail</h5>
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
                                        <label for="service_done_by">Service Done By</label>
                                        <select class="form-control form-control-sm" id="service_done_by"
                                                name="service_done_by"
                                                required>
                                            <option value="">Select...</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="service_charge">Service Charge</label>
                                        <input type="number" step="0.01" class="form-control form-control-sm"
                                               id="service_charge"
                                               name="service_charge" placeholder="">
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
                                        <label for="service_type">Service Type</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="service_type"
                                                   id="service_type_inside" value="inside" checked>
                                            <label class="form-check-label" for="service_type_inside">Inside</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="service_type"
                                                   id="service_type_outside" value="outside">
                                            <label class="form-check-label" for="service_type_outside">Outside</label>
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

<?php if (in_array('createMachineService', $user_permission)): ?>
    <!-- create brand modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="postponeModal">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Postpone Service</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>

                <form method="post" id="postpone_service_form">

                    <div class="modal-body">

                        <div class="row mb-4">
                            <div class="col-sm-6">
                                <label for="service_date">Service No :</label>
                                <span id="postpone_service_no_span"></span>
                            </div>
                            <div class="col-sm-6">
                                <label for="service_date">Machine Type :</label>
                                <span id="postpone_machine_type_span"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="service_date">Service Date</label>
                            <input type="date" class="form-control form-control-sm" id="service_date"
                                   name="service_date"
                                   placeholder="Service Date" required>
                        </div>
                        <div class="form-group">
                            <label for="reason">Reason</label>
                            <textarea class="form-control form-control-sm" id="reason" name="reason"
                                      placeholder="Reason" required></textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm" id="save_btn">Save changes</button>
                    </div>

                </form>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<?php endif; ?>

<div class="modal fade" tabindex="-1" role="dialog" id="deleteModal">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Service</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>

            <form method="post" id="delete_service_form">

                <div class="modal-body">

                    <p>Do you really want to remove?</p>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm" id="save_btn">Save Changes</button>
                </div>

            </form>


        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="viewModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">View Issued Service Items : <strong> <span id="machine_type_name"></span></strong></h5>
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







