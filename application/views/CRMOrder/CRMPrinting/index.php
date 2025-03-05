<main>
    <div class="page-header page-header-light bg-white shadow">
        <div class="container-fluid">
            <div class="page-header-content py-3">
                <h1 class="page-header-title font-weight-bold text-dark">
                    <div class="page-header-icon"><i class="fas fa-quote-left"></i></div>
                    <span>Printing Details</span>
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
<div class="modal fade" id="Printingmodal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="PrintingmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="PrintingmodalLabel">Create Order</h5>
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
                                    <label class="small font-weight-bold text-dark">Cloth Type*</label>
                                    <select class="form-control form-control-sm" name="clothtype" id="clothtype" required>
                                        <option value="">Select</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Quantity*</label>
                                    <input type="number" class="form-control form-control-sm" placeholder="" name="quantity" id="quantity" required>
                                </div>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Printing Company*</label>
                                    <select class="form-control form-control-sm" name="printingcompany" id="printingcompany" required>
                                        <option value="">Select</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Sewing Company*</label>
                                    <select class="form-control form-control-sm" name="sewingcompany" id="sewingcompany" required>
                                        <option value="">Select</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Assigned Date*</label>
                                    <input type="date" class="form-control form-control-sm" name="assigndate" id="assigndate" required>
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Design Type*</label><br>
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" class="form-check-input" name="design[]" id="embroid" value="embroid">
                                        <label class="form-check-label" for="embroid">Embroid</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" class="form-check-input" name="design[]" id="screenprinting" value="screenprinting">
                                        <label class="form-check-label" for="screenprinting">Screen Printing</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" class="form-check-input" name="design[]" id="dtf" value="dtf">
                                        <label class="form-check-label" for="dtf">DTF</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" class="form-check-input" name="design[]" id="submission" value="submission">
                                        <label class="form-check-label" for="submission">Submission</label>
                                    </div>
                                </div>
                            </div>
                            <hr class="border-dark">
                            <div class="form-group mt-3 text-right">
                                <?php if (in_array('createOrderDetail', $user_permission)) : ?>
                                    <button type="submit" id="formsubmit" class="btn btn-primary btn-sm px-5" <?php if ($addcheck == 0) { echo 'disabled'; } ?>>
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
                                        <th>Cloth Type</th>
                                        <th>Quantity</th>
                                        <th>Printing Company</th>
                                        <th>Sewing Company</th>
                                        <th>Assigned Date</th>
                                        <th>Design Type</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <div class="form-group">
                            <label class="small font-weight-bold text-dark">Remark</label>
                            <textarea name="remark" id="remark" class="form-control form-control-sm"></textarea>
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

<!-- Printing Detail Modal -->
<div class="modal fade" id="orderdet" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="orderdetLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderdetLabel">Printing Order Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-12">
                        <h6>Customer: <span id="customerName" class="font-weight-bold"></span></h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="scrollbar pb-3" id="style-3">
                            <table class="table table-striped table-bordered table-sm small" id="orderdetailtable">
                                <thead>
                                    <tr>
                                        <th nowrap>Cloth Type</th>
                                        <th nowrap>Quantity</th>
                                        <th nowrap>Printing Company</th>
                                        <th nowrap>Sewing Company</th>
                                        <th nowrap>Assigned Date</th>
                                        <th nowrap>Design Type</th>
                                        <th nowrap>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <h6>Additional Order Details</h6>
                        <div class="scrollbar pb-3" id="style-3">
                            <table class="table table-striped table-bordered table-sm small" id="additionalOrderTable">
                                <thead>
                                    <tr>
                                        <th nowrap>Category Type</th>
                                        <th nowrap>Supplier</th>
                                        <th nowrap>Color Code</th>
                                        <th nowrap>Order Quantity</th>
                                        <th nowrap>Order Date</th>
                                        <th nowrap>Remarks</th>
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

<!-- Receive details info Modal -->
<div class="modal fade" id="receivedetailsinfo" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="receivedetailsinfoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="receivedetailsinfoLabel">Received Order Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-12">
                        <h6>Customer: <span id="ReceivecustomerName" class="font-weight-bold"></span></h6>
                    </div>
                </div>

                <!-- Received Order Details Table -->
                <div class="row" id="receivedetailsinfotableContainer">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="scrollbar pb-3" id="style-3">
                            <table class="table table-striped table-bordered table-sm small" id="receivedetailsinfotable">
                                <thead>
                                    <tr>
                                        <th nowrap>Cloth Type</th>
                                        <th nowrap>Design Type</th>                                      
                                        <th nowrap>Printing Company</th>
                                        <th nowrap>Sewing Company</th>
                                        <th nowrap>Received Quantity</th>
                                        <th nowrap>Received Date</th>                                       
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Received Color/Cuff Details Table -->
                <div class="row mt-4" id="receivedcolorcuffContainer">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <h6>Received Color/Cuff Details</h6>
                        <div class="scrollbar pb-3" id="style-3">
                            <table class="table table-striped table-bordered table-sm small" id="receivedcolorcuff">
                                <thead>
                                    <tr>
                                        <th nowrap>Color/Cuff</th>
                                        <th nowrap>Company Name</th>
                                        <th nowrap>Received Quantity</th>
                                        <th nowrap>Received Date</th>
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




