<script>
    $(document).ready(function() {
        $('#crmorder_main_nav_link').prop('aria-expanded', 'true').removeClass('collapsed');
        $('#collapseCRMOrder').addClass('show');
        
        var addcheck = '<?php echo (in_array('createCRMOrder', $user_permission)) ? 1 : 0; ?>';
        var editcheck = '<?php echo (in_array('updateCRMOrder', $user_permission)) ? 1 : 0; ?>';
        var statuscheck = '<?php echo (in_array('updateCRMOrder', $user_permission) || in_array('deleteCRMOrder', $user_permission)) ? 1 : 0; ?>';
        var deletecheck = '<?php echo (in_array('deleteCRMOrder', $user_permission)) ? 1 : 0; ?>';
        

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
                { extend: 'csv', className: 'btn btn-success btn-sm', title: 'Order detail Information', text: '<i class="fas fa-file-csv mr-2"></i> CSV', },
                { extend: 'pdf', className: 'btn btn-danger btn-sm', title: 'Order detail Information', text: '<i class="fas fa-file-pdf mr-2"></i> PDF', },
                { 
                    extend: 'print', 
                    title: 'Order detail Information',
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
                        button += '<button class="btn btn-primary btn-sm btnview mr-1" data-toggle="modal" data-target="#orderdet" data-qid="' + full['idtbl_quotation'] + '" data-id="' + full['tbl_inquiry_idtbl_inquiry'] + '" data-customer="' + full['idtbl_customer'] + '" title="Payment details view"><i class="fas fa-eye"></i></button>';
                        button += '<button class="btn btn-success btn-sm btnquotation mr-1" data-toggle="modal" data-target="#staticBackdrop" data-qid="' + full['idtbl_quotation'] + '" data-id="' + full['tbl_inquiry_idtbl_inquiry'] + '" data-customer="' + full['idtbl_customer'] + '" title="Create Order"><i class="fas fa-list"></i></button>';
                        button += '<button class="btn btn-dark btn-sm btnpayment mr-1" data-toggle="modal" data-target="#Paymentmodal" data-qid="' + full['idtbl_quotation'] + '" data-id="' + full['tbl_inquiry_idtbl_inquiry'] + '" data-customer="' + full['idtbl_customer'] + '" title="Payment details"><i class="fas fa-credit-card"></i></button>';
                        // button += '<button class="btn btn-white btn-sm btncutting mr-1" data-toggle="modal" data-target="#Cuttingmodal" data-qid="' + full['idtbl_quotation'] + '" data-id="' + full['tbl_inquiry_idtbl_inquiry'] + '" data-customer="' + full['idtbl_customer'] + '" title="Cutting details"><i class="fa fa-scissors"></i></button>';
                        return button;
                    }
                }
            ],
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });

        $('#customer').on('change', function () {
        var customer_id = $(this).val(); 

        if (customer_id) {
            $.ajax({
                url: '<?= base_url("CRMOrderdetail/getItemsByCustomer") ?>', 
                type: 'POST',
                data: { customer_id: customer_id },
                dataType: 'json',
                success: function (response) {
                    $('#d_item').html('<option selected disabled>Select</option>'); // Reset dropdown

                    if (response.length > 0) {
                        $.each(response, function (index, product) {
                            $('#d_item').append('<option value="' + product.idtbl_product + '">' + product.product + '</option>');
                        });
                    } else {
                        $('#d_item').append('<option disabled>No items available</option>');
                    }
                }
            });
        } else {
            $('#d_item').html('<option selected disabled>Select</option>'); 
        }
    });

        $('#dataTableAccepted').on('click', '.btnquotation', function() {
            var qid = $(this).data('qid');
            var id = $(this).data('id');
            $('#inquiryid').val(id);

            $('#staticBackdrop').modal('show');
        });

        $('#dataTableAccepted').on('click', '.btnpayment', function() {
            var qid = $(this).data('qid');
            var id = $(this).data('id');
            $('#inquiryid').val(id);
        });

        $('#directorder').on('click', function () {
        $('#directordermodal').modal('show');
     });

        $('#dataTableAccepted').on('click', '.btnview', function() {
            var id = $(this).data('id');
            $('#inquiryid').val(id);

            $.ajax({
                url: "<?php echo base_url() ?>CRMOrderdetail/Getorderdetails",
                type: 'POST',
                data: { inquiryid: id },
                dataType: 'json',
                success: function(data) {
                    var tableBody = $('#orderdetailtable tbody');
                    tableBody.empty();
                    $('#commonFields').remove();

                    if (data.length > 0) {
                        var commonFields = '<div id="commonFields">' +
                                        '<div><strong>Payment Type:</strong> ' + data[0].p_type + '</div>' +
                                        '<div><strong>Advance &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp:</strong> ' + data[0].advance + '</div>';
                        if (data[0].bname) {
                            commonFields += '<div><strong>Bank Name &nbsp&nbsp&nbsp&nbsp:</strong>&nbsp;  ' + data[0].bname + '</div>';
                        }

                        commonFields += '</div>';
                        $('#orderdet .modal-body').prepend(commonFields);
                        data.forEach(function(orderDetail) {
                            var balance = orderDetail.cutting_qty - orderDetail.quantity;
                            var row = '<tr>' +
                                    '<td>' + orderDetail.cloth_type + '</td>' +
                                    '<td>' + orderDetail.material_type + '</td>' +
                                    '<td>' + orderDetail.size + '</td>' +
                                    '<td>' + orderDetail.quantity + '</td>' +
                                    '<td><input type="number" class="form-control form-control-sm cutting-qty" data-id="' + orderDetail.idtbl_order_detail + '" value="' + orderDetail.cutting_qty + '" /></td>' +
                                    '<td class="balance">' + (balance >= 0 ? '+' : '') + balance + '</td>' + 
                                    '</tr>';
                            tableBody.append(row);
                        });

                        $('#orderdet').modal('show');
                    } else {
                        alert('No order details found for this inquiry.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    alert('Failed to load order details. Please try again later.');
                }
            });
        });

        $(document).on('input', '.cutting-qty', function() {
            var $row = $(this).closest('tr');
            var quantity = parseInt($row.find('td').eq(3).text());
            var cuttingQty = parseInt($(this).val());
            var balance = cuttingQty - quantity;
            $row.find('.balance').text((balance >= 0 ? '+' : '') + balance);
        });

        $('#saveCuttingDetails').on('click', function() {
            var updatedData = [];

            // Collect updated data from the table
            $('#orderdetailtable tbody tr').each(function() {
                var row = $(this);
                var cuttingQty = row.find('.cutting-qty').val();
                var id = row.find('.cutting-qty').data('id');

                updatedData.push({
                    id: id,
                    cuttingQty: cuttingQty
                });
            });

            // Send updated data to the server
            $.ajax({
                url: "<?php echo base_url() ?>CRMOrderdetail/SaveCuttingDetails",
                type: 'POST',
                data: {
                    updatedData: JSON.stringify(updatedData)
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        alert('Cutting details saved successfully!');
                        $('#orderdet').modal('hide');
                    } else {
                        alert('Failed to save cutting details. Please try again.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    alert('An error occurred. Please try again later.');
                }
            });
        });       

        // $("#clothtype").select2({
        //     dropdownParent: $('#staticBackdrop'),
        //     ajax: {
        //         url: "<?php echo base_url() ?>CRMOrderdetail/Getclothtype",
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

        // $("#sizetype").select2({  
        //     dropdownParent: $('#staticBackdrop'),
        //     ajax: {
        //         url: "<?php echo base_url() ?>CRMOrderdetail/Getsizetype",
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

        $("#bank").select2({  
            dropdownParent: $('#Paymentmodal'),
            ajax: {
                url: "<?php echo base_url() ?>CRMOrderdetail/Getbankname",
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
        $("#paymenttype").select2({  
            dropdownParent: $('#Paymentmodal'),
            ajax: {
                url: "<?php echo base_url() ?>CRMOrderdetail/Getpaymenttype",
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

        $('#payformsubmit').click(function() { 
            var formData = {
                bank: $('#bank').val(),
                paymenttype: $('#paymenttype').val(),
                advance: $('#advance').val(),
                pdate: $('#pdate').val(),
                inquiryid: $('#inquiryid').val(),
                recordOption: $('#recordOption').val()
            };

            $.ajax({
                type: 'POST',
                url: "<?php echo base_url() ?>CRMOrderdetail/PaymentDetailInsertUpdate",
                data: formData,
                dataType: 'json',
                encode: true,
                success: function(data) {
                    // console.log(data);
                    window.location.reload();
                }
            });
        });

        $("#materialtype").select2({
            dropdownParent: $('#staticBackdrop'),
            placeholder: "Select material type",
            allowClear: true
        });

        $("#clothtype").on('change', function() {
            var clothtypeId = $(this).val();
            if (clothtypeId) {
                $("#materialtype").prop("disabled", false);
                $("#materialtype").select2({
                    dropdownParent: $('#staticBackdrop'),
                    ajax: {
                        url: "<?php echo base_url() ?>CRMOrderdetail/Getmaterialtype",
                        type: "post",
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                inquiryid: $('#inquiryid').val(),
                                clothtypeId: clothtypeId,
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

                $.ajax({
                    url: "<?php echo base_url() ?>CRMOrderdetail/GetQuantity",
                    type: "post",
                    data: {
                        inquiryid: $('#inquiryid').val(),
                        clothtypeId: clothtypeId
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response && response.quantity) {
                            $('#quantity').val(response.quantity);
                        } else {
                            $('#quantity').val('');
                            alert('Failed to fetch quantity');
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#quantity').val('');
                        alert('Error in fetching quantity');
                    }
                });
            } else {
                $("#materialtype").prop("disabled", true);
                $("#materialtype").val(null).trigger('change');
            }
        });

    });

    $("#formsubmit").click(function() {
        if (!$("#createorderform")[0].checkValidity()) {
            // If the form is invalid, submit it. The form won't actually submit;
            // this will just cause the browser to display the native HTML5 error messages.
            $("#submitBtn").click();
        } else {
            // var clothTypeID = $('#clothtype').val();
            // var materialTypeID = $('#materialtype').val();
            // var sizeTypeID = $('#sizetype').val();
            // var clothType = $("#clothtype option:selected").text();
            // var materialType = $("#materialtype option:selected").text();
            // var sizeType = $("#sizetype option:selected").text();
            var recordOption = $('#recordOption').val();
            var itemId = $('#item').val();
            var item = $("#item option:selected").text();
            var orderDate = $('#order_date').val();
            var qty = parseFloat($('#qty').val());
            var description = $('#remark').val();

            // $('.selecter2').select2();

            $('#tableorder > tbody:last').append(
                '<tr class="pointer">' +
                '<td class="d-none">' + recordOption + '</td>' +
                '<td class="d-none">' + itemId + '</td>' +
                '<td>' + item + '</td>' +
                '<td>' + orderDate + '</td>' +
                '<td>' + qty + '</td>' +
                '<td class="d-none total">' + qty + '</td>' + 
                '</tr>'
            );

            $('#item').val('').trigger('change');
            $('#order_date').val('').trigger('change');
            $('#qty').val('');
            $('#remark').val(''); 

            // var sum = 0;
            // $(".total").each(function() {
            //     sum += parseFloat($(this).text());
            // });
        }
    });

    $('#btncreateorder').click(function() {
        $('#btncreateorder').prop('disabled', true).html('<i class="fas fa-circle-notch fa-spin mr-2"></i> Creating Order');

        var tbody = $("#tableorder tbody");
        var formData = new FormData();

        if (tbody.children().length > 0) {
            var jsonObj = [];
            $("#tableorder tbody tr").each(function() {
                item = {}
				$(this).find('td').each(function(col_idx) {
					item["col_" + (col_idx + 1)] = $(this).text();
				});
				jsonObj.push(item);
            });

            console.log(jsonObj);
            var recordOption = $('recordOption').val();
            var itemId = $('#item').val();
            var date = $('#order_date').val();
            var qty = parseFloat($('#qty').val());
            // var inquiryid = $('#inquiryid').val();
            var quotationid = $('#quotationid').val();

            formData.append('tableData', JSON.stringify(jsonObj)); 
            formData.append('recordOption',recordOption);
            formData.append('itemId', itemId);
            formData.append('date', date);
            formData.append('qty', qty);
            // formData.append('inquiryid', inquiryid);
            formData.append('quotationid', quotationid);

            $.ajax({
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                url: '<?php echo base_url() ?>CRMOrderdetail/Orderdetailinsertupdate',
                success: function(result) {
                    var obj = result;//JSON.parse(result);
                    $('#staticBackdrop').modal('hide');
                    $('#btncreateorder').prop('disabled', false).html('<i class="fas fa-save mr-2"></i> Create Order');
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

    // direct order formsubmit
    $("#formsubmitdirectorder").click(function() {
        if (!$("#createdirectorderform")[0].checkValidity()) {
            $("#submitBtn").click();
        } else {
            var custId = $('#customer').val();
            var customer = $("#customer option:selected").text();
            var itemId = $('#d_item').val();
            var item = $("#d_item option:selected").text();
            var orderDate = $('#d_order_date').val();
            var qty = parseFloat($('#d_qty').val());
            var description = $('#remark').val();

            $('#tabledirectorder > tbody:last').append(
                '<tr class="pointer">' +
                '<td class="d-none">' + custId + '</td>' +
                '<td>' + customer + '</td>' +
                '<td class="d-none">' + itemId + '</td>' +
                '<td>' + item + '</td>' +
                '<td>' + orderDate + '</td>' +
                '<td>' + qty + '</td>' +
                '<td class="d-none total">' + qty + '</td>' + 
                '</tr>'
            );

            $('#d_item option:selected').text('').trigger('change');
            $('#d_item').val('').trigger('change');
            $('#d_order_date').val('').trigger('change');
            $('#d_qty').val('');
            $('#remark').val(''); 
        }
    });

    $('#btncreatedirectorder').click(function() {
        $('#btncreatedirectorder').prop('disabled', true).html('<i class="fas fa-circle-notch fa-spin mr-2"></i> Creating Order');

        var tbody = $("#tabledirectorder tbody");
        var formData = new FormData();

        if (tbody.children().length > 0) {
            var jsonObj = [];
            $("#tabledirectorder tbody tr").each(function() {
                item = {}
				$(this).find('td').each(function(col_idx) {
					item["col_" + (col_idx + 1)] = $(this).text();
				});
				jsonObj.push(item);
            });

            // console.log(jsonObj);
            var custId =$('#customer').val();
            var itemId = $('#d_item').val();
            var date = $('#d_order_date').val();
            var qty = parseFloat($('#d_qty').val());
            var inquiryid = $('#inquiryid').val();
            var quotationid = $('#quotationid').val();

            formData.append('tableData', JSON.stringify(jsonObj)); 
            formData.append('itemId', itemId);
            formData.append('date', date);
            formData.append('qty', qty);
            formData.append('inquiryid', inquiryid);
            formData.append('quotationid', quotationid);

            $.ajax({
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                url: '<?php echo base_url() ?>CRMOrderdetail/Orderdetailinsertupdate',
                success: function(result) {
                    var obj = result;//JSON.parse(result);
                    $('#staticBackdrop').modal('hide');
                    $('#btncreatedirectorder').prop('disabled', false).html('<i class="fas fa-save mr-2"></i> Create Order');
                    if (obj.status == 1) {
                        setTimeout(function() {
                            window.location.reload();
                        }, 3000);
                    }
                    action(obj);
                },
                error: function(xhr, status, error) {
                    console.error('Error: ' + error);
                    $('#btncreatedirectorder').prop('disabled', false).html('Create Order');
                }
            });
        }
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