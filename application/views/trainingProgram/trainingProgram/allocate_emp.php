<div class="container-fluid mt-2">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h2 class="">Allocate to Employees </h2>
                </div>
                <div class="col">
                    <?php if(in_array('createTrainingProgram', $user_permission)): ?>
                        <button class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target="#addModal">Add Training Program</button>
                    <?php endif; ?>
                </div>
            </div>
            <hr>
            <div id="messages"></div>
            <div class="table-responsive">
                <table id="manageTable" class="table table-bordered table-striped table-sm">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Trainer</th>
                        <th>Location</th>
                        <th>Date</th>
                        <th>Remarks</th>
                        <th>No of Employees</th>
                        <?php if(in_array('updateTrainingProgram', $user_permission) || in_array('deleteTrainingProgram', $user_permission)): ?>
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