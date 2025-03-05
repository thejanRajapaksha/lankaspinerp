<main>
    <div class="page-header page-header-light bg-white shadow">
        <div class="container-fluid">
            <div class="page-header-content py-3">
                <h1 class="page-header-title font-weight-bold text-dark">
                    <div class="page-header-icon"><i class="fas fa-quote-left"></i></div>
                    <span>Accepted Quotations</span>
                </h1>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-2 p-0 p-2">
        <div class="card">
            <div class="card-body p-0 p-2">
                <table class="table table-bordered table-striped table-sm nowrap" id="dataTableAccepted" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Customer</th>
                            <th>Quotation Date</th>
                            <th>Due Date</th>
                            <th>Total</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</main>


<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Create Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-3">
                        <form id="createorderform" autocomplete="off" enctype="multipart/form-data">
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Cloth type*</label>
                                    <select class="form-control form-control-sm" name="clothtype" id="clothtype" required>
                                        <option value="">Select</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Material type*</label>
                                    <select class="form-control form-control-sm" name="materialtype" id="materialtype" required>
                                        <option value="">Select</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Size type*</label>
                                    <select class="form-control form-control-sm" name="sizetype" id="sizetype" required>
                                        <option value="">Select</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Quantity*</label>
                                    <input type="number" class="form-control form-control-sm" placeholder="" name="qty" id="qty" required>
                                </div>
                            </div>
                            <hr class="border-dark">
                            <div class="form-group mt-3 text-right">
                                <?php if (in_array('createOrderDetail', $user_permission)) : ?>
                                    <button type="button" id="formsubmit" class="btn btn-primary btn-sm px-5" <?php if ($addcheck == 0) { echo 'disabled'; } ?>>
                                        <i class="far fa-save"></i>&nbsp;Add to list
                                    </button>
                                <?php endif; ?>
                                <input name="submitBtn" type="submit" value="Save" id="submitBtn" class="d-none">
                                <input type="hidden" id="recordOption" value="1">
                                <input type="hidden" id="inquiryid" value="">
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-8 col-xl-9">
                        <div class="scrollbar pb-3" id="style-2">
                            <table class="table table-striped table-bordered table-sm small" id="tableorder">
                                <thead>
                                    <tr>
                                        <!-- <th>Cloth</th>
                                        <th>Material</th>
                                        <th>Size</th> -->
                                        <th>Qty</th>
                                        <!-- <th>Unitprice</th> -->
                                        <th class="d-none">Order details ID</th>
                                        <th class="text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <div class="form-group">
                            <label class="small font-weight-bold text-dark">Remark</label>
                            <textarea name="remark" id="remark" class="form-control form-control-sm"></textarea>
                        </div>
                        <div class="row">
                            <div class="col text-right">
                                <!-- <h1 class="font-weight-600" id="divtotal">Rs. 0.00</h1> -->
                            </div>
                            <input type="hidden" id="hidetotalorder" value="0">
                            <input type="hidden" id="sumdis" value="0">
                        </div>
                        <hr>
                        
                        <div class="form-group mt-2">
                            <button type="button" id="btncreateorder" class="btn btn-outline-primary btn-sm fa-pull-right"><i class="fas fa-save"></i>&nbsp;Create Order</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div class="modal fade" id="Paymentmodal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="PaymentmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="PaymentmodalLabel">Payment Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <form id="paymentform" autocomplete="off" enctype="multipart/form-data">
                            <div class="form-row mb-3">
                                <div class="col-md-6">
                                    <label for="bank" class="small font-weight-bold text-dark">Bank Name*</label>
                                    <select class="form-control form-control-sm" name="bank" id="bank">
                                        <option value="">Select</option>
                                        <!-- Add bank options here -->
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="paymenttype" class="small font-weight-bold text-dark">Payment type*</label>
                                    <select class="form-control form-control-sm" name="paymenttype" id="paymenttype" required>
                                        <option value="">Select</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row mb-3">
                                <div class="col-md-6">
                                    <label for="advance" class="small font-weight-bold text-dark">Advance Rs.*</label>
                                    <input type="number" class="form-control form-control-sm" placeholder="" name="advance" id="advance" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="pdate" class="small font-weight-bold text-dark">Date*</label>
                                    <input type="date" class="form-control form-control-sm" name="pdate" id="pdate" required>
                                </div>
                            </div>
                            <hr class="border-dark">
                            <div class="form-group text-right">
                                <?php if (in_array('createOrderDetail', $user_permission)) : ?>
                                    <button type="button" id="payformsubmit" class="btn btn-primary btn-sm px-5" <?php if ($addcheck == 0) { echo 'disabled'; } ?>>
                                        <i class="far fa-save"></i>&nbsp;Save details
                                    </button>
                                <?php endif; ?>
                                <input type="hidden" id="recordOption" value="1">
                                <input type="hidden" id="inquiryid" value="">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div class="modal fade" id="orderdet" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="orderdetLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderdetLabel">Order Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="commonFields"></div>
                <div class="row my-4"></div>
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                        <div class="scrollbar pb-3" id="style-2">
                            <table class="table table-striped table-bordered table-sm small" id="orderdetailtable">
                                <thead>
                                    <tr>
                                        <!-- <th>Cloth</th>
                                        <th>Material</th>
                                        <th>Size</th> -->
                                        <th>Qty</th>
                                        <th>Cutting Qty</th>
                                        <th>Balance</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <button id="saveCuttingDetails" class="btn btn-primary">Save Cutting Details</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
