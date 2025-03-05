<main>
    <div class="page-header page-header-light bg-white shadow">
        <div class="container-fluid">
            <div class="page-header-content py-3">
                <h1 class="page-header-title font-weight-bold text-dark">
                    <div class="page-header-icon"><i class="fas fa-quote-left"></i></div>
                    <span>Material Details</span>
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
<div class="modal fade" id="Materialmodal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="MaterialmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="MaterialmodalLabel">Create Order</h5>
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
                                    <label for="mtype" class="small font-weight-bold text-dark">Material Type*</label>
                                    <select class="form-control form-control-sm" name="mtype" id="mtype" required>
                                        <option value="">Select</option>
                                        <!-- Add bank options here -->
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="oquantity" class="small font-weight-bold text-dark">Order Quantity*</label>
                                    <input type="number" class="form-control form-control-sm"  name="oquantity" id="oquantity" required>
                                </div>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label for="morderdate" class="small font-weight-bold text-dark">Material Order Date*</label>
                                    <input type="date" class="form-control form-control-sm" name="morderdate" id="morderdate" required>
                                </div>
                                <div class="col">
                                    <label for="remarks" class="small font-weight-bold text-dark">Remarks</label>
                                    <input type="text" class="form-control form-control-sm" name="remarks" id="remarks">
                                </div>
                            </div>
                            <hr class="border-dark">
                            <div class="form-group mt-3 text-right">
                                <?php if (in_array('createMaterialDetail', $user_permission)) : ?>
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
                            <table class="table table-striped table-bordered table-sm small" id="tablematerial">
                                <thead>
                                    <tr>
                                        <th>Material Type</th>
                                        <th>Order Quantity</th>
                                        <th>Material Order Date</th>
                                        <th>Remarks</th>
                                        <th class="d-none">Order details ID</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <hr>
                        <br>
                        <div class="form-group mt-2">
                            <button type="button" id="btncreateorder" class="btn btn-outline-primary btn-sm fa-pull-right"><i class="fas fa-save"></i>&nbsp;Save details</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div class="modal fade" id="materialdetail" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="materialdetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="materialdetailLabel">Material Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-10">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-sm small" id="materialdetailtable">
                                <thead>
                                    <tr>
                                        <th>Material Type</th>
                                        <th>Order Date</th>
                                        <th>Quantity (Kg)</th>
                                        <th>Balance Quantity(Kg)</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <button id="saveBalanceDetails" class="btn-sm btn-primary">Save Material Balance</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
