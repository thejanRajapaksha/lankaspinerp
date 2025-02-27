<main>
    <div class="page-header page-header-light bg-white shadow">
        <div class="container-fluid">
            <div class="page-header-content py-3">
                <h1 class="page-header-title font-weight-light">
                    <div class="page-header-icon"><i class="fas fa-quote-right"></i></div>
                    <span>Quotation Form</span>
                </h1>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-2 p-0 p-2">
        <div class="card">
            <div class="card-body p-0 p-2">
                <div class="row">
                    <div class="col-12 text-right">
                    <?php if (in_array('createCustomerInfo', $user_permission)) : ?>
                                        <button type="button" class="btn btn-primary btn-sm px-5" data-toggle="modal" data-target="#staticBackdrop">
                                            <i class="fas fa-plus mr-2"></i>&nbsp;Create Quotation
                                        </button>
                                    <?php endif; ?>
                        <hr>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">

                        <table class="table table-bordered table-striped table-sm nowrap" id="dataTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Quotation Date</th>
                                    <th>Customer Name</th>
                                    <th class="d-none">Inquiry ID</th>
                                    <th class="d-none">Customer ID</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </thead>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Create Quotation</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
						<form id="createorderform" autocomplete="off" enctype="multipart/form-data">
							<div class="form-row mb-1">
								<div class="col">
									<label class="small font-weight-bold text-dark">Quotation Date*</label>
									<input type="date" class="form-control form-control-sm" placeholder="" name="quot_date" id="quot_date" value="<?php echo date('Y-m-d') ?>" required>
								</div>
								<div class="col">
									<label class="small font-weight-bold text-dark">Due Date*</label>
									<input type="date" class="form-control form-control-sm" placeholder="" name="duedate" id="duedate" value="<?php echo date('Y-m-d') ?>" required>
								</div>
							</div>
							<div class="form-row mb-1">
								<div class="col">
									<label class="small font-weight-bold text-dark">Customer*</label>
									<select class="form-control form-control-sm" name="customer" id="customer" required>
										<option value="">Select</option>
										<?php foreach ($result['customerlist'] as $rowcustomerlist) { ?>
											<option value="<?php echo $rowcustomerlist->tbl_customer_idtbl_customer ?>"><?php echo $rowcustomerlist->name ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-row mb-1">
								<div class="col">
									<label class="small font-weight-bold text-dark">Cloth Type*</label>
									<select class="form-control form-control-sm" name="product" id="product" required>
										<option value="">Select</option>
										<?php foreach ($result['productlst'] as $rowproductlst) { ?>
											<option value="<?php echo $rowproductlst->idtbl_cloth ?>"><?php echo $rowproductlst->type ?></option>
										<?php } ?>
									</select>
								</div>

								<div class="col">
									<label class="small font-weight-bold text-dark">Meterial Type*</label>
									<select class="form-control form-control-sm" name="meterial" id="meterial" required>
										<option value="">Select</option>

									</select>
								</div>
							</div>
							<div class="form-row mb-1">
								<div class="col">
									<label class="small font-weight-bold text-dark">Qty*</label>
									<input type="number" class="form-control form-control-sm" placeholder="" name="qty" id="qty" required>
								</div>
								<div class="col">
									<label class="small font-weight-bold text-dark">Price*</label>
									<input type="number" class="form-control form-control-sm" placeholder="" name="unitprice" id="unitprice" required>
								</div>
							</div>
							<div class="form-group mb-1">
								<label class="small font-weight-bold text-dark">Description</label>
								<?php if (in_array('updateCRMQuotationform', $user_permission)) : ?>
                                    <textarea name="comment" id="comment" class="form-control form-control-sm"></textarea>
                                <?php else : ?>
                                    <textarea name="comment" id="comment" class="form-control form-control-sm" readonly></textarea>
                                <?php endif; ?>
							</div>
							<hr class="border-dark">
							<div class="form-group mt-1">
								<label class="small font-weight-bold text-dark">Product Image</label>
								<input type="file" name="productimage[]" id="productimage" class="form-control form-control-sm" style="padding-bottom:32px;" multiple>
								<small id="" class="form-text text-danger">Image size 800X800 Pixel</small>
							</div>
							<div class="form-group mt-3 text-right">
								<button type="button" id="formsubmit" class="btn btn-primary btn-sm px-4" <?php if ($addcheck == 0) {
																												echo 'disabled';
																											} ?>><i class="fas fa-plus"></i>&nbsp;Add to list</button>
								<input name="submitBtn" type="submit" value="Save" id="submitBtn" class="d-none">
								<input type="hidden" id="recordOption" value="1">
							</div>
							<!-- <input type="hidden" name="refillprice" id="refillprice" value=""> -->
						</form>
					</div>
					<div class="col-sm-12 col-md-12 col-lg-8 col-xl-8">
						<div class="scrollbar pb-3" id="style-3">
							<table class="table table-striped table-bordered table-sm small" id="tableorder">
								<thead>
									<tr>
										<th>Cloth</th>
										<th>Meterial</th>
										<th>Description</th>
										<th>Qty</th>
										<th>Unitprice</th>
										<th class="d-none">Quotation details ID</th>
										<th class="text-right">Total</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>
						<div class="row">
							<div class="col text-right">
								<h1 class="font-weight-600" id="divtotal">Rs. 0.00</h1>
							</div>
							<input type="hidden" id="hidetotalorder" value="0">
							<input type="hidden" id="sumdis" value="0">
						</div>
						<hr>
						<div class="form-group">
							<label class="small font-weight-bold text-dark">Remark</label>
							<textarea name="remark" id="remark" class="form-control form-control-sm"></textarea>
							<input type="hidden" id="getid" value="<?php echo $result['getid']; ?>">
						</div>
						<div class="form-group mt-2">
							<button type="button" id="btncreateorder" class="btn btn-outline-primary btn-sm fa-pull-right"><i class="fas fa-save"></i>&nbsp;Create
								Quotation</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal Quotation Details -->
<div class="modal fade" id="quotationmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="page-header-title font-weight-bold">
                    <div class="page-header-icon"><i class="fas fa-address-book"></i> <span>Quotation Details</span></div>
                </h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeCD">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="scrollbar pb-3" id="style-2">
                            <table class="table table-bordered table-striped table-sm nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="d-none"></th>
                                        <th>Due Date</th>
                                        <th>Description</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th class="text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody id="getquotationdataform">
                                    <!-- Quotation details will be loaded here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="mt-3 text-right">
                    <button class="btn btn-success approvebtn" value="1">Approve Quotation</button>
                    <button class="btn btn-danger approvebtnelse" value="2">Disapprove Quotation</button>
                </div>
            </div>
        </div>
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
                    <div class="form-group">
                        <label for="disapprovalReason">Reason for Disapproval</label>
                        <select class="form-control" id="disapprovalReason" required>
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


<div class="modal fade" id="inquiryCancelModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalCenterTitle">Cancel this Quotation</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form>
				<div class="modal-body">
					<div class="form-group">
						<label for="exampleFormControlInput1">Reason</label>
						<textarea class="form-control form-control-sm" id="cancelMsg" rows="5"></textarea>
					</div>
					<input type="hidden" id="modalInquiryCancelID">
					<input type="hidden" id="agentMobileNum">
				</div>
				<div class="modal-footer">
					<button type="button" id="btnDeleteAgentMsg" class="btn btn-outline-danger btn-sm" <?php if ($deletecheck == 0) {
																											echo 'disabled';
																										} ?>><i class="fas fa-trash-alt"></i>&nbsp;Cancel Quotation</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Modal Image View -->
<div class="modal fade" id="modalimageview" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header p-2">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-12">
						<div id="imagelist" class=""></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
