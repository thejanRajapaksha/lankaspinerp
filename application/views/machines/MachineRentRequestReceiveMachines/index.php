<div class="container-fluid mt-2">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h2 class="">Machine Rent Requests Received Machines </h2>
                </div>
                <div class="col">

                </div>
            </div>
            <hr>
            <div id="messages"></div>
            <div class="table-responsive">
                <table id="manageTable" class="table table-bordered table-striped table-sm">
                    <thead>
                    <tr>
                        <th>Request ID</th>
                        <th>Machine Type</th>
                        <th>Total Requested Count</th>
                        <th>Total Received Count</th>
                        <th>Total Returned Count</th>
                        <?php if (in_array('updateMachineRentRequestReceiveMachine', $user_permission) || in_array('deleteMachineRentRequestReceiveMachine', $user_permission)): ?>
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

<div class="modal fade" tabindex="-1" role="dialog" id="viewModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">View Rent Request Received Machines : <strong> <span id="view_machine_requests"></span></strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="viewMsg"></div>
                <div id="viewResponse"></div>

            </div>
            <div class="modal-footer">

                <?php if (in_array('createMachineRentRequestReceiveMachineReturn', $user_permission)): ?>
                    <button type="button" class="btn btn-secondary btn-sm float-left" id="return-btn">Return Rent Machine</button>
                <?php endif; ?>

                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
            </div>


        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<?php if (in_array('updateMachineRequest', $user_permission)): ?>
    <!-- edit brand modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="editModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Style Color : <strong> <span id="edit_color_name"></span> </strong> </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>

                <div class="modal-body">
                    <div id="msgEdit"></div>
                    <div id="edit_html">

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

<?php if (in_array('deleteMachineRequest', $user_permission)): ?>
    <!-- remove brand modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Remove Style Color</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>

                <form role="form" action="<?php echo base_url('MachineRequests/remove') ?>" method="post" id="removeForm">
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

<?php if (in_array('createMachineRentRequestReceiveMachineReturn', $user_permission)): ?>

    <div class="modal fade" tabindex="-1" role="dialog" id="returnModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Return Rented Machines </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="returnMsg"></div>
                    <div id="returnResponse"></div>

                </div>
                <div class="modal-footer">

                    <?php if (in_array('createMachineRentRequestReceiveMachineReturn', $user_permission)): ?>
                        <button type="button" class="btn btn-secondary btn-sm float-left" id="return-confirm-btn">Confirm</button>
                    <?php endif; ?>

                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                </div>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

<?php endif; ?>

<?php if (in_array('createMachineOnLoanRequest', $user_permission)): ?>

    <div class="modal fade" tabindex="-1" role="dialog" id="issueModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">On Loan Requests </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="issueMsg"></div>
                    <div id="issueResponse"></div>

                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary btn-sm float-left" id="issue-confirm-btn">Issue</button>

                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                </div>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

<?php endif; ?>

<?php if (in_array('createMachineRequestApprove', $user_permission)): ?>

    <div class="modal fade" tabindex="-1" role="dialog" id="approveModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Approve Requests </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="approveMsg"></div>
                    <div id="approveResponse"></div>

                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary btn-sm float-left" id="approve-confirm-btn">Approve</button>

                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                </div>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

<?php endif; ?>



