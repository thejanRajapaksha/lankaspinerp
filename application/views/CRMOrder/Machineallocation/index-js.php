<script>
	$(document).ready(function(){
		$('#crmorder_main_nav_link').prop('aria-expanded', 'true').removeClass('collapsed');
        $('#collapseCRMOrder').addClass('show');
	});
	$("#tblmachinelist").on('click', '.btnDeleterow', function () {
		$(this).closest('tr').remove();
	});

	$(document).on("click", "#BtnAddmachine", function () {

		var addcheck = '<?php echo (in_array('createMachineallocation', $user_permission)) ? 1 : 0; ?>';
		
		if (!$("#allocationform")[0].checkValidity()) {
			$("#allocationsubmit").click();
		} else {
			var machine = $('#machine').val();
			var machinelist = $("#machine option:selected").text();
			var startdate = $('#startdate').val();
			var enddate = $('#enddate').val();
			var allocationqty = $('#allocationqty').val();
			var deliveryplan = $('#deliveryplan').val();

			$.ajax({
				type: "POST",
				data: {
					machineid: machine,
					startdate: startdate,
					enddate: enddate,
				},
				url: '<?php echo base_url() ?>Machinealloction/Checkmachineavailability',
				success: function (result) { //alert(result);
					var obj = JSON.parse(result);
					var html = '';

					if (obj.actiontype == 1) {
						html +=
							'<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Sorry!</strong> Machine is Not Available.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
						$('#alert').html(html);
					} else {
						
						$('#tblmachinelist> tbody:last').append(
							'<tr><td class="text-center">' +machinelist + 
							'</td><td class="d-none text-center">' + machine +
							'</td><td class="text-center">' + startdate.replace('T', ' ') +
    						'</td><td class="text-center">' + enddate.replace('T', ' ') +
							'</td><td class="text-center">' + allocationqty +
							'</td><td class="d-none text-center">' + deliveryplan +
							'</td><td> <button type="button" class="btnDeleterow btn btn-danger btn-sm float-right"><i class="fas fa-trash-alt"></i></button></td></tr>'
						);
						$('#machine').val('');
						$('#startdate').val('');
						$('#enddate').val('');
						$('#deliveryplan').val('');
						$('#allocationqty').val('');
					}

				}
			});


		}
	});

	$(document).on("click", "#submitBtn2", function () {

		var costitemid = $('#costitemid').val();
		var jobid = $('#hiddenselectjobid').val();
		var deliveryplan = $('#deliveryplan').val();
		var employee = $('#employee').val();
		var poid = $('#poid').val();

		// get table data into array
		var tbody = $('#tblmachinelist tbody');
		if (tbody.children().length > 0) {
			var jsonObj = []
			$("#tblmachinelist tbody tr").each(function () {
				item = {}
				$(this).find('td').each(function (col_idx) {
					item["col_" + (col_idx + 1)] = $(this).text();
				});
				jsonObj.push(item);
			});
		}
		// console.log(jsonObj);

		$.ajax({
			type: "POST",
			data: {
				tableData: jsonObj,
				jobid: jobid,
				employee: employee,
				costitemid: costitemid,
				poid:poid

			},
			url: '<?php echo base_url() ?>Machinealloction/Machineinsertupdate',
			success: function (result) {
				//console.log(result);
				location.reload();
			}
		});

	});

	$('#machine').change(function () {
		var recordID = $(this).val()

		$.ajax({
            type: "POST",
            url: "<?php echo site_url('Machinealloction/FetchAllocationData'); ?>",
            data: {
                recordID: recordID
            },
            success: function (result) {
                $('#tblallocationlist> tbody:last').empty().append(result);
            }
        });
	})


	$('#customer').change(function () {
		let recordId = $('#customer :selected').val();
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('Machinealloction/FetchCustomerInquiryAndOrderData'); ?>",
			data: { recordId: recordId },
			success: function (result) {
				try {
					var obj = JSON.parse(result);
					var html1 = '<option value="">Select</option>';
					$.each(obj, function (i, item) {
						// Check both fields exist before adding
						if (item.idtbl_order && item.idtbl_inquiry) {
							html1 += '<option value="' + item.idtbl_order + '">';
							html1 += 'INQ ' + item.idtbl_inquiry + ' - PO ' + item.idtbl_order;
							html1 += '</option>';
						}
					});
					$('#selectedPo').empty().append(html1);
				} catch (e) {
					console.error("JSON parsing error: ", e);
					console.log("Raw result: ", result);
				}
			}
		});
	});

	$('#selectedPo').change(function () {
        let recordId = $('#selectedPo :selected').val();
        $.ajax({
            type: "POST",
            data: {
                recordId: recordId
            },
            url: "<?php echo site_url('Machinealloction/FetchItemDataForAllocation'); ?>",
            success: function (result) {
                $('#machineAllocationTable> tbody:last').empty().append(result);
            }
        });

		$.ajax({
            type: "POST",
            url: "<?php echo site_url('Machinealloction/GetDeliveryPlanDetails'); ?>",
            data: {
                recordId: recordId
            },
            success: function (result) {
                var obj = JSON.parse(result);

                var html1 = '';
                html1 += '<option value="">Select</option>';
                $.each(obj, function (i, item) {
                    // alert(result[i].id);
                    html1 += '<option value="' + obj[i].idtbl_delivery_detail + '">';
                    html1 += 'Id: ' + obj[i].deliveryId + ' /Date: ' + obj[i].delivery_date + ' /Qty: ' + obj[i].deliver_quantity;
                    html1 += '</option>';
                });
                $('#deliveryplan').empty().append(html1);
            }
        });
	})

	

	$(document).ready(function () {
    // Load Orders
		$.ajax({
			type: "GET",
			url: "<?php echo site_url('Machinealloction/GetOrderList'); ?>",
			success: function (result) {
				const obj = JSON.parse(result);
				let html = '<option value="">Select</option>';
				obj.forEach(row => {
					html += `<option value="${row.tbl_order_idtbl_order}">
								PO${row.tbl_order_idtbl_order} - ${row.name} - ${row.product} - ${row.quantity}
							</option>`;
				});
				$('#orderid').html(html);
			}
		});

		$('#orderid').change(function () {
			const selectedOrder = $(this).val();

			$.ajax({
				type: "POST",
				url: "<?php echo site_url('Machinealloction/GetDeliveryIdsForOrder'); ?>",
				data: { orderId: selectedOrder },
				success: function (result) {
					const obj = JSON.parse(result);
					let html = '';
					let index = 1;

					obj.forEach(item => {
						html += `
							<tr>
								<td>${index++}</td>
								<td>${item.customer_name}</td>
								<td>PO${item.tbl_order_idtbl_order}</td>
								<td>${item.deliveryId}</td>
								<td>${item.deliver_quantity}</td>
								<td>${item.cost_item_name}</td>
								<td class="text-right">
									<button type="button" class="btn btn-dark btn-sm float-right btnAdd" id="${item.deliveryId}">
										<i class="fas fa-tools"></i>
									</button>
								</td>
							</tr>
						`;
					});

					$('#machineAllocationTable tbody').html(html);
				}
			});
		});

		// Button click to open modal
		$('#machineAllocationTable tbody').on('click', '.btnAdd', function () {
			var costItemId = 0;
			var poId = $(this).attr('id');
			var jobId = $('#selectedInquiry').val();
			var customerName = $('#customer option:selected').text();
			var poDisplayText = $('#selectedPo option:selected').text();
			$('#poid').val(poId);
			$('#costitemid').val(costItemId);
			$('#hiddenselectjobid').val(jobId);$('#selectedCustomer').text(customerName);
			$('#selectedPO').text(poDisplayText);
			$('#machineallocatemodal').modal('show');
		});


	});


	function deactive_confirm() {
		return confirm("Are you sure you want to deactive this?");
	}

	function active_confirm() {
		return confirm("Are you sure you want to active this?");
	}

	function delete_confirm() {
		return confirm("Are you sure you want to remove this?");
	}
</script>
