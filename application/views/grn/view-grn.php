<div class="container-fluid mt-2">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h2 class="">GRN Report</h2>
                </div>
                <div class="col">

                </div>
            </div>
            <hr>
            <div id="messages"></div>

            <div class="row mb-4 ">
                <div class="col-sm-3 mb-2">
                    <label for="part_no_filter"> Part No </label>
                    <select class="form-control form-control-sm" id="part_no_filter" >
                        <option value="">Select...</option>
                    </select>
                </div>
                <div class="col-sm-3 mb-2">
                    <label for="supplier_filter"> Supplier </label>
                    <select class="form-control form-control-sm" id="supplier_filter" >
                        <option value="">Select...</option>
                    </select>
                </div>
                <div class="col-sm-3 mb-2">
                    <label for="machine_type_filter"> Machine Type </label>
                    <select class="form-control form-control-sm" id="machine_type_filter" >
                        <option value="">Select...</option>
                    </select>
                </div>
<!--                <div class="col-sm-3 mb-2">-->
<!--                    <label>Date From</label>-->
<!--                    <input type="date" class="form-control form-control-sm" id="date_from_filter" name="date_from" placeholder="Date From">-->
<!--                </div>-->
<!--                <div class="col-sm-3 mb-2">-->
<!--                    <label>Date To</label>-->
<!--                    <input type="date" class="form-control form-control-sm" id="date_to_filter" name="date_to" placeholder="Date To">-->
<!--                </div>-->
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
                        <th>GRN Type</th>
                        <th>Date</th>
                        <th>Batch No</th>
                        <th>Supplier</th>
                        <th>Location</th>
                        <th>Invoice No</th>
                        <th>Dispatch No</th>
                        <th>Total</th>
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

<div class="modal fade" id="porderviewmodal" data-backdrop="static" data-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">View Good Receive Note</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="viewhtml"></div>
            </div>
        </div>
    </div>
</div>





