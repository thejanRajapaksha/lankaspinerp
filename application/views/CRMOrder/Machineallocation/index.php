<main>
    <div class="page-header page-header-light bg-white shadow">
        <div class="container-fluid">
            <div class="page-header-content py-3">
                <h1 class="page-header-title font-weight-light">
                    <div class="page-header-icon"><i class="fas fa-list"></i></div>
                    <span>Machine Allocation</span>
                </h1>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-2 p-0 p-2">
        <div class="card">
            <div class="card-body p-0 p-2">
                <form id="searchform">
                    <div class="form-row">
<<<<<<< Updated upstream
                        <div class="col-3">
							<label class="small font-weight-bold text-dark">Orders*</label>
							<div class="input-group input-group-sm mb-3">
								<select class="form-control form-control-sm" name="orderid" id="orderid" required>
									<option value="">Select</option>
								</select>
							</div>
						</div>

						<!-- <div class="col-3">
							<label class="small font-weight-bold text-dark">Delivery ID*</label>
							<div class="input-group input-group-sm mb-3">
								<select type="text" class="form-control dpd1a rounded-0" id="selectdeliveryid" name="selectdeliveryid" required>
									<option value="">Select</option>
								</select>
							</div>
						</div> -->
=======
					<div class="col-3">
                            <label class="small font-weight-bold text-dark">Customer*</label>
                            <div class="input-group input-group-sm mb-3">
                                <select class="form-control form-control-sm" name="customer" id="customer"
                                    required>
                                    <option value="">Select</option>
                                    <?php foreach ($result['customer'] as $customer): ?>
										<option value="<?php echo $customer->idtbl_customer; ?>">
											<?php echo $customer->name; ?>
										</option>
									<?php endforeach; ?>
                                </select>
                            </div>
                        </div>

						<div class="col-3">
                            <label class="small font-weight-bold text-dark">Inquiry*</label>
                            <div class="input-group input-group-sm mb-3">
                                <select type="text" class="form-control dpd1a rounded-0" id="selectedInquiry"
                                    name="selectedInquiry" required>
                                    <option value="">Select</option>

                                </select>
                            </div>
                        </div>

                        <!-- <div class="col-3">
                            <label class="small font-weight-bold text-dark">PO Number*</label>
                            <div class="input-group input-group-sm mb-3">
                                <select class="form-control form-control-sm" name="inquiryid" id="inquiryid"
                                    required>
                                    <option value="">Select</option>
                                    <?php //foreach ($result['inquiryinfo'] as $rowInquiry): ?>
										<option value="<?php //echo $rowInquiry->idtbl_inquiry; ?>">
											PO<?php // echo $rowInquiry->idtbl_inquiry; ?>
										</option>
									<?php // endforeach; ?>
                                </select>
                            </div>
                        </div> -->
                        <div class="col-3">
                            <label class="small font-weight-bold text-dark">PO NUMBER*</label>
                            <div class="input-group input-group-sm mb-3">
                                <select type="text" class="form-control dpd1a rounded-0" id="selectedPo"
                                    name="selectedPo" required>
                                    <option value="">Select</option>
>>>>>>> Stashed changes

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
                                        <th>Customer</th>
                                        <th>Po Number</th>
<<<<<<< Updated upstream
                                        <th>Delivery ID</th>
=======
                                        <!-- <th>Job</th> -->
>>>>>>> Stashed changes
                                        <th>Qty</th>
                                        <th>Cost Item Name</th>
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

