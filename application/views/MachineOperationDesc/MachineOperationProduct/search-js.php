<script type="text/javascript">
    var manageTable;
    var base_url = "<?php echo base_url(); ?>";

    $(document).ready(function() {

        $('#machine_requirement_nav_link').prop('aria-expanded', 'true').removeClass('collapsed');
        $('#collapseLayoutsMachineRequirements').addClass('show');

        //line_select
        // $("input[name='factory']").change(function(e){
        //     let val = $(this).val();
        //     if(val == 'factory'){
        //         $('.line_select').css('display','none');
        //     }else{
        //         $('.line_select').css('display','block');
        //     }
        // });


        $('#operation_filter').select2({
            placeholder: 'Select...',
            width: '100%',
            allowClear: true,
            ajax: {
                url:  base_url + 'MachineOperationDesc/get_operations_select',
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

        $('#product_filter').select2({
            placeholder: 'Select...',
            width: '100%',
            allowClear: true,
            ajax: {
                url:  base_url + 'MachineOperationProduct/get_products_select',
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

        load_dt();

        $('#filter_button').click(function(e) {

            load_dt();

        });

        function load_dt()
        {
            let rad = $('input[name="operation"]:checked').val();
            let operation = $('#operation_filter').val();
            let product = $('#product_filter').val();
            let date_from = $('#date_from_filter').val();
            let date_to = $('#date_to_filter').val();

            $.ajax({
                url: base_url + 'MachineOperationProduct/get_search_dt',
                type: 'post',
                data: {'rad': rad, 'operation': operation, 'product': product, 'date_from': date_from, 'date_to': date_to},
                dataType: 'json',
                success:function(response) {

                    if(response[0].status == true){

                        let res = response[0].data;

                        let res_table = '<table class="table table-striped table-sm">';
                        if(rad == 'operation'){
                            res_table += '<thead> <tr> <td> Operation </td> <td> No of Products </td>  <td> </td> </tr> </thead>';

                            for(let j = 0; j < res.length; j++) {

                                let operation_name = res[j].operation_name;
                                let products_count = res[j].products_count;
                                let operation_id = res[j].operation_id;
                                let title = res[j].operation_name + ' - ' + res[j].products_count ;

                                res_table += '<tr>' +
                                    '<td>' +
                                    operation_name +
                                    '</td>' +
                                    '<td>' +
                                    products_count +
                                    '</td>' +
                                    '<td>' +
                                    '<a href="#" class="btn btn-info btn-sm view_operation_products" ' +
                                    'data-operation_id="'+ operation_id +'"' +
                                    ' data-operation="'+ operation +'"' +
                                    ' data-product="'+product+'"  ' +
                                    ' data-date_from="'+date_from+'"  ' +
                                    ' data-date_to="'+date_to+'"  ' +
                                    '> <i class="fa fa-eye"></i> </a> ' +
                                    '</td>' +
                                    '</tr>';
                            }
                        }else{
                            res_table += '<thead> <tr> <td> Product </td> <td> No of Operations </td> <td> </td> </tr> </thead>';

                            for(let j = 0; j < res.length; j++) {

                                let product_name = res[j].product_name;
                                let product_id = res[j].product_id;
                                let operations_count = res[j].operations_count;

                                let title = res[j].product_name + ' - ' + res[j].operations_count ;

                                res_table += '<tr>' +
                                    '<td>' +
                                    product_name +
                                    '</td>' +
                                    '<td>' +
                                    operations_count +
                                    '</td>' +
                                    '<td>' +
                                    '<a href="#" class="btn btn-info btn-sm view_product_operations" ' +
                                    'data-product_id="'+ product_id+'"' +
                                    ' data-operation="'+ operation +'"' +
                                    ' data-product="'+product+'"  ' +
                                    ' data-date_from="'+date_from+'"  ' +
                                    ' data-date_to="'+date_to+'"  ' +
                                    ' > <i class="fa fa-eye"></i> </a> ' +
                                    '</td>' +
                                    '</tr>';
                            }
                        }

                        res_table += '</table>';

                        $("#search_res").html(res_table);

                    }else{
                        let res_table = '<div class="alert alert-danger"> '+ response[0].message +' </div>';

                        $("#search_res").html(res_table);
                    }

                }
            });

        }

        //view_emps
        $(document).on("click",".view_operation_products",function() {

            let operation_id = $(this).data('operation_id');
            let operation = $(this).data('operation');
            let product = $(this).data('product');
            let date_from = $(this).data('date_from');
            let date_to = $(this).data('date_to');
            let title = $(this).data('title');

            $.ajax({
                url: base_url + 'MachineOperationProduct/get_operation_products_by_operation_id',
                type: 'post',
                dataType: 'json',
                data: {'operation_id': operation_id, 'operation': operation, 'product': product, 'date_from': date_from, 'date_to': date_to},
                success:function(rating_data) {

                    let res_table = '<table class="table table-sm">';
                    res_table += '<thead> <tr> ' +
                        '<td> Product </td>' +
                        ' <td> Category </td>' +
                        ' <td> Process </td> ' +
                        ' <td> Component </td> ' +
                        ' <td> Operation </td> ' +
                        ' <td> Sequence </td> ' +
                        ' <td> SMV </td> ' +
                        '</tr> </thead>';
                    for(let j = 0; j < rating_data.length; j++) {

                        let product_name = rating_data[j].product_name;
                        let category_name = rating_data[j].category_name;
                        let process_name = rating_data[j].process_name;
                        let component_name = rating_data[j].component_name;
                        let operation_name = rating_data[j].operation_name;
                        let sequence = rating_data[j].sequence;
                        let smv = rating_data[j].smv;
                        let assigned_by_name = rating_data[j].assigned_by_name;

                        res_table += '<tr';

                        res_table += '>' +
                            '<td>' +
                            product_name +
                            '</td>' +
                            '<td>' +
                            category_name +
                            '</td>' +
                            '<td>' +
                            process_name +
                            '</td>' +
                            '<td>' +
                            component_name +
                            '</td>' +
                            '<td>' +
                            operation_name +
                            '</td>' +
                            '<td>' +
                            sequence +
                            '</td>' +
                            '<td>' +
                            smv +
                            '</td>' +
                            '</tr>';
                    }

                    res_table += '</table>'

                    let operation_name = rating_data[0].operation_name;

                    let heading = operation_name;

                    $('#machine_name').html(heading);

                    $("#viewModal .modal-body #viewResponse").html(res_table);

                    $('#viewModal').modal('show');

                }
            });
        });

        $(document).on("click",".view_product_operations",function() {

            let product_id = $(this).data('product_id');
            let operation = $(this).data('operation');
            let product = $(this).data('product');
            let date_from = $(this).data('date_from');
            let date_to = $(this).data('date_to');
            let title = $(this).data('title');

            $.ajax({
                url: base_url + 'MachineOperationProduct/get_product_operations_by_operation_id',
                type: 'post',
                dataType: 'json',
                data: {'product_id': product_id, 'operation': operation, 'product': product, 'date_from': date_from, 'date_to': date_to},
                success:function(rating_data) {

                    if(rating_data != ''){
                        let res_table = '<table class="table table-sm">';
                        res_table += '<thead> <tr> ' +
                            '<td> Operation ID </td> ' +
                            '<td> Operation Name </td>' +
                            ' <td> Description </td> ' +
                            '<td> Criticality </td> ' +
                            '<td> Machine </td> ' +
                            '<td> SMV </td> ' +
                            '<td> Rate </td> ' +
                            '<td> Documents </td> ' +
                            '<td> Video </td> ' +
                            '<td> Remarks </td> ' +
                            '<td> Value </td> ' +
                            '</tr> </thead>';
                        for(let j = 0; j < rating_data.length; j++) {

                            let operation_id = rating_data[j].operation_id;
                            let operation_name = rating_data[j].operation_name;
                            let description = rating_data[j].description;
                            let criticality_name = rating_data[j].criticality_name;
                            let machine_type_name = rating_data[j].machine_type_name;
                            let smv = rating_data[j].smv;
                            let rate = rating_data[j].rate;
                            let doc_link = rating_data[j].doc_link;

                            res_table += '<tr';

                            res_table += '>' +
                                '<td>' +
                                factory_name +
                                '</td>' +
                                '<td>' +
                                line_name +
                                '</td>' +
                                '<td>' +
                                slot_name +
                                '</td>' +
                                '<td>' +
                                s_no +
                                '</td>' +
                                '</tr>';
                        }

                        res_table += '</table>'

                        let machine_type_name = rating_data[0].machine_type_name;
                        let factory_name = rating_data[0].factory_name;
                        let line_name = rating_data[0].line_name;

                        let heading = factory_name + ' - ' + line_name + ' - ' + machine_type_name;

                        $('#machine_name').html(heading);

                        $("#viewModal .modal-body #viewResponse").html(res_table);

                        $('#viewModal').modal('show');

                    }else{
                        let html = '<div class="alert alert-danger"> No Available Machines </div>';
                        $("#viewModal .modal-body #viewResponse").html(html);

                        $('#viewModal').modal('show');
                    }

                }
            });
        });


    });
</script>