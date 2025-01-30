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

        $('#edit_created_by').select2({
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

        $('#edit_approved_by').select2({
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

        // initialize the datatable
        manageTable = $('#manageTable').DataTable({
            'ajax': base_url + 'MachineOperationDesc/fetchCategoryDataApprove',
            'order': [],
            "drawCallback": function(settings){

            }
        });

        // submit the create from
        $("#createForm").unbind('submit').on('submit', function(e) {
            var form = $(this);

            // remove the text-danger
            $(".text-danger").remove();

            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                dataType: 'json',
                processData:false,
                contentType:false,
                data: new FormData(this),
                success:function(response) {

                    manageTable.ajax.reload(null, false);

                    if(response.success === true) {
                        $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                            '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
                            '</div>');

                         let operation_id = response.operation_id;

                        //$('#operationId').val('');
                        //$('.operation_id').val(operation_id);
                        location.reload();

                        // hide the modal
                        $("#addModal").modal('hide');

                        // reset the form
                        $("#createForm")[0].reset();
                        $("#createForm .form-group").removeClass('has-error').removeClass('has-success');

                    } else {

                        if(response.messages instanceof Object) {
                            $.each(response.messages, function(index, value) {
                                let id = $("#"+index);

                                if (index == 'criticality_id') {
                                    id = $("#criticality_id_error");
                                }

                                if (index == 'machine_type_id') {
                                    id = $("#machine_type_id_error");
                                }

                                if (index == 'created_by') {
                                    id = $("#created_by_id_error");
                                }

                                if (index == 'approved_by') {
                                    id = $("#approved_by_id_error");
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


        let selected_cb = [];

        $(document).on("click","#check_all:checkbox",function(e) {
            $('input:checkbox').prop('checked', this.checked);

            $('input:checkbox').each(function() {
                let id = $(this).data("id");

                let b = {};
                b["id"] = id;

                if($(this).is(':checked')){
                    if(jQuery.inArray(b, selected_cb) === -1){
                        selected_cb.push(b);

                        let selector = $('.cb[data-id="' + id + '"]');
                        //selector.parent().parent().parent().css('background-color', '#f7c8c8');
                    }
                }else {
                    removeA(selected_cb, id)
                }

            });

        });

        $('body').on('click', '.cb', function (){
            let id = $(this).data('id');

            let b = {};
            b["id"] = id;

            if($(this).is(':checked')){
                if(jQuery.inArray(b, selected_cb) === -1){
                    selected_cb.push(b);

                    let selector = $('.cb[data-id="' + id + '"]');
                    //selector.parent().parent().parent().css('background-color', '#f7c8c8');
                }
            }else {
                removeA(selected_cb, id)
            }
            //show_selected_po_nos(selected_cb)
        });

        function removeA(arr, id) {
            $.each(arr , function(index, val) {
                if(id == val.id){
                    //remove val
                    selected_cb.splice(index,1);
                    let selector = $('.cb[data-id="' + id + '"]');
                    //selector.parent().parent().parent().css('background-color', 'inherit');
                }
            });
        }

        $(document).on('click', '#approve_batch', function (e) {
            e.preventDefault();
            let save_btn = $(this);
            let r = confirm("Approve ?");
            if (r == true) {
                save_btn.prop("disabled", true);
                save_btn.html('<i class="fa fa-spinner fa-spin"></i> loading...' );
                $.ajax({
                    url: base_url + 'MachineOperationDesc/approve',
                    method: "POST",
                    dataType: "json",
                    data: {
                        'selected_cb': selected_cb,
                    },
                    success: function (data) {
                        if(data.status == true){
                            $('#messages').html("<div class='alert alert-success'>"+data.msg+"</div>");
                            $('#manageTable').DataTable().ajax.reload();
                            selected_cb = [];
                            $('#view_msg').html("");
                            $('#viewModal').modal('hide');
                        }else{
                            $('#view_msg').html("<div class='alert alert-danger'>"+data.msg+"</div>");
                        }
                        save_btn.prop("disabled", false);
                        save_btn.html('Approve' );
                    }
                });
            }
        });

    });

    function editFunc(id)
    {
        $.ajax({
            url: base_url + 'MachineOperationDesc/fetchMachineOperationDescDataById/'+id,
            type: 'post',
            dataType: 'json',
            success:function(response) {

                $("#edit_operationId").val(response.operation_id);
                $("#edit_operationName").val(response.operation_name);
                $("#edit_description").val(response.description);

                $("#edit_criticality_id").val(response.criticality_id);
                $("#edit_machine_type_id").val(response.machine_type_id);
                $("#edit_smv").val(response.smv);
                $("#edit_rate").val(response.rate);
                //$("#edit_date_created").val(response.date_created);

                // let option1 = new Option(response.created_by_name, response.created_by, true, true);
                // $('#edit_created_by').append(option1);
                // $('#edit_created_by').trigger('change');
                //
                // let option2 = new Option(response.updated_by_name, response.updated_by, true, true);
                // $('#edit_approved_by').append(option2);
                // $('#edit_approved_by').trigger('change');

                $("#edit_remarks").val(response.remarks);
                $("#edit_value_id").val(response.value_id);

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
                                        if (index == 'edit_created_by') {
                                            id = $("#edit_created_by_id_error");
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

            }
        });
    }

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

                        manageTable.ajax.reload(null, false);
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






</script>