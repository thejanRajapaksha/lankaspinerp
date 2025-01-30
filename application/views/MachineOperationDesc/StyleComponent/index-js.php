<script type="text/javascript">
    var manageTable;
    var base_url = "<?php echo base_url(); ?>";


    $(document).ready(function () {

        $('#machine_operation_desc_main_nav_link').prop('aria-expanded', 'true').removeClass('collapsed');
        $('#collapseLayoutsMachineOperationDescs').addClass('show');

        $('#operation_id').select2({
            placeholder: 'Select...',
            width: '100%',
            allowClear: true,
            dropdownParent: $('#addModal'),
            ajax: {
                url: base_url + 'MachineOperationDesc/get_operations_select',
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
            'ajax': base_url + 'StyleComponent/fetchCategoryData',
            'order': []
        });

        let colorTable = $('#colorTable').DataTable({});

        //#addBtn click event
        $("#addBtn").on('click', function (e) {

            e.preventDefault();
            let btn = $(this);
            let btn_text = btn.html();

            $('.text-danger').remove();

            let operation = $('#operation_id').select2('data');

            let operation_id = operation[0].id;
            let operation_text = operation[0].text;

            let is_valid = true;

            if (operation_id == '') {
                $('#operation_id').focus();
                $('#operation_id_error').after('<span class="text-danger">The Operation field is required</span>');
                is_valid = false;
            }

            if (!is_valid) {
                return false;
            }

            btn.html('<i class="fa fa-spinner fa-spin"></i> Saving...');
            btn.prop('disabled', true);

            $.ajax({
                url: base_url + 'MachineOperationDesc/fetchMachineOperationDescDataById/'+operation_id,
                type: 'get',
                dataType: 'json',
                success: function (response) {

                    let operation_id_input = '<input type="hidden" class="id" value="'+response.id+'"/> ' + response.operation_id + '';
                    let operation_name = response.operation_name;
                    let machine_type = response.machine_type_name;
                    let smv = response.smv;

                    colorTable.row.add([
                        operation_id_input,
                        operation_name,
                        machine_type,
                        smv,
                        '<button type="button" class="btn btn-sm btn-danger btn-delete"><i class="fa fa-trash text-white"></i></button>'
                    ]).draw(false);

                    $('#operation_id').val('').trigger('change');

                    btn.html(btn_text);
                    btn.prop('disabled', false);

                }
            });

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

            let name = $('#name').val();

            let is_valid = true;

            if (name == '') {
                $('#name').focus();
                $('#name').after('<span class="text-danger">The Name is required</span>');
                is_valid = false;
            }

            //if colorTable is empty
            if (colorTable.data().count() == 0) {
                $('#msgCreate').html('<div class="alert alert-danger">Please add at least one record</div>');
                is_valid = false;
            }

            if (!is_valid) {
                return false;
            }

            //each table row .color_name and .color_code
            let color_data = [];

            $('#colorTable tbody tr').each(function () {
                let operation_id = $(this).find('.id').val();

                color_data.push({
                    operation_id: operation_id,
                });
            });

            btn.html('<i class="fa fa-spinner fa-spin"></i> Saving...');
            btn.prop('disabled', true);

            $.ajax({
                url: base_url + 'StyleComponent/createBatch',
                type: 'post',
                dataType: 'json',
                data: {
                    color_data: color_data,
                    name: name
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

        $('#edit_operation_id').select2({
            placeholder: 'Select...',
            width: '100%',
            allowClear: true,
            dropdownParent: $('#editModal'),
            ajax: {
                url: base_url + 'MachineOperationDesc/get_operations_select',
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

        let edit_colorTable = $('#edit_colorTable').DataTable({});
        $(document.body).on("click",".btn-edit",function(e){
            let id = $(this).data('id');

            $.ajax({
                url: base_url + 'StyleComponent/fetchStyleComponentOperationsById',
                type: 'post',
                dataType: 'json',
                data: {component_id: id},
                success: function (response) {

                    $('#edit_name').val(response.component.name);

                    let operations = response.operations;
                    $.each(operations, function (index, value) {

                        let operation_id_input = '<input type="hidden" class="id" name="id[]" value="' + value.id + '">'+ value.operation_id ;
                        let operation_name = value.operation_name;
                        let machine_type = value.machine_type_name;
                        let smv = value.smv;

                        edit_colorTable.row.add([
                            operation_id_input,
                            operation_name,
                            machine_type,
                            smv,
                            '<button type="button" class="btn btn-sm btn-danger btn-delete"><i class="fa fa-trash text-white"></i></button>'
                        ]).draw(false);

                    });

                    let component = response.component;
                    $('#edit_id').val(component.id);
                    $('#edit_color_name').html(component.name);

                    $(document.body).on("click",".btn-delete",function(e){
                        edit_colorTable.row($(this).parents('tr')).remove().draw();
                    });

                    $("#edit_addBtn").on('click', function (e) {

                        e.preventDefault();
                        let btn = $(this);
                        let btn_text = btn.html();

                        $('.text-danger').remove();

                        let operation = $('#edit_operation_id').select2('data');

                        let operation_id = operation[0].id;
                        let operation_text = operation[0].text;

                        let is_valid = true;

                        if (operation_id == '') {
                            $('#edit_operation_id').focus();
                            $('#edit_operation_id_error').after('<span class="text-danger">The Operation field is required</span>');
                            is_valid = false;
                        }

                        if (!is_valid) {
                            return false;
                        }

                        btn.html('<i class="fa fa-spinner fa-spin"></i> Saving...');
                        btn.prop('disabled', true);

                        $.ajax({
                            url: base_url + 'MachineOperationDesc/fetchMachineOperationDescDataById/'+operation_id,
                            type: 'get',
                            dataType: 'json',
                            success: function (response) {

                                let operation_id_input = '<input type="hidden" class="id" value="'+response.id+'"/> ' + response.operation_id + '';
                                let operation_name = response.operation_name;
                                let machine_type = response.machine_type_name;
                                let smv = response.smv;

                                edit_colorTable.row.add([
                                    operation_id_input,
                                    operation_name,
                                    machine_type,
                                    smv,
                                    '<button type="button" class="btn btn-sm btn-danger btn-delete"><i class="fa fa-trash text-white"></i></button>'
                                ]).draw(false);

                                $('#edit_operation_id').val('').trigger('change');

                                btn.html(btn_text);
                                btn.prop('disabled', false);

                            }
                        });

                    });

                    // submit the edit from
                    $("#edit-btn").on('click', function (e) {

                        let btn = $("#edit-btn");
                        let btn_text = btn.html();
                        $('.text-danger').remove();

                        let color_data = [];

                        let name = $('#edit_name').val();
                        let id = $('#edit_id').val();

                        let is_valid = true;

                        if (name == '') {
                            $('#edit_name').focus();
                            $('#edit_name').after('<span class="text-danger">The Name is required</span>');
                            is_valid = false;
                        }

                        //if colorTable is empty
                        if (edit_colorTable.data().count() == 0) {
                            $('#msgCreate').html('<div class="alert alert-danger">Please add at least one record</div>');
                            is_valid = false;
                        }

                        if (!is_valid) {
                            return false;
                        }

                        let edit_color_data = [];

                        $('#edit_colorTable tbody tr').each(function () {
                            let operation_id = $(this).find('.id').val();

                            edit_color_data.push({
                                operation_id: operation_id,
                            });
                        });

                        btn.html('<i class="fa fa-spinner fa-spin"></i> Saving...');
                        btn.prop('disabled', true);

                        $.ajax({
                            url: base_url + 'StyleComponent/editBatch',
                            type: 'post',
                            dataType: 'json',
                            data: {
                                color_data: edit_color_data,
                                name: name,
                                id: id
                            },
                            success: function (response) {
                                if (response.success == true) {
                                    $('#messages').html('<div class="alert alert-success">' + response.messages + '</div>');
                                    //hide addModal after 1 second
                                    //setTimeout(function () {
                                        $('#editModal').modal('hide');
                                        //reload the manageTable
                                        manageTable.ajax.reload(null, false);
                                        edit_colorTable.clear().draw();
                                    //}, 1000);

                                } else {
                                    $('#msgEdit').html('<div class="alert alert-danger">' + response.messages + '</div>');
                                }
                                btn.html('Save Changes');
                                btn.prop('disabled', false);
                            }
                        });

                        return false;
                    });

                }
            });

        })

    });

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
        $.ajax({
            url: base_url + 'StyleComponent/fetchStyleComponentOperationsById',
            type: 'post',
            dataType: 'json',
            data: {component_id: id},
            success: function (response) {

                let res_table = '<table class="table table-striped table-sm" id="viewTable">';
                let res_tr = '<thead><tr><th>Operation ID</th><th>Operation Name</th><th>Machine Type</th> <th> SMV </th> </tr></thead> <tbody>';
                $.each(response.operations, function (index, value) {
                    res_tr += '<tr>' +
                        '<td>' + value.operation_id + '</td>' +
                        '<td>' + value.operation_name + '</td>' +
                        '<td>' + value.machine_type_name + '</td>' +
                        '<td>' + value.smv + '</td>' +
                        '</tr>';
                });
                res_table += res_tr + '</tbody> </table>';

                let style_name = response.component.name;
                $('#view_style_name').html(style_name);

                $("#viewModal .modal-body #viewResponse").html(res_table);
                $('#viewTable').DataTable();

            }
        });
    }


</script>