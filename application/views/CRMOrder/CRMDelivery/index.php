<main>
    <div class="page-header page-header-light bg-white shadow">
        <div class="container-fluid">
            <div class="page-header-content py-3">
                <h1 class="page-header-title font-weight-bold text-dark">
                    <div class="page-header-icon"><i class="fas fa-quote-left"></i></div>
                    <span>Delivery Details</span>
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
<div class="modal fade" id="Deliverymodal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="DeliverymodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="DeliverymodalLabel">Create Order</h5>
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
                                    <label for="clothtype" class="small font-weight-bold text-dark">Cloth Type*</label>
                                    <select class="form-control form-control-sm" name="clothtype" id="clothtype" required>
                                        <option value="">Select</option>
                                        <!-- Add bank options here -->
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="size" class="small font-weight-bold text-dark">size*</label>
                                    <select class="form-control form-control-sm" name="size" id="size" required>
                                        <option value="">Select</option>
                                        <!-- Add bank options here -->
                                    </select>
                                </div>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label for="quantity" class="small font-weight-bold text-dark">Quantity*</label>
                                    <input type="number" class="form-control form-control-sm"  name="quantity" id="quantity" required>
                                </div>
                                <div class="col">
                                    <label for="date" class="small font-weight-bold text-dark">Finished Date*</label>
                                    <input type="date" class="form-control form-control-sm" name="date" id="date" required>
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
                            <table class="table table-striped table-bordered table-sm small" id="tablepackaging">
                                <thead>
                                    <tr>
                                        <th>Cloth Type</th>
                                        <th>Size</th>
                                        <th>Quantity</th>
                                        <th>Date</th>
                                        <th class="d-none">Order details ID</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <div class="form-group mt-2">
                            <button type="button" id="btncreateorder" class="btn btn-outline-primary btn-sm fa-pull-right"><i class="fas fa-save"></i>&nbsp;Save details</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Structure -->
<div class="modal fade" id="deliverydetail" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="deliverydetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deliverydetailLabel">Delivery and Packaging Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-10">
                        <div class="table-responsive">
                            <h6>Delivery Details</h6>
                            <table class="table table-striped table-bordered table-sm small" id="deliverydetailtable">
                                <thead>
                                    <tr>
                                        <th>Cloth Type</th>
                                        <th>Size</th>
                                        <th>Quantity</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <div class="table-responsive mt-3">
                            <h6>Packaging Details</h6>
                            <table class="table table-striped table-bordered table-sm small" id="packagingdetailtable">
                                <thead>
                                    <tr>
                                        <th>Cloth Type</th>
                                        <th>Size</th>
                                        <th>Quantity</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div class="modal fade" id="paymentDetailModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="paymentDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentDetailModalLabel">Payment Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div>
                            <h5>Current Balance: <span id="balanceAmount"></span></h5>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="paymenttype" class="large font-weight-bold text-dark">Payment Type*</label><br>
                                    <select class="form-control" id="paymenttype">
                                        <option value="">Select</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="paymentDate" class="large font-weight-bold text-dark">Date</label>
                                    <input type="date" class="form-control" id="paymentDate">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="paymentAmount" class="large font-weight-bold text-dark">Amount</label>
                                    <input type="number" class="form-control" id="paymentAmount">
                                </div>
                            </div>
                            <input type="hidden" id="total" value="">
                            <button id="addPaymentBtn" class="btn btn-sm btn-primary">Add Payment</button>
                        </div>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-sm small" id="paymentDetailTable">
                                <thead>
                                    <tr>
                                        <th>Type of Payment</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody id="paymentDetailTableBody">
                                    <!-- Payment records will be added here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delivery Modal -->
<div class="modal fade" id="deliveryDetailModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="deliveryDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deliveryDetailModalLabel">Delivery Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Left-side form -->
                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-3">
                        <form id="deliveryDetailForm" autocomplete="off" enctype="multipart/form-data" method="POST" action="your_action_url_here">
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label for="dclothtype" class="small font-weight-bold text-dark">Cloth Type*</label>
                                    <select class="form-control form-control-sm" name="dclothtype" id="dclothtype" required>
                                        <option value="">Select</option>
                                        <!-- Add options here -->
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="dsize" class="small font-weight-bold text-dark">Size*</label>
                                    <select class="form-control form-control-sm" name="dsize" id="dsize" required>
                                        <option value="">Select</option>
                                        <!-- Add options here -->
                                    </select>
                                </div>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label for="deliveryQuantity" class="small font-weight-bold text-dark">Quantity*</label>
                                    <input type="number" class="form-control form-control-sm" name="deliveryQuantity" id="deliveryQuantity" required>
                                </div>
                                <div class="col">
                                    <label for="deliveryDate" class="small font-weight-bold text-dark">Delivery Date*</label>
                                    <input type="date" class="form-control form-control-sm" name="deliveryDate" id="deliveryDate" required>
                                </div>
                            </div>
                            <hr class="border-dark">
                            <div class="form-group mt-3 text-right">
                                <button type="button" id="addDeliveryBtn" class="btn btn-primary btn-sm px-4"><i class="fas fa-plus"></i>&nbsp;Add to list</button>
                                <input type="hidden" id="inquiryid" name="inquiryid" value="">
                            </div>
                        </form>
                    </div>
                    <!-- Right-side table -->
                    <div class="col-sm-12 col-md-12 col-lg-8 col-xl-9">
                        <div class="scrollbar pb-3" id="style-2">
                            <table class="table table-striped table-bordered table-sm small" id="deliveryDetailTable">
                                <thead>
                                    <tr>
                                        <th>Cloth Type</th>
                                        <th>Size</th>
                                        <th>Quantity</th>
                                        <th>Delivery Date</th>
                                    </tr>
                                </thead>
                                <tbody id="deliveryDetailTableBody">
                                    <!-- Delivery records will be added here -->
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group mt-2">
                            <button type="button" id="btnSaveDelivery" class="btn btn-outline-primary btn-sm fa-pull-right"><i class="fas fa-save"></i>&nbsp;Save details</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
