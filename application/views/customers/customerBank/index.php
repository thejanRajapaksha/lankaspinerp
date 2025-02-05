<div class="page-header page-header-light bg-white shadow">
        		<div class="container-fluid">
        			<div class="page-header-content py-3">
        				<h1 class="page-header-title font-weight-light">
        					<div class="page-header-icon"><i class="fas fa-users"></i></div>
        					<span>Customer Bank Details</span>
        				</h1>
        			</div>
        		</div>
        	</div>
        	<div class="container-fluid mt-2 p-0 p-2">
        		<div class="card">
        			<div class="card-body p-0 p-2">
        				<div class="row">
        					<div class="col-9">
        						<form action="<?php echo base_url()?>Customerbank/Customerbankinsertupdate" method="post" autocomplete="off">
        							<div class="row">
        								<div class="col-3">
        									<div class="form-group mb-1">
        										<label class="small font-weight-bold">Bank Name*</label>
        										<input type="text" class="form-control form-control-sm" name="bank"
        											id="bank" required>
        									</div>
        								</div>
        								<div class="col-3">
        									<div class="form-group mb-1">
        										<label class="small font-weight-bold">Branch*</label>
        										<input type="text" class="form-control form-control-sm" name="branch"
        											id="branch" required>
        									</div>
        								</div>
        								<div class="col-3">
        									<div class="form-group mb-1">
        										<label class="small font-weight-bold">Account No*</label>
        										<input type="text" class="form-control form-control-sm" name="accno"
        											id="accno" required>
        									</div>
        								</div>
        								<div class="col-3">
        									<div class="form-group mb-1">
        										<label class="small font-weight-bold">Name*</label>
        										<input type="text" class="form-control form-control-sm" name="accname"
        											id="accname" required>
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
									<input type="hidden" name="customerid" id="customerid" value="<?php echo isset($result['Customerbankdetails'][0]->tbl_customer_idtbl_customer) ? $result['Customerbankdetails'][0]->tbl_customer_idtbl_customer : ''; ?>">
        						</form>
								<input type="hidden" name="hiddenid" id="hiddenid" value="<?php echo isset($result['Customerbankdetails'][0]->tbl_customer_idtbl_customer) ? $result['Customerbankdetails'][0]->tbl_customer_idtbl_customer : ''; ?>">
        						<hr style="border: 1px solid black;">
        						<div class="row">
        							<div class="col-12">
        								<div class="scrollbar pb-3" id="style-2">
        									<table class="table table-bordered table-striped table-sm nowrap" id="tblsupplierbank" width="100%">
        										<thead>
        											<tr>
        												<th>#</th>
        												<th>Bank</th>
        												<th>Branch</th>
        												<th>Account No</th>
        												<th>Name</th>
        												<th class="text-right">Actions</th>
        											</tr>
        										</thead>
												<tbody>
													<?php foreach ($result['Customerbankdetails'] as $detail): ?>
														<tr>
															<td><?php echo $detail->idtbl_customer_bank_details; ?></td>
															<td><?php echo $detail->bank_name; ?></td>
															<td><?php echo $detail->branch; ?></td>
															<td><?php echo $detail->account_no; ?></td>
															<td><?php echo $detail->account_name; ?></td>
															
														</tr>
													<?php endforeach; ?>
												</tbody>
        									</table>
        								</div>
        							</div>
        						</div>
        					</div>
        					<div class="col-3">
        						<div class="card">
        							<div class="card-body p-0 p-2">
        								<a href="<?php echo base_url() ?>Customerbank/index/<?php echo isset($result['Customerbankdetails'])?>"
        									class="btn font-weight-bold"><i
        										class="fas fa-paper-plane"></i>&nbsp;Bank Details</a>
        								<hr>
        								<a href="<?php echo base_url() ?>Customercontact/index/<?php echo isset($result['Customercontactdetails']) ?>"
        									class="btn font-weight-bold"><i
        										class="fas fa-paper-plane"></i>&nbsp; Contact Details</a>
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