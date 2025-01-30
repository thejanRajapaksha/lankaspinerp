<div class="container-fluid mt-2">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h2 class="">Machine Operation Product Summery</h2>
                </div>
                <div class="col">

                </div>
            </div>
            <hr>
            <div id="messages"></div>

            <div class="row mb-4 ">

                <div class="col-sm-2 mb-2">
                    <br>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" value="operation" id="rad_operation" name="operation" checked >Operation
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" value="product" id="rad_product" name="operation" >Product
                        </label>
                    </div>
                </div>

                <div class="col-sm-3 mb-2">
                    <label for="operation_filter"> Operation </label>
                    <select class="form-control form-control-sm" id="operation_filter" >
                        <option value="">Select...</option>
                    </select>
                </div>

                <div class="col-sm-3 mb-2">
                    <label for="product_filter"> Product </label>
                    <select class="form-control form-control-sm" id="product_filter" >
                        <option value="">Select...</option>
                    </select>
                </div>

                <div class="col-sm-2 mb-2">
                    <label for="date_from_filter"> Date From </label>
                    <input type="date" class="form-control-sm form-control" id="date_from_filter" value="<?= Date('Y-m-d') ?>"/>
                </div>

                <div class="col-sm-2 mb-2">
                    <label for="date_to_filter"> Date To </label>
                    <input type="date" class="form-control-sm form-control" id="date_to_filter" value="<?= Date('Y-m-d') ?>"/>
                </div>

                <div class="col-sm-12 mb-2">
                    <label>&nbsp;</label> <br>
                    <button type="button" class="btn btn-primary btn-sm float-right" id="filter_button" style="min-width: 100px;">Search</button>
                </div>

            </div>
            <hr>

            <div id="search_res"></div>
            <div id="search_res2"></div>



        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="viewModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">View Products : <strong> <span id="machine_name"></span></strong></h5>
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

<div class="modal fade" tabindex="-1" role="dialog" id="viewEmpModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">View Employee Skills : <strong> <span id="emp_name"></span></strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="viewEmpMsg"></div>
                <div id="viewEmpResponse"></div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
            </div>


        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->