<main>
    <div class="page-header page-header-light bg-white shadow">
        <div class="container-fluid">
            <div class="page-header-content py-3">
                <h1 class="page-header-title font-weight-light">
                    <div class="page-header-icon"><i class="fas fa-list"></i></div>
                    <span>Allocated Machines</span>
                </h1>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-2 p-0 p-2">
        <div class="card">
            <div class="card-body p-0 p-2">
                <form id="searchform">
                    <div class="form-row">
				            	<div class="col-3">
                            <label class="small font-weight-bold text-dark">Machine*</label>
                            <div class="input-group input-group-sm mb-3">
                                <select class="form-control form-control-sm" name="machine" id="machine"
                                    required>
                                    <option value="">Select</option>
                                    <?php foreach ($result['machine'] as $machines): ?>
										<option value="<?php echo $machines->id; ?>">
											<?php echo $machines->name.'-'.$machines->s_no; ?>
										</option>
									<?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-3">
                            <label class="small font-weight-bold text-dark">Date*</label>
                            <div class="input-group input-group-sm mb-3">
                                <input type="date" class="form-control dpd1a rounded-0" id="date"
                                    name="date" required>
                            </div>
                        </div>
                    </div>
                    <input type="submit" class="d-none" id="hidesubmit">
                </form>
                <div class="row">
                    <div class="col-12">
                        <div class="scrollbar pb-3" id="style-2">
                            <table class="table table-bordered table-striped table-sm nowrap"
                                id="machineAllocationTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Order Id</th>
                                        <th>Delivery Plan Id</th>
                                        <th>Product</th>
                                        <th>Machine</th>
                                        <!-- <th>Cost Item Name</th> -->
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id = "machineAllocationTableBody">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Allocation View Modal -->
<div class="modal fade" id="allocationModal" tabindex="-1" role="dialog" aria-labelledby="allocationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Machine Allocation Details</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="container mt-2">
        <div class="row">
          <div class="col-md-12 text-right">
            <h6><strong>Balance Quantity:</strong> <span id="balanceQty">0</span></h6>
          </div>
        </div>
      </div>

        <div class="modal-body">
                           <div class="col-12">
                        <div class="scrollbar pb-3" id="style-2">
                            <table class="table table-bordered table-striped table-sm nowrap"
                                id="machineAllocationTable">
                                <thead>
                                    <tr>
                                        <td>Machine</td>
                                        <td>Start Date</td>
                                        <td>End Date</td>
                                        <td>Allocated Quantity</td>
                                        <td>Completed Quantity</td>
                                        <td>Waste Quantity</td>
                                        
                                    </tr>
                                </thead>
                                <tbody id = "tableBody">

                                </tbody>
                            </table>
                        </div>
                    </div>
        </div>
    </div>
  </div>
</div>

<!-- modal completed quantity-->

<div class="modal fade" id="addCompletedModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Completed Amount</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <form id="completedAmountForm">
          <input type="hidden" id="allocationId">
            <div class="form-group">
              <label for="completedAmount">Amount Completed Today</label>
              <input type="number" class="form-control" id="completedAmount" required>
            </div>

            <div class="form-group">
              <label for="startTime">Start Time</label>
              <select class="form-control" id="startTime" required>
                <option value="">-- Select Start Time --</option>
              </select>
            </div>

            <div class="form-group">
              <label for="endTime">End Time</label>
              <select class="form-control" id="endTime" required>
                <option value="">-- Select End Time --</option>
              </select>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="saveCompletedAmount">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- modal rejected add-->
 <div class="modal fade" id="addRejectedModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Rejected Amount</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <form id="rejectedAmountForm">
          <input type="hidden" id="allocationMid">
            <div class="form-group">
              <label for="rejectedAmmount">Amount Rejected Today</label>
              <input type="number" class="form-control" id="rejectedAmmount" required>
            </div>
            <div class="form-group">
              <label for="RstartTime">Start Time</label>
              <select class="form-control" id="RstartTime" required>
                <option value="">-- Select Start Time --</option>
              </select>
            </div>

            <div class="form-group">
              <label for="RendTime">End Time</label>
              <select class="form-control" id="RendTime" required>
                <option value="">-- Select End Time --</option>
              </select>
            </div>
            <div class="form-group">
               <label for="rejectReason">Reject Reason Type*</label>
                    <select class="form-control form-control-sm" name="rejectReason" id="rejectReason" required>
                        <option value="">Select</option>
                        <?php foreach ($result['reason'] as $reasons): ?>
										<option value="<?php echo $reasons->id; ?>">
											<?php echo $reasons->reason_type; ?>
										</option>
									<?php endforeach; ?>
                  </select>
              </div>
          <div class="form-group">
            <label for="comment">Comment</label>
            <input type="text" class="form-control" id="comment" required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="saveRejectedAmount">Save</button>
      </div>
    </div>
  </div>
</div>