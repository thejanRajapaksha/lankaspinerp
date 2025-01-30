<div class="container-fluid mt-2">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h2 class="">Machine Operations</h2>
                </div>
                <div class="col">
                    <?php if (in_array('createMachineOperation', $user_permission)): ?>
                        <button class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target="#addModal">
                            Add MachineOperation
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
                        <th>Machine Type</th>
                        <th>No of Operations</th>
                        <?php if (in_array('updateMachineOperation', $user_permission) || in_array('deleteMachineOperation', $user_permission)): ?>
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

<?php if (in_array('createMachineOperation', $user_permission)): ?>
    <!-- create brand modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="addModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add MachineOperation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>

                <form role="form" action="<?php echo base_url('MachineOperations/create') ?>" method="post"
                      id="createForm">

                    <div class="modal-body">

                        <div class="form-group">
                            <label for="machine_in_id">Machine Type</label>
                            <select class="form-control form-control-sm" name="machine_type_id" id="machine_type_id">
                                <option value="">Select Machine</option>
                            </select>
                            <div id="machine_type_id_error"></div>
                        </div>

                        <div class="form-group">
                            <label>Operations</label>
                            <br>
                            <div class="row">
                                <?php
                                foreach ($operations as $operation) {
                                    $id = $operation['id'];
                                    echo '<div class="col-sm-6">';
                                    echo '<div class="form-check form-check-inline">';
                                    echo '<input class="form-check-input" type="checkbox" id="'.$id.'" name="operation_id[]" value="' . $operation['id'] . '">';
                                    echo '<label class="form-check-label" for="'.$id.'">' . $operation['name'] . '</label>';
                                    echo '</div>';
                                    echo '</div>';
                                }
                                ?>
                            </div>
                            <div id="operation_id_error"></div>
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

<div class="modal fade" tabindex="-1" role="dialog" id="viewModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">View Machine Operations : <strong> <span id="machine_type_name"></span></strong></h5>
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


<?php if (in_array('deleteMachineOperation', $user_permission)): ?>
    <!-- remove brand modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Remove MachineOperation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>

                <form role="form" action="<?php echo base_url('MachineOperations/remove') ?>" method="post"
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



