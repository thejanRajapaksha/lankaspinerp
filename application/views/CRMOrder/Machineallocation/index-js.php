<script>
	$("#tblmachinelist").on('click', '.btnDeleterow', function () {
		$(this).closest('tr').remove();
	});

	$(document).on("click", "#BtnAddmachine", function () {
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

		var costitemid = $('#costitemid').val();
		var jobid = $('#hiddenselectjobid').val();
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

	$('#inquiryid').change(function () {
        let recordId = $('#inquiryid :selected').val();
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Machinealloction/GetInquieryDetails'); ?>",
            data: {
                recordId: recordId
            },
            success: function (result) {
                var obj = JSON.parse(result);

                var html1 = '';
                html1 += '<option value="">Select</option>';
                $.each(obj, function (i, item) {
                    // alert(result[i].id);
                    html1 += '<option value="' + obj[i].idtbl_customerinquiry_detail + '">';
                    html1 += obj[i].job;
                    html1 += '</option>';
                });
                $('#selectedjob').empty().append(html1);
            }
        });
	})
	$('#selectedjob').change(function () {
        let recordId = $('#selectedjob :selected').val();
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
                    html1 += '<option value="' + obj[i].idtbl_delivery_plan_details + '">';
                    html1 += 'Id: ' + obj[i].special_id + ' /Date: ' + obj[i].deliveryDate + ' /Qty: ' + obj[i].qty;
                    html1 += '</option>';
                });
                $('#deliveryplan').empty().append(html1);
            }
        });
	})


	$(document).ready(function () {
		var addcheck = '<?php echo $addcheck; ?>';
		var editcheck = '<?php echo $editcheck; ?>';
		var statuscheck = '<?php echo $statuscheck; ?>';
		var deletecheck = '<?php echo $deletecheck; ?>';

		// $('#machineAllocationTable').DataTable({
		// 	"destroy": true,
		// 	"processing": true,
		// 	"serverSide": true,
		// 	dom: "<'row'<'col-sm-5'B><'col-sm-2'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" +
		// 		"<'row'<'col-sm-5'i><'col-sm-7'p>>",
		// 	responsive: true,
		// 	lengthMenu: [
		// 		[10, 25, 50, -1],
		// 		[10, 25, 50, 'All'],
		// 	],
		// 	"buttons": [{
		// 			extend: 'csv',
		// 			className: 'btn btn-success btn-sm',
		// 			title: 'Production View Information',
		// 			text: '<i class="fas fa-file-csv mr-2"></i> CSV',
		// 		},
		// 		{
		// 			extend: 'pdf',
		// 			className: 'btn btn-danger btn-sm',
		// 			title: 'Production View Information',
		// 			text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
		// 		},
		// 		{
		// 			extend: 'print',
		// 			title: 'Production View Information',
		// 			className: 'btn btn-primary btn-sm',
		// 			text: '<i class="fas fa-print mr-2"></i> Print',
		// 			customize: function (win) {
		// 				$(win.document.body).find('table')
		// 					.addClass('compact')
		// 					.css('font-size', 'inherit');
		// 			},
		// 		},
		// 		// 'copy', 'csv', 'excel', 'pdf', 'print'
		// 	],
		// 	ajax: {
		// 		url: "<?php echo base_url() ?>scripts/machineallocationlist.php",
		// 		type: "POST", // you can use GET
		// 		// data: function(d) {}
		// 	},
		// 	"order": [
		// 		[0, "desc"]
		// 	],
		// 	"columns": [{
		// 			"data": "idtbl_customerinquiry"
		// 		},
		// 		{
		// 			"data": "name"
		// 		},
		// 		{
		// 			"data": "po_number"
		// 		},
		// 		{
		// 			"data": "job"
		// 		},
		// 		{
		// 			"data": "qty"
		// 		},
		// 		{
		// 			"data": "costitemname"
		// 		},
		// 		{
		// 			"targets": -1,
		// 			"className": 'text-right',
		// 			"data": null,
		// 			"render": function (data, type, full) {
		// 				var button = '';
		// 				button += '<button class="btn btn-dark btn-sm btnAdd mr-1" id="' + full[
		// 					'idtbl_cost_items'] + '"><i class="fas fa-tools"></i></button>';
		// 				return button;
		// 			}
		// 		}
		// 	],
		// 	drawCallback: function (settings) {
		// 		$('[data-toggle="tooltip"]').tooltip();
		// 	}
		// });

		$('#machineAllocationTable tbody').on('click', '.btnAdd', function () {
			var costItemId = $(this).attr('id');
			var jobId = $('#selectedjob').val();
			$('#costitemid').val(costItemId);
			$('#hiddenselectjobid').val(jobId);
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
