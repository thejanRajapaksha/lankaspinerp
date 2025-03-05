<script>
    $(document).ready(function() {
        $('#crmorder_main_nav_link').prop('aria-expanded', 'true').removeClass('collapsed');
        $('#collapseCRMOrder').addClass('show');
        
        var addcheck = '<?php echo (in_array('createCRMMaterialdetail', $user_permission)) ? 1 : 0; ?>';
        var editcheck = '<?php echo (in_array('updateCRMMaterialdetail', $user_permission)) ? 1 : 0; ?>';
        var statuscheck = '<?php echo (in_array('updateCRMMaterialdetail', $user_permission) || in_array('deleteCRMMaterialdetail', $user_permission)) ? 1 : 0; ?>';
        var deletecheck = '<?php echo (in_array('deleteCRMMaterialdetail', $user_permission)) ? 1 : 0; ?>';

        $('#dataTableAccepted').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            dom: "<'row'<'col-sm-5'B><'col-sm-2'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            responsive: true,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            "buttons": [
                { extend: 'csv', className: 'btn btn-success btn-sm', title: 'Supplier detail Information', text: '<i class="fas fa-file-csv mr-2"></i> CSV', },
                { extend: 'pdf', className: 'btn btn-danger btn-sm', title: 'Supplier detail Information', text: '<i class="fas fa-file-pdf mr-2"></i> PDF', },
                { 
                    extend: 'print', 
                    title: 'Supplier detail Information',
                    className: 'btn btn-primary btn-sm', 
                    text: '<i class="fas fa-print mr-2"></i> Print',
                    customize: function (win) {
                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    }, 
                },
            ],
            ajax: {
                url: "<?php echo base_url() ?>scripts/qutationAccList.php",
                type: "POST",
            },
            "order": [[ 0, "desc" ]],
            "columns": [
                {
                    "data": "tbl_inquiry_idtbl_inquiry"
                },
                {
                    "data": "name"
                },
                {
                    "data": "quot_date"
                },
                {
                    "data": "duedate"
                },
                {
                    "data": "total"
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function(data, type, full) {
                        var button = '';
                        button += '<button class="btn btn-primary btn-sm btnview mr-1" data-toggle="modal" data-target="#materialdetail" data-qid="' + full['idtbl_quotation'] + '" data-id="' + full['tbl_inquiry_idtbl_inquiry'] + '" data-customer="' + full['idtbl_customer'] + '" title="Payment details view"><i class="fas fa-eye"></i></button>';
                        button += '<button class="btn btn-success btn-sm btnquotation mr-1" data-toggle="modal" data-target="#Materialmodal" data-qid="' + full['idtbl_quotation'] + '" data-id="' + full['tbl_inquiry_idtbl_inquiry'] + '" data-customer="' + full['idtbl_customer'] + '" title="Create Order"><i class="fas fa-list"></i></button>';
                        // button += '<button class="btn btn-dark btn-sm btnpayment mr-1" data-toggle="modal" data-target="#Materialmodal" data-qid="' + full['idtbl_quotation'] + '" data-id="' + full['tbl_inquiry_idtbl_inquiry'] + '" data-customer="' + full['idtbl_customer'] + '" title="Payment details"><i class="fas fa-credit-card"></i></button>';
                        return button;
                    }
                }
            ],
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });

        $('#dataTableAccepted').on('click', '.btnquotation', function() {
            var qid = $(this).data('qid');
            var id = $(this).data('id');
            $('#inquiryid').val(id);
        });

        // $("#mtype").select2({  
        //     dropdownParent: $('#Materialmodal'),
        //     ajax: {
        //         url: "<?php echo base_url() ?>CRMMaterialdetail/Getmaterialcategory",
        //         type: "post",
        //         dataType: 'json',
        //         delay: 250,
        //         data: function(params) {
        //             return {
        //                 inquiryid: $('#inquiryid').val(),
        //                 searchTerm: params.term // search term
        //             };
        //         },
        //         processResults: function(response) {
        //             return {
        //                 results: response
        //             };
        //         },
        //         cache: true
        //     }
        // });

        $("#formsubmit").click(function() {
        if (!$("#createorderform")[0].checkValidity()) {
            // If the form is invalid, submit it. The form won't actually submit;
            // this will just cause the browser to display the native HTML5 error messages.
            $("#submitBtn").click();
        } else {
            var materialTypeID = $('#mtype').val();            
            var materialType = $("#mtype option:selected").text();
            var oquantity = $('#oquantity').val();
            var morderdate = $('#morderdate').val();
            var remarks = $('#remarks').val();

            $('.selecter2').select2();

            $('#tablematerial > tbody:last').append(
                '<tr class="pointer">' +
                '<td class="d-none">' + materialTypeID + '</td>' +
                '<td>' + materialType + '</td>' +
                '<td>' + oquantity + '</td>' +
                '<td>' + morderdate + '</td>' +
                '<td>' + remarks + '</td>' +
                '</tr>'
            );

            $('#mtype').val('').trigger('change');
            $('#oquantity').val('');
            $('#morderdate').val('');
            $('#remarks').val(''); // Clear the remark field

        }
    });

    $('#btncreateorder').click(function() {
        $('#btncreateorder').prop('disabled', true).html('<i class="fas fa-circle-notch fa-spin mr-2"></i> Saving material details');

        var tbody = $("#tablematerial tbody");
        var formData = new FormData();

        if (tbody.children().length > 0) {
            var jsonObj = [];
            $("#tablematerial tbody tr").each(function() {
                item = {}
				$(this).find('td').each(function(col_idx) {
					item["col_" + (col_idx + 1)] = $(this).text();
				});
				jsonObj.push(item);
            });

            console.log(jsonObj);

            // var mtype = $('#mtype').val();
            // var oquantity = $('#oquantity').val();
            // var morderdate = $('#morderdate').val();
            // var remarks = $('#remarks').val();
            var inquiryid = $('#inquiryid').val();

            formData.append('tableData', JSON.stringify(jsonObj)); 
            // formData.append('mtype', mtype);
            // formData.append('oquantity', oquantity);
            // formData.append('morderdate', morderdate);
            // formData.append('remarks', remarks);
            formData.append('inquiryid', inquiryid);

            $.ajax({
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                url: '<?php echo base_url() ?>CRMMaterialdetail/Materialdetailinsertupdate',
                success: function(result) {
                    var obj = result;//JSON.parse(result);
                    $('#Materialmodal').modal('hide');
                    if (obj.status == 1) {
                        setTimeout(function() {
                            window.location.reload();
                        }, 3000);
                    }
                    action(obj);
                },
                error: function(xhr, status, error) {
                    console.error('Error: ' + error);
                    $('#btncreateorder').prop('disabled', false).html('Create Order');
                }
            });
        }
    });

    $('#dataTableAccepted').on('click', '.btnview', function() {
        var id = $(this).data('id');
        $('#inquiryid').val(id);

        $.ajax({
            url: "<?php echo base_url() ?>CRMMaterialdetail/Getmaterialdetails",
            type: 'POST',
            data: { inquiryid: id },
            dataType: 'json',
            success: function(data) {
                var tableBody = $('#materialdetailtable tbody');
                tableBody.empty();
                $('#commonFields').remove();

                if (data.length > 0) {
                    data.forEach(function(materialDetail) {
                        var row = '<tr>' +
                                '<td>' + materialDetail.type + '</td>' +
                                '<td>' + materialDetail.mat_odate + '</td>' +
                                '<td>' + materialDetail.mat_quantity + '</td>' +
                                '<td><input type="number" class="form-control form-control-sm mat_balance" data-mid="' + materialDetail.tbl_material_idtbl_material  + '" data-oid="' + materialDetail.tbl_order_idtbl_order  + '" value="' + materialDetail.mat_balance + '" /></td>' +
                                '<td>' + materialDetail.mat_remarks + '</td>' +
                                '</tr>';
                        tableBody.append(row);
                    });

                    $('#materialdetail').modal('show');
                } else {
                    alert('No material details found for this inquiry.');
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('Failed to load material details. Please try again later.');
            }
        });
    });

    $('#saveBalanceDetails').on('click', function() {
        var materialBalances = [];

        $('#materialdetailtable tbody tr').each(function() {
            var balanceInput = $(this).find('input.mat_balance');
            var materialId = balanceInput.data('mid');
            var orderId = balanceInput.data('oid');
            var balanceValue = balanceInput.val();

            materialBalances.push({
                tbl_material_idtbl_material: materialId,
                tbl_order_idtbl_order: orderId,
                mat_balance: balanceValue
            });
        });

        $.ajax({
            url: "<?php echo base_url() ?>CRMMaterialdetail/Savematerialbalances",
            type: 'POST',
            data: { materialBalances: materialBalances },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert('Material balances saved successfully.');
                    $('#materialdetail').modal('hide');
                } else {
                    alert('Failed to save material balances. Please try again.');
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('An error occurred while saving material balances. Please try again later.');
            }
        });
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