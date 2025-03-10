<script>
    $(document).ready(function() {

        $('#crm_main_nav_link').prop('aria-expanded', 'true').removeClass('collapsed');
        $('#collapseCRM').addClass('show');
        
        var addcheck = '<?php echo (in_array('createCRMQuotation', $user_permission)) ? 1 : 0; ?>';
        var editcheck = '<?php echo (in_array('updateCRMQuotation', $user_permission)) ? 1 : 0; ?>';
        var statuscheck = '<?php echo (in_array('updateCRMQuotation', $user_permission) || in_array('deleteCRMQuotation', $user_permission)) ? 1 : 0; ?>';
        var deletecheck = '<?php echo (in_array('deleteCRMQuotation', $user_permission)) ? 1 : 0; ?>';


        $('#dataTable').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "responsive": true,
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
                url: "<?php echo base_url() ?>scripts/quotationlist.php",
                type: "POST", // you can use GET
                data: function(d) {
                    d.userID = '<?php echo $_SESSION['id']; ?>';

                }
            },
            "order": [
                [0, "desc"]
            ],
            "columns": [{
                    "data": function(data, type, full) {
                        return "INQ-" + data.idtbl_inquiry;
                    }
                },
                {
                    "data": "name"
                },
                {
                    "data": "date"
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
                        button += '<button class="btn btn-primary btn-sm btnview mr-1" id="' + full['idtbl_inquiry'] + '" data-toggle="tooltip" data-placement="bottom" title="Inquiry Details"><i class="fas fa-eye"></i></button>';
                        button += '<a href="<?php echo base_url() ?>CRMQuotationform/Getquotation/' + full['idtbl_inquiry'] + '/' + full['idtbl_customer'] + '" class="btn btn-success btn-sm btnquotation mr-1" data-toggle="tooltip" data-placement="bottom" title="Create Quotation"><i class="fas fa-list"></i></a>';


                        return button;
                    }
                }
            ],
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });

        $('#dataTable tbody').on('click', '.btnquotation', function() {
            var idtbl_inquiry = $(this).attr('id');

            // Redirect to Quotation form with the idtbl_inquiry parameter
            // window.location.href = "<?php echo base_url() ?>CRMQuotationform?idtbl_inquiry=" + idtbl_inquiry;
        });

        $('#dataTable tbody').on('click', '.btnview', function() {
            var id = $(this).attr('id')
          //  alert(id);
            $('#inquirydetail').modal('show');

            $('#dataTableInquiryDetail').DataTable({
                "destroy": true,
                "processing": true,
                "serverSide": true,
                responsive: true,
                dom: "<'row'<'col-sm-5'B><'col-sm-2'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                responsive: true,
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, 'All'],
                ],
                "buttons": [{
                        extend: 'csv',
                        className: 'btn btn-success btn-sm',
                        title: 'Inquiry Details Information',
                        text: '<i class="fas fa-file-csv mr-2"></i> CSV',
                    },
                    {
                        extend: 'pdf',
                        className: 'btn btn-danger btn-sm',
                        title: 'Inquiry Details Information',
                        text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
                    },
                    {
                        extend: 'print',
                        title: 'Inquiry Details Information',
                        className: 'btn btn-primary btn-sm',
                        text: '<i class="fas fa-print mr-2"></i> Print',
                        customize: function(win) {
                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        },
                    },
                ],
                ajax: {
                    url: "<?php echo base_url() ?>scripts/inquirydetaillist.php",
                    type: "POST",
                    data: function(d) {
                        d.userID = '<?php echo $_SESSION['id']; ?>';
                        d.id = id;
                       // console.log(id);
                    }
                },
                "order": [
                    [0, "desc"]
                ],
                "columns": [
                    { "data": "idtbl_inquiry_detail" },
                    { "data": "item" },
                    { "data": "quantity" },
                    { "data": "d_date" },
                    { "data": "date" },
                    { "data": "bag_length" },
                    { "data": "bag_width" },
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
                ],
                drawCallback: function(settings) {
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });
        });
        // $('#dataTable tbody').on('click', '.btnquotation', function() {
        //     var idtbl_inquiry = $(this).attr('id');
        //     alert(id);
        //     $.ajax({
        // 		type: "POST",
        // 		data: {
        // 			idtbl_inquiry: idtbl_inquiry	
        // 		},
        // 		url: 'Quotationform/Quotationforminsertupdate',
        // 		success: function(result) { //alert(result);

        // 		}
        // 	});

        // });

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
