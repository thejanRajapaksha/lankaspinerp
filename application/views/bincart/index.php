<main>
			<div class="page-header page-header-light bg-white shadow">
				<div class="container-fluid">
					<div class="page-header-content py-3">
						<h1 class="page-header-title">
							<div class="page-header-icon"><i class="fas fa-users"></i></div>
							<span>Supplier</span>
						</h1>
					</div>
				</div>
			</div>
			<div class="container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">

						<form action="<?php echo base_url() ?>Supplier/Supplierinsertupdate" method="post"
							enctype="multipart/form-data" autocomplete="off">
							<div class="row">
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Registered Name of the Company*</label>
										<input type="text" class="form-control form-control-sm" name="supplier_name"
											id="supplier_name" required>
									</div>
								</div>
								<div class=" col-3 form-group">
									<label class="small font-weight-bold">Supplier Type*</label>
									<select class="form-control form-control-sm" name="suppliertype" id="suppliertype"
										required>
										<option value="">Select</option>
										<?php foreach ($Suppliercategory->result() as $rowsuppliercategory) { ?>
										<option value="<?php echo $rowsuppliercategory->idtbl_supplier_type ?>">
											<?php echo $rowsuppliercategory->type ?></option>
										<?php } ?>
									</select>
								</div>

							</div>
							<div class="row">
								<div class="col-2">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">VAT Registration No*</label>
										<input type="text" class="form-control form-control-sm" name="vatno" id="vatno">
									</div>
								</div>

								<div class="col-2">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Telephone No*</label>
										<input type="number" class="form-control form-control-sm" name="telephoneno"
											id="telephoneno">
									</div>
								</div>
								<div class="col-2">
									<label class="small font-weight-bold ">Company*</label>
									<input type="text" id="f_company_name" name="f_company_name"
										class="form-control form-control-sm" required readonly>
								</div>
								<!-- <div class="col-2">
									<label class="small font-weight-bold ">Company
										Branch*</label>
									<input type="text" id="f_branch_name" name="f_branch_name"
										class="form-control form-control-sm">
								</div> -->
								<div class="col-2">
								<div class="form-group mb-1">
										<label class="small font-weight-bold"> Company Branch*</label>
										<input type="text" class="form-control form-control-sm" name="f_branch_name" id="f_branch_name">
									</div>
								</div>
								<input type="hidden" name="f_company_id" id="f_company_id">
								<input type="hidden" name="f_branch_id" id="f_branch_id">
							</div>

							<hr>
							<div class="row">
								<div class="col-3">
									<label class="small font-weight-bold"><b>Business Address*</b></label>
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Address Line 1*</label>
										<input type="text" class="form-control form-control-sm" name="line1" id="line1"
											required>
									</div>
								</div>
								<div class="col-2">
								</div>
								<!-- <div class="col-3">
									<label class="small font-weight-bold"><b>Delivery Address*</b></label>
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Delivery Address Line 1*</label>
										<input type="text" class="form-control form-control-sm" name="dline1"
											id="dline1" required>
									</div>
								</div> -->
							</div>
							<div class="row">
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Address Line 2*</label>
										<input type="text" class="form-control form-control-sm" name="line2" id="line2"
											required>
									</div>
								</div>
								<div class="col-2">
								</div>
								<!-- <div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Delivery Address Line 2*</label>
										<input type="text" class="form-control form-control-sm" name="dline2"
											id="dline2" required>
									</div>
								</div> -->
							</div>
							<div class="row">
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">City*</label>
										<input type="text" class="form-control form-control-sm" name="city" id="city">
									</div>
								</div>
								<div class="col-2">
								</div>
								<!-- <div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">City*</label>
										<input type="text" class="form-control form-control-sm" name="dcity" id="dcity">
									</div>
								</div> -->
							</div>
							<div class="row">
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">State*</label>
										<input type="text" class="form-control form-control-sm" name="state" id="state">
									</div>
								</div>
								<div class="col-2">
								</div>
								<!-- <div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">State*</label>
										<input type="text" class="form-control form-control-sm" name="dstate"
											id="dstate">
									</div>
								</div> -->
							</div>
							<br>
							<!-- Add VAT,NBT,SVAT cetificate -->
							<div class="row">
								<div class="col-4">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Business Status*</label><br>
										<input type="radio" id="Proprietorship" name="bstatus" value="Proprietorship"
											>
										<label for="age1">Proprietorship</label>
										<input type="radio" id="bstatusPartnership" name="bstatus" value="Partnership"
											>
										<label for="age2">Partnership</label>
										<input type="radio" id="bstatusIncorporation" name="bstatus"
											value="Incorporation" >
										<label for="age3">Incorporation</label><br><br>
									</div>

									<div class="form-group mb-1">
										<label class="small font-weight-bold">Method of Payment*</label><br>
										<input type="radio" id="cashpayementmethod" name="payementmethod" value="Cash"
											>
										<label for="age1">Cash</label>
										<input type="radio" id="bankpayementmethod" name="payementmethod" value="Bank"
											>
										<label for="age2">Bank</label>
									</div>

									<div class="form-group mb-1">
										<label class="small font-weight-bold">Credit Days*</label>
										<input type="text" class="form-control form-control-sm" name="credit_days"
											id="credit_days">
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-9">
									<div class="form-group mt-2 text-right" style="padding-top: 5px;">
									<?php if (in_array('createSupplierInfo', $user_permission)) : ?>
										<button type="submit" id="submitBtn" class="btn btn-primary btn-sm px-5">
											<i class="far fa-save"></i>&nbsp;Add Supplier
										</button>
									<?php endif; ?>
									</div>
								</div>
							</div>
							<input type="hidden" name="recordOption" id="recordOption" value="1">
							<input type="hidden" name="recordID" id="recordID" value="">
						</form>
					</div>
				</div>
			</div>
			<div class="container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">
						<div class="row">
							<div class="col-12">
								<div class="scrollbar pb-3" id="style-2">
									<table class="table table-bordered table-striped table-sm nowrap"
										id="tblsuppliertype" width="100%">
										<thead>
											<tr>
												<th>#</th>
												<th>Name</th>
												<th>Supplier Type</th>
												<th>Company Branch</th>
												<th>Address</th>
												<th>City</th>
												<th class="text-right">Actions</th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</main>
		<!-- Modal Image View -->
		<div class="modal fade" id="modalimageview" data-backdrop="static" data-keyboard="false" tabindex="-1"
			aria-labelledby="staticBackdropLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-lg">
				<div class="modal-content">
					<div class="modal-header p-2">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-12 text-center">
								<div id="imagelist" class=""></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>