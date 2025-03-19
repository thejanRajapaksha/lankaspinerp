<script>
    $(document).ready(function() {
        $('#crmorder_main_nav_link').prop('aria-expanded', 'true').removeClass('collapsed');
        $('#collapseCRMOrder').addClass('show');
        
        var addcheck = '<?php echo (in_array('createCRMDeliverydetail', $user_permission)) ? 1 : 0; ?>';
        var editcheck = '<?php echo (in_array('updateCRMDeliverydetail', $user_permission)) ? 1 : 0; ?>';
        var statuscheck = '<?php echo (in_array('updateCRMDeliverydetail', $user_permission) || in_array('deleteCRMDeliverydetail', $user_permission)) ? 1 : 0; ?>';
        var deletecheck = '<?php echo (in_array('deleteCRMDeliverydetail', $user_permission)) ? 1 : 0; ?>';

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
                        button += '<button class="btn btn-dark btn-sm btnview mr-1" data-toggle="modal" data-target="#deliverydetail" data-qid="' + full['idtbl_quotation'] + '" data-id="' + full['tbl_inquiry_idtbl_inquiry'] + '" data-customer="' + full['idtbl_customer'] + '" title="Packaging details view"><i class="fas fa-eye"></i></button>';
                        button += '<button class="btn btn-dark btn-sm btnquotation mr-1" data-toggle="modal" data-target="#Deliverymodal" data-qid="' + full['idtbl_quotation'] + '" data-id="' + full['tbl_inquiry_idtbl_inquiry'] + '" data-customer="' + full['idtbl_customer'] + '" title="Enter Packaging Details"><i class="fas fa-box"></i></button>';
                        button += '<button class="btn btn-dark btn-sm btnpayment mr-1" data-toggle="modal" data-target="#paymentDetailModal" data-qid="' + full['idtbl_quotation'] + '" data-id="' + full['tbl_inquiry_idtbl_inquiry'] + '" data-customer="' + full['idtbl_customer'] + '" data-total="' + full['total'] + '" title="payment details"><i class="fas fa-credit-card"></i></button>';
                        button += '<button class="btn btn-dark btn-sm btndelivery mr-1" data-toggle="modal" data-target="#jobPlanModal" data-qid="' + full['idtbl_quotation'] + '" data-id="' + full['tbl_inquiry_idtbl_inquiry'] + '" data-customer="' + full['idtbl_customer'] + '" title="Delivery details"><i class="fas fa-truck"></i></button>';
                        if(full['status']==1){
                            button+='<a href="<?php echo base_url() ?>CRMDeliverydetail/Deliverydetailstatus/'+full['idtbl_quotation']+'/4" onclick="return deactive_confirm()" target="_self" class="btn btn-dark btn-sm mr-1 ';if(statuscheck!=1){button+='d-none';}button+='"><i class="fas fa-check"></i></a>';
                        }else{
                            button+='<a href="<?php echo base_url() ?>CRMDeliverydetail/Deliverydetailstatus/'+full['idtbl_quotation']+'/1" onclick="return active_confirm()" target="_self" class="btn btn-success btn-sm mr-1 ';if(statuscheck!=1){button+='d-none';}button+='"><i class="fas fa-times"></i></a>';
                        }
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
        $('#dataTableAccepted').on('click', '.btndelivery', function() {
            var qid = $(this).data('qid');
            var id = $(this).data('id');
            $('#inquiryid').val(id);
        });

        $("#paymenttype").select2({
            dropdownParent: $('#paymentDetailModal'),
            ajax: {
                url: "<?php echo base_url() ?>CRMDeliverydetail/Getpaymenttype",
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

        // $("#clothtype").select2({
        //     dropdownParent: $('#Deliverymodal'),
        //     ajax: {
        //         url: "<?php echo base_url() ?>CRMDeliverydetail/Getclothtype",
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
        // $("#size").select2({  
        //     dropdownParent: $('#Deliverymodal'),
        //     ajax: {
        //         url: "<?php echo base_url() ?>CRMDeliverydetail/Getsizetype",
        //         type: "post",
        //         dataType: 'json',
        //         delay: 250,
        //         data: function(params) {
        //             return {
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

        // $("#dsize").select2({  
        //     dropdownParent: $('#deliveryDetailModal'),
        //     ajax: {
        //         url: "<?php echo base_url() ?>CRMDeliverydetail/Getsizetype",
        //         type: "post",
        //         dataType: 'json',
        //         delay: 250,
        //         data: function(params) {
        //             return {
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
        // $("#dclothtype").select2({
        //     dropdownParent: $('#deliveryDetailModal'),
        //     ajax: {
        //         url: "<?php echo base_url() ?>CRMDeliverydetail/Getclothtype",
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

        $(document).on('click', '.btnpayment', function() {
            var total = $(this).data('total');
            var inquiryid = $(this).data('id'); 
            $('#paymentDetailTableBody').empty();

            var advance = 0;
            var totalPayments = 0;

            $.ajax({
                url: "<?php echo base_url() ?>CRMDeliverydetail/Getadvancepayment",
                type: 'POST',
                data: { inquiryid: inquiryid },
                dataType: 'json',
                success: function(response) {
                    if (response.advance !== undefined) {
                        advance = response.advance;
                    }

                    var balance = total - advance;
                    $.ajax({
                        url: "<?php echo base_url(); ?>CRMDeliverydetail/GetPaymentDetails",
                        type: 'POST',
                        data: { inquiryid: inquiryid },
                        dataType: 'json',
                        success: function(payments) {
                            $.each(payments, function(index, payment) {
                                $('#paymentDetailTableBody').append(
                                    '<tr>' +
                                    '<td>' + payment.p_type + '</td>' +
                                    '<td>' + payment.payment_date + '</td>' +
                                    '<td>' + payment.amount + '</td>' +
                                    '</tr>'
                                );
                                totalPayments += parseFloat(payment.amount);
                            });
                            balance -= totalPayments;
                            $('#balanceAmount').text(balance.toFixed(2));
                        },
                    });
                },
                error: function() {
                    alert('Error fetching advance payment');
                }
            });
        });


        $(document).on('click', '#addPaymentBtn', function() {
            var paymentType = $('#paymenttype').val();
            var paymentDate = $('#paymentDate').val();
            var paymentAmount = $('#paymentAmount').val();
            var inquiryid = $('.btnpayment').data('id'); 
            if (paymentType === "" || paymentDate === "" || paymentAmount === "") {
                alert('Please fill all required fields');
                return;
            }

            $.ajax({
                url: "<?php echo base_url(); ?>CRMDeliverydetail/AddPayment",
                type: 'POST',
                data: {
                    paymenttype: paymentType,
                    paymentDate: paymentDate,
                    paymentAmount: paymentAmount,
                    inquiryid: inquiryid
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        $('#paymentDetailTableBody').append(
                            '<tr>' +
                            '<td>' + $('#paymenttype option:selected').text() + '</td>' +
                            '<td>' + paymentDate + '</td>' +
                            '<td>' + paymentAmount + '</td>' +
                            '</tr>'
                        );

                        $('#paymenttype').val('');
                        $('#paymentDate').val('');
                        $('#paymentAmount').val('');

                        alert('Payment added successfully');
                    } else {
                        alert('Failed to add payment');
                    }
                },
            });
        });


    $("#formsubmit").click(function() {
        if (!$("#createorderform")[0].checkValidity()) {
            $("#submitBtn").click();
        } else {
            var clothTypeID = $('#clothtype').val();            
            var clothType = $("#clothtype option:selected").text();
            var sizeID = $('#size').val();            
            var size = $("#size option:selected").text();
            var quantity = $('#quantity').val();
            var date = $('#date').val();

            $('.selecter2').select2();

            $('#tablepackaging > tbody:last').append(
                '<tr class="pointer">' +
                '<td class="d-none">' + clothTypeID + '</td>' +
                '<td>' + clothType + '</td>' +
                '<td class="d-none">' + sizeID + '</td>' +
                '<td>' + size + '</td>' +
                '<td>' + quantity + '</td>' +
                '<td>' + date + '</td>' +
                '</tr>'
            );

            $('#clothtype').val('').trigger('change');
            $('#size').val('').trigger('change');
            $('#quantity').val('');
            $('#date').val('');

        }
    });

    $('#btncreateorder').click(function() {
        $('#btncreateorder').prop('disabled', true).html('<i class="fas fa-circle-notch fa-spin mr-2"></i> Saving packaging details');

        var tbody = $("#tablepackaging tbody");
        var formData = new FormData();

        if (tbody.children().length > 0) {
            var jsonObj = [];
            $("#tablepackaging tbody tr").each(function() {
                var item = {
                    clothTypeID: $(this).find('td').eq(0).text(),   
                    sizeID: $(this).find('td').eq(2).text(),             
                    quantity: $(this).find('td').eq(4).text(),    
                    date: $(this).find('td').eq(5).text(),             
                };

                jsonObj.push(item);
            });

            console.log(jsonObj);

            var inquiryid = $('#inquiryid').val();

            formData.append('tableData', JSON.stringify(jsonObj)); 
            formData.append('inquiryid', inquiryid);

            $.ajax({
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                url: '<?php echo base_url() ?>CRMDeliverydetail/Packagingdetailinsertupdate',
                success: function(result) {
                    var obj = result;//JSON.parse(result);
                    $('#Deliverymodal').modal('hide');
                    if (obj.status == 1) {
                        setTimeout(function() {
                            window.location.reload();
                        }, 3000);
                    }
                    action(obj);
                },
            });
        }
    });

    $('#addDeliveryBtn').click(function() {
        if (!$("#deliveryDetailForm")[0].checkValidity()) {
            $("#deliveryDetailForm")[0].reportValidity();
        } else {
            var clothTypeID = $('#dclothtype').val();            
            var clothType = $("#dclothtype option:selected").text();
            var sizeID = $('#dsize').val();            
            var size = $("#dsize option:selected").text();
            var quantity = $('#deliveryQuantity').val();
            var deliveryDate = $('#deliveryDate').val();

            $('#deliveryDetailTableBody').append(
                '<tr class="pointer">' +
                '<td class="d-none">' + clothTypeID + '</td>' +
                '<td>' + clothType + '</td>' +
                '<td class="d-none">' + sizeID + '</td>' +
                '<td>' + size + '</td>' +
                '<td>' + quantity + '</td>' +
                '<td>' + deliveryDate + '</td>' +
                '</tr>'
            );

            $('#dclothtype').val('').trigger('change');
            $('#dsize').val('').trigger('change');
            $('#deliveryQuantity').val('');
            $('#deliveryDate').val('');
        }
    });

    $('#btnSaveDelivery').click(function() {
        $('#btnSaveDelivery').prop('disabled', true).html('<i class="fas fa-circle-notch fa-spin mr-2"></i> Saving delivery details');

        var tbody = $("#deliveryDetailTableBody");
        var formData = new FormData();

        if (tbody.children().length > 0) {
            var jsonObj = [];
            tbody.find('tr').each(function() {
                var item = {
                    clothTypeID: $(this).find('td').eq(0).text(),    
                    sizeID: $(this).find('td').eq(2).text(),             
                    quantity: $(this).find('td').eq(4).text(),    
                    deliveryDate: $(this).find('td').eq(5).text() 
                };

                jsonObj.push(item);
            });

            console.log(jsonObj);

            var inquiryid = $('#inquiryid').val();

            formData.append('tableData', JSON.stringify(jsonObj)); 
            formData.append('inquiryid', inquiryid);

            $.ajax({
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                url: '<?php echo base_url() ?>CRMDeliverydetail/Deliverydetailinsertupdate',
                success: function(result) {
                    var obj = JSON.parse(result);
                    $('#deliveryDetailModal').modal('hide');
                    if (obj.status == 1) {
                        setTimeout(function() {
                            window.location.reload();
                        }, 3000);
                    }
                    action(obj);
                },
            });
        }
    });


    $('#dataTableAccepted').on('click', '.btnview', function() {
        var id = $(this).data('id');
        $('#inquiryid').val(id);

        $.ajax({
            url: "<?php echo base_url() ?>CRMDeliverydetail/GetDeliveryAndPackagingDetails",
            type: 'POST',
            data: { inquiryid: id },
            dataType: 'json',
            success: function(data) {
                var deliveryTableBody = $('#deliverydetailtable tbody');
                var packagingTableBody = $('#packagingdetailtable tbody');
                deliveryTableBody.empty();
                packagingTableBody.empty();

                if (data.delivery.length > 0) {
                    data.delivery.forEach(function(deliveryDetail) {
                        var row = '<tr>' +
                            '<td>' + deliveryDetail.cloth_type + '</td>' +
                            '<td>' + deliveryDetail.size + '</td>' +
                            '<td>' + deliveryDetail.deliver_quantity + '</td>' +
                            '<td>' + deliveryDetail.delivery_date + '</td>' +
                            '</tr>';
                        deliveryTableBody.append(row);
                    });
                } else {
                    alert('No delivery details found for this inquiry.');
                }

                if (data.packaging.length > 0) {
                    data.packaging.forEach(function(packagingDetail) {
                        var row = '<tr>' +
                            '<td>' + packagingDetail.cloth_type + '</td>' +
                            '<td>' + packagingDetail.size + '</td>' +
                            '<td>' + packagingDetail.packed_quantity + '</td>' +
                            '<td>' + packagingDetail.packaging_date + '</td>' +
                            '</tr>';
                        packagingTableBody.append(row);
                    });
                } else {
                    alert('No packaging details found for this inquiry.');
                }

                $('#deliverydetail').modal('show');
            },
        });
    });

    $('#saveBalanceDetails').on('click', function() {
        var materialBalances = [];

        $('#deliverydetailtable tbody tr').each(function() {
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
            url: "<?php echo base_url() ?>CRMDeliverydetail/Savematerialbalances",
            type: 'POST',
            data: { materialBalances: materialBalances },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert('Material balances saved successfully.');
                    $('#deliverydetail').modal('hide');
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
        return confirm("Are you sure you want to complete order?");
    }

    function active_confirm() {
        return confirm("Are you sure you want to remove complete order?");
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
