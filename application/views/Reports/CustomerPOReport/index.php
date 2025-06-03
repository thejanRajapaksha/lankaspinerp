<main>
    <div class="page-header page-header-light bg-white shadow">
        <div class="container-fluid">
            <div class="page-header-content py-3">
                <h1 class="page-header-title font-weight-light">
                    <div class="page-header-icon"><i class="fas fa-list"></i></div>
                    <span>WIP Customer Report</span>
                </h1>
            </div>
        </div>
    </div>

    <div class="container-fluid mt-2 p-2">
        <div class="card">
            <div class="card-body p-2">
                
                <form id="searchform">
                    <div class="form-row">
                        <div class="col-md-3">
                            <label class="small font-weight-bold text-dark">Customer*</label>
                            <select class="form-control form-control-sm" name="customername" id="customername" required>
                                <option value="" selected disabled>Select Customer</option>
                                <?php foreach ($result['customername'] as $customernames):?>
                                    <option value="<?php echo $customernames->idtbl_customer;?>">
                                    <?php echo htmlspecialchars($customernames->name);?></option>
                                <?php endforeach;?>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="small font-weight-bold text-dark">PO Number*</label>
                            <div class="input-group input-group-sm mb-3">
                                <select type="text" class="form-control dpd1a rounded-0" id="selectedPo"
                                    name="selectedPo" required>
                                    <option value="">Select</option>

                                </select>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="table-responsive mt-3">
                    <table id="allocationTable" class="table table-bordered table-striped table-sm nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>Machine</th>
                                <th>Order / Delivery</th>
                                <th>End date</th>
                                <th>Delivery date</th>
                                <th>Order Quantity</th>
                                <th>Delivery Quantity</th>
                                <th>Completed Quantity</th>
                            </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>
    </div>
</main>
