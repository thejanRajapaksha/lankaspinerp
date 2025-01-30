<script type="text/javascript">
    var manageTable;
    var base_url = "<?php echo base_url(); ?>";


    $(document).ready(function () {

        $('#machine_operation_desc_main_nav_link').prop('aria-expanded', 'true').removeClass('collapsed');
        $('#collapseLayoutsMachineOperationDescs').addClass('show');

        $('#created_by').select2({
            placeholder: 'Select...',
            width: '100%',
            allowClear: true,
            ajax: {
                url: base_url + 'Employees/get_employees_select',
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

        $('#approved_by').select2({
            placeholder: 'Select...',
            width: '100%',
            allowClear: true,
            ajax: {
                url: base_url + 'Employees/get_employees_select',
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
        //$("#addBtn").on('click', function (e) {
        $('#createForm').submit(function(e){

            e.preventDefault();

            let btn = $(this);
            let btn_text = btn.html();

            $('.vm').remove();

            let operationId = $('#operationId').val();
            let operationName = $('#operationName').val();
            let description = $('#description').val();

            let criticality_id = $('#criticality_id').val();
            let criticality_text = $('#criticality_id option:selected').text();

            let machine_type_id = $('#machine_type_id').val();
            let machine_type_text = $('#machine_type_id option:selected').text();

            let smv = $('#smv').val();
            let rate = $('#rate').val();
            let date_created = $('#date_created').val();

            let created_by_id = $('#created_by').val();
            let created_by_text = $('#created_by option:selected').text();

            let approved_by_id = $('#approved_by').val();
            let approved_by_text = $('#approved_by option:selected').text();

            let documents = $('#documents').val();
            let video = $('#video').val();
            let remarks = $('#remarks').val();

            let value_id = $('#value_id').val();
            let value_text = $('#value_id option:selected').text();

            let is_valid = true;

            if (operationId == '') {
                $('#operationId').after('<p class="text-danger vm">The operationId field is required</p>');
                is_valid = false;
            }

            if (operationName == '') {
                $('#operationName').after('<p class="text-danger vm">The Operation Name field is required</p>');
                is_valid = false;
            }

            if (description == '') {
                $('#description').after('<p class="text-danger vm">The description field is required</p>');
                is_valid = false;
            }

            if (criticality_id == '') {
                $('#criticality_id_error').after('<p class="text-danger vm">The Criticality field is required</p>');
                is_valid = false;
            }

            if (machine_type_id == '') {
                $('#machine_type_id_error').after('<p class="text-danger vm">The Machine Type field is required</p>');
                is_valid = false;
            }

            if (smv == '') {
                $('#smv').after('<p class="text-danger vm">The SMV field is required</p>');
            }

            if (rate == '') {
                $('#rate').after('<p class="text-danger vm">The Rate field is required</p>');
            }

            if (date_created == '') {
                $('#date_created').after('<p class="text-danger vm">The Date Created field is required</p>');
                is_valid = false;
            }

            if (created_by == '') {
                $('#created_by_id_error').after('<p class="text-danger vm">The Created By field is required</p>');
                is_valid = false;
            }

            if (value_id == '') {
                $('#value_id_error').after('<p class="text-danger vm">The Value field is required</p>');
                is_valid = false;
            }

            if (!is_valid) {
                return false;
            }

            $.ajax({
                url: base_url + 'MachineOperationDesc/do_upload',
                type: 'post',
                dataType: 'json',
                processData:false,
                contentType:false,
                // cache:false,
                // async:false,
                data: new FormData(this),
                success: function (response) {
                    // if (response.success == true) {
                    //    //$('#msgCreate').html('<div class="alert alert-success">' + response.messages + '</div>');
                    //
                    //     let doc_success = response.doc.success;
                    //     let doc_link = response.doc.name;
                    //     let doc_icon = '';
                    //     if(doc_success){
                    //         doc_icon = '<i class="fa fa-file"></i>';
                    //     }
                    //
                    //     let video_success = response.video.success;
                    //     let video_link = response.video.name;
                    //     let video_icon = '';
                    //     if(video_success){
                    //         video_icon = '<i class="fa fa-file"></i>';
                    //     }
                    //
                    //
                    //
                    // } else {
                    //     $('#msgCreate').html('<div class="alert alert-danger">' + response.messages + '</div>');
                    // }

                    btn.html(btn_text);
                    btn.prop('disabled', false);

                }
            });

            colorTable.row.add([
                operationId + '<input type="hidden" class="operationId" name="operationId[]" value="' + operationId + '">',
                operationName + '<input type="hidden" class="operationName" name="operationName[]" value="' + operationName + '">',
                description + '<input type="hidden" class="description" name="description[]" value="' + description + '">',
                criticality_text + '<input type="hidden" class="criticality_id" name="criticality_id[]" value="' + criticality_id + '">',
                machine_type_text + '<input type="hidden" class="machine_type_id" name="machine_type_id[]" value="' + machine_type_id + '">',
                smv + '<input type="hidden" class="smv" name="smv[]" value="' + smv + '">',
                rate + '<input type="hidden" class="rate" name="rate[]" value="' + rate + '">',
                date_created + '<input type="hidden" class="date_created" name="date_created[]" value="' + date_created + '">',
                created_by_text + '<input type="hidden" class="created_by" name="created_by[]" value="' + created_by_id + '">',
                approved_by_text + '<input type="hidden" class="approved_by" name="approved_by[]" value="' + approved_by_id + '">',
                1 + '<input type="hidden" class="documents" name="documents1[]" value="' + 1 + '">',
                1 + '<input type="hidden" class="video" name="video1[]" value="' + 1 + '">',
                remarks + '<input type="hidden" class="remarks" name="remarks[]" value="' + remarks + '">',
                value_text + '<input type="hidden" class="value" name="value[]" value="' + value_id + '">',
                '<button type="button" class="btn btn-sm btn-danger btn-delete"><i class="fa fa-trash text-white"></i></button>'
            ]).draw(false);

            // $('#operationId').val('');
            // $('#operationName').val('');
            // $('#description').val('');
            // $('#criticality_id').val('').trigger('change');
            // $('#criticality_id').val('').trigger('change');
            // $('#machine_type_id').val('').trigger('change');
            // $('#smv').val('');
            // $('#rate').val('');
            // $('#date_created').val('');
            // $('#created_by').val('').trigger('change');
            // $('#approved_by').val('').trigger('change');
            // $('#documents').val('');
            // $('#video').val('');
            // $('#remarks').val('');
            // $('#value_id').val('').trigger('change');

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

            let is_valid = true;

            //each table row .color_name and .color_code
            let req_data = [];

            $('#colorTable tbody tr').each(function () {
                let operationId = $(this).find('.operationId').val();
                let operationName = $(this).find('.operationName').val();
                let description = $(this).find('.description').val();
                let criticality_id = $(this).find('.criticality_id').val();
                let machine_type_id = $(this).find('.machine_type_id').val();
                let smv = $(this).find('.smv').val();
                let rate = $(this).find('.rate').val();
                let date_created = $(this).find('.date_created').val();
                let created_by = $(this).find('.created_by').val();
                let approved_by = $(this).find('.approved_by').val();
                let documents = $(this).find('.documents').val();
                let video = $(this).find('.video').val();
                let remarks = $(this).find('.remarks').val();
                let value = $(this).find('.value').val();

                req_data.push({
                    operationId: operationId,
                    operationName: operationName,
                    description: description,
                    criticality_id: criticality_id,
                    machine_type_id: machine_type_id,
                    smv: smv,
                    rate: rate,
                    date_created: date_created,
                    created_by: created_by,
                    approved_by: approved_by,
                    documents: documents,
                    video: video,
                    remarks: remarks,
                    value: value,
                });
            });

            btn.html('<i class="fa fa-spinner fa-spin"></i> Saving...');
            btn.prop('disabled', true);


            $.ajax({
                url: base_url + 'MachineOperationDesc/createBatch',
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