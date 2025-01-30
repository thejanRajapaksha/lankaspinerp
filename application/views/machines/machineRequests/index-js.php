<script type="text/javascript">
    var manageTable;
    var base_url = "<?php echo base_url(); ?>";


    $(document).ready(function () {

        $('#machine_requests_main_nav_link').prop('aria-expanded', 'true').removeClass('collapsed');
        $('#collapseLayoutsMachineRequests').addClass('show');

        $('.select2').select2({
            placeholder: 'Select...',
            width: '100%',
            allowClear: true,
            dropdownParent: $('#addModal'),

            });

        $('#edit_style_id').select2({
            placeholder: 'Select...',
            width: '100%',
            allowClear: true,
            dropdownParent: $('#editModal'),
            ajax: {
                url: base_url + 'Styles/get_styles_select',
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

        // initialize the datatable
        manageTable = $('#manageTable').DataTable({
            'ajax': base_url + 'MachineRequests/fetchCategoryData',
            'order': []
        });

        let colorTable = $('#colorTable').DataTable({});

        //#addBtn click event
        $("#addBtn").on('click', function (e) {

            e.preventDefault();
            $('.vm').remove();

            let machine_type_id = $('#machine_type_id').val();
            let machine_type_text = $('#machine_type_id option:selected').text();

            let machine_model_id = $('#machine_model_id').val();
            let machine_model_text = $('#machine_model_id option:selected').text();

            let from_date = $('#from_date').val();
            let to_date = $('#to_date').val();
            let quantity = $('#quantity').val();
            let remarks = $('#remarks').val();

            let is_valid = true;

            if (machine_type_id == '') {
                $('#machine_type_id_error').after('<p class="text-danger vm">The Machine Type field is required</p>');
                is_valid = false;
            }

            if (machine_model_id == '') {
                $('#machine_model_id_error').after('<p class="text-danger vm">The Machine Model field is required</p>');
                is_valid = false;
            }

            if (from_date == '') {
                $('#from_date').after('<p class="text-danger vm">The From Date field is required</p>');
            }

            //quantity
            if (quantity == '') {
                $('#quantity').after('<p class="text-danger vm">The Quantity field is required</p>');
                is_valid = false;
            }

            if (!is_valid) {
                return false;
            }

            colorTable.row.add([
                machine_type_text + '<input type="hidden" class="machine_type_id" name="machine_type_id[]" value="' + machine_type_id + '">',
                machine_model_text + '<input type="hidden" class="machine_model_id" name="machine_model_id[]" value="' + machine_model_id + '">',
                from_date + '<input type="hidden" class="from_date" name="from_date[]" value="' + from_date + '">',
                to_date + '<input type="hidden" class="to_date" name="to_date[]" value="' + to_date + '">',
                quantity + '<input type="hidden" class="quantity" name="quantity[]" value="' + quantity + '">',
                remarks + '<input type="hidden" class="remarks" name="remarks[]" value="' + remarks + '">',
                '<button type="button" class="btn btn-sm btn-danger btn-delete"><i class="fa fa-trash text-white"></i></button>'
            ]).draw(false);

            //clear the fields
            $('#machine_type_id').val('').trigger('change');
            $('#machine_model_id').val('').trigger('change');
            $('#from_date').val('');
            $('#to_date').val('');
            $('#quantity').val('');
            $('#remarks').val('');

        });

        //.btn-delete click event
        $('#colorTable tbody').on('click', '.btn-delete', function () {
            colorTable.row($(this).parents('tr')).remove().draw();
        });

        //#saveChanges click event
        $("#saveChanges").on('click', function (e) {
            e.preventDefault();
            let btn = $(this);
            let btn_text = btn.html();
            $('.text-danger').remove();

            let style_id = $('#style_id').val();

            let is_valid = true;

            if (machine_type_id == '') {
                $('#machine_type_id_error').after('<p class="text-danger vm">The Machine Type field is required</p>');
                is_valid = false;
            }

            if (machine_model_id == '') {
                $('#machine_model_id_error').after('<p class="text-danger vm">The Machine Model field is required</p>');
                is_valid = false;
            }

            if (from_date == '') {
                $('#from_date').after('<p class="text-danger vm">The From Date field is required</p>');
            }

            //quantity
            if (quantity == '') {
                $('#quantity').after('<p class="text-danger vm">The Quantity field is required</p>');
                is_valid = false;
            }

            //if colorTable is empty
            if (colorTable.data().count() == 0) {
                $('#msgCreate').html('<div class="alert alert-danger">Please add at least one request</div>');
                is_valid = false;
            }

            if (!is_valid) {
                return false;
            }

            //each table row .color_name and .color_code
            let req_data = [];

            $('#colorTable tbody tr').each(function () {
                let machine_type_id = $(this).find('.machine_type_id').val();
                let machine_model_id = $(this).find('.machine_model_id').val();
                let from_date = $(this).find('.from_date').val();
                let to_date = $(this).find('.to_date').val();
                let quantity = $(this).find('.quantity').val();
                let remarks = $(this).find('.remarks').val();

                req_data.push({
                    machine_type_id: machine_type_id,
                    machine_model_id: machine_model_id,
                    from_date: from_date,
                    to_date: to_date,
                    quantity: quantity,
                    remarks: remarks
                });
            });

            btn.html('<i class="fa fa-spinner fa-spin"></i> Saving...');
            btn.prop('disabled', true);


            $.ajax({
                url: base_url + 'MachineRequests/createBatch',
                type: 'post',
                dataType: 'json',
                data: {
                    req_data: req_data
                },
                success: function (response) {
                    if (response.success == true) {
                        $('#msgCreate').html('<div class="alert alert-success">' + response.messages + '</div>');
                        //hide addModal after 1 second
                        setTimeout(function () {
                            $('#addModal').modal('hide');
                            //reload the manageTable
                            manageTable.ajax.reload(null, false);
                            colorTable.clear().draw();
                        }, 1000);

                    } else {
                        $('#msgCreate').html('<div class="alert alert-danger">' + response.messages + '</div>');
                    }

                    btn.html(btn_text);
                    btn.prop('disabled', false);

                }
            });


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
            url: base_url + 'MachineRequests/fetchMachineRequestsByUniqueId',
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
                    '<th>From Date</th> ' +
                    '<th>To Date</th> ' +
                    '<th>Quantity</th> ' +
                    '<th>Remarks</th> ' +
                    '<th> Is Approved </th> ' +
                    '</tr>' +
                    '</thead> ' +
                    '<tbody>';
                $.each(response.machine_requests, function (index, value) {

                    let is_approved = value.is_approved == 1 ? '<span class="badge badge-success">Yes</span>' : '<span class="badge badge-danger">No</span>';

                    res_tr += '<tr>' +
                        '<td> <input type="checkbox" name="view_id[]" value="' + value.id + '" class="checkbox" /> </td>' +
                        '<td>' + value.machine_model_name + '</td>' +
                        '<td>' + value.machine_type_name + '</td>' +
                        '<td>' + value.from_date + '</td>' +
                        '<td>' + value.to_date + '</td>' +
                        '<td>' + value.quantity + '</td>' +
                        '<td>' + value.remarks + '</td>' +
                        '<td>' + is_approved + '</td>' +
                        '</tr>';
                });
                res_table += res_tr + '</tbody> </table>';

                let unique_id = response.machine_request.unique_id;
                $('#view_machine_requests').html(unique_id);

                $("#viewModal .modal-body #viewResponse").html(res_table);
                $('#viewTable').DataTable();

            }
        });
    }

    //approve-btn click event
    $("#approve-btn").on("click", function (e) {

        let btn = $(this);

            let checked_id = [];

            $("#viewTable tbody").find('input[type="checkbox"]').each(function () {
                if ($(this).is(":checked")) {
                    let id = $(this).val();
                    let machine_model_name = $(this).closest('tr').find('td:eq(1)').text();
                    let machine_type_name = $(this).closest('tr').find('td:eq(2)').text();
                    let from_date = $(this).closest('tr').find('td:eq(3)').text();
                    let to_date = $(this).closest('tr').find('td:eq(4)').text();
                    let quantity = $(this).closest('tr').find('td:eq(5)').text();
                    let is_approved = $(this).closest('tr').find('td:eq(7)').text();

                    checked_id.push({
                        id: id,
                        machine_model_name: machine_model_name,
                        machine_type_name: machine_type_name,
                        from_date: from_date,
                        to_date: to_date,
                        quantity: quantity,
                        is_approved: is_approved
                    });

                }
            });

            if (checked_id.length > 0) {

                btn.html('<i class="fa fa-spinner fa-spin"></i> loading...');
                btn.attr('disabled', 'disabled');

                //viewModal hide
                $('#viewModal').modal('hide');
                //rentModal show
                $('#approveModal').modal('show');

                let html = '<div class="alert alert-info">' +
                    '<span>Only Non Approved records will be selected</span> <br>' +
                    '</div>';

                html += '<table class="table table-bordered table-striped table-sm" id="approve-table">' +
                    '<thead>' +
                    '<tr>' +
                    '<th>Machine Model</th>' +
                    '<th>Machine Type</th>' +
                    '<th>From Date</th>' +
                    '<th>To Date</th>' +
                    '<th>Request Quantity</th>' +
                    '<th> Approve Quantity </th>' +
                    '</tr>' +
                    '</thead>' +
                    '<tbody>';

                for (let i = 0; i < checked_id.length; i++) {

                    if(checked_id[i].is_approved == 'No'){

                        html += '<tr>' +
                            '<td>' +
                            '<input type="hidden" class="id" name="id[]" value="' + checked_id[i].id + '">' +
                            checked_id[i].machine_model_name + '</td>' +
                            '<td>' + checked_id[i].machine_type_name + '</td>' +
                            '<td>' + checked_id[i].from_date + '</td>' +
                            '<td>' + checked_id[i].to_date + '</td>' +
                            '<td>' + checked_id[i].quantity + '</td>' +
                            '<td> <input type="number" class="form-control form-control-sm quantity" required name="quantity[]" value="' + checked_id[i].quantity + '"> </td>' +
                            '</tr>';

                    }
                }

                html += '</tbody>' +
                    '</table>';

                html += '<div class="form-group>' +
                    '<label for="remarks">Remarks</label>' +
                    '<input type="text" class="form-control form-control-sm remarks"> ' +
                    '</div>';

                $('#approveModal .modal-body #approveResponse').html(html);

                $("#approve-confirm-btn").on("click", function (e) {

                    let btn2 = $(this);

                    btn2.html('<i class="fa fa-spinner fa-spin"></i> Creating...');
                    btn2.attr('disabled', 'disabled');

                    let confirmed_ids = [];

                    let not_found_quantities = false;
                    let no_of_trs = 0;

                    //approve-table each tr
                    $('#approve-table tbody tr').each(function () {

                        let id = $(this).find('td:eq(0) input').val();
                        let quantity = $(this).find('td:eq(5) input').val();

                        if (quantity == '') {
                            not_found_quantities = true;
                        }

                        confirmed_ids.push({
                            id: id,
                            quantity: quantity
                        });

                        no_of_trs++;

                    });

                    if (not_found_quantities) {
                        btn2.html('Confirm');
                        btn2.removeAttr('disabled');
                        $('#approveModal .modal-body #approveMsg').html('<div class="alert alert-danger">' +
                            '<span>Please enter quantity for all selected records</span> <br>' +
                            '</div>');
                        return false;
                    }

                    if(no_of_trs == 0){
                        btn2.html('Confirm');
                        btn2.removeAttr('disabled');
                        $('#approveModal .modal-body #approveMsg').html('<div class="alert alert-danger">' +
                            '<span>Please select at least one record</span> <br>' +
                            '</div>');
                        return false;
                    }

                    $.ajax({
                        url: base_url + 'MachineRequests/approveMachineRequests',
                        type: 'post',
                        dataType: 'json',
                        data: {checked_id: confirmed_ids, unique_id: $('#view_machine_requests').text(), remarks: $('.remarks').val()},
                        success: function (response) {
                            if (response.success == true) {

                                btn2.html('Approve');
                                btn2.removeAttr('disabled');

                                btn.html('Approve');
                                btn.removeAttr('disabled');

                                //rentModal hide
                                $('#approveModal').modal('hide');
                                //viewModal show
                                $('#viewModal').modal('show');

                                //unckeck all checkboxes
                                $("#viewTable tbody").find('input[type="checkbox"]').each(function () {
                                    $(this).prop('checked', false);
                                });

                                //reset checked_id
                                checked_id = [];
                                confirmed_ids = [];

                                viewFunc(response.unique_id);

                                $('#viewMsg').html('<div class="alert alert-success">' + response.messages + '</div>');

                            }
                        }
                    });

                });

            } else {
                $('#viewMsg').html('<div class="alert alert-danger"> Please select at least one record </div>');
            }

    });

    $("#rent-btn").on("click", function (e) {

        let btn = $(this);

            let checked_id = [];

            //viewTable each tr checkboxes checked
            $("#viewTable tbody").find('input[type="checkbox"]').each(function () {
                if ($(this).is(":checked")) {
                    let id = $(this).val();
                    let machine_model_name = $(this).closest('tr').find('td:eq(1)').text();
                    let machine_type_name = $(this).closest('tr').find('td:eq(2)').text();
                    let from_date = $(this).closest('tr').find('td:eq(3)').text();
                    let to_date = $(this).closest('tr').find('td:eq(4)').text();
                    let quantity = $(this).closest('tr').find('td:eq(5)').text();
                    let is_approved = $(this).closest('tr').find('td:eq(7)').text();

                    checked_id.push({
                        id: id,
                        machine_model_name: machine_model_name,
                        machine_type_name: machine_type_name,
                        from_date: from_date,
                        to_date: to_date,
                        quantity: quantity,
                        is_approved: is_approved
                    });

                }
            });

            if (checked_id.length > 0) {

                btn.html('<i class="fa fa-spinner fa-spin"></i> loading...');
                btn.attr('disabled', 'disabled');

                //viewModal hide
                $('#viewModal').modal('hide');
                 //rentModal show
                $('#rentModal').modal('show');

                let html = '<div class="alert alert-info">' +
                        '<span>Only approved records will be selected</span> <br>' +
                        '</div>';

                html += '<table class="table table-bordered table-striped table-sm" id="confirm-table">' +
                        '<thead>' +
                        '<tr>' +
                        '<th>Machine Model</th>' +
                        '<th>Machine Type</th>' +
                        '<th>From Date</th>' +
                        '<th>To Date</th>' +
                        '<th>Request Quantity</th>' +
                        '<th> Rent Quantity </th>' +
                        '</tr>' +
                        '</thead>' +
                        '<tbody>';

                for (let i = 0; i < checked_id.length; i++) {

                    if(checked_id[i].is_approved == 'Yes'){

                        html += '<tr>' +
                            '<td>' +
                            '<input type="hidden" class="id" name="id[]" value="' + checked_id[i].id + '">' +
                            checked_id[i].machine_model_name + '</td>' +
                            '<td>' + checked_id[i].machine_type_name + '</td>' +
                            '<td>' + checked_id[i].from_date + '</td>' +
                            '<td>' + checked_id[i].to_date + '</td>' +
                            '<td>' + checked_id[i].quantity + '</td>' +
                            '<td> <input type="number" class="form-control form-control-sm quantity" required name="quantity[]" value="' + checked_id[i].quantity + '"> </td>' +
                            '</tr>';

                    }
                }

                html += '</tbody>' +
                        '</table>';

                $('#rentModal .modal-body #rentResponse').html(html);

            } else {
                $('#viewMsg').html('<div class="alert alert-danger"> Please select at least one record </div>');
            }
    });

    //rent-btn click event
    $("#rent-confirm-btn").on("click", function (e) {

        let btn2 = $(this);

        btn2.html('<i class="fa fa-spinner fa-spin"></i> Creating...');
        btn2.attr('disabled', 'disabled');

        let confirmed_ids = [];

        let not_found_quantities = false;

        //confirm-table each tr
        $('#confirm-table tbody tr').each(function () {

            let id = $(this).find('td:eq(0) input').val();
            let quantity = $(this).find('td:eq(5) input').val();

            if (quantity == '') {
                not_found_quantities = true;
            }

            confirmed_ids.push({
                id: id,
                quantity: quantity
            });

        });

        if (not_found_quantities) {
            btn2.html('Confirm');
            btn2.removeAttr('disabled');
            $('#rentModal .modal-body #rentMsg').html('<div class="alert alert-danger">' +
                '<span>Please enter quantity for all selected records</span> <br>' +
                '</div>');
            return false;
        }

        $.ajax({
            url: base_url + 'MachineRequests/rentMachineRequests',
            type: 'post',
            dataType: 'json',
            data: {checked_id: confirmed_ids, unique_id: $('#view_machine_requests').text()},
            success: function (response) {
                if (response.success == true) {

                    btn2.html('Confirm');
                    btn2.removeAttr('disabled');

                    $("#rent-btn").html('Create Rent Request');
                    $("#rent-btn").removeAttr('disabled');

                    //rentModal hide
                    $('#rentModal').modal('hide');
                    //viewModal show
                    $('#viewModal').modal('show');

                    //unckeck all checkboxes
                    $("#viewTable tbody").find('input[type="checkbox"]').each(function () {
                        $(this).prop('checked', false);
                    });

                    confirmed_ids = [];

                    $('#viewMsg').html('<div class="alert alert-success">' + response.messages + '</div>');

                }
            }
        });

    });

    $("#issue-released-btn").on("click", function (e) {

        let btn = $(this);

        let checked_id = [];

        //viewTable each tr checkboxes checked
        $("#viewTable tbody").find('input[type="checkbox"]').each(function () {
            if ($(this).is(":checked")) {
                let id = $(this).val();
                let machine_model_name = $(this).closest('tr').find('td:eq(1)').text();
                let machine_type_name = $(this).closest('tr').find('td:eq(2)').text();
                let from_date = $(this).closest('tr').find('td:eq(3)').text();
                let to_date = $(this).closest('tr').find('td:eq(4)').text();
                let quantity = $(this).closest('tr').find('td:eq(5)').text();
                let is_approved = $(this).closest('tr').find('td:eq(7)').text();

                checked_id.push({
                    id: id,
                    machine_model_name: machine_model_name,
                    machine_type_name: machine_type_name,
                    from_date: from_date,
                    to_date: to_date,
                    quantity: quantity,
                    is_approved: is_approved
                });

            }
        });

        if (checked_id.length > 0) {

            btn.html('<i class="fa fa-spinner fa-spin"></i> Loading...');
            btn.attr('disabled', 'disabled');

            //viewModal hide
            $('#viewModal').modal('hide');
            //rentModal show
            $('#issueModal').modal('show');

            let html = '<div class="alert alert-info">' +
                '<span>Only approved records will be selected</span> <br>' +
                '</div>';

            html += '<table class="table table-bordered table-striped table-sm" id="issue-confirm-table">' +
                '<thead>' +
                '<tr>' +
                '<th>Machine Model</th>' +
                '<th>Machine Type</th>' +
                '<th>From Date</th>' +
                '<th>To Date</th>' +
                '<th>Requested Quantity</th>' +
                '<th>Machine</th>' +
                '</tr>' +
                '</thead>' +
                '<tbody>';

            for (let i = 0; i < checked_id.length; i++) {

                if(checked_id[i].is_approved == 'Yes'){

                    html += '<tr>' +
                        '<td>' +
                        '<input type="hidden" class="id" name="id[]" value="' + checked_id[i].id + '">' +
                        checked_id[i].machine_model_name + '</td>' +
                        '<td>' + checked_id[i].machine_type_name + '</td>' +
                        '<td>' + checked_id[i].from_date + '</td>' +
                        '<td>' + checked_id[i].to_date + '</td>' +
                        '<td>' +checked_id[i].quantity+'</td>' +
                        '<td>' +
                        '<select class="form-control form-control-sm released_machine" required > ' +
                        '</select>' +
                        '</td> ' +
                        '</tr>';

                }
            }

            html += '</tbody>' +
                '</table>';

            $('#issueModal .modal-body #issueResponse').html(html);

            let selected_machines = [];

            //release_machine change event
            $('.released_machine').change(function (e) {

                let machine_id = $(this).val();
                let machine_name = $(this).find('option:selected').text();

                if (machine_id != '') {

                    if (selected_machines.indexOf(machine_id) == -1) {

                        selected_machines.push(machine_id);

                    }

                }

            });

            //released_machine select2
            $('.released_machine').select2({
                placeholder: 'Select...',
                width: '100%',
                allowClear: true,
                multiple: true,
                dropdownParent: $('#issueModal'),
                ajax: {
                    url: base_url + 'machineIns/get_released_machines',
                    dataType: 'json',
                    data: function (params) {
                        return {
                            term: params.term || '',
                            page: params.page || 1,
                            machine_model_name: $(this).closest('tr').find('td:eq(0)').text(),
                            machine_type_name: $(this).closest('tr').find('td:eq(1)').text(),
                            selected_machines: selected_machines
                        }
                    },
                    cache: true
                }
            });

        } else {
            $('#viewMsg').html('<div class="alert alert-danger"> Please select at least one record </div>');
        }

    });

    $("#issue-confirm-btn").on("click", function (e) {

        let btn2 = $(this);

        btn2.html('<i class="fa fa-spinner fa-spin"></i> Creating...');
        btn2.attr('disabled', 'disabled');

        let confirmed_ids = [];

        let not_found_select = false;

        //confirm-table each tr
        $('#issue-confirm-table tbody tr').each(function () {

            let id = $(this).find('td:eq(0) input').val();
            let machine_in_id = $(this).find('td:eq(5) select').val();

            if(machine_in_id == null){
                not_found_select = true;
            }

            confirmed_ids.push({
                machine_request_id: id,
                machine_in_id: machine_in_id
            });

        });

        if(not_found_select){
            btn2.html('issue');
            btn2.removeAttr('disabled');
            $('#issueModal .modal-body #issueMsg').html('<div class="alert alert-danger">Please select at least one machine.</div>');
            return false;
        }

        $.ajax({
            url: base_url + 'MachineOnLoanRequests/create',
            type: 'post',
            dataType: 'json',
            data: {checked_id: confirmed_ids, unique_id: $('#view_machine_requests').text()},
            success: function (response) {
                if (response.success == true) {

                    btn2.html('Issue');
                    btn2.removeAttr('disabled');

                    $('#issue-released-btn').html('Create On Loan Requests');
                    $('#issue-released-btn').removeAttr('disabled');

                    //rentModal hide
                    $('#issueModal').modal('hide');
                    //viewModal show
                    $('#viewModal').modal('show');

                    //unckeck all checkboxes
                    $("#viewTable tbody").find('input[type="checkbox"]').each(function () {
                        $(this).prop('checked', false);
                    });

                    checked_id = [];
                    confirmed_ids = [];

                    $('#viewMsg').html('<div class="alert alert-success">' + response.messages + '</div>');

                }
            }
        });

    });

</script>