<div class="container-fluid mt-2">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h2 class="">Machine Repairs Cost Analysis</h2>
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
                        <th>Repair Charge</th>
                        <th>Transport Charge</th>
                        <th>Remarks</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card mt-2">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h4 class="">Monthly Repair Cost Chart</h4>
                </div>
                <div class="col">
                </div>
            </div>
            <hr>

            <canvas id="monthly_repair_cost_chart"></canvas>

        </div>
    </div>

    <div class="card mt-2">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h4 class="">Machine Type And Repair Counts Chart</h4>
                </div>
                <div class="col-sm-2">
                    <input type="date" rel="txtTooltip" title="Today records shown by default." data-toggle="tooltip" data-placement="left" class="form-control form-control-sm" id="machine_type_chart_date_filter" value="<?= date('Y-m-d') ?>" />
                </div>
            </div>
            <hr>

            <canvas id="machine_type_chart"></canvas>

        </div>
    </div>

</div>

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
                        <label for="repair_date">Repair No :</label>
                        <span id="view_repair_no_span"></span>
                    </div>
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
                                </tr>
                                <tr>
                                    <td colspan="3" align="right"><label> Repair Charge</label></td>
                                    <td align="right" id="repair_charge_span"></td>
                                </tr>
                                <tr>
                                    <td colspan="3" align="right"><label> Transport Charge</label></td>
                                    <td align="right" id="transport_charge_span"></td>
                                </tr>
                                <tr>
                                    <td colspan="3" align="right"><label> Total</label></td>
                                    <td align="right" id="total_span"></td>
                                </tr>
                                </tfoot>
                            </table>
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




