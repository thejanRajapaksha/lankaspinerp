
<main>
    <div class="page-header page-header-light bg-white shadow">
        <div class="container-fluid">
            <div class="page-header-content py-3">
                <h1 class="page-header-title font-weight-bold text-dark">
                    <div class="page-header-icon"><i class="fas fa-quote-left"></i></div>
                    <span>Completed Orders</span>
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

<!-- Integrated Detail Modal with Tabs -->
<div class="modal fade" id="integratedDetailModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="integratedDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="integratedDetailModalLabel">Order and Material Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" id="detailsTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="summary-tab" data-toggle="tab" href="#summaryDetails" role="tab" aria-controls="summaryDetails" aria-selected="true">Summary Details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="order-tab" data-toggle="tab" href="#orderDetails" role="tab" aria-controls="orderDetails" aria-selected="false">Order Details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="material-tab" data-toggle="tab" href="#materialDetails" role="tab" aria-controls="materialDetails" aria-selected="false">Material Details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="receive-tab" data-toggle="tab" href="#receiveDetails" role="tab" aria-controls="receiveDetails" aria-selected="false">Received Details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="delivery-tab" data-toggle="tab" href="#deliveryPackagingDetails" role="tab" aria-controls="deliveryPackagingDetails" aria-selected="false">Delivery & Packaging</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="payment-tab" data-toggle="tab" href="#paymentDetails" role="tab" aria-controls="paymentDetails" aria-selected="false">Payment Details</a>
                    </li>

                </ul>

                <!-- Tab panes -->
                <div class="tab-content mt-4">
                    <!-- Summary Details Tab -->
                    <div class="tab-pane fade show active" id="summaryDetails" role="tabpanel" aria-labelledby="summary-tab">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-sm small" id="summarytable">
                                <thead>
                                    <tr>
                                        <th nowrap>Customer</th>
                                        <th nowrap>Payment Type</th>
                                        <th nowrap>Bank Name</th>
                                        <th nowrap>Advance</th>
                                        <th nowrap>Cloth Images</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Order Details Tab -->
                    <div class="tab-pane fade" id="orderDetails" role="tabpanel" aria-labelledby="order-tab">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-sm small" id="orderdetailtable">
                                <thead>
                                    <tr>
                                        <th nowrap>Cloth</th>
                                        <th nowrap>Material</th>
                                        <th nowrap>Size</th>
                                        <th nowrap>Qty</th>
                                        <th nowrap>Cutting Qty</th>
                                        <th nowrap>Balance</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Material Details Tab -->
                    <div class="tab-pane fade" id="materialDetails" role="tabpanel" aria-labelledby="material-tab">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-sm small" id="materialdetailtable">
                                <thead>
                                    <tr>
                                        <th nowrap>Material Type</th>
                                        <th nowrap>Order Date</th>
                                        <th nowrap>Quantity (Kg)</th>
                                        <th nowrap>Balance Quantity(Kg)</th>
                                        <th nowrap>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Received Details Tab -->
                    <div class="tab-pane fade" id="receiveDetails" role="tabpanel" aria-labelledby="receive-tab">
                        <div class="table-responsive">
                            <h6>Received Order Details</h6>
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

                        <div class="table-responsive mt-3">
                            <h6>Received Color/Cuff Details</h6>
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

                    <!-- Delivery and Packaging Details Tab -->
                    <div class="tab-pane fade" id="deliveryPackagingDetails" role="tabpanel" aria-labelledby="delivery-tab">
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

                    <!-- Payment Details Tab -->
                    <div class="tab-pane fade" id="paymentDetails" role="tabpanel" aria-labelledby="payment-tab">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-sm small" id="paymentdetailtable">
                                <thead>
                                    <tr>
                                        <th nowrap>Payment Type</th>
                                        <th nowrap>Amount</th>
                                        <th nowrap>Payment Date</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>

                </div> <!-- End of Tab content -->
            </div>
        </div>
    </div>
</div>
