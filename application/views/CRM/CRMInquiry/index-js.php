<script>
    $(document).ready(function() {
        var addcheck = '<?php echo (in_array('createCRMInquiry', $user_permission)) ? 1 : 0; ?>';
        var editcheck = '<?php echo (in_array('updateCRMInquiry', $user_permission)) ? 1 : 0; ?>';
        var statuscheck = '<?php echo (in_array('updateCRMInquiry', $user_permission) || in_array('deleteCRMInquiry', $user_permission)) ? 1 : 0; ?>';
        var deletecheck = '<?php echo (in_array('deleteCRMInquiry', $user_permission)) ? 1 : 0; ?>';

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
                            button += '<a href="<?php echo base_url() ?>Inquiry/Inquirystatus/' + full['idtbl_inquiry'] + '/2" onclick="return deactive_confirm()" target="_self" class="btn btn-success btn-sm mr-1"><i class="fas fa-check"></i></a>';
                        } else {
                            button += '<a href="<?php echo base_url() ?>Inquiry/Inquirystatus/' + full['idtbl_inquiry'] + '/1" onclick="return active_confirm()" target="_self" class="btn btn-warning btn-sm mr-1"><i class="fas fa-times"></i></a>';
                        }
                        button += '<a href="<?php echo base_url() ?>Inquiry/Inquirystatus/' + full['idtbl_inquiry'] + '/3" onclick="return delete_confirm()" target="_self" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a>';
                        
                        return button;
                    }
                }
            ],
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });

        var dt=$('#inquiryDetailsTable').DataTable( {
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
                { extend: 'csv', className: 'btn btn-success btn-sm', title: 'Inquiry Detail Information', text: '<i class="fas fa-file-csv mr-2"></i> CSV', },
                { extend: 'pdf', className: 'btn btn-danger btn-sm', title: 'Inquiry Detail Information', text: '<i class="fas fa-file-pdf mr-2"></i> PDF', },
                { 
                    extend: 'print', 
                    title: 'Inquiry Detail Information',
                    className: 'btn btn-primary btn-sm', 
                    text: '<i class="fas fa-print mr-2"></i> Print',
                    customize: function ( win ) {
                        $(win.document.body).find( 'table' )
                            .addClass( 'compact' )
                            .css( 'font-size', 'inherit' );
                    }, 
                },
                // 'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            ajax: {
                url: "<?php echo base_url() ?>scripts/inquirydetaillist.php",
                type: "POST", // you can use GET
                data: function(d) {d.id=$('#hinquiry_id').val();}
            },
            "order": [[ 0, "desc" ]],
            "columns": [
                {
                    "data": "tbl_inquiry_idtbl_inquiry"
                },
                {
                    "data": "sname"
                },
                {
                    "data": "type"
                },
                {
                    "data": "mattype"
                },
                {
                    "data": "quantity"
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function(data, type, full) {
                        var button = '';
                        //button+='<button class="btn btn-primary btn-sm btnEdit mr-1 ';if(editcheck!=1){button+='d-none';}button+='" id="'+full['idtbl_inquiry_detail']+'"><i class="fas fa-pen"></i></button>';
                        if(full['status']==1){
                            button+='<a href="<?php echo base_url() ?>Inquiry/Inquirydetailstatus/'+full['idtbl_inquiry_detail']+'/2" onclick="return deactive_confirm()" target="_self" class="btn btn-success btn-sm mr-1 ';if(statuscheck!=1){button+='d-none';}button+='"><i class="fas fa-check"></i></a>';
                        }else{
                            button+='<a href="<?php echo base_url() ?>Inquiry/Inquirydetailstatus/'+full['idtbl_inquiry_detail']+'/1" onclick="return active_confirm()" target="_self" class="btn btn-warning btn-sm mr-1 ';if(statuscheck!=1){button+='d-none';}button+='"><i class="fas fa-times"></i></a>';
                        }
                        button+='<a href="<?php echo base_url() ?>Inquiry/Inquirydetailstatus/'+full['idtbl_inquiry_detail']+'/3" onclick="return delete_confirm()" target="_self" class="btn btn-danger btn-sm ';if(deletecheck!=1){button+='d-none';}button+='"><i class="fas fa-trash-alt"></i></a>';
                        
                        return button;
                    }
                }
            ],
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
        
        $(document).on("click", ".btnView", function(){
            var inquiryId = $(this).data('id');
            $("#hinquiry_id").val(inquiryId);
            dt.ajax.reload();
            $('#inquiryDetailsModal').modal('show');

        });
        $('#submitlist').click(function() {
            if (!$("#grnform")[0].checkValidity()) {
                $("#submitBtn").click();
            } else {
                var customernameid = $('#customername').val();
                var customername = $('#customername option:selected').text();
                var salesrepnameid = $('#salesrepname').val();
                var salesrepname = $('#salesrepname option:selected').text();
                var clothtypeid = $('#clothtype').val();
                var clothtype = $('#clothtype option:selected').text();   
                var materialtypeid = $('#materialtype').val();
                var materialtype = $('#materialtype option:selected').text();
                var quantity = $('#quantity').val();
                var date = $('#date').val();

                $('#dataTable > tbody:last').append('<tr><td>' + customername +
                    '</td><td>' + salesrepname +
                    '</td><td>' + date +
                    '</td><td data-id="'+clothtypeid+'">' + clothtype +
                    '</td><td data-id="'+materialtypeid+'">' + materialtype +
                    '</td><td data-id="">' + quantity +
                    '</td><td class="text-right"><button type="button" class="btn btn-danger btn-sm remove-row">Remove</button></td></tr>');

                // Clear the form fields except customer name and date
                $('#clothtype').val(null).trigger('change');
                $('#materialtype').val(null).trigger('change');
                $('#quantity').val('');
            }
        });

        $('#dataTable').on('click', '.remove-row', function() {
            $(this).closest('tr').remove();
        });

        // Function to submit all data
        $('#submitdata').click(function() {
            var tableData = [];
            $('#dataTable tbody tr').each(function() {
                var row = {
                    tbl_customer_idtbl_customer: $('#customername').val(),
                    tbl_salesrep_idtbl_salesrep: $('#salesrepname').val(),
                    date: $('#date').val(),
                    tbl_cloth_idtbl_cloth: $(this).find('td:eq(3)').data('id'),
                    tbl_material_idtbl_material: $(this).find('td:eq(4)').data('id'),
                    quantity: $(this).find('td:eq(5)').text()
                };
                tableData.push(row);
            });

            if (tableData.length === 0) {
                alert("Please add items to the list before submitting.");
                return;
            }

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url("Inquiry/Inquiryinsertupdate"); ?>',
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
