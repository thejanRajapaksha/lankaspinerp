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
                                <label class="small font-weight-bold">Customer Name</label>
                                <select class="form-control form-control-sm" name="customername" id="customername" required>
                                    <option value="" selected disabled>Select Customer</option>
                                    <?php foreach ($result['customername'] as $customernames):?>
                                        <option value="<?php echo $customernames->idtbl_customer;?>">
                                        <?php echo htmlspecialchars($customernames->name);?></option>
                                    <?php endforeach;?>
                                </select>
                             </div>  
                            <div class="form-group mb-1">
                                <label class="small font-weight-bold">Item*</label>
                                <input type="text" class="form-control form-control-sm" name="item" id="item" required>
                            </div>
                            <div class="form-group mb-1">
                                <label class="small font-weight-bold">Quantity*</label>
                                <input type="text" class="form-control form-control-sm" name="quantity" id="quantity" required>
                            </div>
                            <div class="form-group mb-1">
                                <label class="small font-weight-bold">Date*</label>
                                <input type="date" class="form-control form-control-sm" name="date" id="date" required>
                            </div>
                            <div class="form-group mb-1">
                                <label class="small font-weight-bold">Delevary Date*</label>
                                <input type="date" class="form-control form-control-sm" name="d_date" id="d_date" required>
                            </div>
                            <div class="form-group mb-1">
                                <label class="small font-weight-bold">Bag Length*</label>
                                <input type="number" class="form-control form-control-sm" name="bg_length" id="bg_length" required>
                            </div>
                            <div class="form-group mb-1">
                                <label class="small font-weight-bold">Bag width*</label>
                                <input type="number" class="form-control form-control-sm" name="bg_width" id="bg_width" required>
                            </div>
                            <div class="form-group mb-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="inner_bag" name="inner_bag" value="false">
                                    <label class="form-check-label font-weight-bold" for="inner_bag">Inner Bag</label>
                                </div>
                            </div>
                            <div class="form-group mb-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="off_print" name="off_print" value="false">
                                    <label class="form-check-label font-weight-bold" for="off_print">Printing</label>
                                </div>
                            </div>

                            <div class="form-group mb-1">
                                <label class="small font-weight-bold">Printing type</label>
                                <select class="form-control form-control-sm" name="printing_type" id="printing_type" required>
                                    <option value="" selected disabled>Select Type</option>
                                    <option value="offPrint">offPrint</option>
                                </select>
                             </div>  
                            <div class="form-group mb-1">
                                <label class="small font-weight-bold">Color No*</label>
                                <input type="number" class="form-control form-control-sm" name="col_no" id="col_no" required>
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
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Delevary Date</th>
                                    <th>Date</th>
                                    <th>Length</th>
                                    <th>Width</th>
                                    <th>Inner Bag</th>
                                    <th>Off Print</th>
                                    <th>Printing Type</th>
                                    <th>Color No</th>
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
                        <table class="table table-bordered table-striped table-sm nowrap" id="inquiryTable" width="100%">
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
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-sm" id="inquiryDetailsTable" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Inquiry ID</th>
                                                <th>Item</th>
                                                <th>Quantity</th>
                                                <th>Delivery Date</th>
                                                <th>Date</th>
                                                <th>Bag Length</th>
                                                <th>Bag Width</th>
                                                <th>Inner Bag</th>
                                                <th>Printing</th>
                                                <th>Printing Type</th>
                                                <th>Colour No</th>
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

