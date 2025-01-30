<script type="text/javascript">
    var manageTable;
    var base_url = "<?php echo base_url(); ?>";


    $(document).ready(function () {

        let color = "#00ba94";

        // Define card
        function card(color, component_id, component_text) {
            return (
                `<div class="kanban-card" id="cid_`+component_id+`" style="background-color:` +
                color +
                `">
                <input type="hidden" class="component_id" value="`+component_id+`">
                <input type="hidden" class="sequence">
           <table> <tr> <td style="width: 150px">     ` +

                component_text +
                `
                </td>
                <td>
                    <h5 class="seq_outer"> Sequence : <span> <strong class="seq"> </strong> </span> </h5>
                </td>
            </tr> </table>
            <button class="btn btn-sm btn-danger" data-id="`+component_id+`">
                                                        <span class="fa fa-times"></span>
                                                    </button>
        </div>`
            );
        }

        // Delete card
        $(document).on("click", ".kanban-card > button", function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            $(this)
                .parent()
                .fadeOut(250, function() {
                    $(this).remove();
                    update_seq_edit();
                    update_seq();
                    $('#cido_'+id).remove();
                });
        });

        $(function() {
            $("#unselected")
                .sortable({
                    connectWith: ".list-body"
                })
                .disableSelection();
        });

        $("#selected")
            .sortable({
                connectWith: ".list-body",
                start: function(e, ui) {
                    // creates a temporary attribute on the element with the old index
                    //$(this).attr('data-previndex', ui.item.index());
                },
                update: function(e, ui) {
                    // // gets the new and old index then removes the temporary attribute
                    // var newIndex = ui.item.index();
                    // var oldIndex = $(this).attr('data-previndex');
                    // var element_id = ui.item.attr('id');
                    // //alert('id of Item moved = '+element_id+' old position = '+oldIndex+' new position = '+newIndex);
                    // $(this).removeAttr('data-previndex');
                    // //$(this).find('.kanban-card table tr td h5 .seq').html(newIndex)
                    // //$(this).closest('.kanban-card').children('table').closest('tr').find('td').css('border', 'solid 2px red')
                    // //$(this).find('.seq').html(newIndex)
                    update_seq();
                }
            })
            .disableSelection();

        $(function() {
            $("#edit_unselected")
                .sortable({
                    connectWith: ".list-body"
                })
                .disableSelection();
        });

        $("#edit_selected")
            .sortable({
                connectWith: ".list-body",
                start: function(e, ui) {
                },
                update: function(e, ui) {
                    update_seq_edit();
                }
            })
            .disableSelection();

        function update_seq(){
            let start_seq_html = 1;
            let start_seq_input = 1;

            var testimonialElements = $("#selected .seq");
            for(var i=0; i<testimonialElements.length; i++){
                var element = testimonialElements.eq(i);
                //do something with element
                element.html(start_seq_html)
                start_seq_html++;
            }

            var testimonialElements_input = $("#selected .sequence");
            for(var i=0; i<testimonialElements_input.length; i++){
                var element_input = testimonialElements_input.eq(i);
                //do something with element
                element_input.val(start_seq_input)
                start_seq_input++;
            }
        }

        function update_seq_edit(){
            let start_seq_html = 1;
            let start_seq_input = 1;

            var testimonialElements = $("#edit_selected .seq");
            for(var i=0; i<testimonialElements.length; i++){
                var element = testimonialElements.eq(i);
                //do something with element
                element.html(start_seq_html)
                start_seq_html++;
            }

            var testimonialElements_input = $("#edit_selected .sequence");
            for(var i=0; i<testimonialElements_input.length; i++){
                var element_input = testimonialElements_input.eq(i);
                //do something with element
                element_input.val(start_seq_input)
                start_seq_input++;
            }

        }


        $('#machine_operation_desc_main_nav_link').prop('aria-expanded', 'true').removeClass('collapsed');
        $('#collapseLayoutsMachineOperationDescs').addClass('show');


        $('#product_id').select2({
            placeholder: 'Select...',
            width: '100%',
            allowClear: true,
            dropdownParent: $('#addModal'),
            ajax: {
                url: base_url + 'MachineOperationDesc/get_products_select',
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

        $('#category_id').select2({
            placeholder: 'Select...',
            width: '100%',
            allowClear: true,
            dropdownParent: $('#addModal'),
            ajax: {
                url: base_url + 'MachineOperationDesc/get_categories_select',
                dataType: 'json',
                data: function (params) {
                    return {
                        term: params.term || '',
                        page: params.page || 1,
                        product_id: $('#product_id').val()
                    }
                },
                cache: true
            }
        });

        $('#process_id').select2({
            placeholder: 'Select...',
            width: '100%',
            allowClear: true,
            dropdownParent: $('#addModal'),
            ajax: {
                url: base_url + 'MachineOperationDesc/get_process_select',
                dataType: 'json',
                data: function (params) {
                    return {
                        term: params.term || '',
                        page: params.page || 1,
                        product_id: $('#product_id').val()
                    }
                },
                cache: true
            }
        });

        $('#component_id').select2({
            placeholder: 'Select...',
            width: '100%',
            allowClear: true,
            dropdownParent: $('#addModal'),
            ajax: {
                url: base_url + 'StyleComponent/get_component_select',
                dataType: 'json',
                data: function (params) {
                    return {
                        term: params.term || '',
                        page: params.page || 1,
                        product_id: $('#product_id').val()
                    }
                },
                cache: true
            }
        });




        //edit
        $('#edit_product_id').select2({
            placeholder: 'Select...',
            width: '100%',
            allowClear: true,
            dropdownParent: $('#editModal'),
            ajax: {
                url: base_url + 'MachineOperationDesc/get_products_select',
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

        $('#edit_category_id').select2({
            placeholder: 'Select...',
            width: '100%',
            allowClear: true,
            dropdownParent: $('#editModal'),
            ajax: {
                url: base_url + 'MachineOperationDesc/get_categories_select',
                dataType: 'json',
                data: function (params) {
                    return {
                        term: params.term || '',
                        page: params.page || 1,
                        product_id: $('#product_id').val()
                    }
                },
                cache: true
            }
        });

        $('#edit_process_id').select2({
            placeholder: 'Select...',
            width: '100%',
            allowClear: true,
            dropdownParent: $('#editModal'),
            ajax: {
                url: base_url + 'MachineOperationDesc/get_process_select',
                dataType: 'json',
                data: function (params) {
                    return {
                        term: params.term || '',
                        page: params.page || 1,
                        product_id: $('#product_id').val()
                    }
                },
                cache: true
            }
        });

        $('#edit_component_id').select2({
            placeholder: 'Select...',
            width: '100%',
            allowClear: true,
            dropdownParent: $('#editModal'),
            ajax: {
                url: base_url + 'StyleComponent/get_component_select',
                dataType: 'json',
                data: function (params) {
                    return {
                        term: params.term || '',
                        page: params.page || 1,
                        product_id: $('#product_id').val()
                    }
                },
                cache: true
            }
        });

        // initialize the datatable
        manageTable = $('#manageTable').DataTable({
            'ajax': base_url + 'MachineOperationProduct/fetchCategoryData',
            'order': []
        });

        $(document.body).on("change","#component_id",function(e) {

            var data = $('#component_id').select2('data')
            let component_id = data[0].id;
            let component_text = data[0].text;

            if(component_id == ''){
                return false;
            }

            $('#selected').append(card(color, component_id, component_text));
            update_seq();

            //get operations for component_id
            $.ajax({
                url: base_url + 'StyleComponent/fetchStyleComponentOperationsById',
                type: 'post',
                dataType: 'json',
                data: {component_id: component_id},
                success: function (response) {

                    let html = ' ';

                    html += '<div class="card mb-2" id="cido_'+component_id+'" >' +
                        '<div class="card-body">' +
                        '<h5 class="card-title" style="margin: 0 !important;" > '+ response.component.name +' - Component </h5>';

                    $.each(response.operations, function (index, value) {
                        html += '<p class="card-text" style="margin: 0 !important;" >'+ value.operation_name +'</p>';
                    });

                    html +=    '</div>' +
                        '</div>';

                    $("#addModal .modal-body #sc_operations").append(html);

                }
            });

        });


        // $("#addBtn").on('click', function (e) {
        $("#createForm").unbind('submit').on('submit', function(e) {
            var form = $(this);
            e.preventDefault();

            $(".text-danger").remove();

            let btn = $(this);
            let btn_text = btn.html();

            $('.vm').remove();

            var formData = new FormData(this);

            $('#selected .kanban-card').each(function () {
                let sequence = $(this).find('.sequence').val();
                let component_id = $(this).find('.component_id').val();

                if(component_id != undefined){
                    formData.append('sequence[]', sequence);
                    formData.append('component_id[]', component_id);
                }

            });

            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                dataType: 'json',
                processData:false,
                contentType:false,
                data: formData,
                success:function(response) {

                    if(response.success === true) {
                        $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                            '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
                            '</div>');

                        manageTable.ajax.reload(null, false);

                        // hide the modal
                        $("#addModal").modal('hide');

                        $('#product_id').val('').trigger('change');
                        $('#category_id').val('').trigger('change');
                        $('#process_id').val('').trigger('change');
                        $('#component_id').val('').trigger('change');

                        $('#selected').html('');
                        $('#sc_operations').html('');

                        // reset the form
                        $("#createForm")[0].reset();
                        $("#createForm .form-group").removeClass('has-error').removeClass('has-success');

                    } else {

                        if(response.messages instanceof Object) {
                            $.each(response.messages, function(index, value) {
                                let id = $("#"+index);

                                if (index == 'product_id') {
                                    id = $("#product_id_error");
                                }

                                if (index == 'category_id') {
                                    id = $("#category_id_error");
                                }

                                if (index == 'process_id') {
                                    id = $("#process_id_error");
                                }

                                if (index == 'component_id') {
                                    id = $("#component_id_error");
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

                            let operation_id = response.component_id;

                            if(operation_id != 'Undefined'){

                                $("#component_id_error").html('<p class="text-danger">'+
                                    ' '+operation_id+
                                    '</p>');
                            }else{
                                $("#msgCreate").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
                                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                                    '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
                                    '</div>');
                            }
                        }
                    }
                }
            });

        });

        $(document.body).on("change","#edit_component_id",function(e) {

            let component_id = $(this).val();

            $.ajax({
                url: base_url + 'StyleComponent/fetchMachineOperationDescDataByComponentId/'+component_id,
                type: 'get',
                dataType: 'json',
                success: function (response) {

                    $.each(response, function(i, item) {
                        let id = item.id;
                        let component_id = item.component_id;
                        let component_name = item.component_name;
                        $('#edit_selected').append(card(color, component_id, component_name));
                        update_seq_edit();
                    });

                }
            });

            $.ajax({
                url: base_url + 'StyleComponent/fetchStyleComponentOperationsById',
                type: 'post',
                dataType: 'json',
                data: {component_id: component_id},
                success: function (response) {

                    let html = ' ';

                    html += '<div class="card mb-2" id="cido_'+component_id+'" >' +
                        '<div class="card-body">' +
                        '<h5 class="card-title" style="margin: 0 !important;" > '+ response.component.name +' - Component </h5>';

                    $.each(response.operations, function (index, value) {
                        html += '<p class="card-text" style="margin: 0 !important;" >'+ value.operation_name +'</p>';
                    });

                    html +=    '</div>' +
                        '</div>';

                    $("#editModal .modal-body #edit_sc_operations").append(html);

                }
            });

        });




    });

    function editFunc(id)
    {
        $('#edit_selected').html('');
        $('#edit_unselected').html('');

        function card(color, component_id, component_text, sequence) {
            return (
                `<div class="kanban-card" id="cid_`+component_id+`" style="background-color:` +
                color +
                `">
                <input type="hidden" class="component_id" value="`+component_id+`">
                <input type="hidden" class="sequence" value="`+sequence+`">
           <table> <tr> <td style="width: 150px">     ` +

                component_text +
                `
                </td>
                <td>
                    <h5 class="seq_outer"> Sequence : <span> <strong class="seq"> `+sequence+` </strong> </span> </h5>
                </td>
            </tr> </table>
            <button class="btn btn-sm btn-danger" data-id="`+component_id+`">
                                                        <span class="fa fa-times"></span>
                                                    </button>
        </div>`
            );
        }

        $.ajax({
            url: base_url + 'MachineOperationProduct/fetchMachineOperationProductDataById/'+id,
            type: 'post',
            dataType: 'json',
            success:function(data) {

                let response = data.main_data;

                let option1 = new Option(response.product_name, response.product_id, true, true);
                $('#edit_product_id').append(option1);
                $('#edit_product_id').trigger('change');

                let option2 = new Option(response.category_name, response.category_id, true, true);
                $('#edit_category_id').append(option2);
                $('#edit_category_id').trigger('change');

                let option3 = new Option(response.process_name, response.process_id, true, true);
                $('#edit_process_id').append(option3);
                $('#edit_process_id').trigger('change');

                let op = data.op;

                $.each(op, function(i, item) {

                    let color = '#00ba94';
                    let id = item.id;
                    let component_id = item.component_id;
                    let component_name = item.component_name;
                    let sequence = item.sequence;
                    $('#edit_selected').append(card(color, component_id, component_name, sequence));

                });

                let ops = data.ops;

                let html = ' ';

                html += '<div class="card mb-2"   >' +
                    '<div class="card-body">' ;

                    $.each(ops, function(i, item) {

                        html += '<p class="card-text" style="margin: 0 !important;" >'+ item.operation_name +'</p>';
                    });

                html +=    '</div>' +
                    '</div>';

                $("#editModal .modal-body #edit_sc_operations").append(html);




                // submit the edit from
                $("#updateForm").unbind('submit').bind('submit', function() {
                    var form = $(this);

                    // remove the text-danger
                    $(".text-danger").remove();

                    let btn = $(this);
                    let btn_text = btn.html();

                    var formData = new FormData(this);

                    $('#edit_selected .kanban-card').each(function () {
                        let sequence = $(this).find('.sequence').val();
                        let component_id = $(this).find('.component_id').val();

                        if(component_id != undefined){
                            formData.append('sequence[]', sequence);
                            formData.append('component_id[]', component_id);
                        }

                    });

                    $.ajax({
                        url: form.attr('action') + '/' + id,
                        type: form.attr('method'),
                        processData:false,
                        contentType:false,
                        dataType: 'json',
                        data: formData,
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

                                $('#edit_operation_id').val('').trigger('change');

                            } else {

                                if(response.messages instanceof Object) {
                                    $.each(response.messages, function(index, value) {
                                        var id = $("#"+index);
                                        if (index == 'edit_product_id') {
                                            id = $("#edit_product_id_error");
                                        }

                                        if (index == 'edit_category_id') {
                                            id = $("#edit_category_id_error");
                                        }

                                        if (index == 'edit_process_id') {
                                            id = $("#edit_process_id_error");
                                        }

                                        if (index == 'edit_component_id') {
                                            id = $("#edit_component_id_error");
                                        }

                                        if (index == 'edit_operation_id') {
                                            id = $("#edit_operation_id_error");
                                        }

                                        if (index == 'edit_assigned_by_id') {
                                            id = $("#edit_assigned_by_id_error");
                                        }

                                        id.closest('.form-group')
                                            .removeClass('has-error')
                                            .removeClass('has-success')
                                            .addClass(value.length > 0 ? 'has-error' : 'has-success');

                                        id.after(value);

                                    });
                                } else {
                                    let operation_id = response.edit_operation_id;

                                    if(operation_id != 'Undefined'){

                                        $("#edit_operation_id_error").html('<p class="text-danger">'+
                                            ' '+response.operation_id+
                                            '</p>');
                                    }else{
                                        $("#msgUpdate").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
                                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                                            '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
                                            '</div>');
                                    }
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

    function viewFunc(id) {
        $.ajax({
            url: base_url + 'MachineOperationProduct/fetchProductOperationsByMopId',
            type: 'post',
            dataType: 'json',
            data: {mop_id: id},
            success: function (response) {

                let res_table = '<table class="table table-striped table-sm" id="viewTable">';
                let res_tr = '<thead><tr> <th> Component Sequence </th> <th> Component </th> <th>Operation Name</th> <th> Machine </th> <th> SMV </th>  <th>Target Per Hour</th> <th> Rate </th>  </tr></thead> <tbody>';
                $.each(response.op, function (index, value) {
                    let tph = value.smv / 60;
                    res_tr += '<tr>' +
                        '<td>' + value.sequence + '</td>' +
                        '<td>' + value.component_name + '</td>' +
                        '<td>' + value.operation_name + '</td>' +
                        '<td>' + value.machine_type_name + '</td>' +
                        '<td>' + value.smv + '</td>' +
                        '<td>' + tph.toFixed(2)+ '</td>' +
                        '<td>' + value.rate + '</td>' +

                        '</tr>';
                });
                res_table += res_tr + '</tbody> </table>';

                let style_name = response.main_data.product_name;
                $('#view_product_name').html(style_name);

                $("#viewModal .modal-body #viewResponse").html(res_table);
                $('#viewTable').DataTable();

            }
        });
    }






</script>