<!-- Modal -->
<div class="modal fade" id="machineallocatemodal" data-backdrop="static" data-keyboard="false" tabindex="-1"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Machine Allocation</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div id="alert"></div>
			<div class="modal-body">
				<div class="row">
					<div class="col-4">
						<form action="" id="allocationform" autocomplete="off">
							<div class="form-row mb-1">
								<input type="hidden" class="form-control form-control-sm" name="poid"
									id="poid" required>
								<input type="hidden" class="form-control form-control-sm" name="costitemid"
									id="costitemid" required>
								<input type="hidden" class="form-control form-control-sm" name="hiddenselectjobid"
									id="hiddenselectjobid" required>
								<label class="small font-weight-bold text-dark">Machine*</label><br>
								<select class="form-control form-control-sm" style="width: 100%;" name="machine"
									id="machine" required>
									<option value="">Select</option>
									<?php foreach ($result['machine'] as $rowmachine): ?>
										<option value="<?php echo $rowmachine->id; ?>">
<<<<<<< Updated upstream
											<?php echo $rowmachine->name . ' - ' . $rowmachine->machinecode; ?>
=======
											<?php echo $rowmachine->name . ' - ' . $rowmachine->s_no; ?>
>>>>>>> Stashed changes
										</option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="form-row mb-1">
								<label class="small font-weight-bold text-dark">Employee*</label><br>
								<select class="form-control form-control-sm" style="width: 100%;" name="employee"
									id="employee" required>
									<option value="">Select</option>
									<?php foreach ($result['employee'] as $rowemployee): ?>
										<option value="<?php echo $rowemployee->id; ?>">
											<?php echo $rowemployee->emp_fullname . ' - ' . $rowemployee->emp_id; ?>
										</option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="form-row mb-1">
								<label class="small font-weight-bold text-dark">Delivery Plan*</label>
								<div class="input-group input-group-sm">
									<select type="text" class="form-control dpd1a rounded-0" id="deliveryplan"
											name="deliveryplan" required>
										<option value="">Select</option>
                                    </select>
								</div>
							</div>
							<div class="form-row mb-1">
								<label class="small font-weight-bold">Allocation Qty*</label>
								<input type="number" class="form-control form-control-sm" placeholder=""
									name="allocationqty" id="allocationqty" required>
							</div>
							<div class="form-row mb-1">
								<label class="small font-weight-bold">Start Date*</label>
								<input type="datetime-local" class="form-control form-control-sm" placeholder=""
									name="startdate" id="startdate" required>
							</div>
							<div class="form-row mb-1">
								<label class="small font-weight-bold">End Date*</label>
								<input type="datetime-local" class="form-control form-control-sm" placeholder=""
									name="enddate" id="enddate" required>
							</div>
							<div class="form-group mt-3 px-2 text-right">
								<button type="button" name="BtnAddmachine" id="BtnAddmachine"
									class="btn btn-primary btn-m  fa-pull-right"><i
										class="fas fa-plus"></i>&nbsp;Add</button>
							</div>
							<button type="submit" id="allocationsubmit" class='d-none'>Submit</button>
						</form>
					</div>
					<div class="col-8">
						<div class="row mt-4">
							<div class="col-12 col-md-12">
								<div class="table" id="style-2">
									<table class="table table-bordered table-striped  nowrap display"
										id="tblmachinelist">
										<thead>
											<th class="d-none">Costing ID</th>
											<th>Machine</th>
											<th>Start Date</th>
											<th>End Date</th>
											<th>Allocated Qty</th>
											<th>Action</th>
										</thead>
										<tbody id="tblmachinebody">

										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="form-group mt-3 text-right">
							<button type="button" id="submitBtn2" class="btn btn-outline-primary btn-sm fa-pull-right"
								<?php if(in_array('createMachineallocation', $user_permission)):?>
									><i class="far fa-save"></i>&nbsp;Allocate
								Machine</button>
							<?php endif;?>
						</div>
					</div>
				</div>

				<div class="row mt-3">
					<div class="col-12 col-md-12">
						<div class="table" id="style-2">
							<table class="table table-bordered table-striped  nowrap display" id="tblallocationlist">
								<thead>
									<th>Start Date</th>
									<th>End Date</th>
									<!-- <th>Cost Item</th> -->
									<th>Quantity</th>
								</thead>
								<tbody id="tblallocationlistbody">

								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
