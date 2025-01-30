<div class="container-fluid mt-2">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h2 class="">Employee Machine Services</h2>
                </div>
                <div class="col">

                </div>
            </div>
            <hr>
            <div id="messages"></div>

            <div class="row mb-4 ">
                <div class="col-sm-3 mb-2">
                    <label for="employee_filter"> Employee </label>
                    <select class="form-control form-control-sm" id="employee_filter" name="employee_id">
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
                        <th>Employee Name</th>
                        <th>No of Services</th>
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

<div class="modal fade" tabindex="-1" role="dialog" id="viewModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">View Employee Services : <strong> <span id="employee_name"></span></strong></h5>
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




