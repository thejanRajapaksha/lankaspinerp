<script type="text/javascript">
    var manageTable;
    var base_url = "<?php echo base_url(); ?>";


    $(document).ready(function () {

        $('#machine_requests_main_nav_link').prop('aria-expanded', 'true').removeClass('collapsed');
        $('#collapseLayoutsMachineRequests').addClass('show');

        // initialize the datatable
        manageTable = $('#manageTable').DataTable({
            'ajax': base_url + 'MachineRentRequests/fetchCategoryData',
            'order': []
        });

    });

    function rentRequest(id) {
        $('#rentModal').modal('show');
    }

    // edit function
    function editFunc(id) {
        $.ajax({
            url: base_url + 'StyleColors/fetchStyleColorsByStyleId',
            type: 'post',
            dataType: 'json',
            data: {style_id: id},
            success: function (response) {

                $('#edit_color_name').html(response.style.name);

                let color_table_html = '';
                color_table_html += '<div class="table-responsive">';
                color_table_html += '<table class="table table-bordered table-sm" id="editColorTable">';
                color_table_html += '<thead>';
                color_table_html += '<tr>';
                color_table_html += '<th>Color Name</th>';
                color_table_html += '<th>Color Code</th>';
                color_table_html += '</tr>';
                color_table_html += '</thead>';
                color_table_html += '<tbody>';

                let colors = response.colors;
                $.each(colors, function (index, value) {

                    let color_id = '<input type="hidden" class="color_id" name="color_id[]" value="' + value.id + '">';
                    let color_name_input = '<input type="text" name="color_name[]" class="form-control form-control-sm color_name" value="' + value.color_name + '">';
                    let color_code_input = '<input type="text" name="color_code[]" class="form-control form-control-sm color_code" value="' + value.color_code + '">';

                    color_table_html += '<tr>';
                    color_table_html += '<td>' + color_id + color_name_input + '</td>';
                    color_table_html += '<td>' + color_code_input + '</td>';
                    color_table_html += '</tr>';
                });

                color_table_html += '</tbody>';
                color_table_html += '</table>';
                color_table_html += '</div>';

                $('#edit_html').html(color_table_html);

                let colorTable = $('#editColorTable').dataTable({
                    'bDestroy': true,
                    'paging': false,
                    'searching': false,
                });

                // submit the edit from
                $("#edit-btn").on('click', function (e) {

                    let btn = $("#edit-btn");
                    let btn_text = btn.html();

                    let color_data = [];

                    $('#editColorTable tbody tr').each(function () {
                        let color_name = $(this).find('.color_name').val();
                        let color_code = $(this).find('.color_code').val();
                        let color_id = $(this).find('.color_id').val();

                        color_data.push({
                            color_name: color_name,
                            color_code: color_code,
                            color_id: color_id
                        });
                    });

                    // remove the text-danger
                    $(".text-danger").remove();

                    $.ajax({
                        url: base_url + 'StyleColors/editBatch',
                        type: 'post',
                        dataType: 'json',
                        data: {
                            color_data: color_data
                        },
                        success: function (response) {
                            if (response.success == true) {
                                $('#msgEdit').html('<div class="alert alert-success">' + response.messages + '</div>');
                                //hide addModal after 1 second
                                setTimeout(function () {
                                    $('#editModal').modal('hide');
                                    //reload the manageTable
                                    manageTable.ajax.reload(null, false);
                                    //colorTable.clear().draw();
                                }, 1000);

                            } else {
                                $('#msgEdit').html('<div class="alert alert-danger">' + response.messages + '</div>');
                            }
                            btn.html(btn_text);
                            btn.prop('disabled', false);
                        }
                    });

                    return false;
                });

            }
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

                        manageTable.ajax.reload(null, false);
                        // hide the modal
                        $("#removeModal").modal('hide');
                        viewFunc(response.style_id);

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

    // removeModal show event
    $("#removeModal").on("show.bs.modal", function (e) {
        //hide viewModal
        $("#viewModal").modal('hide');
    });

    function viewFunc(id) {

        $('#rent-btn').prop('disabled', false);
        $('#rent-btn').html('Create Rent Request');

        $('#issue-released-btn').prop('disabled', false);
        $('#issue-released-btn').html('Create On Loan Requests');

        $.ajax({
            url: base_url + 'MachineRentRequests/fetchMachineRentRequestsByUniqueId',
            type: 'post',
            dataType: 'json',
            data: {unique_id: id},
            success: function (response) {

                let res_table = '  ' +
                    '<table class="table table-striped table-sm" id="viewTable">';
                let res_tr = '<thead>' +
                    '<tr>' +
                    '<th></th>' +
                    '<th>Machine Model</th>' +
                    '<th>Machine Type</th> ' +
                    '<th>Request Date</th> ' +
                    '<th>Quantity</th> ' +
                    '</tr>' +
                    '</thead> ' +
                    '<tbody>';
                $.each(response.machine_rent_requests, function (index, value) {

                    let is_approved = value.is_approved == 1 ? '<span class="badge badge-success">Yes</span>' : '<span class="badge badge-danger">No</span>';

                    res_tr += '<tr>' +
                        '<td> <input type="checkbox" name="view_id[]" value="' + value.id + '" class="checkbox" /> </td>' +
                        '<td>' + value.machine_model_name + '</td>' +
                        '<td>' + value.machine_type_name + '</td>' +
                        '<td>' + value.request_date + '</td>' +
                        '<td>' + value.quantity + '</td>' +
                        '</tr>';
                });
                res_table += res_tr + '</tbody> </table>';

                let unique_id = response.machine_rent_request.unique_id;
                $('#view_machine_requests').html(unique_id);

                $("#viewModal .modal-body #viewResponse").html(res_table);
                $('#viewTable').DataTable();

            }
        });
    }

    //approve-btn click event
    $("#receive-btn").on("click", function (e) {

        let btn = $(this);

            let checked_id = [];

            $("#viewTable tbody").find('input[type="checkbox"]').each(function () {
                if ($(this).is(":checked")) {
                    let id = $(this).val();
                    let machine_model_name = $(this).closest('tr').find('td:eq(1)').text();
                    let machine_type_name = $(this).closest('tr').find('td:eq(2)').text();
                    let request_date = $(this).closest('tr').find('td:eq(3)').text();
                    let quantity = $(this).closest('tr').find('td:eq(4)').text();

                    checked_id.push({
                        id: id,
                        machine_model_name: machine_model_name,
                        machine_type_name: machine_type_name,
                        request_date: request_date,
                        quantity: quantity
                    });

                }
            });

            if (checked_id.length > 0) {

                btn.html('<i class="fa fa-spinner fa-spin"></i> loading...');
                btn.attr('disabled', 'disabled');

                //viewModal hide
                $('#viewModal').modal('hide');
                //rentModal show
                $('#receiveModal').modal('show');

                let html = ' ';

                html += '<table class="table table-bordered table-striped table-sm" id="receive-table">' +
                    '<thead>' +
                    '<tr>' +
                    '<th>Machine Model</th>' +
                    '<th>Machine Type</th>' +
                    '<th>Request Date</th>' +
                    '<th>Requested Quantity</th>' +
                    '<th>Received Quantity</th>' +
                    '<th>Rent</th>' +
                    '</tr>' +
                    '</thead>' +
                    '<tbody>';

                for (let i = 0; i < checked_id.length; i++) {

                        html += '<tr>' +
                            '<td>' +
                            '<input type="hidden" class="id" name="id[]" value="' + checked_id[i].id + '">' +
                            checked_id[i].machine_model_name + '</td>' +
                            '<td>' + checked_id[i].machine_type_name + '</td>' +
                            '<td>' + checked_id[i].request_date + '</td>' +
                            '<td>' + checked_id[i].quantity + '</td>' +
                            '<td> <input type="number" class="form-control form-control-sm quantity" required name="quantity[]" value=""> </td>' +
                            '<td> <input type="number" class="form-control form-control-sm rent" required name="rent[]" value=""> </td>' +
                            '</tr>';

                }

                html += '</tbody>' +
                    '</table>';

                html += '<div class="form-group">' +
                    '<label>Remarks</label>' +
                    '<input type="text" class="form-control form-control-sm remarks"> ' +
                    '</div>';

                $('#receiveModal .modal-body #receiveResponse').html(html);

            } else {
                $('#viewMsg').html('<div class="alert alert-danger"> Please select at least one record </div>');
            }

    });

    $("#receive-confirm-btn").on("click", function (e) {

        let btn2 = $(this);

        btn2.html('<i class="fa fa-spinner fa-spin"></i> Creating...');
        btn2.attr('disabled', 'disabled');

        let confirmed_ids = [];

        let not_found_quantities = false;
        let not_found_rents = false;
        let no_of_trs = 0;

        //approve-table each tr
        $('#receive-table tbody tr').each(function () {

            let id = $(this).find('td:eq(0) input').val();
            let quantity = $(this).find('td:eq(4) input').val();
            let rent = $(this).find('td:eq(5) input').val();

            if (quantity == '') {
                not_found_quantities = true;
            }

            if (rent == '') {
                not_found_rents = true;
            }

            confirmed_ids.push({
                rent_request_id: id,
                quantity: quantity,
                rent: rent
            });

            no_of_trs++;

        });

        if (not_found_quantities) {
            btn2.html('Receive');
            btn2.removeAttr('disabled');
            $('#receiveModal .modal-body #receiveMsg').html('<div class="alert alert-danger">' +
                '<span>Please enter quantity for all selected records</span> <br>' +
                '</div>');
            return false;
        }

        if (not_found_rents) {
            btn2.html('Receive');
            btn2.removeAttr('disabled');
            $('#receiveModal .modal-body #receiveMsg').html('<div class="alert alert-danger">' +
                '<span>Please enter rent for all selected records</span> <br>' +
                '</div>');
            return false;
        }

        if(no_of_trs == 0){
            btn2.html('Receive');
            btn2.removeAttr('disabled');
            $('#receiveModal .modal-body #receiveMsg').html('<div class="alert alert-danger">' +
                '<span>Please select at least one record</span> <br>' +
                '</div>');
            return false;
        }

        $.ajax({
            url: base_url + 'MachineRentRequestReceiveMachine/create',
            type: 'post',
            dataType: 'json',
            data: {checked_id: confirmed_ids, unique_id: $('#view_machine_requests').text(), remarks: $('.remarks').val()},
            success: function (response) {
                if (response.success == true) {

                    btn2.html('Receive');
                    btn2.removeAttr('disabled');

                    $('#receive-btn').html('Receive Rent Machine');
                    $('#receive-btn').removeAttr('disabled');

                    //rentModal hide
                    $('#receiveModal').modal('hide');
                    //viewModal show
                    $('#viewModal').modal('show');

                    //unckeck all checkboxes
                    $("#viewTable tbody").find('input[type="checkbox"]').each(function () {
                        $(this).prop('checked', false);
                    });

                    viewFunc(response.unique_id);

                    $('#viewMsg').html('<div class="alert alert-success">' + response.messages + '</div>');

                }
            }
        });

    });

</script>