<main>
    <div class="page-header page-header-light bg-white shadow">
        <div class="container-fluid">
            <div class="page-header-content py-3">
                <h1 class="page-header-title font-weight-light">
                    <div class="page-header-icon"><i class="fas fa-list"></i></div>
                    <span>WIP Machines Report</span>
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
                            <label class="small font-weight-bold text-dark">Machine*</label>
                            <select class="form-control form-control-sm" name="machine" id="machine" required>
                                <option value="">Select</option>
                                <?php foreach ($result['machine'] as $machines): ?>
                                    <option value="<?php echo $machines->id; ?>">
                                        <?php echo $machines->name . '-' . $machines->s_no; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="small font-weight-bold text-dark">Date*</label>
                            <input type="date" class="form-control form-control-sm" id="date" name="date" required>
                        </div>
                    </div>
                </form>

                <div class="table-responsive mt-3">
                    <table id="allocationTable" class="table table-bordered table-striped table-sm nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Order / Delivery</th>
                                <th>End date</th>
                                <th>Delivery date</th>
                                <th>Order Qty</th>
                                <th>Delivery Qty</th>
                                <th>Completed Qty</th>
                            </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>
    </div>
</main>
