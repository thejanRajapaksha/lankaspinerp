<script type="text/javascript">
    var manageTable;
    var base_url = "<?php echo base_url(); ?>";

    $(document).ready(function() {

        $('#machine_requirement_nav_link').prop('aria-expanded', 'true').removeClass('collapsed');
        $('#collapseLayoutsMachineRequirements').addClass('show');

        //line_select
        $("input[name='factory']").change(function(e){
            let val = $(this).val();
            if(val == 'factory'){
                $('.line_select').css('display','none');
            }else{
                $('.line_select').css('display','block');
            }
        });


        $('#factory_id_filter').select2({
            placeholder: 'Select...',
            width: '100%',
            allowClear: true,
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

        $('#line_id_filter').select2({
            placeholder: 'Select...',
            width: '100%',
            allowClear: true,
            ajax: {
                url:  base_url + 'lines/get_lines_select',
                dataType: 'json',
                data: function(params) {
                    return {
                        term: params.term || '',
                        page: params.page || 1,
                        factory_id: $('#factory_id_filter').val()
                    }
                },
                cache: true
            }
        });

        $('#forecast_filter').select2({
            placeholder: 'Select...',
            width: '100%',
            allowClear: true,
            ajax: {
                url:  base_url + 'MachineRequirements/get_forecast_select',
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
            let rad = $('input[name="factory"]:checked').val();
            let factory = $('#factory_id_filter').val();
            let line = $('#line_id_filter').val();
            let forecast = $('#forecast_filter').val();

            $.ajax({
                url: base_url + 'MachineRequirements/get_machine_requirements',
                type: 'post',
                data: {'rad': rad, 'factory': factory, 'line': line, 'forecast': forecast},
                dataType: 'json',
                success:function(response) {

                    if(response[0].status == true){

                        let res = response[0].data;

                        let res_table = '<table class="table table-striped table-sm">';
                        if(rad == 'factory'){
                            res_table += '<thead> <tr> <td> Factory </td> <td> Machine Type </td> <td> Requirement </td> <td> Available </td>  <td> </td> </tr> </thead>';

                            for(let j = 0; j < res.length; j++) {

                                let operation = res[j].operation_name;
                                let machine_type_name = res[j].machine_type_name;
                                let machine_type_id = res[j].machine_type_id;
                                let required_machines = res[j].required_machines;
                                let total_machines = res[j].total_machines;
                                let factory_name = res[j].factory_name;
                                let factory_id = res[j].factory_id;
                                let operation_id = res[j].operation_id;
                                let title = res[j].factory_name + ' - ' + res[j].machine_type_name ;

                                res_table += '<tr>' +
                                    '<td>' +
                                    factory_name +
                                    '</td>' +
                                    '<td>' +
                                    machine_type_name +
                                    '</td>' +
                                    '<td>' +
                                    required_machines +
                                    '</td>' +
                                    '<td>' +
                                    total_machines +
                                    '</td>' +
                                    '<td>' +
                                    '<a href="#" class="btn btn-info btn-sm view_machines_factory" data-machine_type_id="'+ machine_type_id +'" data-factory_id="'+ factory_id +'" data-title="'+ title +'" > <i class="fa fa-eye"></i> </a> ' +
                                    '</td>' +
                                    '</tr>';
                            }
                        }else{
                            res_table += '<thead> <tr> <td> Factory </td> <td> Line </td> <td> Machine Type </td> <td> Requirement </td> <td> Available </td>  <td> </td> </tr> </thead>';

                            for(let j = 0; j < res.length; j++) {

                                let operation = res[j].operation_name;
                                let machine_type_name = res[j].machine_type_name;
                                let machine_type_id = res[j].machine_type_id;
                                let required_machines = res[j].required_machines;
                                let total_machines = res[j].total_machines;
                                let factory_name = res[j].factory_name;
                                let line_name = res[j].line_name;
                                let line_id = res[j].line_id;
                                let operation_id = res[j].operation_id;
                                let title = res[j].line_name + ' - ' + res[j].operation_name ;

                                res_table += '<tr>' +
                                    '<td>' +
                                    factory_name +
                                    '</td>' +
                                    '<td>' +
                                    line_name +
                                    '</td>' +
                                    '<td>' +
                                    machine_type_name +
                                    '</td>' +
                                    '<td>' +
                                    required_machines +
                                    '</td>' +
                                    '<td>' +
                                    total_machines +
                                    '</td>' +
                                    '<td>' +
                                    '<a href="#" class="btn btn-info btn-sm view_machines_line" data-machine_type_id="'+ machine_type_id +'" data-line_id="'+ line_id +'" data-title="'+ title +'" data-id="'+operation_id+'"> <i class="fa fa-eye"></i> </a> ' +
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
        $(document).on("click",".view_machines_factory",function() {

            let factory_id = $(this).data('factory_id');
            let machine_type_id = $(this).data('machine_type_id');
            let title = $(this).data('title');

            $.ajax({
                url: base_url + 'MachineRequirements/get_machines_by_factory_id_machine_type_id/'+ machine_type_id + '/' + factory_id ,
                type: 'post',
                dataType: 'json',
                success:function(rating_data) {

                    let res_table = '<table class="table table-sm">';
                    res_table += '<thead> <tr> <td> Line </td> <td> Slot </td> <td> Machine S No </td> <td> </td> </tr> </thead>';
                    for(let j = 0; j < rating_data.length; j++) {

                        let s_no = rating_data[j].s_no;
                        let line_name = rating_data[j].line_name;
                        let slot_name = rating_data[j].slot_name;
                        let factory_name = rating_data[j].factory_name;

                        res_table += '<tr';

                        res_table += '>' +
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

                    let heading = factory_name + ' - ' +  machine_type_name;

                    $('#machine_name').html(heading);

                    $("#viewModal .modal-body #viewResponse").html(res_table);

                    $('#viewModal').modal('show');

                }
            });
        });

        $(document).on("click",".view_machines_line",function() {

            let line_id = $(this).data('line_id');
            let machine_type_id = $(this).data('machine_type_id');
            let title = $(this).data('title');

            $.ajax({
                url: base_url + 'MachineRequirements/get_machines_by_line_id_machine_type_id/'+ machine_type_id + '/' + line_id ,
                type: 'post',
                dataType: 'json',
                success:function(rating_data) {

                    if(rating_data != ''){
                        let res_table = '<table class="table table-sm">';
                        res_table += '<thead> <tr> <td> Factory </td> <td> Line </td> <td> Slot </td> <td> Machine S No </td> <td> </td> </tr> </thead>';
                        for(let j = 0; j < rating_data.length; j++) {

                            let s_no = rating_data[j].s_no;
                            let line_name = rating_data[j].line_name;
                            let slot_name = rating_data[j].slot_name;
                            let factory_name = rating_data[j].factory_name;

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