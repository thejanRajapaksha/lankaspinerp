<script>
    $(document).ready(function() {
        $('#crmorder_main_nav_link').prop('aria-expanded', 'true').removeClass('collapsed');
        $('#collapseCRMOrder').addClass('show');

        var addcheck = '<?php echo (in_array('createCRMPrintingdetail', $user_permission)) ? 1 : 0; ?>';
        var editcheck = '<?php echo (in_array('updateCRMPrintingdetail', $user_permission)) ? 1 : 0; ?>';
        var statuscheck = '<?php echo (in_array('updateCRMPrintingdetail', $user_permission) || in_array('deleteCRMPrintingdetail', $user_permission)) ? 1 : 0; ?>';
        var deletecheck = '<?php echo (in_array('deleteCRMPrintingdetail', $user_permission)) ? 1 : 0; ?>';

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
                { extend: 'csv', className: 'btn btn-success btn-sm', title: 'Printing detail Information', text: '<i class="fas fa-file-csv mr-2"></i> CSV', },
                { extend: 'pdf', className: 'btn btn-danger btn-sm', title: 'Printing detail Information', text: '<i class="fas fa-file-pdf mr-2"></i> PDF', },
                { 
                    extend: 'print', 
                    title: 'Printing detail Information',
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
                        button += '<button class="btn btn-primary btn-sm btnview mr-1" data-toggle="modal" data-target="#orderdet" data-qid="' + full['idtbl_quotation'] + '" data-id="' + full['tbl_inquiry_idtbl_inquiry'] + '" data-customer="' + full['idtbl_customer'] + '" title="View order details"><i class="fas fa-eye"></i></button>';
                        button += '<button class="btn btn-dark btn-sm receivebtnview mr-1" data-toggle="modal" data-target="#receivedetailsinfo" data-qid="' + full['idtbl_quotation'] + '" data-id="' + full['tbl_inquiry_idtbl_inquiry'] + '" data-customer="' + full['idtbl_customer'] + '" title="View order receive details"><i class="fas fa-eye"></i></button>';
                        button += '<button class="btn btn-dark btn-sm btnorder mr-1" data-toggle="modal" data-target="#Printingmodal" data-qid="' + full['idtbl_quotation'] + '" data-id="' + full['tbl_inquiry_idtbl_inquiry'] + '" data-customer="' + full['idtbl_customer'] + '" title="Add Printing details"><i class="fas fa-list"></i></button>';
                        button += '<button class="btn btn-dark btn-sm btnrecieve mr-1" data-toggle="modal" data-target="#ReceiveDetailsModal" data-qid="' + full['idtbl_quotation'] + '" data-id="' + full['tbl_inquiry_idtbl_inquiry'] + '" data-customer="' + full['idtbl_customer'] + '" title="Add Receive details"><i class="fas fa-download"></i></button>';
                        button += '<button class="btn btn-dark btn-sm btncolorcuff mr-1" data-toggle="modal" data-target="#ColorcuffModal" data-qid="' + full['idtbl_quotation'] + '" data-id="' + full['tbl_inquiry_idtbl_inquiry'] + '" data-customer="' + full['idtbl_customer'] + '" title="Color/Cuff details"><i class="fas fa-tshirt"></i></button>';
                        return button;
                    }
                }
            ],
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });

        $('#dataTableAccepted').on('click', '.btnorder', function() {
            var qid = $(this).data('qid');
            var id = $(this).data('id');
            $('#inquiryid').val(id);
        });

        $('#dataTableAccepted').on('click', '.btnrecieve', function() {
            var qid = $(this).data('qid');
            var id = $(this).data('id');
            $('#inquiryid').val(id);
        });

        $("#CMSupplier").select2({  
            dropdownParent: $('#ColorcuffModal'),
            ajax: {
                url: "<?php echo base_url() ?>CRMPrintingdetail/Getcuffcompany",
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
        // $("#CMColorcode").select2({  
        //     dropdownParent: $('#ColorcuffModal'),
        //     ajax: {
        //         url: "<?php echo base_url() ?>CRMPrintingdetail/Getcolorcode",
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

        $("#printingcompany").select2({  
            dropdownParent: $('#Printingmodal'),
            ajax: {
                url: "<?php echo base_url() ?>CRMPrintingdetail/Getprintingcompany",
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
        $("#sewingcompany").select2({  
            dropdownParent: $('#Printingmodal'),
            ajax: {
                url: "<?php echo base_url() ?>CRMPrintingdetail/Getsewingcompany",
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
        //     dropdownParent: $('#Printingmodal'),
        //     ajax: {
        //         url: "<?php echo base_url() ?>CRMPrintingdetail/Getclothtype",
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

        $("#Rprintingcompany").select2({  
            dropdownParent: $('#ReceiveDetailsModal'),
            ajax: {
                url: "<?php echo base_url() ?>CRMPrintingdetail/Getprintingcompany",
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
        $("#Rsewingcompany").select2({  
            dropdownParent: $('#ReceiveDetailsModal'),
            ajax: {
                url: "<?php echo base_url() ?>CRMPrintingdetail/Getsewingcompany",
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
        $("#Rcolorcompany").select2({  
            dropdownParent: $('#ReceiveDetailsModal'),
            ajax: {
                url: "<?php echo base_url() ?>CRMPrintingdetail/Getcolorcompany",
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
        // $("#Rclothtype").select2({
        //     dropdownParent: $('#ReceiveDetailsModal'),
        //     ajax: {
        //         url: "<?php echo base_url() ?>CRMPrintingdetail/Getclothtype",
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
        $("#Rdesigntype").select2({
            dropdownParent: $('#ReceiveDetailsModal'),
            ajax: {
                url: "<?php echo base_url() ?>CRMPrintingdetail/Getdesigntype",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    var RclothId = $('#Rclothtype').val();
                    if (!RclothId) {
                        alert('Please select a cloth type to get the design types.');
                        return false; 
                    }

                    return {
                        inquiryid: $('#inquiryid').val(),
                        RclothId: RclothId, 
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

        $("#addReceiveDetails").click(function() {
            var RclothTypeID = $('#Rclothtype').val();
            var RprintingComID = $('#Rprintingcompany').val();
            var RsewingComID = $('#Rsewingcompany').val();
            var RcolorcomID = $('#Rcolorcompany').val();
            var RcolorcuffID = $('#Rcolorcuff').val();
            var RclothType = $("#Rclothtype option:selected").text();
            var RprintingCom = $("#Rprintingcompany option:selected").text();
            var RsewingCom = $("#Rsewingcompany option:selected").text();
            var Rcolorcom = $("#Rcolorcompany option:selected").text();
            var Rcolorcuff = $("#Rcolorcuff option:selected").text();
            var receivedQuantity = parseFloat($('#receivedQuantity').val());
            var receiveDate = $('#receiveDate').val();
            var Rdesigntype = $('#Rdesigntype').val();

            if (!receivedQuantity || !receiveDate ) {
                alert('Please fill in all fields.');
                return;  
            }

            if (isNaN(receivedQuantity) || receivedQuantity <= 0) {
                alert('Please enter a valid quantity.');
                return;  
            }

            $('#orderReceivetable > tbody:last').append(
                '<tr class="pointer">' +
                '<td class="d-none">' + RclothTypeID + '</td>' + 
                '<td>' + RclothType + '</td>' +  
                '<td class="d-none">' + RprintingComID + '</td>' + 
                '<td>' + RprintingCom + '</td>' +    
                '<td class="d-none">' + RsewingComID + '</td>' + 
                '<td>' + RsewingCom + '</td>' +  
                '<td class="d-none">' + RcolorcomID + '</td>' + 
                '<td>' + Rcolorcom + '</td>' +
                '<td>' + Rdesigntype + '</td>' +
                '<td class="d-none">' + RcolorcuffID + '</td>' + 
                '<td>' + Rcolorcuff + '</td>' +                                
                '<td>' + receivedQuantity + '</td>' +           
                '<td>' + receiveDate + '</td>' +                
                '</tr>'
            );

            $('#Rclothtype').val('').trigger('change');    
            $('#Rprintingcompany').val('').trigger('change');
            $('#Rsewingcompany').val('').trigger('change');  
            $('#Rdesigntype').val('').trigger('change');
            $('#Rcolorcom').val('').trigger('change');  
            $('#Rcolorcuff').val('').trigger('change');  
            $('#receivedQuantity').val('');             
            $('#receiveDate').val('');                  
        });

        $("#btnSaveReceiveDetails").click(function() {
            var Rremark = $('#Rremark').val();
            var receiveDetails = [];
            $('#orderReceivetable tbody tr').each(function() {
                var row = $(this);
                var clothTypeID = row.find('td:eq(0)').text();
                var clothType = row.find('td:eq(1)').text();
                var printingComID = row.find('td:eq(2)').text();
                var sewingComID = row.find('td:eq(4)').text();
                var colorcomID = row.find('td:eq(6)').text();
                var designType = row.find('td:eq(8)').text();
                var colorcuffID = row.find('td:eq(9)').text();
                var receivedQuantity = row.find('td:eq(11)').text();
                var receiveDate = row.find('td:eq(12)').text();

                if (receivedQuantity && receiveDate) { 
                    receiveDetails.push({
                        clothTypeID: clothTypeID,
                        clothType: clothType,
                        printingCom: printingComID,
                        sewingCom: sewingComID,
                        colorcom: colorcomID,
                        designType: designType,
                        colorcuff: colorcuffID,
                        receivedQuantity: receivedQuantity,
                        receiveDate: receiveDate
                    });
                }
            });

            if (receiveDetails.length > 0) {
                $.ajax({
                    url: "<?php echo base_url() ?>CRMPrintingdetail/SaveReceiveDetails",
                    type: 'POST',
                    data: {
                        receiveDetails: receiveDetails,
                        Rremark: Rremark,
                        inquiryid: $('#inquiryid').val()
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert('Receive details saved successfully!');
                            $('#ReceiveDetailsModal').modal('hide');
                            $('#orderReceivetable tbody').empty();
                        } else {
                            alert('Failed to save receive details. Please try again.');
                        }
                    },
                    error: function() {
                        alert('An error occurred while saving receive details.');
                    }
                });
            } else {
                alert('No details to save.');
            }
        });


        $("#addColorCuffDetails").click(function() {
            var CMcategorytypeID = $('#CMcategorytype').val();
            var CMSupplierID = $('#CMSupplier').val();
            var CMColorcodeID = $('#CMColorcode').val();
            var CMcategorytype = $("#CMcategorytype option:selected").text();
            var CMSupplier = $("#CMSupplier option:selected").text();
            var CMColorcode = $("#CMColorcode option:selected").text();
            var CMOrderQuantity = parseFloat($('#CMOrderQuantity').val());
            var CMOrderDate = $('#CMOrderDate').val();

            if (!CMcategorytypeID || !CMSupplierID || !CMColorcodeID || !CMOrderQuantity || !CMOrderDate) {
                alert('Please fill in all fields.');
                return;  
            }

            $('#colorcufftable > tbody:last').append(
                '<tr class="pointer">' +
                '<td class="d-none">' + CMcategorytypeID + '</td>' + 
                '<td>' + CMcategorytype + '</td>' +  
                '<td class="d-none">' + CMSupplierID + '</td>' + 
                '<td>' + CMSupplier + '</td>' +    
                '<td class="d-none">' + CMColorcodeID + '</td>' + 
                '<td>' + CMColorcode + '</td>' +                                
                '<td>' + CMOrderQuantity + '</td>' +           
                '<td>' + CMOrderDate + '</td>' +                
                '</tr>'
            );

            $('#CMcategorytype').val('').trigger('change');    
            $('#CMSupplier').val('').trigger('change');
            $('#CMColorcode').val('').trigger('change');  
            $('#CMOrderDate').val('').trigger('change');  
            $('#CMOrderQuantity').val('');             
            $('#CMOrderDate').val('');                  
        });

        $("#btnSaveColorCuffDetails").click(function() {
            var CMremark = $('#CMremark').val();
            var colorcuffDetails = [];
            $('#colorcufftable tbody tr').each(function() {
                var row = $(this);
                var CMcategorytypeID = row.find('td:eq(0)').text();
                var CMSupplierID = row.find('td:eq(2)').text();
                var CMColorcodeID = row.find('td:eq(4)').text();
                var CMOrderQuantity = row.find('td:eq(6)').text();
                var CMOrderDate = row.find('td:eq(7)').text();

                colorcuffDetails.push({
                    CMcategorytypeID: CMcategorytypeID,
                    CMSupplierID: CMSupplierID,
                    CMColorcodeID: CMColorcodeID,
                    CMOrderQuantity: CMOrderQuantity,
                    CMOrderDate: CMOrderDate
                });
            });

            if (colorcuffDetails.length > 0) {
                $.ajax({
                    url: "<?php echo base_url() ?>CRMPrintingdetail/SavecolorcuffDetails",
                    type: 'POST',
                    data: {
                        colorcuffDetails: colorcuffDetails,
                        CMremark: CMremark,
                        inquiryid: $('#inquiryid').val()
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert('color/cuff details saved successfully!');
                            $('#ColorcuffModal').modal('hide');
                            $('#colorcufftable tbody').empty();
                        } else {
                            alert('Failed to save color/cuff details. Please try again.');
                        }
                    },
                    error: function() {
                        alert('An error occurred while saving color/cuff details.');
                    }
                });
            } else {
                alert('No details to save.');
            }
        });

        $('#dataTableAccepted').on('click', '.btnview', function() {
            var id = $(this).data('id');
            var customerid = $(this).data('customer');
            $('#inquiryid').val(id);

            $.ajax({
                url: "<?php echo base_url() ?>CRMPrintingdetail/Getorderdetails",
                type: 'POST',
                data: { inquiryid: id, customerid: customerid },
                dataType: 'json',
                success: function(data) {
                    var tableBody = $('#orderdetailtable tbody');
                    tableBody.empty();

                    if (data.order_details.length > 0) {
                        $('#customerName').html(data.customer_name);

                        data.order_details.forEach(function(orderDetail) {
                            var row = '<tr>' +
                                        '<td>' + orderDetail.cloth_type + '</td>' +
                                        '<td>' + orderDetail.printing_qty + '</td>' +
                                        '<td>' + orderDetail.printing_company + '</td>' +
                                        '<td>' + orderDetail.sewing_company + '</td>' +
                                        '<td>' + orderDetail.assigndate + '</td>' +
                                        '<td>' + orderDetail.design_type + '</td>' +
                                        '<td>' + orderDetail.remark + '</td>' +
                                    '</tr>';
                            tableBody.append(row);
                        });

                        $('#orderdet').modal('show');
                    } else {
                        alert('No order details found for this inquiry.');
                    }

                    var additionalTableBody = $('#additionalOrderTable tbody');
                    additionalTableBody.empty();

                    if (data.additional_details.length > 0) {
                        data.additional_details.forEach(function(detail) {
                            var cmCategoryType = (detail.CMcategorytypeID == 1) ? 'Color' : (detail.CMcategorytypeID == 2) ? 'Cuff' : 'Unknown';

                            var row = '<tr>' +
                                        '<td>' + cmCategoryType + '</td>' +
                                        '<td>' + detail.colorcuff_company + '</td>' +
                                        '<td>' + detail.colour + '</td>' +
                                        '<td>' + detail.CMOrderQuantity + '</td>' +
                                        '<td>' + detail.CMOrderDate + '</td>' +
                                        '<td>' + detail.CMremark + '</td>' +
                                    '</tr>';
                            additionalTableBody.append(row);
                        });

                        $('#additionalOrderTable').show();
                    } else {
                        alert('No additional details found for this inquiry.');
                    }
                },
                error: function() {
                    alert('An error occurred while fetching the details.');
                }
            });
        });

        $('#dataTableAccepted').on('click', '.receivebtnview', function() {
            var id = $(this).data('id');
            var customerid = $(this).data('customer');
            $('#inquiryid').val(id);

            $.ajax({
                url: "<?php echo base_url() ?>CRMPrintingdetail/GetReceiveorderInfoDetails",
                type: 'POST',
                data: { inquiryid: id, customerid: customerid },
                dataType: 'json',
                success: function(data) {
                    var orderTableBody = $('#receivedetailsinfotable tbody');
                    var colorCuffTableBody = $('#receivedcolorcuff tbody');
                    orderTableBody.empty();
                    colorCuffTableBody.empty();

                    if (data.received_order_details.length > 0) {
                        $('#ReceivecustomerName').html(data.customer_name);

                        data.received_order_details.forEach(function(orderDetail) {
                            if (orderDetail.printing_company !== null || orderDetail.sewing_company !== null) {
                                var row = '<tr>' +
                                            '<td>' + orderDetail.cloth_type + '</td>' +
                                            '<td>' + orderDetail.design_type + '</td>' +
                                            '<td>' + orderDetail.printing_company + '</td>' +
                                            '<td>' + orderDetail.sewing_company + '</td>' +
                                            '<td>' + orderDetail.received_qty + '</td>' +
                                            '<td>' + orderDetail.received_date + '</td>' +
                                        '</tr>';
                                orderTableBody.append(row);
                            }
                        });
                    }

                    if (data.received_colorcuff_details.length > 0) {
                        data.received_colorcuff_details.forEach(function(detail) {
                            var colorCuffMap = { "1": "color", "2": "cuff" };
                            var colorCuffText = colorCuffMap[detail.colorcuff] || 'Unknown';

                            if (colorCuffText !== 'Unknown' && detail.colorcuff_com) {
                                var row = '<tr>' +
                                            '<td>' + colorCuffText + '</td>' +
                                            '<td>' + detail.colorcuff_com + '</td>' +
                                            '<td>' + detail.received_qty + '</td>' +
                                            '<td>' + detail.received_date + '</td>' +
                                        '</tr>';
                                colorCuffTableBody.append(row);
                            }
                        });
                    }

                    $('#receivedetailsinfo').modal('show');
                },
                error: function() {
                    alert('An error occurred while fetching the details.');
                }
            });
        });


        $("#formsubmit").click(function() {
            if (!$("#createorderform")[0].checkValidity()) {

                $("#submitBtn").click();
            } else {
                var clothTypeID = $('#clothtype').val();
                var printingComID = $('#printingcompany').val();
                var sewingComID = $('#sewingcompany').val();
                var clothType = $("#clothtype option:selected").text();
                var printingCom = $("#printingcompany option:selected").text();
                var sewingCom = $("#sewingcompany option:selected").text();
                var quantity = parseFloat($('#quantity').val());
                var assigndate = $('#assigndate').val();
                var remark = $('#remark').val(); 
                var selectedDesigns = [];
                $('input[name="design[]"]:checked').each(function() {
                    selectedDesigns.push($(this).next('label').text());
                });
                var designText = selectedDesigns.join(', ');

                $('.selecter2').select2();

                $('#tableorder > tbody:last').append(
                    '<tr class="pointer">' +
                    '<td class="d-none">' + clothTypeID + '</td>' +
                    '<td>' + clothType + '</td>' +
                    '<td>' + quantity + '</td>' +
                    '<td class="d-none">' + printingComID + '</td>' +
                    '<td>' + printingCom + '</td>' +
                    '<td class="d-none">' + sewingComID + '</td>' +
                    '<td>' + sewingCom + '</td>' +
                    '<td>' + assigndate + '</td>' +                   
                    '<td>' + designText + '</td>' +
                    '</tr>'
                );

                $('#clothtype').val('').trigger('change');
                $('#printingcompany').val('').trigger('change');
                $('#sewingcompany').val('').trigger('change');
                $('#quantity').val('');
                $('#remark').val(''); 
                $('input[name="design[]"]').prop('checked', false);

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

                var clothTypeID = $('#clothtype').val();
                var printingComID = $('#printingcompany').val();
                var sewingComID = $('#sewingcompany').val();
                var quantity = parseFloat($('#quantity').val());
                var inquiryid = $('#inquiryid').val();
                var assigndate = $('#assigndate').val();
                var designText = $('#designText').val();
                var remark = $('#remark').val();

                formData.append('tableData', JSON.stringify(jsonObj)); 
                formData.append('inquiryid', inquiryid);
                formData.append('remark', remark);

                $.ajax({
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    url: '<?php echo base_url() ?>CRMPrintingdetail/Orderdetailinsertupdate',
                    success: function(result) {
                        var obj = result;//JSON.parse(result);
                        $('#Printingmodal').modal('hide');
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
