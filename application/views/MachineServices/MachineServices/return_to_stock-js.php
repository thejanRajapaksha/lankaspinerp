<script type="text/javascript">
    var manageTable;
    var base_url = "<?php echo base_url(); ?>";


    $(document).ready(function () {

        $('#return_main_nav_link').prop('aria-expanded', 'true').removeClass('collapsed');
        $('#collapseLayoutsReturn').addClass('show');

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
        });

        $('#service_no').on('change', function () {
            var service_no = $(this).val();
            colorTable.clear().draw();
            if (service_no) {
                $.ajax({
                    url: base_url + 'MachineServices/fetchMachineServicesDataById/' + service_no,
                    type: 'post',
                    dataType: 'json',
                    success: function (data) {

                        var op = data.re_det;

                        $.each(op, function (key, value) {
                            let sp_id = value.sp_id;
                            let sp_name = value.sp_name;
                            let issue_id = value.issue_id;
                            let issued_qty = value.issued_qty;
                            let returned_qty = value.returned_qty;

                            let f = sp_name;

                            let pending_qty = 1;


                            let sp_id_input = '<input type="hidden" name="sp_id[]" class="id" value="' + sp_id + '"/> ' + f + '';
                            let issue_id_input = '<input type="hidden" name="issue_id[]" class="id" value="' + issue_id + '"/> ' + '';
                            let issued_qty_input = '<input type="text" name="issued_qty[]" readonly="true" class="form-control form-control-sm issued_qty" value="' + issued_qty + '" /> ';
                            let returned_qty_input = '<input type="text" name="received_qty[]" readonly="true" class="form-control form-control-sm received_qty" value="' + returned_qty + '" /> ';
                            let qty_input = '<input type="text" name="qty[]" class="form-control form-control-sm qty" value="' + pending_qty + '" /> ';

                            colorTable.row.add([
                                sp_id_input + issue_id_input,
                                issued_qty_input,
                                returned_qty_input,
                                qty_input,
                                '<button type="button" class="btn btn-sm btn-danger btn-delete"><i class="fa fa-trash text-white"></i></button>'
                            ]).draw(false);

                        });

                        if (op == '') {
                            colorTable.clear().draw()
                        }

                        let main_data = data.main_data;

                        let html = "" +
                            "<div class=''>" +
                            "<table class=''>" +
                            "<tr>" +
                            "<td> <label> Machine Type </label> " + "</td>" +
                            "<td style='padding-left:15px'> " + main_data.machine_type_name + "</td>" +
                            "</tr>" +
                            "<tr>" +
                            "<td> <label> Machine Serial No </label> " + "</td>" +
                            "<td style='padding-left:15px'> " + main_data.s_no + "</td>" +
                            "</tr>" +
                            "</table> " +
                            "</div>";

                        $('.info').html(html);

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
            'ajax': base_url + 'MachineServices/fetchCategoryDataReturnToStock',
            'order': []
        });

        // submit the create from
        $("#createForm").unbind('submit').on('submit', function () {
            var form = $(this);

            // remove the text-danger
            $(".text-danger").remove();

            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                data: form.serialize(), // /converting the form data into array and sending it to server
                dataType: 'json',
                success: function (response) {

                    manageTable.ajax.reload(null, false);

                    if (response.success === true) {
                        $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                            '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>' + response.messages +
                            '</div>');

                        // hide the modal
                        $("#addModal").modal('hide');

                        // reset the form
                        $("#createForm")[0].reset();
                        $('#service_no').val('').trigger('change');
                        $("#createForm .form-group").removeClass('has-error').removeClass('has-success');

                    } else {

                        if (response.messages instanceof Object) {
                            $.each(response.messages, function (index, value) {
                                let id = $("#" + index);

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
                            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                                '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>' + response.messages +
                                '</div>');
                        }
                    }
                }
            });

            return false;
        });

        $(document).on("click", ".btn_accept", function (e) {
            e.preventDefault()
            let service_id = $(this).data('service_id');

            let colorTable = $('#colorTable2').DataTable({
                searching: false,
                paging: false,
                info: false,
                destroy: true
            });

            $.ajax({
                url: base_url + 'MachineServices/fetchMachineServicesDataById/' + service_id,
                type: 'post',
                dataType: 'json',
                success: function (data) {

                    var op = data.ac_det;

                    $.each(op, function (key, value) {
                        let sp_id = value.sp_id;
                        let sp_name = value.sp_name;
                        let return_id = value.return_id;
                        let returned_qty = value.returned_qty;
                        let accepted_qty = value.accepted_qty;

                        let f = sp_name;

                        let pending_qty = 1;


                        let sp_id_input = '<input type="hidden" name="sp_id[]" class="id" value="' + sp_id + '"/> ' + f + '';
                        let return_id_input = '<input type="hidden" name="return_id[]" class="id" value="' + return_id + '"/> ' + '';
                        let accepted_qty_input = '<input type="text" name="accepted_qty[]" readonly="true" class="form-control form-control-sm issued_qty" value="' + accepted_qty + '" /> ';
                        let returned_qty_input = '<input type="text" name="returned_qty[]" readonly="true" class="form-control form-control-sm received_qty" value="' + returned_qty + '" /> ';
                        let qty_input = '<input type="text" name="qty[]" class="form-control form-control-sm qty" value="' + pending_qty + '" /> ';

                        colorTable.row.add([
                            sp_id_input + return_id_input,
                            returned_qty_input,
                            accepted_qty_input,
                            qty_input,
                            '<button type="button" class="btn btn-sm btn-danger btn-delete"><i class="fa fa-trash text-white"></i></button>'
                        ]).draw(false);

                    });

                    let machine_type_name = data.main_data.service_no;
                    $('#accept_machine_type_name').html(machine_type_name);
                    $('#accept_service_id').val(data.main_data.id);

                }
            });

        });

        $("#acceptForm").unbind('submit').on('submit', function () {
            var form = $(this);

            // remove the text-danger
            $(".text-danger").remove();

            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                data: form.serialize(), // /converting the form data into array and sending it to server
                dataType: 'json',
                success: function (response) {

                    manageTable.ajax.reload(null, false);

                    if (response.success === true) {
                        $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                            '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>' + response.messages +
                            '</div>');

                        // hide the modal
                        $("#acceptModal").modal('hide');

                        // reset the form
                        $("#acceptForm")[0].reset();
                        $("#acceptForm .form-group").removeClass('has-error').removeClass('has-success');

                    } else {

                        if (response.messages instanceof Object) {
                            $.each(response.messages, function (index, value) {
                                let id = $("#" + index);

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
                            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                                '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>' + response.messages +
                                '</div>');
                        }
                    }
                }
            });

            return false;
        });

    });

    // edit function
    function editFunc(id) {
        $.ajax({
            url: base_url + 'MachineServices/fetchReturnedServiceItems/' + id,
            type: 'post',
            dataType: 'json',
            success: function (data) {

                let html = "";
                let head_det = data.head_det;

                $.each(head_det, function (key, value) {
                    html += "<div class='card mt-3'>";
                    html += "<div class='card-body'>";
                    html += "<h4> Returned Items </h4>";
                    html += "<div class='table-responsive'> ";
                    html += "<table class='table table-sm'>";
                    html += "<thead>" +
                        " <tr> " +
                        "<th> Item </th>" +
                        " <th> Return QTY </th>  " +
                        " <th> </th>  " +
                        "</tr> " +
                        "</thead>";
                    html += "<tbody>";

                    let sc = value.sc;
                    let header_id = value.header_id;
                    let remarks = value.remarks;
                    $.each(sc, function (key1, value1) {

                        let sp_id = value1.id;
                        let sp_name = value1.name;
                        let part_no = value1.part_no;
                        let returned_id = value1.return_id;
                        // let returned_qty = value1.returned_qty;
                        let qty = value1.qty;

                        let f = sp_name + ' - ' + part_no;

                        let sp_id_input = '<input type="hidden" name="sp_id[]" class="id" value="' + sp_id + '"/> ' + f + '';
                        let return_id_input = '<input type="hidden" name="return_id[]" class="id" value="' + returned_id + '"/> ' + '';
                        let qty_input = '<input type="text" name="qty[]" class="form-control form-control-sm qty" value="' + qty + '" /> ';
                        // let returned_qty_input = '<input type="text" name="return_qty[]" readonly="true" class="form-control form-control-sm issued_qty" value="'+returned_qty+'" /> ';

                        let btn = '<button type="button" class="btn btn-sm btn-danger btn-delete-edit" data-id="" onclick="removeFunc(' + returned_id + ')" data-toggle="modal" data-target="#removeModal" ><i class="fa fa-trash text-white"></i></button>';

                        html += '<tr>';
                        html += '<td> ' + sp_id_input + return_id_input + ' </td>';
                        html += '<td> ' + qty_input + ' </td>';
                        html += '<td> ' + btn + ' </td>';
                        html += '</tr>';

                    });
                    html += "</tbody>";
                    html += "</table>";

                    html += "</div>";

                    html += "<div class='mt-3'>";
                    html += "<div class='form-group'>" +
                        " <label for='remarks'>Remarks</label>" +
                        "<input type='text' name='remarks[]' value='" + remarks + "' class='form-control form-control-sm' /> " +
                        "<input type='hidden' name='header_id[]' value='" + header_id + "' /> " +
                        " </div> ";
                    html += "</div>";

                    html += "</div>";
                    html += "</div>";
                })

                $('#edit_res').html(html);

                // var op = data.sc;
                //
                // $.each(op, function(key, value) {
                //     let sp_id = value.id;
                //     let sp_name = value.name;
                //     let part_no = value.part_no;
                //     let returned_id = value.return_id;
                //     let returned_qty = value.returned_qty;
                //     let qty = value.qty;
                //
                //     let f = sp_name + ' - ' + part_no ;
                //
                //     let sp_id_input = '<input type="hidden" name="sp_id[]" class="id" value="'+sp_id+'"/> ' + f + '';
                //     let return_id_input = '<input type="hidden" name="return_id[]" class="id" value="'+returned_id+'"/> '  + '';
                //     let qty_input = '<input type="text" name="qty[]" class="form-control form-control-sm qty" value="'+qty+'" /> ';
                //     let returned_qty_input = '<input type="text" name="return_qty[]" readonly="true" class="form-control form-control-sm issued_qty" value="'+returned_qty+'" /> ';
                //
                //     colorTable.row.add([
                //         sp_id_input+return_id_input,
                //         returned_qty_input,
                //         qty_input,
                //         '<button type="button" class="btn btn-sm btn-danger btn-delete-edit" data-id="" onclick="removeFunc('+returned_id+')" data-toggle="modal" data-target="#removeModal" ><i class="fa fa-trash text-white"></i></button>'
                //     ]).draw(false);
                //
                // });


                let machine_type_name = data.main_data.service_no;
                $('#service_no_span').html(machine_type_name);

                // submit the edit from
                $("#updateForm").unbind('submit').bind('submit', function () {
                    var form = $(this);

                    // remove the text-danger
                    $(".text-danger").remove();

                    $.ajax({
                        url: form.attr('action') + '/' + id,
                        type: form.attr('method'),
                        data: form.serialize(), // /converting the form data into array and sending it to server
                        dataType: 'json',
                        success: function (response) {

                            manageTable.ajax.reload(null, false);

                            if (response.success === true) {
                                $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">' +
                                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                                    '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>' + response.messages +
                                    '</div>');

                                // hide the modal
                                $("#editModal").modal('hide');
                                // reset the form
                                $("#updateForm .form-group").removeClass('has-error').removeClass('has-success');

                            } else {

                                if (response.messages instanceof Object) {
                                    $.each(response.messages, function (index, value) {
                                        var id = $("#" + index);
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
                                    $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                                        '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>' + response.messages +
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
    function removeFunc(id) {
        if (id) {
            $("#removeForm").on('submit', function () {

                var form = $(this);

                // remove the text-danger
                $(".text-danger").remove();

                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: {id: id},
                    dataType: 'json',
                    success: function (response) {

                        let service_id = response.service_id;
                        editFunc(service_id);

                        //manageTable.ajax.reload(null, false);
                        // hide the modal
                        $("#removeModal").modal('hide');

                        if (response.success === true) {
                            $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">' +
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                                '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>' + response.messages +
                                '</div>');


                        } else {

                            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                                '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>' + response.messages +
                                '</div>');
                        }
                    }
                });

                return false;
            });
        }
    }

    function viewFunc(id) {
        $.ajax({
            url: base_url + 'MachineServices/fetchReturnedServiceItems/' + id,
            type: 'post',
            dataType: 'json',
            success: function (data) {
                let res_table = "<div class='table-responsive mt-3'>";
                res_table += '<table class="table table-striped table-sm" id="viewTable">';
                let res_tr = '<thead><tr><th>Service Item</th> <th> Issued Quantity </th> <th>Returned Quantity</th> <th>Unit Price</th>  </tr></thead> <tbody>';
                let response = data.rc_det;
                let total = 0;
                $.each(response, function (index, value) {
                    res_tr += '<tr>' +
                        '<td>' + value.sp_name + '</td>' +
                        '<td>' + value.issued_qty + '</td>' +
                        '<td>' + value.received_qty + '</td>' +
                        '<td style="text-align: right">' + value.unit_price + '</td>' +
                        '</tr>';
                    total += (parseFloat(value.received_qty)) * ( parseFloat(value.unit_price));
                });
                res_table += res_tr + '</tbody>';

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
                    '<h4> Returned Records </h4>';

                let head = data.head_det;

                $.each(head, function (index, value) {
                    res_table += "<div class='card mt-3'>" +
                        "<div class='card-body'> ";

                    res_table += "<div class='table-responsive mt-3'>" +
                        " ";
                    res_table += '<table class="table table-striped table-sm" id="viewTable">';
                    let res_tr1 = '<thead><tr><th>Service Item</th> <th> Returned Quantity </th> <th>Unit Price</th> <th>Returned At</th>  </tr></thead> <tbody>';

                    let response1 = value.sc;

                    $.each(response1, function (index, value) {
                        res_tr1 += '<tr>' +
                            '<td>' + value.name + ' - ' + value.part_no + '</td>' +
                            '<td>' + value.qty + '</td>' +
                            '<td>' + value.unit_price + '</td>' +
                            '<td>' + value.returned_at + '</td>' +
                            '</tr>';
                    });
                    res_table += res_tr1 + '</tbody> </table>';
                    res_table += '</div>';

                    res_table += "<label> Remarks </label> " +
                        value.remarks;

                    res_table += "</div> " +
                        "</div>" +
                        "";
                });

                let machine_type_name = data.main_data.service_no;
                $('#machine_type_name').html(machine_type_name);

                $("#viewModal .modal-body #viewResponse").html(res_table);
                $('#viewTable').DataTable();

            }
        });
    }


</script>