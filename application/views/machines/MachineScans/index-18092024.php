<div class="container-fluid mt-2">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h2 class="">Machine Scan</h2>
                </div>
            </div>
            <hr>
            <div id="messages"></div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <div class="card">
                            <div class="card-body" style="padding: 10px !important;">
                                <form role="form" action="<?php echo base_url('MachineScans/scan') ?>" method="post" id="scanForm">
                                    <div class="form-group">
                                        <label for="s_no">Machine S No</label>
                                        <select class="form-control form-control-sm" id="s_no" name="s_no">
                                            <option value="">Select S No</option>
                                        </select>
                                        <div id="s_no_error"></div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-sm float-right btn-scan btn-submit">Scan</button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div id="machine_in_details"></div>
                    </div>

                </div>

<!--                <div class="col-lg-4">-->
<!--                    <div id="machine_in_details"></div>-->
<!--                </div>-->

                <div class="col-lg-6">
                    <div id="machine_allocation_current"></div>
                    <div id="machine_repair_current"></div>
                    <div id="released_machines"></div>
                </div>

                <div class="col-lg-12">

                    <div id="machine_allocation_history">

                    </div>

                </div>
                <div class="col-lg-6">
                    <div id="machine_repair_history">

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php if (in_array('createMachineRelease', $user_permission)): ?>
    <!-- remove brand modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Release Machine</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>

                <form role="form" action="<?php echo base_url('MachineScans/release_machine') ?>" method="post"
                      id="removeForm">
                    <div class="modal-body">
                        <p>Do you really want to release?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm btn-submit btn-remove">Yes</button>
                    </div>
                </form>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<?php endif; ?>

<?php if (in_array('createMachineRelease', $user_permission)): ?>
    <!-- remove brand modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="repairReleaseModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Release Machine</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>

                <form role="form" action="<?php echo base_url('MachineScans/release_machine_from_repair') ?>" method="post"
                      id="repairReleaseForm">
                    <div class="modal-body">
                        <p>Do you really want to release from repair?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm btn-submit btn-repair-release">Yes</button>
                    </div>
                </form>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<?php endif; ?>

<?php if (in_array('createMachineRepairRequest', $user_permission)): ?>
    <!-- remove brand modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="repairModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Repair Machine</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>

                <form role="form" action="<?php echo base_url('MachineScans/repair_machine') ?>" method="post"
                      id="repairForm">
                    <div class="modal-body">
                        <p>Do you really want to send to Repair?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm btn-submit btn-repair">Yes</button>
                    </div>
                </form>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<?php endif; ?>

<?php if (in_array('createMachineAllocate', $user_permission)): ?>
    <!-- remove brand modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="allocateModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"> Machine Allocate</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>

                <form role="form" action="<?php echo base_url('MachineScans/allocate_machine') ?>" method="post"
                      id="allocateForm">
                    <div class="modal-body">

                        <div class="form-group">
                            <div id="allocate_modal_machine_in_details"></div>
                        </div>

                        <div class="form-group">
                            <label for="factory_id">Factory</label>
                            <select class="form-control form-control-sm select2" id="factory_id" name="factory_id">
                                <option value="">Select factory</option>
                            </select>
                            <div id="factory_id_error"></div>
                        </div>

                        <div class="form-group">
                            <label for="department_id">Department</label>
                            <select class="form-control form-control-sm" id="department_id" name="department_id">
                                <option value="">Select department</option>
                            </select>
                            <div id="department_id_error"></div>
                        </div>

                        <div class="form-group">
                            <label for="section_id">Section</label>
                            <select class="form-control form-control-sm" id="section_id" name="section_id">
                                <option value="">Select section</option>
                            </select>
                            <div id="section_id_error"></div>
                        </div>

                        <div class="form-group">
                            <label for="line_id">Line</label>
                            <select class="form-control form-control-sm" id="line_id" name="line_id">
                                <option value="">Select line</option>
                            </select>
                            <div id="line_id_error"></div>
                        </div>

                        <div class="form-group">
                            <label for="slot_id">Slot</label>
                            <select class="form-control form-control-sm" id="slot_id" name="slot_id">
                                <option value="">Select slot</option>
                            </select>
                            <div id="slot_id_error"></div>
                        </div>

                        <div class="form-group">
                            <label for="allocated_date">Allocation Date</label>
                            <input type="date" class="form-control form-control-sm" id="allocated_date"
                                   name="allocated_date" placeholder="Allocation Date" autocomplete="off">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm btn-submit btn-allocate-submit">Save Changes</button>
                        <input type="hidden" name="machine_in_id" id="machine_in_id_allocate"/>
                    </div>
                </form>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<?php endif; ?>

<?php if (in_array('createMachineAllocate', $user_permission)): ?>
    <!-- remove brand modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="allocateFromRepairModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"> Machine Allocate</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>

                <form role="form" action="<?php echo base_url('MachineScans/allocate_machine_from_repair') ?>" method="post"
                      id="allocateFromRepairForm">
                    <div class="modal-body">

                        <div class="form-group">
                            <div id="allocate_from_repair_modal_machine_in_details"></div>
                        </div>

                        <div class="form-group">
                            <label for="af_factory_id">Factory</label>
                            <select class="form-control form-control-sm select2" id="af_factory_id" name="factory_id">
                                <option value="">Select factory</option>
                            </select>
                            <div id="af_factory_id_error"></div>
                        </div>

                        <div class="form-group">
                            <label for="af_department_id">Department</label>
                            <select class="form-control form-control-sm" id="af_department_id" name="department_id">
                                <option value="">Select department</option>
                            </select>
                            <div id="af_department_id_error"></div>
                        </div>

                        <div class="form-group">
                            <label for="af_section_id">Section</label>
                            <select class="form-control form-control-sm" id="af_section_id" name="section_id">
                                <option value="">Select section</option>
                            </select>
                            <div id="af_section_id_error"></div>
                        </div>

                        <div class="form-group">
                            <label for="af_line_id">Line</label>
                            <select class="form-control form-control-sm" id="af_line_id" name="line_id">
                                <option value="">Select line</option>
                            </select>
                            <div id="af_line_id_error"></div>
                        </div>

                        <div class="form-group">
                            <label for="af_slot_id">Slot</label>
                            <select class="form-control form-control-sm" id="af_slot_id" name="slot_id">
                                <option value="">Select slot</option>
                            </select>
                            <div id="af_slot_id_error"></div>
                        </div>

                        <div class="form-group">
                            <label for="af_allocated_date">Allocation Date</label>
                            <input type="date" class="form-control form-control-sm" id="af_allocated_date"
                                   name="allocated_date" placeholder="Allocation Date" autocomplete="off">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm btn-submit af-btn-allocate-submit">Save Changes</button>
                        <input type="hidden" name="machine_in_id" id="af_machine_in_id_allocate"/>
                    </div>
                </form>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<?php endif; ?>
