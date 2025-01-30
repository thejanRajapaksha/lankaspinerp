 <div class="container-fluid mt-2">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h2 class="">Return To Supplier Approve</h2>
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
                        <th>Supplier</th>
                        <th>Date</th>
                        <th>Is Approved</th>
                        <th>Remarks</th>
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
                 <div id="approve_res"></div>
                 <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
             </div>


         </div><!-- /.modal-content -->
     </div><!-- /.modal-dialog -->
 </div><!-- /.modal -->




