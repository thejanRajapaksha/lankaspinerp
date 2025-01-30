<script type="text/javascript">
    var manageTable;
    var base_url = "<?php echo base_url(); ?>";


    $(document).ready(function () {

        $('#machines_main_nav_link').prop('aria-expanded', 'true').removeClass('collapsed');
        $('#collapseLayoutsMachines').addClass('show');

        $('#machine_type_id').select2({
            placeholder: 'Select...',
            width: '100%',
            allowClear: true,
            dropdownParent: $('#addModal'),
            ajax: {
                url: base_url + 'machineTypes/get_machine_types_select',
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

        $('#operation_id').select2({
            placeholder: 'Select...',
            width: '100%',
            allowClear: true,
            multiple: true,
            dropdownParent: $('#addModal'),
            ajax: {
                url: base_url + 'operationsForMachines/get_operations_for_machines_select',
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

        //operation_id select2 selected
        $('#operation_id').on('select2:select', function (e) {
            //remove null option
            $('#operation_id option[value=""]').remove();
        });

        // initialize the datatable
        manageTable = $('#manageTable').DataTable({
            'ajax': base_url + 'MachineOperations/fetchCategoryData',
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
                        $('#machine_type_id').val('').trigger('change');
                        $("#createForm .form-group").removeClass('has-error').removeClass('has-success');

                    } else {

                        if (response.messages instanceof Object) {
                            $.each(response.messages, function (index, value) {
                                var id = $("#" + index);
                                if (index == 'machine_type_id') {
                                    id = $("#machine_type_id_error");
                                }

                                if (index == 'operation_id') {
                                    id = $("#operation_id_error");
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

        $('#removeModal').on('show.bs.modal', function () {
            //show view modal
            $('#viewModal').modal('hide');
        });

        $('#removeModal').on('hidden.bs.modal', function () {
            //show view modal
            $('#viewModal').modal('show');
        });

    });

    //view function
    function viewFunc(id)
    {
        $.ajax({
            url: base_url + 'MachineOperations/fetchMachineOperationsByMachineInId/'+id,
            type: 'post',
            dataType: 'json',
            success:function(response) {

                let res_table = '<table class="table table-striped table-sm" id="viewTable">';
                let res_tr = '<thead><tr><th>Operation</th><th>Type</th> <th> Action </th> </tr></thead> <tbody>';
                $.each(response, function(index, value) {
                     if(index != 'machine_type_name'){
                         res_tr += '<tr>' +
                             '<td>' + value.operation_name + '</td>' +
                             '<td>' + value.operation_type_name + '</td>' +
                             '<td> <button type="button" class="btn btn-default btn-sm" onclick="removeFunc('+value.id+')" data-toggle="modal" data-target="#removeModal"><i class="text-danger fa fa-trash"></i> </td>' +
                             '</tr>';
                     }
                });
                res_table += res_tr + '</tbody> </table>';

                let machine_type_name = response.machine_type_name;
                $('#machine_type_name').html(machine_type_name);

                $("#viewModal .modal-body #viewResponse").html(res_table);
                $('#viewTable').DataTable();

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
                    data: {machine_operation_id: id},
                    dataType: 'json',
                    success: function (response) {

                        let machine_type_id = response.machine_type_id;

                        viewFunc(machine_type_id);
                        manageTable.ajax.reload(null, false);
                        // hide the modal
                        $("#removeModal").modal('hide');
                        $('#viewModal').modal('show');

                        if (response.success === true) {
                            $("#viewMsg").html('<div class="alert alert-success alert-dismissible" role="alert">' +
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                                '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>' + response.messages +
                                '</div>');

                        } else {

                            $("#viewMsg").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
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


</script>