<!-- Receive Details Modal -->   <!-- receive => R   --> 
<div class="modal fade" id="ReceiveDetailsModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="ReceiveDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ReceiveDetailsModalLabel">Receive Order Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-3">
                        <form id="receivedetailsform" autocomplete="off">
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Cloth Type*</label>
                                    <select class="form-control form-control-sm" name="Rclothtype" id="Rclothtype">
                                        <option value="">Select</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Color/Cuff*</label>
                                    <select class="form-control form-control-sm" name="Rcolorcuff" id="Rcolorcuff">
                                        <option value="0">Select</option>
                                        <option value="1">Color</option>
                                        <option value="2">Cuff</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Printing Company*</label>
                                    <select class="form-control form-control-sm" name="Rprintingcompany" id="Rprintingcompany">
                                        <option value="">Select</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Sewing Company*</label>
                                    <select class="form-control form-control-sm" name="Rsewingcompany" id="Rsewingcompany">
                                        <option value="">Select</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Design Type*</label>
                                    <select class="form-control form-control-sm" name="Rdesigntype" id="Rdesigntype">
                                        <option value="">Select</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Color/Cuff Company*</label>
                                    <select class="form-control form-control-sm" name="Rcolorcompany" id="Rcolorcompany">
                                        <option value="">Select</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Received Quantity*</label>
                                    <input type="number" class="form-control form-control-sm" name="receivedQuantity" id="receivedQuantity" required>
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Receive Date*</label>
                                    <input type="date" class="form-control form-control-sm" name="receiveDate" id="receiveDate" required>
                                </div>
                            </div>
                            <hr class="border-dark">
                            <div class="form-group mt-3 text-right">
                                <button type="button" id="addReceiveDetails" class="btn btn-primary btn-sm px-4"><i class="fas fa-plus"></i>&nbsp;Add to list</button>
                                <input type="hidden" id="inquiryid" value="">
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-8 col-xl-9">
                        <div class="scrollbar pb-3" id="style-2">
                            <table class="table table-striped table-bordered table-sm small" id="orderReceivetable">
                                <thead>
                                    <tr>
                                        <th>Cloth Type</th>
                                        <th>Printing Company</th>
                                        <th>Sewing Company</th>
                                        <th>Color/Cuff Company</th>
                                        <th>Design Type</th>
                                        <th>Color/Cuff</th>
                                        <th>Received Quantity</th>
                                        <th>Receive Date</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <div class="form-group">
                            <label class="small font-weight-bold text-dark">Remark</label>
                            <textarea name="Rremark" id="Rremark" class="form-control form-control-sm"></textarea>
                        </div>
                        <hr>
                        <div class="form-group mt-2">
                            <button type="button" id="btnSaveReceiveDetails" class="btn btn-outline-primary btn-sm fa-pull-right"><i class="fas fa-save"></i>&nbsp;Save Details</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Color Cuff Modal -->      <!-- color modal => CM --> 
<div class="modal fade" id="ColorcuffModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="ColorcuffModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ColorcuffModalLabel">Color/Cuff Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-3">
                        <form id="receivedetailsform" autocomplete="off">
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Category Type*</label>
                                    <select class="form-control form-control-sm" name="CMcategorytype" id="CMcategorytype" required>
                                        <option value="">Select</option>
                                        <option value="1">Color</option>
                                        <option value="2">Cuff</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Supplier*</label>
                                    <select class="form-control form-control-sm" name="CMSupplier" id="CMSupplier">
                                        <option value="">Select</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Color Code*</label>
                                    <select class="form-control form-control-sm" name="CMColorcode" id="CMColorcode">
                                        <option value="">Select</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Order Quantity*</label>
                                    <input type="number" class="form-control form-control-sm" name="CMOrderQuantity" id="CMOrderQuantity" required>
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Order Date*</label>
                                    <input type="date" class="form-control form-control-sm" name="CMOrderDate" id="CMOrderDate" required>
                                </div>
                            </div>
                            <hr class="border-dark">
                            <div class="form-group mt-3 text-right">
                                <button type="button" id="addColorCuffDetails" class="btn btn-primary btn-sm px-4"><i class="fas fa-plus"></i>&nbsp;Add to list</button>
                                <input type="hidden" id="inquiryid" value="">
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-8 col-xl-9">
                        <div class="scrollbar pb-3" id="style-2">
                            <table class="table table-striped table-bordered table-sm small" id="colorcufftable">
                                <thead>
                                    <tr>
                                        <th>Category Type</th>
                                        <th>Supplying Company</th>
                                        <th>Color Code</th>
                                        <th>Order Quantity</th>
                                        <th>Order Date</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <div class="form-group">
                            <label class="small font-weight-bold text-dark">Remark</label>
                            <textarea name="CMremark" id="CMremark" class="form-control form-control-sm"></textarea>
                        </div>
                        <hr>
                        <div class="form-group mt-2">
                            <button type="button" id="btnSaveColorCuffDetails" class="btn btn-outline-primary btn-sm fa-pull-right"><i class="fas fa-save"></i>&nbsp;Save Details</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
