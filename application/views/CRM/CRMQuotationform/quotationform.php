<?php
include "include/header.php";
include "include/topnavbar.php";
?>
<div id="layoutSidenav">
	<div id="layoutSidenav_nav">
		<?php include "include/menubar.php"; ?>
	</div>
	<div id="layoutSidenav_content">
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
								<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#staticBackdrop" <?php if ($addcheck == 0) {
																																			echo 'disabled';
																																		} ?>><i class="fas fa-plus mr-2"></i>Create Quotation</button>
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
		<?php include "include/footerbar.php"; ?>
	</div>
</div>
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
										<?php foreach ($customerlist->result() as $rowcustomerlist) { ?>
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
										<?php foreach ($productlst->result() as $rowproductlst) { ?>
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
								<textarea name="comment" id="comment" class="form-control form-control-sm" <?php if ($editcheck == 0) {
																												echo 'readonly';
																											} ?>></textarea>
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
							<input type="hidden" id="getid" value="<?php echo $getid; ?>">
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

<?php include "include/footerscripts.php"; ?>
<script>
	$(document).ready(function() {
		var addcheck = '<?php echo $addcheck; ?>';
		var editcheck = '<?php echo $editcheck; ?>';
		var statuscheck = '<?php echo $statuscheck; ?>';
		var deletecheck = '<?php echo $deletecheck; ?>';

		var getid = $('#getid').val();

		//alert(getid);

		$('#staticBackdrop').on('shown.bs.modal', function() {
			$('.selecter2').select2({
				width: '100%',
				dropdownParent: $('#staticBackdrop')
			});

			var getid = $('#getid').val();
			$.ajax({
				type: "POST",
				data: {
					getid: getid,

				},
				url: '<?php echo base_url() ?>Quotationform/Quotationformgetcustomer',
				success: function(result) { //alert(result);
					//console.log(result);
					// $('#quotationmodal').modal('show');
					// $('#getquotationdataform').html(result);

				}
			});
		});

		$('#dataTable').DataTable({
			"destroy": true,
			"processing": true,
			"serverSide": true,
			dom: "<'row'<'col-sm-5'B><'col-sm-2'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
			responsive: true,
			lengthMenu: [
				[10, 25, 50, -1],
				[10, 25, 50, 'All'],
			],
			"buttons": [{
					extend: 'csv',
					className: 'btn btn-success btn-sm',
					title: 'Quotation Information',
					text: '<i class="fas fa-file-csv mr-2"></i> CSV',
				},
				{
					extend: 'pdf',
					className: 'btn btn-danger btn-sm',
					title: 'Quotation Information',
					text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
				},
				{
					extend: 'print',
					title: 'Quotation Information',
					className: 'btn btn-primary btn-sm',
					text: '<i class="fas fa-print mr-2"></i> Print',
					customize: function(win) {
						$(win.document.body).find('table')
							.addClass('compact')
							.css('font-size', 'inherit');
					},
				},
				// 'copy', 'csv', 'excel', 'pdf', 'print'
			],
			ajax: {
				url: "<?php echo base_url() ?>scripts/quotationformlist.php",
				type: "POST", // you can use GET
				data: function(d) {
					d.userID = '<?php echo $_SESSION['userid']; ?>';
					d.getid = getid;
				}
			},
			"order": [
				[0, "desc"]
			],
			"columns": [{
					"data": function(data, type, full) {
						return "QT-" + data.idtbl_quotation;
					}
				},
				{
					"data": "quot_date"
				},
				{
					"data": "name"
					// "render": function(data, type, full) {
					//         return "UN/GRN-0000" + data;
					// }
				},
				{
					"className": 'd-none',
					"data": "idtbl_inquiry"
				},
				{
					"className": 'd-none',
					"data": "idtbl_customer"
				},
				{
					"targets": -1,
					"className": 'text-right',
					"data": null,
					"render": function(data, type, full) {
						var button = '';
						button += '<button class="btn btn-primary btn-sm btnlistview mr-1" id="' + full['idtbl_quotation'] + '" data-id="' + full['idtbl_quotation'] + '" data-toggle="tooltip" data-placement="bottom" title="View list image"><i class="fa fa-eye" aria-hidden="true"></i></button>';
						// if (full['approvestatus'] == 1) {
						// 	button += '<button  id="' + full['idtbl_quotation'] + '" target="_self" class="btn btn-secondary btn-sm mr-1 approvebtn" value ="2"  data-toggle="tooltip" data-placement="bottom" title="Disapprove Quotation"';
						// 	if (statuscheck != 1) {
						// 		button += 'd-none';
						// 	}
						// 	button += '"><i class="fas fa-check"></i></a>';
						// } else {
						// 	button += '<button id="' + full['idtbl_quotation'] + '"  target="_self" class="btn btn-danger btn-sm mr-1 approvebtnelse" value ="1" data-toggle="tooltip" data-placement="bottom" title="Approve Quotation"';
						// 	if (statuscheck != 1) {
						// 		button += 'd-none';
						// 	}
						// 	button += '"><i class="fas fa-times"></i></a>';

						// }
						button += '<button class="btn btn-primary btn-sm btninfo mr-1" id="' + full['idtbl_quotation'] + '" data-toggle="tooltip" data-placement="bottom" title="Quotation Details"><i class="fa fa-info-circle" aria-hidden="true"></i></button>';

						if (full['approvestatus'] == 0) {
							button += '<button disabled target="_blank" class="btn btn-danger btn-sm btnPdf mr-1" id="' + full['idtbl_quotation'] + '" data-toggle="tooltip" data-placement="bottom" title="Quotation PDF"><i class="fas fa-file-pdf"></i></button>';
						} else {
							button += '<a href="<?php echo base_url() ?>Quotationform/Quotationformpdf/' + full['idtbl_quotation'] + '" target="_blank" class="btn btn-danger btn-sm btnPdf mr-1" data-toggle="tooltip" data-placement="bottom" title="Quotation PDF"><i class="fas fa-file-pdf"></i></a>';

						}

						if (full['status'] == 1) {
							button += '<button id="' + full['idtbl_quotation'] + '"  target="_self" class="btn btn-success btn-sm mr-1 btnstatus" value ="2" data-toggle="tooltip" data-placement="bottom" title="Deactive"';
							if (statuscheck != 1) {
								button += 'd-none';
							}
							button += '"><i class="fas fa-check"></i></a>';
						} else {
							button += '<button id="' + full['idtbl_quotation'] + '"  target="_self" class="btn btn-warning btn-sm mr-1 btnstatuselse" value ="1" data-toggle="tooltip" data-placement="bottom" title="Active"';
							if (statuscheck != 1) {
								button += 'd-none';
							}
							button += '"><i class="fas fa-times"></i></a>';
						}
						button += '<button id="' + full['idtbl_quotation'] + '" target="_self" class="btn btn-danger btn-sm btndlt" value ="3" data-toggle="tooltip" data-placement="bottom" title="Cancel Quotation"';
						if (deletecheck != 1) {
							button += 'd-none';
						}
						button += '"><i class="fas fa-trash-alt"></i></a>';

						return button;
					}
				}
			],
			drawCallback: function(settings) {
				$('[data-toggle="tooltip"]').tooltip();
			}
		});

		$('#dataTable').on('click', '.btninfo', function() {
			var cusId = $(this).attr('id');

			$.ajax({
				type: "POST",
				data: {
					cusId: cusId,
				},
				url: '<?php echo base_url() ?>Quotationform/Quotationformgetinfodata',
				success: function(result) {
					$('#getquotationdataform').html(result);
					$('#quotationmodal').data('idtbl_quotation', cusId).modal('show');
				}
			});
		});

		$("#disapprovalReason").select2({
			dropdownParent: $('#disapprovalModal'),
			ajax: {
				url: "<?php echo base_url() ?>Quotationform/Getreasontype",
				type: "post",
				dataType: 'json',
				delay: 250,
				data: function(params) {
					return {
						searchTerm: params.term // search term
					};
				},
				processResults: function(response) {
					return {
						results: response
					};
				},
				cache: true
			}
		});

		$(document).ready(function() {
			// Event handler for approve buttons
			$('#quotationmodal').on('click', '.approvebtn', function() {
				var recordID = $('#quotationmodal').data('idtbl_quotation');
				var type = $(this).val();

				var confirmationMessage = type == 2 ? "Are you sure, You want to disapprove this?" : "Are you sure, You want to approve this?";
				var r = confirm(confirmationMessage);

				if (r == true) {
					$.ajax({
						type: "POST",
						data: {
							recordID: recordID,
							type: type,
						},
						url: '<?php echo base_url() ?>Quotationform/Quotationformapprovestatus',
						success: function(result) {
							var obj = JSON.parse(result);
							if (obj.status == 1) {
								setTimeout(function() {
									window.location.reload();
								}, 700);
							}
							action(obj.action);
						}
					});
				}
			});

			$('#quotationmodal').on('click', '.approvebtnelse', function() {
				$('#disapprovalModal').modal('show');
			});

			// Event handler for reject buttons
			$('#disapprovalForm').on('submit', function(event) {
				event.preventDefault(); // Prevent default form submission

				var recordID = $('#quotationmodal').data('idtbl_quotation');
				var reasonID = $('#disapprovalReason').val(); // Get the value from the select input
				var reasonAdd = $('#additionalReason').val(); // Get the value from the textarea
				var type = $(this).find('button[type="submit"]').val();

				var confirmationMessage = type == 2 ? "Are you sure, You want to disapprove this?" : "Are you sure, You want to approve this?";
				var r = confirm(confirmationMessage);

				if (r == true) {
					$.ajax({
						type: "POST",
						data: {
							recordID: recordID,
							type: type,
							reasonID: reasonID,
							reasonAdd: reasonAdd,
						},
						url: '<?php echo base_url() ?>Quotationform/Quotationformapprovestatus',
						success: function(result) {
							var obj = JSON.parse(result);
							if (obj.status == 1) {
								setTimeout(function() {
									window.location.reload();
								}, 700);
							}
							action(obj.action);
						}
					});
				}
			});
		});


		$('#dataTable').on('click', '.btnstatus', function() {

			var recordID = $(this).attr('id');
			var type = $('.btnstatus').val();
			//alert(recordID);
			//alert(type);
			if (type == 2) {
				var r = confirm("Are you sure you want to deactive this?");
			} else {
				var r = confirm("Are you sure you want to active this?");
			}

			if (r == true) {
				$.ajax({
					type: "POST",
					data: {
						recordID: recordID,
						type: type,

					},
					url: '<?php echo base_url() ?>Quotationform/Quotationformstatus',
					success: function(result) { //alert(result);
						var obj = JSON.parse(result);
						if (obj.status == 1) {

							setTimeout(function() {
								window.location.reload();

							}, 400);
						}
						action(obj.action);
					}
				});
			}

		});
		$('#dataTable').on('click', '.btnstatuselse', function() {

			var recordID = $(this).attr('id');
			var type = $('.btnstatuselse').val();

			//alert(type);
			if (type == 2) {
				var r = confirm("Are you sure you want to deactive this?");
			} else {
				var r = confirm("Are you sure you want to active this?");
			}

			if (r == true) {
				$.ajax({
					type: "POST",
					data: {
						recordID: recordID,
						type: type,

					},
					url: '<?php echo base_url() ?>Quotationform/Quotationformstatus',
					success: function(result) { //alert(result);
						var obj = JSON.parse(result);
						if (obj.status == 1) {

							setTimeout(function() {
								window.location.reload();

							}, 400);
						}
						action(obj.action);
					}
				});
			}

		});
		$('#dataTable').on('click', '.btndlt', function() {

			$('#inquiryCancelModal').modal('show');
			var recordID = $(this).attr('id');
			var type = $('.btndlt').val();

			rejectreason(recordID, type);


		});

		$('#dataTable tbody').on('click', '.btnlistview', function() {
                var productID = $(this).attr('id');
                loadlistimages(productID);
                $('#modalimageview').modal('show');

            });

	});

	$('#meterial').on('change', function() {
		var productid = $('#meterial').val();
		var getid = $('#getid').val();
		var customer = $('#customer').val();

		$.ajax({
			type: "POST",
			data: {
				productid: productid,
				getid: getid,
				customer: customer
			},
			url: '<?php echo base_url() ?>Quotationform/Quotationformunitprice',
			success: function(result) {
				var obj = JSON.parse(result);
				if (obj.error) {

				} else {
					$('#qty').val(obj.quantity);
					//$('#qty').val(obj.value);
					console.log(obj);
				}
			}
		});
	});
		
	$('#product').on('change', function() {
		var productid = $('#product').val();
		var getid = $('#getid').val();

		//alert(productid);
		//alert(getid);
		$.ajax({
			type: "POST",
			data: {
				productid: productid,
				getid: getid
			},
			url: '<?php echo base_url() ?>Quotationform/Quotationformmeterial',
			success: function(result) {
				var objfirst = JSON.parse(result);
				console.log(objfirst);
				var html = '';
				html += '<option value="">Select</option>';
				$.each(objfirst, function(i, item) {
					//alert(objfirst[i].id);
					html += '<option value="' + objfirst[i].idtbl_material + '">';
					html += objfirst[i].type; //+' - '+objfirst[i].subids
					html += '</option>';
				});

				$('#meterial').empty().append(html);

				// if (value != '') {
				//     $('#productcategory').val(value);
				// }
			}
		});
	});

	function rejectreason(recordID, type) {
		$('#inquiryCancelModal').on('click', '#btnDeleteAgentMsg', function() {
			var cancelMsg = $('#cancelMsg').val();

			$.ajax({
				type: "POST",
				data: {
					recordID: recordID,
					type: type,
					cancelMsg: cancelMsg

				},
				url: '<?php echo base_url() ?>Quotationform/Quotationformstatus',
				success: function(result) { //alert(result);
					var obj = JSON.parse(result);
					if (obj.status == 0) {

						setTimeout(function() {
							window.location.reload();

						}, 400);
					}
					action(obj.action);
				}
			});
		});
	}
	// function Getquotation(quotationId) {

	// 	$('#quotationdatatable').DataTable({
	// 		"destroy": true,
	// 		"processing": true,
	// 		"serverSide": true,
	// 		dom: "<'row'<'col-sm-5'B><'col-sm-7'f><'col-sm-2'l>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
	// 		responsive: true,
	// 		lengthMenu: [
	// 			[10, 25, 50, -1],
	// 			[10, 25, 50, 'All'],
	// 		],
	// 		"buttons": [{
	// 				extend: 'csv',
	// 				className: 'btn btn-success btn-sm',
	// 				title: 'Quotation Information',
	// 				text: '<i class="fas fa-file-csv mr-2"></i> CSV',
	// 			},
	// 			{
	// 				extend: 'pdf',
	// 				className: 'btn btn-danger btn-sm',
	// 				title: 'Quotation Information',
	// 				text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
	// 			},
	// 			{
	// 				extend: 'print',
	// 				title: 'Quotation Information',
	// 				className: 'btn btn-primary btn-sm',
	// 				text: '<i class="fas fa-print mr-2"></i> Print',
	// 				customize: function(win) {
	// 					$(win.document.body).find('table')
	// 						.addClass('compact')
	// 						.css('font-size', 'inherit');
	// 				},
	// 			},
	// 			// 'copy', 'csv', 'excel', 'pdf', 'print'
	// 		],
	// 		ajax: {
	// 			url: "<?php echo base_url() ?>scripts/quotationinfolist.php",
	// 			type: "POST",
	// 			data: function(d) {
	// 				d.userID = '<?php echo $_SESSION['userid']; ?>';
	// 				d.quotationId = quotationId;
	// 			}
	// 		},
	// 		"order": [
	// 			[0, "desc"]
	// 		],
	// 		"columns": [{
	// 				"data": "quot_date"
	// 			},
	// 			{
	// 				"data": "duedate"
	// 			},
	// 			{
	// 				"data": "remarks"
	// 			},
	// 			{
	// 				"data": "comment"
	// 			},
	// 			{
	// 				"data": "qty"
	// 			},
	// 			{
	// 				"data": "unitprice"
	// 			},
	// 			{
	// 				"data": "delivery_charge"
	// 			},
	// 			{
	// 				"data": "discount"
	// 			},
	// 			{
	// 				"data": "total"
	// 			},

	// 		],
	// 		drawCallback: function(settings) {
	// 			$('[data-toggle="tooltip"]').tooltip();
	// 		}
	// 	});
	// }


	$("#formsubmit").click(function() {
		if (!$("#createorderform")[0].checkValidity()) {
			// If the form is invalid, submit it. The form won't actually submit;
			// this will just cause the browser to display the native HTML5 error messages.
			$("#submitBtn").click();
		} else {
			var productID = $('#product').val();
			var meterialID = $('#meterial').val();
			var meterial = $("#meterial option:selected").text();
			var product = $("#product option:selected").text();
			var unitprice = parseFloat($('#unitprice').val());
			var qty = parseFloat($('#qty').val());
			//var quotdate = $('#quot_date').val();
			var description = $('#comment').val();
			//var duedate = $('#duedate').val();
			//var deliverycharge = $('#delivery_charge').val();
			var customer = $('#customer').val();


			$('.selecter2').select2();


			var total = unitprice * qty;

			var showtotal = addCommas(parseFloat(total).toFixed(2));

			$('#tableorder > tbody:last').append('<tr class="pointer"><td class="d-none">' + productID +
				'</td><td>' + product + '</td><td class="d-none">' + meterialID +
				'</td><td>' + meterial + '</td><td>' + description + '</td><td>' + qty +
				'</td><td class="d-none">' + unitprice + '</td><td>' + addCommas(unitprice.toFixed(2)) + '</td><td>' + showtotal + '</td><td class="d-none total">' + total + '</td></tr>');

			$('#product').val('');
			$('#unitprice').val('');
			$('#qty').val('');
			$('#comment').val('');
			$('#meterial').val('');


			var sum = 0;
			$(".total").each(function() {
				sum += parseFloat($(this).text());
			});

			var showsum = addCommas(parseFloat(sum).toFixed(2));

			$('#divtotal').html('Rs. ' + showsum);
			$('#hidetotalorder').val(sum);
			$('#product').focus();

			var dis = 0;
			$(".totaldis").each(function() {
				dis += parseFloat($(this).text());
			});
			var showdis = addCommas(parseFloat(dis).toFixed(2));

			$('#sumdis').val(dis);

		}
	});
	$('#tableorder').on('click', 'tr', function() {
		var r = confirm("Are you sure, You want to remove this product ? ");
		if (r == true) {
			$(this).closest('tr').remove();

			var sum = 0;
			$(".total").each(function() {
				sum += parseFloat($(this).text());
			});

			var showsum = addCommas(parseFloat(sum).toFixed(2));

			$('#divtotal').html('Rs. ' + showsum);
			$('#hidetotalorder').val(sum);
			$('#product').focus();
		}
	});

	$('#btncreateorder').click(function() {
		$('#btncreateorder').prop('disabled', true).html('<i class="fas fa-circle-notch fa-spin mr-2"></i> Create Good Receive Note');
		var tbody = $("#tableorder tbody");
		var formData = new FormData();

		var productImages = $('#productimage')[0].files;

		for (var i = 0; i < productImages.length; i++) {
			formData.append('productimage[]', productImages[i]);
		}
		if (tbody.children().length > 0) {
			jsonObj = [];
			$("#tableorder tbody tr").each(function() {
				item = {}
				$(this).find('td').each(function(col_idx) {
					item["col_" + (col_idx + 1)] = $(this).text();
				});
				jsonObj.push(item);
			});
			console.log(jsonObj);

			var remarks = $('#remark').val();
			var getid = $('#getid').val();
			var showsum = $('#divtotal').html();
			var trimmedValue = $('#hidetotalorder').val();
			var sumdis = $('#sumdis').val();
			var recordOption = $('#recordOption').val();
			var quotdate = $('#quot_date').val();
			var duedate = $('#duedate').val();
			var customer = $('#customer').val();

			formData.append('tableData', JSON.stringify(jsonObj)); // Properly encode JSON
			formData.append('getid', getid);
			formData.append('recordOption', recordOption);
			formData.append('trimmedValue', trimmedValue);
			formData.append('sumdis', sumdis);
			formData.append('quotdate', quotdate);
			formData.append('duedate', duedate);
			formData.append('customer', customer);
			formData.append('remarks', remarks);

			$.ajax({
				type: "POST",
				data: formData,
				processData: false,
				contentType: false,
				url: '<?php echo base_url() ?>Quotationform/Quotationforminsertupdate',
				success: function(result) {
					var obj = JSON.parse(result);
					$('#staticBackdrop').modal('hide');
					if (obj.status == 1) {
						setTimeout(function() {
							window.location.reload();
						}, 3000);
					}
					action(obj.action);
				}
			});
		}
	});


	// $('#product').change(function() {
	// 	var productID = $(this).val();

	// 	$.ajax({
	// 		type: "POST",
	// 		data: {
	// 			recordID: productID
	// 		},
	// 		url: 'Quotationform/Getproduct',
	// 		success: function(result) { //alert(result);
	// 			var obj = JSON.parse(result);
	// 			$('#product').val(obj.product);
	// 			// $('#unitprice').val(obj.unitprice);
	// 			// $('#comment').val(obj.comment);
	// 		}
	// 	});
	// });
	// $('#quater').change(function () {
	// 	var quaterID = $(this).val();
	// 	var mfdate = $('#mfdate').val();

	// 	$.ajax({
	// 		type: "POST",
	// 		data: {
	// 			recordID: quaterID,
	// 			mfdate: mfdate
	// 		},
	// 		url: 'Goodreceive/Getexpdateaccoquater',
	// 		success: function (result) { //alert(result);
	// 			$('#expdate').val(result);
	// 		}
	// 	});
	// });
	function loadlistimages(productID) {
            $('#imagelist').addClass('text-center');
            $('#imagelist').html('<img src="images/spinner.gif" class="img-fluid">');

            $.ajax({
                type: "POST",
                data: {
                    productID: productID,
                },
                url: '<?php echo base_url() ?>Quotationform/Getproductlistimages',
                success: function(result) { //alert(result);
                    $('#imagelist').removeClass('text-center');
                    $('#imagelist').html(result);
                    optionimages(productID);
                }
            });
        }

        function optionimages(productID) {
            $('#productimagetable tbody').on('click', '.btnremoveimage', function() {
                var imageID = $(this).attr('id');
                var r = confirm("Are you sure, You want to Delete this ? ");
                if (r == true) {
                    $.ajax({
                        type: "POST",
                        data: {
                            imageID: imageID,

                        },
                        url: '<?php echo base_url() ?>Quotationform/Getproductlistimagesdelete',
                        success: function(result) { //alert(result);
                            $('#imagelist').html(result);
                            loadlistimages(productID);
                        }
                    });
                }
            });
        }

	function addCommas(nStr) {
		nStr += '';
		x = nStr.split('.');
		x1 = x[0];
		x2 = x.length > 1 ? '.' + x[1] : '';
		var rgx = /(\d+)(\d{3})/;
		while (rgx.test(x1)) {
			x1 = x1.replace(rgx, '$1' + ',' + '$2');
		}
		return x1 + x2;
	}

	function action(data) { //alert(data);
		var obj = JSON.parse(data);
		$.notify({
			// options
			icon: obj.icon,
			title: obj.title,
			message: obj.message,
			url: obj.url,
			target: obj.target
		}, {
			// settings
			element: 'body',
			position: null,
			type: obj.type,
			allow_dismiss: true,
			newest_on_top: false,
			showProgressbar: false,
			placement: {
				from: "top",
				align: "center"
			},
			offset: 100,
			spacing: 10,
			z_index: 1031,
			delay: 5000,
			timer: 1000,
			url_target: '_blank',
			mouse_over: null,
			animate: {
				enter: 'animated fadeInDown',
				exit: 'animated fadeOutUp'
			},
			onShow: null,
			onShown: null,
			onClose: null,
			onClosed: null,
			icon_type: 'class',
			template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
				'<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
				'<span data-notify="icon"></span> ' +
				'<span data-notify="title">{1}</span> ' +
				'<span data-notify="message">{2}</span>' +
				'<div class="progress" data-notify="progressbar">' +
				'<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
				'</div>' +
				'<a href="{3}" target="{4}" data-notify="url"></a>' +
				'</div>'
		});
	}
</script>
<?php include "include/footer.php"; ?>