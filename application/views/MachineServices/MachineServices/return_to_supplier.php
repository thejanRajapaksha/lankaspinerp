<div class="container-fluid mt-2">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h2 class="">Return Items to Supplier</h2>
                </div>
                <div class="col">
                    <?php if (in_array('createSparePartReturnToSupplier', $user_permission)): ?>
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
                        <th>Supplier</th>
                        <th>Date</th>
                        <th>Is Approved</th>
                        <?php if (in_array('updateSparePartReturnToSupplier', $user_permission) || in_array('deleteSparePartReturnToSupplier', $user_permission)): ?>
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

<?php if (in_array('createSparePartReturnToSupplier', $user_permission)): ?>
    <!-- create brand modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="addModal">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Return Item to Supplier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>

                <form role="form" action="<?php echo base_url('MachineServices/create_return_to_supplier') ?>" method="post"
                      id="createForm">

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="supplier_id">Supplier</label>
                                    <select class="form-control form-control-sm" id="supplier_id" name="supplier_id">
                                        <option value="">Select</option>
                                    </select>
                                    <div id="supplier_id_error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date">Date </label>
                                    <input type="date" class="form-control form-control-sm" id="date" value="<?= Date('Y-m-d') ?>"
                                           name="date" placeholder="Enter Date" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="item">Item</label>
                                            <select class="form-control form-control-sm" id="spare_part_id" name="spare_part_id">
                                            </select>
                                            <div id="spare_part_id_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="qty">QTY</label>
                                            <input type="number" name="qty" id="qty" class="form-control form-control-sm qty"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <button class="btn btn-primary btn-sm" style="margin-top: 25px;" id="addBtn"> Add </button>
                                    </div>
                                </div>

                                <div class="form-group table-responsive">
                                    <table class="table table-sm" id="colorTable">
                                        <thead>
                                            <tr>
                                                <th> Spare Part </th>
                                                <th> Quantity </th>
                                                <th>  </th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="remarks">Remarks</label>
                                    <textarea cols="3" class="form-control-sm form-control" name="remarks"></textarea>
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

<?php if (in_array('updateSparePartReturnToSupplier', $user_permission)): ?>
    <!-- edit brand modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="editModal">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Spare Part Return To Supplier</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>

                <form role="form" action="<?php echo base_url('MachineServices/update_return_to_supplier') ?>" method="post"
                      id="updateForm">

                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="edit_supplier_id">Supplier</label>
                                    <select class="form-control form-control-sm" id="edit_supplier_id" name="edit_supplier_id">
                                        <option value="">Select</option>
                                    </select>
                                    <div id="supplier_id_error"></div>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_date">Date </label>
                                    <input type="date" class="form-control form-control-sm" id="edit_date" value="<?= Date('Y-m-d') ?>"
                                           name="edit_date" placeholder="Enter Date" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="edit_item">Item</label>
                                            <select class="form-control form-control-sm" id="edit_spare_part_id" name="edit_spare_part_id">
                                            </select>
                                            <div id="edit_spare_part_id_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="edit_qty">QTY</label>
                                            <input type="number" name="edit_qty" id="edit_qty" class="form-control form-control-sm edit_qty"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <button class="btn btn-primary btn-sm" style="margin-top: 25px" id="edit_addBtn"> Add </button>
                                    </div>
                                </div>

                                <div class="form-group table-responsive">
                                    <table class="table table-sm" id="edit_colorTable">
                                        <thead>
                                        <tr>
                                            <th> Spare Part </th>
                                            <th> Quantity </th>
                                            <th>  </th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_remarks">Remarks</label>
                                    <textarea cols="3" class="form-control-sm form-control" name="edit_remarks" id="edit_remarks"></textarea>
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

<?php if (in_array('deleteSparePartReturnToSupplier', $user_permission)): ?>
    <!-- remove brand modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Remove Record?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>

                <form role="form" action="<?php echo base_url('MachineServices/remove_return_to_supplier') ?>" method="post"
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
                <h5 class="modal-title">View Returned Items : <strong> <span id="machine_type_name"></span></strong></h5>
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



