<div class="container-fluid mt-2">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h2 class="">Machine Dashboard</h2>
                </div>
                <div class="col">

                </div>
            </div>

        </div>
    </div>

    <div class="row mt-2 equal">
        <div class="col-md-3 pr-0" >
            <div class="card" style="height: 100%; width: 100%;">
                <div class="card-body">
                    <h5 class="card-title">All Machine List</h5>
                    <p class="card-text text-center text-success p-5" style="font-size: 5rem">
                        <?php echo $this->data['count_machine_ins']; ?>
                    </p>
                </div>
                <div class="card-footer">
                    <a href="<?php echo base_url(); ?>MachineIns" class="text-primary float-right">View More <i class="fa fa-arrow-right"></i> </a>
                </div>
            </div>
        </div>

        <div class="col-md-5 equal pr-0">
            <div class="card" style="padding-top: 15px;">
                <div class="card-body">
                        <canvas id="machine_ins_pie_chart"></canvas>
                </div>
                <div class="card-footer">
                    <a href="<?php echo base_url(); ?>MachineIns" class="text-primary float-right">View More <i class="fa fa-arrow-right"></i> </a>
                </div>
            </div>
        </div>

        <div class="col-md-4 ">
            <div class="card" style="height: 100%; width: 100%;">
                <div class="card-body">
                    <h5 class="card-title">Machine By Aging</h5>

                    <div class="table-responsive">
                        <table class="table table-sm ">
                            <thead>
                                <tr>
                                    <th> # </th>
                                    <th> Type </th>
                                    <?php
                                    foreach ($counts as $key => $val){
                                        echo '<th> '.$key.' </th>';
                                    }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                 <?php
                                 $i = 1;
                                 foreach ($count_data as $cd){

                                     echo '<tr>';
                                     echo '<td> '.$i.' </td>';
                                     echo '<td> '.$cd['machine_type_name'].' </td>';
                                     echo '<td> '.$cd['count_0_1'].' </td>';
                                     echo '<td> '.$cd['count_2_3'].' </td>';
                                     echo '<td> '.$cd['count_4_5'].' </td>';
                                     echo '<td> '.$counts['5<'].' </td>';
                                     echo '</tr>';
                                     $i++;
                                 }

                                 ?>
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="card-footer">

                </div>
            </div>
        </div>

    </div>


    <div class="card mt-2">
        <div class="card-body">
            <h5 class="card-title">Machine by Type</h5>
            <hr>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="machine_in_id">Machine Type</label>
                        <select class="form-control form-control-sm" name="machine_type_id" id="machine_type_id">
                            <option value="">Select Machine</option>
                        </select>
                        <div id="machine_type_id_error"></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="count_div"></div>
                </div>
                <div class="col-md-8">
                    <div class="allocated_machines_div"></div>
                </div>
            </div>

        </div>
    </div>

</div>

<div class="modal fade" tabindex="-1" role="dialog" id="availableMachinesModal">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">View Available Machines : <strong> <span id="machine_type_name"></span></strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="availableMachinesMsg"></div>
                <div id="availableMachinesResponse"></div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
            </div>


        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="repairingMachinesModal">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">View Repairing Machines : <strong> <span id="r_machine_type_name"></span></strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="repairingMachinesMsg"></div>
                <div id="repairingMachinesResponse"></div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
            </div>


        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->





