<div class="container-fluid mt-2">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h2 class="">Service Item Return To Stock</h2>
                </div>
                <div class="col">
                    <?php if (in_array('createMachineServiceItemReturn', $user_permission)): ?>
                        <button class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target="#addModal">
                            New Return
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
                        <th>Service No</th>
                        <th>Machine Type</th>
                        <th>Machine Serial No</th>
                        <th>Service Date From</th>
                        <th>Service Date To</th>
                        <th>Estimated Service Hours</th>
                        <?php if (in_array('updateMachineServiceItemReturn', $user_permission) || in_array('deleteMachineServiceItemReturn', $user_permission)): ?>
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

<?php if (in_array('createMachineServiceItemReturn', $user_permission)): ?>
    <!-- create brand modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="addModal">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Service Item Return</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>

                <form role="form" action="<?php echo base_url('MachineServices/return_to_stock_new') ?>" method="post"
                      id="createForm">

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="service_no">Service No</label>
                                    <select class="form-control form-control-sm" id="service_no" name="service_no">
                                        <option value="">Select...</option>
                                    </select>
                                    <div id="service_no_error"></div>
                                </div>

                                <div class="form-group">
                                    <div class="info"></div>
                                </div>

                            </div>
                            <div class="col-md-9">

                                <div class="form-group table-responsive">
                                    <table class="table table-sm" id="colorTable">
                                        <thead>
                                        <tr>
                                            <th> Spare Part </th>
                                            <th> Issued Quantity </th>
                                            <th> Returned Quantity </th>
                                            <th> New Return Quantity </th>
                                            <th>  </th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>

                                <div class="form-group">
                                    <label>Remarks</label>
                                    <textarea cols="3" class="form-control form-control-sm" name="remarks"></textarea>
                                </div>

                            </div>
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

<?php if (in_array('updateMachineServiceItemIssue', $user_permission)): ?>
    <!-- edit brand modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="editModal">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Service Item Return : <span id="service_no_span"></span> </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>

                <form role="form" action="<?php echo base_url('MachineServices/update_return_to_stock') ?>" method="post"
                      id="updateForm">

                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-12">
                                <div id="edit_res"></div>

                                <span id="edit_service_no"></span>

                            </div>
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

<?php if (in_array('deleteMachineServiceItemAllocate', $user_permission)): ?>
    <!-- remove brand modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Remove Service Item Receive</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>

                <form role="form" action="<?php echo base_url('MachineServices/remove_return_to_stock') ?>" method="post"
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

<div class="modal fade" tabindex="-1" role="dialog" id="viewModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">View Received Service Items : <strong> <span id="machine_type_name"></span></strong></h5>
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

<form role="form" action="<?php echo base_url('MachineServices/return_to_stock_new_accept') ?>" method="post"
      id="acceptForm">
    <div class="modal fade" tabindex="-1" role="dialog" id="acceptModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Accept Returned Service Items : <strong> <span id="accept_machine_type_name"></span></strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="acceptMsg"></div>
                    <div id="acceptResponse">
                                <div class="form-group table-responsive">
                                    <table class="table table-sm" id="colorTable2">
                                        <thead>
                                        <tr>
                                            <th> Spare Part </th>
                                            <th> Returned Quantity </th>
                                            <th> Accepted Quantity </th>
                                            <th> New Accept Quantity </th>
                                            <th>  </th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>

                                <div class="form-group">
                                    <label>Remarks</label>
                                    <textarea cols="3" class="form-control form-control-sm" name="remarks"></textarea>
                                </div>

                        <input type="hidden" name="service_no" id="accept_service_id">

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm">Save changes</button>
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                </div>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</form>


