<main>
	<div class="page-header page-header-light bg-white shadow">
		<div class="container-fluid">
			<div class="page-header-content py-3">
				<h1 class="page-header-title font-weight-light">
					<div class="page-header-icon"><i class="fas fa-shopping-basket"></i></div>
					<span>Quotation Status</span>
				</h1>
			</div>
		</div>
	</div>
	<div class="container-fluid mt-2 p-0 p-2">
		<div class="card">
			<!-- Boostrap Tabs Start -->
			<nav>
				<div class="nav nav-tabs" id="nav-tab" role="tablist">
					<a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Pending</a>
					<a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Approved</a><!-- GM Approved -->
					<a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Rejected</a>
					<!-- <a class="nav-item nav-link" id="nav-contact1-tab" data-toggle="tab" href="#nav-contact1" role="tab" aria-controls="nav-contact1" aria-selected="false">Rejected</a> -->
			</nav>
			<div class="tab-content" id="nav-tabContent">
				<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
					<div class="card-body p-0 p-2">
						<div class="row">
							<div class="col-12 text-right">
								<button class="btn btn-primary btn-sm mb-3" id="addnewrequest"><i class="fas fa-plus mr-2"></i>Add New Request</button>
							</div>
							<div class="col-12">
								<div class="scrollbar pb-3" id="style-2">
									<table class="table table-bordered table-striped table-sm nowrap" id="dataTablePending">
										<thead>
											<tr>
												<th>#</th>
												<th>Customer</th>
												<th>Quotation Date</th>
												<th>Due Date</th>
												<th>Total</th>
												<th>Remarks</th>
												<th class="text-right">Actions</th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
					<div class="card-body p-0 p-2">
						<div class="row">
							<div class="col-12">
								<div class="scrollbar pb-3" id="style-2">
									<table class="table table-bordered table-striped table-sm nowrap w-100" id="dataTableapproved">
										<thead>
											<tr>
												<th>#</th>
												<th>Customer</th>
												<th>Quotation Date</th>
												<th>Due Date</th>
												<th>Total</th>
												<th>Remarks</th>
												<!-- <th class="text-right">Actions</th> -->
											</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
					<div class="card-body p-0 p-2">
						<div class="row">
							<div class="col-12">
								<div class="scrollbar pb-3" id="style-2">
									<table class="table table-bordered table-striped table-sm nowrap w-100" id="dataTableRejected">
										<thead>
											<tr>
												<th>#</th>
												<th>Customer</th>
												<th>Quotation Date</th>
												<th>Due Date</th>
												<th>Total</th>
												<th>Remarks</th>
												<th>Reason</th>
												<th>Additional Reason</th>
												<!-- <th class="text-right">Actions</th> -->
											</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>

				

				<!-- <div class="tab-pane fade" id="nav-contact1" role="tabpanel" aria-labelledby="nav-contact1-tab">
					<div class="card-body p-0 p-2">
						<div class="row">
							<div class="col-12">
								<div class="scrollbar pb-3" id="style-2">
									<table class="table table-bordered table-striped table-sm nowrap w-100" id="dataTableRejected">
										<thead>
											<tr>
												<th>#</th>
												<th>Customer</th>
												<th>Quotation Date</th>
												<th>Due Date</th>
												<th>Total</th>
												<th>Discount</th>
												<th>NetTotal</th>
												<th>Delivery Charge</th>
												<th>Remarks</th>
												<th>Reason</th>
												<th class="text-right">Actions</th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div> -->
			</div>
			<!-- Boostrap Tabs End -->
		</div>
	</div>

	<!-- Disapproval Modal -->
<div class="modal fade" id="disapprovalModal" tabindex="-1" role="dialog" aria-labelledby="disapprovalModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="disapprovalModalLabel">Disapprove Quotation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="disapprovalForm">
                    <div class="form-group mb-1">
                        <label for="disapprovalReason">Reason for Disapproval</label>
                        <select class="form-control form-control-sm" id="disapprovalReason" required>
                            <option value="">Select </option>

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="additionalReason">Additional Comments</label>
                        <textarea class="form-control" id="additionalReason" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-danger" value="2">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
</main>
