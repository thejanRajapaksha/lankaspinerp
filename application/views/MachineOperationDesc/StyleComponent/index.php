<div class="container-fluid mt-2">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h2 class=""> Component</h2>
                </div>
                <div class="col">
                    <?php if (in_array('createStyleComponent', $user_permission)): ?>
                        <button class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target="#addModal">
                            Add Component
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
                        <th>Component</th>
                        <th>Total Operations</th>
                        <th>Operations</th>
                        <th>is Approved</th>
                        <?php if (in_array('updateStyleComponent', $user_permission) || in_array('deleteStyleComponent', $user_permission)): ?>
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

<?php if (in_array('createStyleComponent', $user_permission)): ?>
    <!-- create brand modal -->
    <div class="modal fade modal-fullscreen-xl" tabindex="-1" role="dialog" id="addModal">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Component</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>

                <form role="form" action="<?php echo base_url('StyleComponent/create') ?>" method="post" id="createForm">

                    <div class="modal-body">

                        <div id="msgCreate"></div>

                        <div class="row">

                            <div class="col-md-12 row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="name">Component Name</label>
                                        <input type="text" class="form-control form-control-sm" id="name" name="name"
                                               placeholder="Enter Name" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <hr>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="operation_id">Operation</label>
                                    <select class="form-control" id="operation_id" name="operation_id">
                                        <option value="">Select Operation</option>
                                    </select>
                                    <div id="operation_id_error"></div>
                                </div>

                                <div class="form-group">
                                    <button type="button" class="btn btn-primary btn-sm btn-submit float-right" id="addBtn">Add</button>
                                </div>

                            </div>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-sm table-striped" id="colorTable">
                                                <thead>
                                                <tr>
                                                    <th>Operation ID</th>
                                                    <th>Operation Name</th>
                                                    <th>Machine Type</th>
                                                    <th>SMV</th>
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
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary btn-sm" id="saveChanges">Save changes</button>
                    </div>

                </form>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<?php endif; ?>

<?php if (in_array('updateStyleComponent', $user_permission)): ?>
    <!-- edit brand modal -->
    <div class="modal fade modal-fullscreen-xl" tabindex="-1" role="dialog" id="editModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Component Operations : <strong> <span id="edit_color_name"></span> </strong> </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>

                <div class="modal-body">
                    <div id="msgEdit"></div>

                    <div class="row">

                        <div class="col-md-12 row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="hidden" id="edit_id">
                                    <label for="edit_name">Component Name</label>
                                    <input type="text" class="form-control form-control-sm" id="edit_name" name="edit_name"
                                           placeholder="Enter Name" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <hr>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="edit_operation_id">Operation</label>
                                <select class="form-control" id="edit_operation_id" name="edit_operation_id">
                                    <option value="">Select Operation</option>
                                </select>
                                <div id="edit_operation_id_error"></div>
                            </div>

                            <div class="form-group">
                                <button type="button" class="btn btn-primary btn-sm btn-submit float-right" id="edit_addBtn">Add</button>
                            </div>

                        </div>

                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-striped" id="edit_colorTable">
                                            <thead>
                                            <tr>
                                                <th>Operation ID</th>
                                                <th>Operation Name</th>
                                                <th>Machine Type</th>
                                                <th>SMV</th>
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



                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm" id="edit-btn">Save changes</button>
                </div>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<?php endif; ?>

<?php if (in_array('deleteStyleComponent', $user_permission)): ?>
    <!-- remove brand modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Remove Component</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>

                <form role="form" action="<?php echo base_url('StyleComponent/remove') ?>" method="post" id="removeForm">
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
                <h5 class="modal-title">View Component Operations : <strong> <span id="view_style_name"></span></strong></h5>
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



