 <div class="container-fluid mt-2">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h2 class="">Good Receive Note Approve</h2>
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
                        <th><input type="checkbox" id="check_all"/></th>
                        <th>GRN Type</th>
                        <th>Date</th>
                        <th>Batch No</th>
                        <th>Supplier</th>
                        <th>Location</th>
                        <th>Invoice No</th>
                        <th>Dispatch No</th>
                        <th>Total</th>
                        <th>Approved Status</th>
                        <th>Quality Status</th>
                        <th>Remarks</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <button type="button" class="btn btn-primary btn-sm float-right mt-2" id="approve_batch">Approve</button>
        </div>
    </div>
</div>

 <div class="modal fade" id="porderviewmodal" data-backdrop="static" data-keyboard="false" tabindex="-1"
      aria-labelledby="staticBackdropLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered modal-lg">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="staticBackdropLabel">View Good Receive Note</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body">
                 <div id="viewhtml"></div>
             </div>
         </div>
     </div>
 </div>





