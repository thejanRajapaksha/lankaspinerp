<script>

	$("#tblmachinelist").on('click', '.btnDeleterow', function () {
		$(this).closest('tr').remove();
	});

	$(document).on("click", "#BtnAddmachine", function () {

		var addcheck = '<?php echo (in_array('createMachineallocation', $user_permission)) ? 1 : 0; ?>';
		
		if (!$("#allocationform")[0].checkValidity()) {
			// If the form is invalid, submit it. The form won't actually submit;
			// this will just cause the browser to display the native HTML5 error messages.
			$("#allocationsubmit").click();
		} else {
			var machine = $('#machine').val();
			var machinelist = $("#machine option:selected").text();
			var startdate = $('#startdate').val();
			var enddate = $('#enddate').val();
			var allocationqty = $('#allocationqty').val();

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
						
						$('#tblmachinelist> tbody:last').append('<tr><td class="text-center">' +
							machinelist + '</td><td class="d-none text-center">' + machine +
							'</td><td class="text-center">' + startdate +
							'</td><td class="text-center">' + enddate +
							'</td> <td class="text-center">' + allocationqty +
							'</td><td> <button type="button" class="btnDeleterow btn btn-danger btn-sm float-right"><i class="fas fa-trash-alt"></i></button></td></tr>'
						);
						$('#machine').val('');
						$('#startdate').val('');
						$('#enddate').val('');
					}

				}
			});


		}
	});

	$(document).on("click", "#submitBtn2", function () {

		// var costitemid = $('#costitemid').val();
		// var jobid = $('#hiddenselectjobid').val();
		var deliveryplan = $('#deliveryplan').val();
		var employee = $('#employee').val();

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
		//console.log(jsonObj);

		$.ajax({
			type: "POST",
			data: {
				tableData: jsonObj,
				jobid: jobid,
				deliveryplan: deliveryplan,
				employee: employee,
				costitemid: costitemid
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
									<button type="button" class="btn btn-dark btn-sm btnAdd" id="${item.deliveryId}">
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
			const deliveryId = $(this).attr('id');
			// $('#costitemid').val(''); // Update if needed
			// $('#hiddenselectjobid').val(deliveryId);
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
