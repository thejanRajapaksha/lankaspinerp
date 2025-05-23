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
                    <div class="col-12">
                        <form method="post" autocomplete="off" id="grnform">
                            <div class="form-row">
                                <div class="form-group col-md-2 mb-1">
                                    <label class="small font-weight-bold">Customer Name</label>
                                    <select class="form-control form-control-sm" name="customername" id="customername" required>
                                        <option value="" selected disabled>Select Customer</option>
                                        <?php foreach ($result['customername'] as $customernames):?>
                                            <option value="<?php echo $customernames->idtbl_customer;?>">
                                            <?php echo htmlspecialchars($customernames->name);?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                                <div class="form-group col-md-2 mb-1">
                                    <label class="small font-weight-bold text-dark">Item*</label>
                                    <select class="form-control form-control-sm" name="item" id="item" required>
                                        <option selected disabled>Select</option>
                                        <?php foreach($result['product'] as $products):?>
                                            <option value="<?php echo $products->idtbl_product; ?>">
                                            <?php echo $products->product;?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                                <div class="form-group col-md-2 mb-1">
                                    <label class="small font-weight-bold">Quantity*</label>
                                    <input type="text" class="form-control form-control-sm" name="quantity" id="quantity" required>
                                </div>
                                <div class="form-group col-md-2 mb-1">
                                    <label class="small font-weight-bold">Date*</label>
                                    <input type="date" class="form-control form-control-sm" name="date" id="date" required>
                                </div>
                                <div class="form-group col-md-2 mb-1">
                                    <label class="small font-weight-bold">Delivery Date*</label>
                                    <input type="date" class="form-control form-control-sm" name="d_date" id="d_date" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-2 mb-1">
                                    <label class="small font-weight-bold">Bag Length*</label>
                                    <input type="number" class="form-control form-control-sm" name="bg_length" id="bg_length" required>
                                </div>
                                <div class="form-group col-md-2 mb-1">
                                    <label class="small font-weight-bold">Bag Width*</label>
                                    <input type="number" class="form-control form-control-sm" name="bg_width" id="bg_width" required>
                                </div>
                                <div class="form-group col-md-2 mb-1">
                                    <label class="small font-weight-bold">Liner Size*</label>
                                    <input type="number" class="form-control form-control-sm" name="liner_size" id="liner_size" required>
                                </div>
                                <div class="form-group col-md-2 mb-1">
                                    <label class="small font-weight-bold">Liner Color*</label>
                                    <input type="number" class="form-control form-control-sm" name="liner_color" id="liner_color" required>
                                </div>
                                <div class="form-group col-md-2 mb-1">
                                    <label class="small font-weight-bold">Bag Weight*</label>
                                    <input type="number" class="form-control form-control-sm" name="bg_weight" id="bg_weight" required>
                                </div>
                                <div class="form-group col-md-2 mb-1">
                                    <label class="small font-weight-bold">Liner Weight*</label>
                                    <input type="number" class="form-control form-control-sm" name="ln_weight" id="ln_weight" required>
                                </div>
                                <div class="form-group col-md-2 mb-1">
                                    <label class="small font-weight-bold">Printing Type</label>
                                    <select class="form-control form-control-sm" name="printing_type" id="printing_type" required>
                                        <option value="" selected disabled>Select Type</option>
                                        <option value="offPrint">Off Print</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2 mb-1">
                                    <label class="small font-weight-bold">Color No*</label>
                                    <input type="number" class="form-control form-control-sm" name="col_no" id="col_no" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-2 mb-1 d-flex align-items-center">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="inner_bag" name="inner_bag" value="false">
                                        <label class="form-check-label font-weight-bold ml-2" for="inner_bag">Inner Bag</label>
                                    </div>
                                </div>
                                <div class="form-group col-md-2 mb-1 d-flex align-items-center">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="off_print" name="off_print" value="false">
                                        <label class="form-check-label font-weight-bold ml-2" for="off_print">Printing</label>
                                    </div>
                                </div>

                                <div class="form-group col-md-3 mb-1 text-right">
                                    <label class="d-block">&nbsp;</label>
                                    <button type="button" id="submitlist" class="btn btn-primary btn-sm px-4">
                                        <i class="far fa-save"></i>&nbsp;Add List
                                    </button>
                                    <input name="submitBtn" type="submit" value="Save" id="submitBtn" class="d-none">
                                </div>
                            </div>

                            <input type="hidden" name="recordOption" id="recordOption" value="1">
                            <input type="hidden" name="recordID" id="recordID" value="">
                            <input type="hidden" id="hinquiry_id" value="">
                        </form>
                    </div>
                </div>
                <hr>
                <div class="row mt-3">
                    <div class="col-12">
                        <table class="table table-bordered table-striped table-sm nowrap" id="dataTable">
                            <thead>
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Delivery Date</th>
                                    <th>Date</th>
                                    <th>Length</th>
                                    <th>Width</th>
                                    <th>Liner Size</th>
                                    <th>Liner Color</th>
                                    <th>Bag Weight</th>
                                    <th>Liner Weight</th>
                                    <th>Inner Bag</th>
                                    <th>Off Print</th>
                                    <th>Printing Type</th>
                                    <th>Color No</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>

                        <div class="form-group text-right p-2">
                            <button type="button" id="submitdata" class="btn btn-primary btn-sm px-4">
                                <i class="far fa-save"></i>&nbsp;Submit All
                            </button>
                        </div>

                        <table class="table table-bordered table-striped table-sm nowrap mt-3" id="inquiryTable" width="100%">
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
                </div>

                <!-- Modal -->
                <div class="modal fade" id="inquiryDetailsModal" tabindex="-1" role="dialog" aria-labelledby="inquiryDetailsModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
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
                                                <th>Liner Size</th>
                                                <th>Liner Color</th>
                                                <th>Bag Weight</th>
                                                <th>Liner Weight</th>
                                                <th>Inner Bag</th>
                                                <th>Printing</th>
                                                <th>Printing Type</th>
                                                <th>Color No</th>
                                                <th class="text-right">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
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
