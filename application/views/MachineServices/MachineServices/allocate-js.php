<script type="text/javascript">
    var manageTable;
    var base_url = "<?php echo base_url(); ?>";


    $(document).ready(function() {

        $('#machine_services_main_nav_link').prop('aria-expanded', 'true').removeClass('collapsed');
        $('#collapseLayoutsMachineServices').addClass('show');

        $('#service_no').select2({
            placeholder: 'Select...',
            width: '100%',
            allowClear: true,
            dropdownParent: $('#addModal'),
            ajax: {
                url: base_url + 'MachineServices/get_service_no_select_id',
                dataType: 'json',
                data: function (params) {
                    return {
                        term: params.term || '',
                        page: params.page || 1
                    }
                },
                cache: true
            }
        });

        let colorTable = $('#colorTable').DataTable({
            searching: false, paging: false, info: false,
            "createdRow": function( row, data, dataIndex){
                if( data[3] == ''){
                    $(row).addClass('bg-success');
                }else {

                }
            }
        });

        $('#service_no').on('change', function() {
            var service_no = $(this).val();
            colorTable.clear();
            if (service_no) {
                $.ajax({
                    url: base_url + 'MachineServices/fetchMachineServicesDataById/'+service_no,
                    type: 'post',
                    dataType: 'json',
                    success:function(data) {

                        var op = data.sc_det;

                        $.each(op, function(key, value) {
                            let sp_id = value.sp_id;
                            let sp_name = value.sp_name;
                            let estimate_id = value.estimate_id;
                            let estimate_qty = value.estimate_qty;
                            let allocated_qty = value.allocated_qty;

                            let f = sp_name;

                            let pending_qty = estimate_qty - allocated_qty;

                            let sp_id_input = '<input type="hidden" name="sp_id[]" class="id" value="'+sp_id+'"/> ' + f + '';
                            let estimate_id_input = '<input type="hidden" name="estimate_id[]" class="id" value="'+estimate_id+'"/> ' + '';
                            let estimate_qty_input = '<input type="text" name="estimate_qty[]" readonly="true" class="form-control form-control-sm estimate_qty" value="'+estimate_qty+'" /> ';
                            let allocated_qty_input = '<input type="text" name="allocated_qty[]" readonly="true" class="form-control form-control-sm allocated_qty" value="'+allocated_qty+'" /> ';
                            let qty_input = '<input type="text" name="qty[]" class="form-control form-control-sm qty" value="'+pending_qty+'" /> ';

                            colorTable.row.add([
                                sp_id_input+estimate_id_input,
                                estimate_qty_input,
                                allocated_qty_input,
                                qty_input,
                                '<button type="button" class="btn btn-sm btn-danger btn-delete"><i class="fa fa-trash text-white"></i></button>'
                            ]).draw(false);

                        });

                        let main_data = data.main_data;

                        let html = "" +
                            "<div class=''>" +
                            "<table class=''>" +
                            "<tr>" +
                            "<td> <label> Machine Type </label> " + "</td>" +
                            "<td style='padding-left:15px'> "+ main_data.machine_type_name + "</td>" +
                            "</tr>" +
                            "<tr>" +
                            "<td> <label> Machine Serial No </label> " + "</td>" +
                            "<td style='padding-left:15px'> "+ main_data.s_no + "</td>" +
                            "</tr>" +
                            "</table> " +
                            "</div>";

                        $('.info').html(html);

                        $('#edit_colorTable tbody').on('click', '.btn-delete', function () {
                            colorTable.row($(this).parents('tr')).remove().draw();
                        });

                    }
                });

            }
        });

        $('#colorTable tbody').on('click', '.btn-delete', function () {
            colorTable.row($(this).parents('tr')).remove().draw();
        });

        $("#addModal").on("hide.bs.modal", function (e) {
            //hide viewModal
            colorTable.clear();
        });

        // initialize the datatable
        manageTable = $('#manageTable').DataTable({
            'ajax': base_url + 'MachineServices/fetchCategoryDataAllocate',
            'order': []
        });

        // submit the create from
        $("#createForm").unbind('submit').on('submit', function() {
            var form = $(this);

            // remove the text-danger
            $(".text-danger").remove();

            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                data: form.serialize(), // /converting the form data into array and sending it to server
                dataType: 'json',
                success:function(response) {

                    manageTable.ajax.reload(null, false);

                    if(response.success === true) {
                        $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                            '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
                            '</div>');

                        // hide the modal
                        $("#addModal").modal('hide');

                        // reset the form
                        $("#createForm")[0].reset();
                        $('#service_no').val('').trigger('change');
                        $("#createForm .form-group").removeClass('has-error').removeClass('has-success');

                    } else {

                        if(response.messages instanceof Object) {
                            $.each(response.messages, function(index, value) {
                                let id = $("#"+index);

                                if (index == 'service_no') {
                                    id = $("#service_no_error");
                                }

                                id.closest('.form-group')
                                    .removeClass('has-error')
                                    .removeClass('has-success')
                                    .addClass(value.length > 0 ? 'has-error' : 'has-success');

                                id.after(value);

                            });
                        } else {
                            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                                '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
                                '</div>');
                        }
                    }
                }
            });

            return false;
        });

    });

    // edit function
    function editFunc(id)
    {

        let colorTable = $('#edit_colorTable').DataTable({
            searching: false,
            paging: false,
            info: false,
            destroy:true
        });

        colorTable.clear().draw();

        $.ajax({
            url: base_url + 'MachineServices/fetchAllocatedServiceItems/'+id,
            type: 'post',
            dataType: 'json',
            success:function(data) {

                var op = data.ac;

                $.each(op, function(key, value) {
                    let sp_id = value.id;
                    let sp_name = value.name;
                    let part_no = value.part_no;
                    let allocate_id = value.allocate_id;
                    let estimated_qty = value.estimated_qty;
                    let qty = value.qty;

                    let f = sp_name + ' - ' + part_no ;


                    let sp_id_input = '<input type="hidden" name="sp_id[]" class="id" value="'+sp_id+'"/> ' + f + '';
                    let allocate_id_input = '<input type="hidden" name="allocate_id[]" class="id" value="'+allocate_id+'"/> '  + '';
                    let qty_input = '<input type="text" name="qty[]" class="form-control form-control-sm qty" value="'+qty+'" /> ';
                    let estimate_qty_input = '<input type="text" name="estimate_qty[]" readonly="true" class="form-control form-control-sm estimate_qty" value="'+estimated_qty+'" /> ';

                    colorTable.row.add([
                        sp_id_input+allocate_id_input,
                        estimate_qty_input,
                        qty_input,
                        '<button type="button" class="btn btn-sm btn-danger btn-delete-edit" data-id="" onclick="removeFunc('+allocate_id+')" data-toggle="modal" data-target="#removeModal" ><i class="fa fa-trash text-white"></i></button>'
                    ]).draw(false);

                });


                let machine_type_name = data.main_data.service_no;
                $('#service_no_span').html(machine_type_name);

                $('#edit_colorTable tbody').on('click', '.btn-delete', function () {
                    colorTable.row($(this).parents('tr')).remove().draw();
                });

                // submit the edit from
                $("#updateForm").unbind('submit').bind('submit', function() {
                    var form = $(this);

                    // remove the text-danger
                    $(".text-danger").remove();

                    $.ajax({
                        url: form.attr('action') + '/' + id,
                        type: form.attr('method'),
                        data: form.serialize(), // /converting the form data into array and sending it to server
                        dataType: 'json',
                        success:function(response) {

                            manageTable.ajax.reload(null, false);

                            if(response.success === true) {
                                $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                                    '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
                                    '</div>');

                                // hide the modal
                                $("#editModal").modal('hide');
                                // reset the form
                                $("#updateForm .form-group").removeClass('has-error').removeClass('has-success');

                            } else {

                                if(response.messages instanceof Object) {
                                    $.each(response.messages, function(index, value) {
                                        var id = $("#"+index);
                                        // if (index == 'edit_service_no') {
                                        //     id = $("#edit_estimated_service_items_error");
                                        // }

                                        id.closest('.form-group')
                                            .removeClass('has-error')
                                            .removeClass('has-success')
                                            .addClass(value.length > 0 ? 'has-error' : 'has-success');

                                        id.after(value);

                                    });
                                } else {
                                    $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
                                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                                        '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
                                        '</div>');
                                }
                            }
                        }
                    });

                    return false;
                });

            }
        });

        $("#removeModal").on("hide.bs.modal", function (e) {
            //hide viewModal
            $('#editModal').modal('show');
        });

        $("#removeModal").on("show.bs.modal", function (e) {
            //hide viewModal
            $('#editModal').modal('hide');
        });

    }

    // remove functions
    function removeFunc(id)
    {
        if(id) {
            $("#removeForm").on('submit', function() {

                var form = $(this);

                // remove the text-danger
                $(".text-danger").remove();

                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: { id:id },
                    dataType: 'json',
                    success:function(response) {

                        let service_id = response.service_id;
                        editFunc(service_id);

                        //manageTable.ajax.reload(null, false);
                        // hide the modal
                        $("#removeModal").modal('hide');

                        if(response.success === true) {
                            $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                                '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
                                '</div>');


                        } else {

                            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                                '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
                                '</div>');
                        }
                    }
                });

                return false;
            });
        }
    }

    function viewFunc(id)
    {
        $.ajax({
            url: base_url + 'MachineServices/fetchAllocatedServiceItems/'+id,
            type: 'post',
            dataType: 'json',
            success:function(data) {
                let res_table = "<div class='table-responsive mt-3'>";
                res_table += '<table class="table table-striped table-sm" id="viewTable">';
                let res_tr = '<thead><tr><th>Service Item</th> <th> Estimated Quantity </th> <th>Allocated Quantity</th> <th>Unit Price</th> </tr></thead> <tbody>';
                let response = data.sc_det;
                let total = 0;
                $.each(response, function(index, value) {
                    res_tr += '<tr>' +
                        '<td>' + value.sp_name + '</td>' +
                        '<td>' + value.estimate_qty + '</td>' +
                        '<td>' + value.allocated_qty + '</td>' +
                        '<td style="text-align: right">' + value.unit_price + '</td>' +
                        '</tr>';
                    total += (parseFloat(value.allocated_qty)) * ( parseFloat(value.unit_price));
                });

                res_table += res_tr + '</tbody> ';

                res_table += '<tfoot>';
                res_table += '<tr> ' +
                    '<td> </td>' +
                    '<td> </td>' +
                    '<th style="text-align: right"> Total </th>' +
                    '<th style="text-align: right"> '+ total.toFixed(2) +' </th>' +
                    '</tr>';
                res_table += '</tfoot>';

                res_table += '</table>';
                res_table += '</div> <hr>' +
                    '<h4> Allocate Records </h4>';

                res_table += "<div class='table-responsive mt-3'>" +
                    " ";
                res_table += '<table class="table table-striped table-sm" id="viewTable">';
                let res_tr1 = '<thead><tr><th>Service Item</th> <th> Allocated Quantity </th> <th>Unit Price</th> <th>Allocated At</th>  </tr></thead> <tbody>';
                let response1 = data.ac;
                $.each(response1, function(index, value) {
                    res_tr1 += '<tr>' +
                        '<td>' + value.name + ' - ' + value.part_no + '</td>' +
                        '<td>' + value.qty + '</td>' +
                        '<td>' + value.unit_price + '</td>' +
                        '<td>' + value.created_at + '</td>' +
                        '</tr>';
                });
                res_table += res_tr1 + '</tbody> ';
                res_table += '</table>';
                res_table += '</div>';

                let machine_type_name = data.main_data.service_no;
                $('#machine_type_name').html(machine_type_name);

                $("#viewModal .modal-body #viewResponse").html(res_table);
                $('#viewTable').DataTable();

            }
        });
    }


</script>