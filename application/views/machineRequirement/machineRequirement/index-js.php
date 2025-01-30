<script type="text/javascript">
    var manageTable;
    var base_url = "<?php echo base_url(); ?>";


    $(document).ready(function () {

        $('#machine_requirement_main_nav_link').prop('aria-expanded', 'true').removeClass('collapsed');
        $('#collapseLayoutsMachineRequirements').addClass('show');

        $('#factory_id').select2({
            placeholder: 'Select...',
            width: '100%',
            allowClear: true,
            dropdownParent: $('#addModal'),
            ajax: {
                url:  base_url + 'factories/get_factories_select',
                dataType: 'json',
                data: function(params) {
                    return {
                        term: params.term || '',
                        page: params.page || 1
                    }
                },
                cache: true
            }
        });

        $('#department_id').select2({
            placeholder: 'Select...',
            width: '100%',
            allowClear: true,
            dropdownParent: $('#addModal'),
            ajax: {
                url:  base_url + 'departments/get_departments_select',
                dataType: 'json',
                data: function(params) {
                    return {
                        term: params.term || '',
                        page: params.page || 1,
                        factory_id: $('#factory_id').val()
                    }
                },
                cache: true
            }
        });

        $('#section_id').select2({
            placeholder: 'Select...',
            width: '100%',
            allowClear: true,
            dropdownParent: $('#addModal'),
            ajax: {
                url:  base_url + 'sections/get_sections_select',
                dataType: 'json',
                data: function(params) {
                    return {
                        term: params.term || '',
                        page: params.page || 1,
                        department_id: $('#department_id').val()
                    }
                },
                cache: true
            }
        });

        $('#line_id').select2({
            placeholder: 'Select...',
            width: '100%',
            allowClear: true,
            dropdownParent: $('#addModal'),
            ajax: {
                url:  base_url + 'lines/get_lines_select',
                dataType: 'json',
                data: function(params) {
                    return {
                        term: params.term || '',
                        page: params.page || 1,
                        section_id: $('#section_id').val()
                    }
                },
                cache: true
            }
        });

        // $('.select2').select2({
        //     placeholder: 'Select...',
        //     width: '100%',
        //     allowClear: true,
        //
        //     });

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
            'ajax': base_url + 'MachineRequirements/fetchCategoryData',
            'order': []
        });

        let colorTable = $('#colorTable').DataTable({});

        //#addBtn click event
        $("#addBtn").on('click', function (e) {

            e.preventDefault();
            $('.vm').remove();

            let machine_type_id = $('#machine_type_id').val();
            let machine_type_text = $('#machine_type_id option:selected').text();

            let forecast = $('#forecast').val();

            let factory_id = $('#factory_id').val();
            let factory_text = $('#factory_id option:selected').text();

            let department_id = $('#department_id').val();
            let department_text = $('#department_id option:selected').text();

            let section_id = $('#section_id').val();
            let section_text = $('#section_id option:selected').text();

            let line_id = $('#line_id').val();
            let line_text = $('#line_id option:selected').text();

            //let machine_model_id = $('#machine_model_id').val();
            //let machine_model_text = $('#machine_model_id option:selected').text();

            let from_date = $('#from_date').val();
            let to_date = $('#to_date').val();
            let quantity = $('#quantity').val();
            let remarks = $('#remarks').val();

            let is_valid = true;

            if (factory_id == '') {
                $('#factory_id_error').after('<p class="text-danger vm">The Factory field is required</p>');
                is_valid = false;
            }

            if (department_id == '') {
                $('#department_id_error').after('<p class="text-danger vm">The department field is required</p>');
                is_valid = false;
            }

            if (section_id == '') {
                $('#section_id_error').after('<p class="text-danger vm">The section field is required</p>');
                is_valid = false;
            }

            if (line_id == '') {
                $('#line_id_error').after('<p class="text-danger vm">The line field is required</p>');
                is_valid = false;
            }

            if (machine_type_id == '') {
                $('#machine_type_id_error').after('<p class="text-danger vm">The Machine Type field is required</p>');
                is_valid = false;
            }

            // if (machine_model_id == '') {
            //     $('#machine_model_id_error').after('<p class="text-danger vm">The Machine Model field is required</p>');
            //     is_valid = false;
            // }

            if (forecast == '') {
                $('#forecast').after('<p class="text-danger vm">The Forecast field is required</p>');
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
                forecast + '<input type="hidden" class="forecast" name="forecast[]" value="' + forecast + '">',
                factory_text + '<input type="hidden" class="factory" name="factory[]" value="' + factory_id + '">',
                department_text + '<input type="hidden" class="department" name="department[]" value="' + department_id + '">',
                section_text + '<input type="hidden" class="section" name="section[]" value="' + section_id + '">',
                line_text + '<input type="hidden" class="line_id" name="line_id[]" value="' + line_id + '">',
                machine_type_text + '<input type="hidden" class="machine_type_id" name="machine_type_id[]" value="' + machine_type_id + '">',
                //machine_model_text + '<input type="hidden" class="machine_model_id" name="machine_model_id[]" value="' + machine_model_id + '">',
                from_date + '<input type="hidden" class="from_date" name="from_date[]" value="' + from_date + '">',
                to_date + '<input type="hidden" class="to_date" name="to_date[]" value="' + to_date + '">',
                quantity + '<input type="hidden" class="quantity" name="quantity[]" value="' + quantity + '">',
                remarks + '<input type="hidden" class="remarks" name="remarks[]" value="' + remarks + '">',
                '<button type="button" class="btn btn-sm btn-danger btn-delete"><i class="fa fa-trash text-white"></i></button>'
            ]).draw(false);

            //clear the fields
            $('#machine_type_id').val('').trigger('change');
            $('#machine_model_id').val('').trigger('change');
            //$('#from_date').val('');
            //$('#to_date').val('');
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

            // if (machine_model_id == '') {
            //     $('#machine_model_id_error').after('<p class="text-danger vm">The Machine Model field is required</p>');
            //     is_valid = false;
            // }

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
                let forecast = $(this).find('.forecast').val();
                let factory_id = $(this).find('.factory_id').val();
                let section_id = $(this).find('.section_id').val();
                let department_id = $(this).find('.department_id').val();
                let line_id = $(this).find('.line_id').val();
                let machine_type_id = $(this).find('.machine_type_id').val();
                let from_date = $(this).find('.from_date').val();
                let to_date = $(this).find('.to_date').val();
                let quantity = $(this).find('.quantity').val();
                let remarks = $(this).find('.remarks').val();

                req_data.push({
                    forecast: forecast,
                    factory_id: factory_id,
                    section_id: section_id,
                    department_id: department_id,
                    line_id: line_id,
                    machine_type_id: machine_type_id,
                    from_date: from_date,
                    to_date: to_date,
                    quantity: quantity,
                    remarks: remarks
                });
            });

            btn.html('<i class="fa fa-spinner fa-spin"></i> Saving...');
            btn.prop('disabled', true);


            $.ajax({
                url: base_url + 'MachineRequirements/createBatch',
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

    function viewFunc(id) {

        $('#rent-btn').prop('disabled', false);
        $('#rent-btn').html('Create Machine Request');

        $.ajax({
            url: base_url + 'MachineRequirements/fetchMachineRequirementsByUniqueId',
            type: 'post',
            dataType: 'json',
            data: {unique_id: id},
            success: function (response) {

                let res_table = '  ' +
                    '<table class="table table-striped table-sm" id="viewTable">';
                let res_tr = '<thead>' +
                    '<tr>' +
                    '<th></th>' +
                    '<th>Machine Type</th> ' +
                    '<th>From Date</th> ' +
                    '<th>To Date</th> ' +
                    '<th>Remarks</th> ' +
                    '<th>Required Quantity</th> ' +
                    '<th>Factory Available Quantity</th> ' +
                    '<th>Rented Quantity</th> ' +
                    '<th>On Loan Quantity</th> ' +
                    '<th>Balance Quantity</th> ' +
                    '</tr>' +
                    '</thead> ' +
                    '<tbody>';
                $.each(response.machine_requirements, function (index, value) {

                    //let is_approved = value.is_approved == 1 ? '<span class="badge badge-success">Yes</span>' : '<span class="badge badge-danger">No</span>';

                    res_tr += '<tr>' +
                        '<td> <input type="checkbox" name="view_id[]" value="' + value.id + '" class="checkbox" /> </td>' +
                        '<td>' + value.machine_type_name + '</td>' +
                        '<td>' + value.from_date + '</td>' +
                        '<td>' + value.to_date + '</td>' +
                        '<td>' + value.remarks + '</td>' +
                        '<td>' + value.quantity + '</td>' +
                        '<td>' + value.factory_available_machines + '</td>' +
                        '<td>' + value.available_rented_quantity + '</td>' +
                        '<td>' + value.on_loan_available_quantity + '</td>' +
                        '<td>' + value.balance + '</td>' +
                        '</tr>';
                });
                res_table += res_tr + '</tbody> </table>';

                let unique_id = response.machine_requirement.unique_id;
                $('#view_machine_requirements').html(unique_id);

                $("#viewModal .modal-body #viewResponse").html(res_table);
                $('#viewTable').DataTable();

            }
        });
    }

    $("#request-btn").on("click", function (e) {

        let btn = $(this);

            let checked_id = [];

            //viewTable each tr checkboxes checked
            $("#viewTable tbody").find('input[type="checkbox"]').each(function () {
                if ($(this).is(":checked")) {
                    let id = $(this).val();
                    //let machine_model_name = $(this).closest('tr').find('td:eq(1)').text();
                    let machine_type_name = $(this).closest('tr').find('td:eq(1)').text();
                    let from_date = $(this).closest('tr').find('td:eq(2)').text();
                    let to_date = $(this).closest('tr').find('td:eq(3)').text();
                    let quantity = $(this).closest('tr').find('td:eq(5)').text();
                    let factory_available_quantity = $(this).closest('tr').find('td:eq(6)').text();
                    let rented_quantity = $(this).closest('tr').find('td:eq(7)').text();
                    let on_loan_available_quantity = $(this).closest('tr').find('td:eq(8)').text();
                    let balance_quantity = $(this).closest('tr').find('td:eq(9)').text();

                    checked_id.push({
                        id: id,
                        //machine_model_name: machine_model_name,
                        machine_type_name: machine_type_name,
                        from_date: from_date,
                        to_date: to_date,
                        quantity: quantity,
                        factory_available_quantity: factory_available_quantity,
                        rented_quantity: rented_quantity,
                        on_loan_available_quantity: on_loan_available_quantity,
                        balance_quantity: balance_quantity,
                    });

                }
            });

            if (checked_id.length > 0) {

                btn.html('<i class="fa fa-spinner fa-spin"></i> loading...');
                btn.attr('disabled', 'disabled');

                //viewModal hide
                $('#viewModal').modal('hide');
                 //rentModal show
                $('#requestModal').modal('show');

                let html = '';

                html += '<table class="table table-bordered table-striped table-sm" id="confirm-table">' +
                        '<thead>' +
                        '<tr>' +
                        '<th>Machine Type</th>' +
                        '<th>From Date</th>' +
                        '<th>To Date</th>' +
                        '<th>Required Quantity</th>' +
                        '<th>Factory Available Quantity</th>' +
                        '<th>Rented Quantity</th>' +
                        '<th>On loan Quantity</th>' +
                        '<th> Balance Quantity </th>' +
                        '<th> Request Quantity </th>' +
                        '</tr>' +
                        '</thead>' +
                        '<tbody>';

                for (let i = 0; i < checked_id.length; i++) {


                        html += '<tr>' +
                            '<td>' + checked_id[i].machine_type_name + '</td>' +
                            '<td>' + checked_id[i].from_date + '</td>' +
                            '<td>' + checked_id[i].to_date + '</td>' +
                            '<td>' + checked_id[i].quantity + '</td>' +
                            '<td>' + checked_id[i].factory_available_quantity + '</td>' +
                            '<td>' + checked_id[i].rented_quantity + '</td>' +
                            '<td>' + checked_id[i].on_loan_available_quantity + '</td>' +
                            '<td>' + checked_id[i].balance_quantity + '</td>' +
                            '<td> <input type="number" class="form-control form-control-sm quantity" required name="quantity[]" value="' + checked_id[i].balance_quantity + '"> </td>' +
                            '</tr>';

                }

                html += '</tbody>' +
                        '</table>';

                $('#requestModal .modal-body #requestResponse').html(html);

            } else {
                $('#viewMsg').html('<div class="alert alert-danger"> Please select at least one record </div>');
            }
    });

    //rent-btn click event
    $("#request-confirm-btn").on("click", function (e) {

        let btn2 = $(this);

        btn2.html('<i class="fa fa-spinner fa-spin"></i> Creating...');
        btn2.attr('disabled', 'disabled');

        let confirmed_ids = [];

        let not_found_quantities = false;

        //confirm-table each tr
        $('#confirm-table tbody tr').each(function () {

            let machine_type_name = $(this).find('td:eq(0)').text();
            let from_date = $(this).find('td:eq(1)').text();
            let to_date = $(this).find('td:eq(2)').text();
            let request_quantity = $(this).find('td:eq(8) input').val();



            if (request_quantity == '') {
                not_found_quantities = true;
            }

            confirmed_ids.push({
                machine_type_name: machine_type_name,
                from_date: from_date,
                to_date: to_date,
                request_quantity: request_quantity
            });

        });

        if (not_found_quantities) {
            btn2.html('Confirm');
            btn2.removeAttr('disabled');
            $('#requestModal .modal-body #requestMsg').html('<div class="alert alert-danger">' +
                '<span>Please enter quantity for all selected records</span> <br>' +
                '</div>');
            return false;
        }

        $.ajax({
            url: base_url + 'MachineRequests/createMachineRequests',
            type: 'post',
            dataType: 'json',
            data: {checked_id: confirmed_ids, unique_id: $('#view_machine_requests').text()},
            success: function (response) {
                if (response.success == true) {

                    btn2.html('Confirm');
                    btn2.removeAttr('disabled');

                    $("#request-btn").html('Create Machine Request');
                    $("#request-btn").removeAttr('disabled');

                    //rentModal hide
                    $('#requestModal').modal('hide');
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

</script>