<main>
    <div class="page-header page-header-light bg-white shadow">
        <div class="container-fluid">
            <div class="page-header-content py-3">
                <h1 class="page-header-title font-weight-light">
                    <div class="page-header-icon"><i class="fas fa-shopping-basket"></i></div>
                    <span>Inquiry details</span>
                </h1>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-2 p-0 p-2">
        <div class="card">
            <div class="card-body p-0 p-2">
                <div class="row">
                    <div class="col-4">
                        <form method="post" autocomplete="off" id="grnform">
                            
                                

                            <div class="form-group mb-1">
                                <label class="small font-weight-bold">Quantity*</label>
                                <input type="text" class="form-control form-control-sm" name="quantity" id="quantity" required>
                            </div>
                            <div class="form-group mb-1">
                                <label class="small font-weight-bold">Date*</label>
                                <input type="date" class="form-control form-control-sm" name="date" id="date" required>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group mt-4 text-right">
                                        <button type="button" id="submitlist" class="btn btn-primary btn-sm px-4"><i class="far fa-save"></i>&nbsp;Add List</button>
                                        <input name="submitBtn" type="submit" value="Save" id="submitBtn" class="d-none">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="recordOption" id="recordOption" value="1">
                            <input type="hidden" name="recordID" id="recordID" value="">
                            <input type="hidden" id="hinquiry_id" value="">
                        </form> &nbsp;
                        <table class="table table-bordered table-striped table-sm nowrap mt-3" id="dataTable">
                            <thead>
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Sales Rep Name</th>
                                    <th>Date</th>
                                    <th>Cloth Type</th>
                                    <th>Material Type</th>
                                    <th>Quantity</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <div class="form-group col-12 mt-2 text-right p-2">
                            <button type="button" id="submitdata" class="btn btn-primary btn-sm px-4"><i class="far fa-save"></i>&nbsp;Submit All</button>
                        </div>
                    </div>
                    <div class="col-8">
                        <table class="table table-bordered table-striped table-sm nowrap" id="inquiryTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Customer Name</th>
                                    <th>Date</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>  
                    
                    <div class="modal fade" id="inquiryDetailsModal" tabindex="-1" role="dialog" aria-labelledby="inquiryDetailsModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="inquiryDetailsModalLabel">Inquiry Details</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-bordered table-striped table-sm" id="inquiryDetailsTable" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Inquiry ID</th>
                                                <th>Sales Rep Name</th>
                                                <th>Cloth Type</th>
                                                <th>Material Type</th>
                                                <th>Quantity</th>
                                                <th class="text-right">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Details will be appended here -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>

