<script>
    var dt;
    $(document).ready(function() {

        $('#crm_main_nav_link').prop('aria-expanded', 'true').removeClass('collapsed');
        $('#collapseCRM').addClass('show');


        var addcheck = '<?php echo (in_array('createCRMInquiry', $user_permission)) ? 1 : 0; ?>';
        var editcheck = '<?php echo (in_array('updateCRMInquiry', $user_permission)) ? 1 : 0; ?>';
        var statuscheck = '<?php echo (in_array('updateCRMInquiry', $user_permission) || in_array('deleteCRMInquiry', $user_permission)) ? 1 : 0; ?>';
        var deletecheck = '<?php echo (in_array('deleteCRMInquiry', $user_permission)) ? 1 : 0; ?>';

        $('#submitlist').click(function() {
            if (!$("#grnform")[0].checkValidity()) {
                $("#submitBtn").click();
            } else {
                var customernameid = $('#customername').val();
                var customername = $('#customername option:selected').text();
                var itemId = $('#item').val();
                var item = $('#item option:selected').text();
                var quantity = $('#quantity').val();
                var d_date = $('#d_date').val();
                var date = $('#date').val();
                var bg_length = $('#bg_length').val();
                var bg_width = $('#bg_width').val();
                var liner_size =$('#liner_size').val();
                var liner_color = $('#liner_color').val();
                var bg_weight = $('#bg_weight').val();
                var ln_weight =$('#ln_weight').val();
                var inner_bag = $('#inner_bag').is(':checked') ? 'Yes' : 'No'; 
                var off_print = $('#off_print').is(':checked') ? 'Yes' : 'No'; 
                var printing_type = $('#printing_type').val();
                var col_no = $('#col_no').val();

                $('#dataTable > tbody:last').append(
                    '<tr><td>' + customername +
                    '<td class="d-none">' + itemId + '</td>' +
                    '</td><td>' + item +
                    '</td><td>' + quantity +
                    '</td><td>' + d_date +
                    '</td><td>' + date +
                    '</td><td>' + bg_length +
                    '</td><td>' + bg_width +
                    '</td><td>' + liner_size +
                    '</td><td>' + liner_color +
                    '</td><td>' + bg_weight +
                    '</td><td>' + ln_weight +
                    '</td><td>' + inner_bag +
                    '</td><td>' + off_print +
                    '</td><td>' + printing_type +
                    '</td><td>' + col_no +
                    '</td><td class="text-right"><button type="button" class="btn btn-danger btn-sm remove-row">Remove</button></td></tr>');

                //$('#customername').val(null).trigger('change');
                // $('#item').val('');
                $('#quantity').val('');
                $('#bg_length').val('');
                $('#bg_width').val('');
                $('#liner_size').val('');
                $('#liner_color').val('');
                $('#bg_weight').val('');
                $('#ln_weight').val('');
                $('#inner_bag').prop('checked', false);
                $('#off_print').prop('checked', false);
                $('#printing_type').val('');
                $('#col_no').val('');

            }
        });

        $('#submitdata').click(function() {
            var tableData = [];
            $('#dataTable tbody tr').each(function() {
                var row = {
                    tbl_customer_idtbl_customer: $('#customername').val(),
                    itemId: $(this).find('td:eq(1)').text(),
                    date: $(this).find('td:eq(5)').text(),
                    quantity: $(this).find('td:eq(3)').text(),
                    d_date: $(this).find('td:eq(4)').text(),
                    bag_length: $(this).find('td:eq(6)').text(),
                    bag_width: $(this).find('td:eq(7)').text(),
                    liner_size: $(this).find('td:eq(8)').text(),
                    liner_color: $(this).find('td:eq(9)').text(),
                    bg_weight: $(this).find('td:eq(10)').text(),
                    ln_weight: $(this).find('td:eq(11)').text(),
                    inner_bag: $(this).find('td:eq(12)').text() === 'Yes' ? true : false,
                    off_print: $(this).find('td:eq(13)').text() === 'Yes' ? true : false,
                    printing_type: $(this).find('td:eq(14)').text(),
                    colour_no: $(this).find('td:eq(15)').text()
                };
               
                  tableData.push(row);
            // console.log(row);
            });

            if (tableData.length === 0) {
                alert("Please add items to the list before submitting.");
                return;
            }

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url("CRMInquiry/Inquiryinsertupdate"); ?>',
                data: { data: tableData },
                dataType: 'json',
                success: function(data) {
                    if(data.success){
                        location.reload();
                    }else{
                        alert('Error');
                    }
                }
            });
        });

        $(document).on("click", ".btnView", function(){
        var inquiryId = $(this).data('id');
        $("#hinquiry_id").val(inquiryId);
            dt.ajax.reload();

        $('#inquiryDetailsModal').modal('show');
});

        
        $('#inquiryTable').DataTable({          
            "destroy": true,
            "processing": true,
            "serverSide": true,
            //dom: "<'row'<'col-sm-5'B><'col-sm-2'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            responsive: true,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            ajax: {
                url: "<?php echo base_url() ?>scripts/inquirylist.php",
                type: "POST", // you can use GET
                // data: function(d) {}
            },
            "order": [[ 0, "desc" ]],
            "columns": [
                {
                    "data": "idtbl_inquiry"
                },
                {
                    "data": "name"
                },
                {
                    "data": "date"
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function(data, type, full) {
                        var button = '';
                        button += '<button class="btn btn-primary btn-sm btnView mr-1" data-id="' + full['idtbl_inquiry'] + '"><i class="fas fa-eye"></i></button>';
                        if (full['status'] == 1) {
                            button += '<a href="<?php echo base_url() ?>CRMInquiry/Inquirystatus/' + full['idtbl_inquiry'] + '/2" onclick="return deactive_confirm()" target="_self" class="btn btn-success btn-sm mr-1"><i class="fas fa-check"></i></a>';
                        } else {
                            button += '<a href="<?php echo base_url() ?>CRMInquiry/Inquirystatus/' + full['idtbl_inquiry'] + '/1" onclick="return active_confirm()" target="_self" class="btn btn-warning btn-sm mr-1"><i class="fas fa-times"></i></a>';
                        }
                        button += '<a href="<?php echo base_url() ?>CRMInquiry/Inquirystatus/' + full['idtbl_inquiry'] + '/3" onclick="return delete_confirm()" target="_self" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a>';
                        
                        return button;
                    }
                }
            ],
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
        var dt;
$(document).ready(function () {
    dt = $('#inquiryDetailsTable').DataTable({
        "processing": true,
        "serverSide": true,
        "destroy": true, // Consider removing this if reinitializing is unnecessary
        dom: "<'row'<'col-sm-5'B><'col-sm-2'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        responsive: true,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'All']],
        buttons: [
            { extend: 'csv', className: 'btn btn-success btn-sm', title: 'Inquiry Detail Information', text: '<i class="fas fa-file-csv mr-2"></i> CSV' },
            { extend: 'pdf', className: 'btn btn-danger btn-sm', title: 'Inquiry Detail Information', text: '<i class="fas fa-file-pdf mr-2"></i> PDF' },
            { 
                extend: 'print', className: 'btn btn-primary btn-sm', title: 'Inquiry Detail Information', 
                text: '<i class="fas fa-print mr-2"></i> Print',
                customize: function (win) {
                    $(win.document.body).find('table').addClass('compact').css('font-size', 'inherit');
                }
            }
        ],
        ajax: {
            url: "<?php echo base_url() ?>scripts/inquirydetaillist.php",
            type: "POST",
            data: function (d) {
                var inquiryId = $('#hinquiry_id').val();
                    d.id = inquiryId;
            }
        },
        "order": [[0, "desc"]],
        "columns": [
            { "data": "idtbl_inquiry_detail" },
            { "data": "item" },
            { "data": "quantity" },
            { "data": "d_date" },
            { "data": "date" },
            { "data": "bag_length" },
            { "data": "bag_width" },
            { "data": "liner_size" },
            { "data": "liner_color" },
            { "data": "bg_weight" },
            { "data": "ln_weight" },
            { 
                "data": "inner_bag",
                "render": function (data) {
                    return data == 1 ? 'Yes' : 'No';
                }
            },
            { 
                "data": "off_print",
                "render": function (data) {
                    return data == 1 ? 'Yes' : 'No';
                }
            },
            { "data": "printing_type" },
            { "data": "colour_no" },
            {
                "targets": -1,
                "className": 'text-right',
                "data": null,
                "render": function (data, type, full) {
                    var button = '';
                    if (full['status'] == 1) {
                        button += '<a href="<?php echo base_url() ?>CRMInquiry/Inquirydetailstatus/' + full['idtbl_inquiry_detail'] + '/2" onclick="return deactive_confirm()" class="btn btn-success btn-sm mr-1 ' + (typeof statuscheck !== "undefined" && statuscheck != 1 ? 'd-none' : '') + '"><i class="fas fa-check"></i></a>';
                    } else {
                        button += '<a href="<?php echo base_url() ?>CRMInquiry/Inquirydetailstatus/' + full['idtbl_inquiry_detail'] + '/1" onclick="return active_confirm()" class="btn btn-warning btn-sm mr-1 ' + (typeof statuscheck !== "undefined" && statuscheck != 1 ? 'd-none' : '') + '"><i class="fas fa-times"></i></a>';
                    }
                    button += '<a href="<?php echo base_url() ?>CRMInquiry/Inquirydetailstatus/' + full['idtbl_inquiry_detail'] + '/3" onclick="return delete_confirm()" class="btn btn-danger btn-sm ' + (typeof deletecheck !== "undefined" && deletecheck != 1 ? 'd-none' : '') + '"><i class="fas fa-trash-alt"></i></a>';
                    return button;
                }
            }
        ],
        drawCallback: function (settings) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
});


        $('#dataTable').on('click', '.remove-row', function() {
            $(this).closest('tr').remove();
        });

        document.getElementById('off_print').addEventListener('change', function() {
        this.value = this.checked ? "true" : "false";
        });
        // Function to submit all data

    });


    function deactive_confirm() {
        return confirm("Are you sure you want to deactivate this?");
    }

    function active_confirm() {
        return confirm("Are you sure you want to activate this?");
    }

    function delete_confirm() {
        return confirm("Are you sure you want to remove this?");
    }
</script>
