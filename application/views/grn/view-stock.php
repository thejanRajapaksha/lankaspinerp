<div class="container-fluid mt-2">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h2 class="">Stock Report</h2>
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
                        <th>Product</th>
                        <th>Available Quantity</th>
                        <th>Allocated Quantity</th>
                        <th> </th>
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
                <h5 class="modal-title">View Allocated Records : <strong> <span id="service_item_name"></span></strong></h5>
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

<?php if (in_array('deleteMachineServiceItemAllocate', $user_permission)): ?>
    <!-- remove brand modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Remove Service Item Allocation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>

                <form role="form" action="<?php echo base_url('MachineServices/remove_allocation') ?>" method="post"
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




