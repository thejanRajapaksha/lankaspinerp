<style>

    .list-body {
        height: 100%;
    }

    .kanban-card {
        background-color: #00ba94;
        color:white;
        display: flex;
        justify-content: space-between;
        padding: 5px;
        margin-top: 5px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        border-radius: 5px;
    }
    .seq_outer{
        color:white;
    }

    .kanban-card > button {
        align-self: flex-start;
    }

    .kanban-card:hover {
        box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
    }

    #unselected .kanban-card:hover {
        cursor: e-resize;
    }

    #selected .kanban-card:hover {
        cursor: n-resize;
    }

    #edit_unselected .kanban-card:hover {
        cursor: e-resize;
    }

    #edit_selected .kanban-card:hover {
        cursor: n-resize;
    }

</style>

<div class="container-fluid mt-2">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h2 class="">Product Templates</h2>
                </div>
                <div class="col">
                    <?php if (in_array('createMachineOperationProduct', $user_permission)): ?>
                        <button class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target="#addModal">
                            New Product
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
                        <th>Product</th>
                        <th>Category</th>
                        <th>Process</th>
                        <th>Component</th>
                        <th>Total SMV</th>
                        <th>is Approved</th>
                        <?php if (in_array('updateMachineOperationProduct', $user_permission) || in_array('deleteMachineOperationProduct', $user_permission)): ?>
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

<?php if (in_array('createMachineOperationProduct', $user_permission)): ?>
    <!-- create brand modal -->
    <div class="modal fade modal-fullscreen-xl" tabindex="-1" role="dialog" id="addModal">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Product Template</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>

                <form role="form" action="<?php echo base_url('MachineOperationProduct/create') ?>" enctype='multipart/form-data' method="post" id="createForm">

                    <div class="modal-body">

                        <div id="msgCreate"></div>

                        <div class="row">
                            <div class="col-md-12 row">

                                <div class="form-group col-sm-6 ">
                                    <label for="product_id"> Product <span class="text-danger">*</span> </label>
                                    <select class="form-control form-control-sm" id="product_id" name="product_id">
                                        <option value="">Select...</option>
                                    </select>
                                    <div id="product_id_error"></div>
                                </div>

                                <div class="form-group col-sm-6 ">
                                    <label for="category_id"> Category <span class="text-danger">*</span> </label>
                                    <select class="form-control form-control-sm" id="category_id" name="category_id">
                                        <option value="">Select...</option>
                                    </select>
                                    <div id="category_id_error"></div>
                                </div>

                                <div class="form-group col-sm-6 ">
                                    <label for="process_id"> Process <span class="text-danger">*</span> </label>
                                    <select class="form-control form-control-sm" id="process_id" name="process_id">
                                        <option value="">Select...</option>
                                    </select>
                                    <div id="process_id_error"></div>
                                </div>

                                <div class="form-group col-sm-6 ">
                                    <label for="component_id"> Component <span class="text-danger">*</span> </label>
                                    <select class="form-control form-control-sm" id="component_id">
                                        <option value="">Select...</option>
                                    </select>
                                    <div id="component_id_error"></div>
                                </div>

                                <div class="form-group col-sm-12">
                                    <hr>
                                </div>

                                <div class="form-group col-sm-12 ">
                                    <div class="alert alert-info">
                                        <span>Please select multiple components & move Up & Down to change the Sequence</span>
                                    </div>
                                </div>

                                <div class="form-group col-sm-12 row ">

                                    <section class="col-sm-6 column list">
                                        <header class="mb-4">
                                            <h4>Selected Components</h4>
                                        </header>
                                        <div id="selected" class="list-body"></div>
                                    </section>

                                    <section class="col-sm-6 column">
                                        <header class="mb-4">
                                            <h4>Selected Component Operations</h4>
                                        </header>
                                        <div id="sc_operations" ></div>
                                    </section>

                                </div>

                                <div class="form-group col-sm-12">

                                </div>

                            </div>


                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm" id="saveChanges">Save changes</button>
                    </div>

                </form>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<?php endif; ?>


<?php if(in_array('updateMachineOperationDesc', $user_permission)): ?>
    <!-- edit brand modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="editModal">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Product Template</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>

                <form role="form" action="<?php echo base_url('MachineOperationProduct/update') ?>" method="post" id="updateForm" enctype="multipart/form-data">

                    <div class="modal-body">

                        <div id="msgUpdate"></div>

                        <div class="row">

                            <div class="form-group col-sm-6 ">
                                <label for="edit_product_id"> Product <span class="text-danger">*</span> </label>
                                <select class="form-control form-control-sm" id="edit_product_id" name="edit_product_id">
                                    <option value="">Select...</option>
                                </select>
                                <div id="edit_product_id_error"></div>
                            </div>

                            <div class="form-group col-sm-6 ">
                                <label for="edit_category_id"> Category <span class="text-danger">*</span> </label>
                                <select class="form-control form-control-sm" id="edit_category_id" name="edit_category_id">
                                    <option value="">Select...</option>
                                </select>
                                <div id="edit_category_id_error"></div>
                            </div>

                            <div class="form-group col-sm-6 ">
                                <label for="edit_process_id"> Process <span class="text-danger">*</span> </label>
                                <select class="form-control form-control-sm" id="edit_process_id" name="edit_process_id">
                                    <option value="">Select...</option>
                                </select>
                                <div id="edit_process_id_error"></div>
                            </div>

                            <div class="form-group col-sm-6 ">
                                <label for="edit_component_id"> Component <span class="text-danger">*</span> </label>
                                <select class="form-control form-control-sm" id="edit_component_id" name="">
                                    <option value="">Select...</option>
                                </select>
                                <div id="edit_component_id_error"></div>
                            </div>

                            <div class="form-group col-sm-12">
                                <hr>
                            </div>

                            <div class="form-group col-sm-12 ">
                                <div class="alert alert-info">
                                    <span>Please Drag and Drop Operations from left to right & move Up & Down to change the Sequence</span>
                                </div>
                            </div>

                            <div class="form-group col-sm-12 row ">

                                <section class="col-sm-6 column list">
                                    <header class="mb-4">
                                        <h4>Selected Components</h4>
                                    </header>
                                    <div id="edit_selected" class="list-body"></div>
                                </section>

                                <section class="col-sm-6 column">
                                    <header class="mb-4">
                                        <h4>Selected Component Operations</h4>
                                    </header>
                                    <div id="edit_sc_operations" ></div>
                                </section>

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

<?php if(in_array('deleteMachineOperationProduct', $user_permission)): ?>
    <!-- remove brand modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Remove Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>

                <form role="form" action="<?php echo base_url('MachineOperationProduct/remove') ?>" method="post" id="removeForm">
                    <div class="modal-body">
                        <p>Do you really want to remove?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<?php endif; ?>

<div class="modal fade" tabindex="-1" role="dialog" id="viewModal">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">View Product Operations : <strong> <span id="view_product_name"></span></strong></h5>
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
