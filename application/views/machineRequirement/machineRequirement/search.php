<div class="container-fluid mt-2">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h2 class="">Machine Requirements View</h2>
                </div>
                <div class="col">

                </div>
            </div>
            <hr>
            <div id="messages"></div>

            <div class="row mb-4 ">

                <div class="col-sm-3 mb-2">
                    <br>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" value="factory" id="rad_factory" name="factory" >Factory
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" value="line" id="rad_line" name="factory" checked>Line
                        </label>
                    </div>
                </div>

                <div class="col-sm-3 mb-2">
                    <label for="forecast_filter"> Forecast </label>
                    <select class="form-control form-control-sm" id="forecast_filter" >
                        <option value="">Select...</option>
                    </select>
                </div>

                <div class="col-sm-3 mb-2">
                    <label for="factory_id_filter"> Factory </label>
                    <select class="form-control form-control-sm" id="factory_id_filter" >
                        <option value="">Select...</option>
                        <?php foreach($factories as $factory): ?>
                            <option value="<?php echo $factory['id'] ?>"><?php echo $factory['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-sm-3 mb-2 line_select">
                    <label for="line_id_filter"> Line </label>
                    <select class="form-control form-control-sm" id="line_id_filter" >
                        <option value="">Select...</option>
                    </select>
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
                <h5 class="modal-title">View Machines : <strong> <span id="machine_name"></span></strong></h5>
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