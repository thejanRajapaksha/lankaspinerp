<main>
	<div class="page-header page-header-light bg-white shadow">
		<div class="container-fluid">
			<div class="page-header-content py-3">
				<h1 class="page-header-title font-weight-light">
					<div class="page-header-icon"><i class="fas fa-users"></i></div>
					<span>Row Materials</span>
				</h1>
			</div>
		</div>
	</div>
	<div class="container-fluid mt-2 p-0 p-2">
		<div class="card">
			<div class="card-body p-0 p-2">
				<div class="row">
					<div class="col-3">
						<form action="<?php echo base_url() ?>Rowmaterials/Rowmaterialsinsertupdate" method="post"
							autocomplete="off">
							<div class="form-group mb-1">
								<label class="small font-weight-bold">Material Main Category*</label>
								<select class="form-control selecter2 form-control-sm" name="materialmaincategory" id="materialmaincategory" required>
									<option value="">Select</option>
									<?php foreach ($result['maincategorylist'] as $rowmateriallist):?>
										<option value="<?php echo $rowmateriallist->idtbl_material_main_cat;?>">
										<?php echo ($rowmateriallist->categoryname);?></option>
									<?php endforeach;?>
								</select>
							</div>
							<div class="form-group mb-1">
								<label class="small font-weight-bold">Material Name*</label>
								<input type="text" class="form-control form-control-sm" name="materialname" id="materialname"
									required>
							</div>
							<div class="form-group mb-1">
								<label class="small font-weight-bold">Supplier*</label>
								<select class="form-control selecter2 form-control-sm" name="supplier" id="supplier" required>
									<option value="">Select</option>
									<?php foreach ($result['supplierlist'] as $rowsupplierlist):?>
										<option value="<?php echo $rowsupplierlist->idtbl_supplier;?>">
										<?php echo ($rowsupplierlist->suppliername);?></option>
									<?php endforeach;?>
								</select>
							</div>
							<div class="form-group mb-1">
								<label class="small font-weight-bold">Measurment*</label>
								<select class="form-control selecter2 form-control-sm" name="measurment" id="measurment" required>
									<option value="">Select</option>
									<?php foreach ($result['measurmentlist'] as $rowmeasurmentlist):?>
										<option value="<?php echo $rowmeasurmentlist->idtbl_mesurements;?>">
										<?php echo ($rowmeasurmentlist->measure_type);?></option>
									<?php endforeach;?>
								</select>
							</div>
							<div class="form-group mb-1">
								<label class="small font-weight-bold">Unit Price*</label>
								<input type="text" class="form-control form-control-sm" name="unitprice" id="unitprice"
									required>
							</div>
							<div class="form-group mb-1">
								<label class="small font-weight-bold">Sale Price*</label>
								<input type="text" class="form-control form-control-sm" name="saleprice" id="saleprice"
									required>
							</div>
							<div class="form-group mb-1">
								<label class="small font-weight-bold">ROL*</label>
								<input type="text" class="form-control form-control-sm" name="rol" id="rol"
									required>
							</div>
							<div class="form-group mt-2 text-right">
								<?php if (in_array('createRowmaterials', $user_permission)) : ?>
									<button type="submit" id="submitBtn" class="btn btn-primary btn-sm px-4">
										<i class="far fa-save"></i>&nbsp;Add 
									</button>
								<?php endif; ?>
							</div>
							<input type="hidden" name="recordOption" id="recordOption" value="1">
							<input type="hidden" name="recordID" id="recordID" value="">
						</form>
					</div>
					<div class="col-9">
						<div class="scrollbar pb-3" id="style-2">
							<table class="table table-bordered table-striped table-sm nowrap"
								id="tblmeasurment">
								<thead>
									<tr>
										<th>#</th>
										<th>Name</th>
										<th>Supplier</th>
										<th>Measurment</th>
										<th>Main Material</th>
										<th>ROL</th>
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
