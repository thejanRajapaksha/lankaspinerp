<div class="page-header page-header-light bg-white shadow">
        		<div class="container-fluid">
        			<div class="page-header-content py-3">
        				<h1 class="page-header-title font-weight-light">
        					<div class="page-header-icon"><i class="fas fa-users"></i></div>
        					<span>Customer Contact Details</span>
        				</h1>
        			</div>
        		</div>
        	</div>
        	<div class="container-fluid mt-2 p-0 p-2">
        		<div class="card">
        			<div class="card-body p-0 p-2">
        				<div class="row">
        					<div class="col-9">
        						<form action="<?php echo base_url() ?>Customercontact/Customercontactinsertupdate" method="post" autocomplete="off">
        							<div class="row">
        								<div class="col-3">
        									<div class="form-group mb-1">
        										<label class="small font-weight-bold"> Name*</label>
        										<input type="text" class="form-control form-control-sm" name="name"
        											id="name" required>
        									</div>
        								</div>
        								<div class="col-3">
        									<div class="form-group mb-1">
        										<label class="small font-weight-bold">Position*</label>
        										<input type="text" class="form-control form-control-sm" name="postion"
        											id="postion" required>
        									</div>
        								</div>
        								<div class="col-3">
        									<div class="form-group mb-1">
        										<label class="small font-weight-bold">Mobile No*</label>
        										<input type="text" class="form-control form-control-sm" name="mobileno"
        											id="mobileno" required>
        									</div>
        								</div>
        								<div class="col-3">
        									<div class="form-group mb-1">
        										<label class="small font-weight-bold">Email*</label>
        										<input type="email" class="form-control form-control-sm" name="email"
        											id="email" required>
        									</div>
        								</div>
        							</div>
        							<div class="row">
        								<div class="col-12">
        									<div class="form-group mt-2 text-right">
        										<button type="submit" id="submitBtn"
        											class="btn btn-primary btn-sm px-4"><i
        												class="far fa-save"></i>&nbsp;Add</button>
        									</div>
        								</div>
        							</div>
        							<input type="hidden" name="recordOption" id="recordOption" value="1">
        							<input type="hidden" name="recordID" id="recordID" value="">
									<input type="hidden" name="customerid" id="customerid" value="<?php echo $customer_id; ?>">
        						</form>
								<input type="hidden" name="hiddenid" id="hiddenid" value="<?php echo $customer_id; ?>">
        						<hr style="border: 1px solid black;">
        						<div class="row">
        							<div class="col-12">
        								<div class="scrollbar pb-3" id="style-2">
        									<table class="table table-bordered table-striped table-sm nowrap"
        										id="tblsuppliercontact" width="100%">
        										<thead>
        											<tr>
        												<th>#</th>
        												<th>Name</th>
        												<th>Position</th>
        												<th>Mobile No</th>
        												<th>Email</th>
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
        		</div>
        	</div>
        </main>
    </div>
</div>