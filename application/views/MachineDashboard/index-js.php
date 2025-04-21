<script type="text/javascript">

    var base_url = "<?php echo base_url(); ?>";

    $(document).ready(function() {

        init_repair_items_chart();

        function init_repair_items_chart()
        {
            $.ajax({
                url: base_url + 'MachineDashboard/fetchMachineInsChartData',
                type: 'post',
                dataType: 'json',
                data: {

                },
                success:function(response) {
                    machine_type_id
                    var xValues = response.machine_types;
                    var yValues = response.total_counts;
                    var barColors = response.colors;

                    new Chart("machine_ins_pie_chart", {
                        type: "pie",
                        data: {
                            labels: xValues,
                            datasets: [{
                                backgroundColor: barColors,
                                data: yValues
                            }]
                        },
                        options: {
                            //legend: {display: true},
                            responsive:true,
                            title: {
                                display: true,
                                text: "Machine Types Count ",
                            }
                        }
                    });

                },
                error:function(response) {
                    alert(response);
                }
            });
        }

        $('#machine_type_id').select2({
            placeholder: 'Select...',
            width: '100%',
            allowClear: true,
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

        //machine_type_id change event
        $('#machine_type_id').on('change', function (e){
            let id = $(this).val();
            $.ajax({
                url: base_url + 'MachineDashboard/fetch_machine_types_data',
                type: 'post',
                dataType: 'json',
                data: {
                    id: id
                },
                success:function(response) {

                    let available_machines = response.available_machines;
                    let repairing_machines = response.repairing_machines;

                    let html = '';
                    html += ' <div class="card card-icon">' +
                        '<div class="row no-gutters">'+
                            '<div class="col-auto card-icon-aside p-1 text-white bg-primary">'+
                                '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>'+
                            '</div>'+
                            '<div class="col">'+
                                '<div class="card-body py-3">'+
                                    '<h5 class="card-title">Available Machines <span class="badge badge-pill badge-light float-right" > ' +
                                        available_machines +
                                            '</span> <button data-status="0" data-types="" class="badge badge-pill badge-light float-right btn btn-sm btn_view_available_machines" id="" value="1"><span class="text-primary">View</span> </button></h5>'+

                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div> ';

                    html += ' <div class="card card-icon mt-2">' +
                        '<div class="row no-gutters">'+
                        '<div class="col-auto card-icon-aside p-1 text-white bg-warning">'+
                        '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>'+
                        '</div>'+
                        '<div class="col">'+
                        '<div class="card-body py-3">'+
                        '<h5 class="card-title">Repairing Machines <span class="badge badge-pill badge-light float-right" > ' +
                        repairing_machines +
                        '</span> <button data-status="0" data-types="" class="badge badge-pill badge-light float-right btn btn-sm btn_view_repairing_machines" id="" value="1"> <span class="text-primary">View</span> </button></h5>'+

                        '</div>'+
                        '</div>'+
                        '</div>'+
                        '</div> ';

                    $('.count_div').html(html);

                    // let $allocated_machines = response.allocated_machines;

                    // let html2 = '<h4> Allocated Machines </h4>' +
                    //     '<hr>';
                    // html2 += '<div class="table-responsive">' +
                    //         '<table class="table table-striped table-bordered table-hover table-sm">' +
                    //         '<thead>' +
                    //             '<tr>' +
                    //                 '<th>Serial No</th>' +
                    //                 '<th>Allocated Date</th>' +
                    //                 '<th>Slot</th>' +
                    //                 '<th>Line</th>' +
                    //                 '<th>Section</th>' +
                    //                 '<th>Department</th>' +
                    //                 '<th>Factory</th>' +
                    //             '</tr>' +
                    //         '</thead>' +
                    //         '<tbody>';
                    // $.each($allocated_machines, function(key, value){
                    //     html2 += '<tr>' +
                    //         '<td>' + value.s_no + '</td>' +
                    //         '<td>' + value.allocated_date + '</td>' +
                    //         '<td>' + value.slot_name + '</td>' +
                    //         '<td>' + value.line_name + '</td>' +
                    //         '<td>' + value.section_name + '</td>' +
                    //         '<td>' + value.department_name + '</td>' +
                    //         '<td>' + value.factory_name + '</td>' +
                    //     '</tr>';
                    // });

                    // html2 += '</tbody>' +
                    //         '</table>' +
                    //         '</div>';

                    // $('.allocated_machines_div').html(html2);

                },
                error:function(response) {
                    alert(response);
                }
            });

        });

        //btn_view_available_machines
        $(document).on('click', '.btn_view_available_machines', function(e) {
            e.preventDefault();
            let machine_type_id = $('#machine_type_id').val();
            $.ajax({
                url: base_url + 'MachineDashboard/fetch_available_machines_data',
                type: 'post',
                dataType: 'json',
                data: {
                    machine_type_id: machine_type_id
                },
                success: function (response) {
                    let html = '';

                    html += '<div class="table-responsive">' +
                        '<table class="table table-striped table-bordered table-hover table-sm">' +
                        '<thead>' +
                            '<tr>' +
                                '<th>Serial No</th>' +
                                '<th>Bar Code</th>' +
                                '<th>Machine Type</th>' +
                                '<th>Machine Model</th>' +
                                '<th>In Type</th>' +
                                '<th>Next Service Date</th>' +
                                '<th>Origin Date</th>' +
                                // '<th>Factory</th>' +
                            '</tr>' +
                        '</thead>' +
                        '<tbody>';

                    let machine_type_name = '';

                    $.each(response, function(key, value){
                        // console.log(value);
                        machine_type_name = value.machine_type_name;
                        html += '<tr>' +
                            '<td>' + value.s_no + '</td>' +
                            '<td>' + value.bar_code + '</td>' +
                            '<td>' + value.machine_type_name + '</td>' +
                            '<td>' + value.machine_model_name + '</td>' +
                            '<td>' + value.in_type_name + '</td>' +
                            '<td>' + value.next_service_date + '</td>' +
                            '<td>' + value.origin_date + '</td>' +
                            // '<td>' + value.factory_name + '</td>' +
                        '</tr>';
                    });

                    html += '</tbody>' +
                        '</table>' +
                        '</div>';

                    $('#availableMachinesResponse').html(html);
                    $('#machine_type_name').html(machine_type_name);
                    $('#availableMachinesModal').modal('show');

                },
                error: function (response) {
                    alert(response);
                }

            });

        });

        //btn_view_repairing_machines
        $(document).on('click', '.btn_view_repairing_machines', function(e) {
            e.preventDefault();
            let machine_type_id = $('#machine_type_id').val();
            $.ajax({
                url: base_url + 'MachineDashboard/fetch_repairing_machines_data',
                type: 'post',
                dataType: 'json',
                data: {
                    machine_type_id: machine_type_id
                },
                success: function (response) {
                    let html = '';

                    html += '<div class="table-responsive">' +
                        '<table class="table table-striped table-bordered table-hover table-sm">' +
                        '<thead>' +
                        '<tr>' +
                        '<th>Serial No</th>' +
                        '<th>Bar Code</th>' +
                        '<th>Machine Type</th>' +
                        '<th>Machine Model</th>' +
                        '<th>In Type</th>' +
                        '<th>Next Service Date</th>' +
                        '<th>Origin Date</th>' +
                        // '<th>Factory</th>' +
                        '<th>Repair In Date</th>' +
                        '</tr>' +
                        '</thead>' +
                        '<tbody>';

                    let machine_type_name = '';

                    $.each(response, function(key, value){
                        // console.log("Machine", value);
                        machine_type_name = value.machine_type_name;
                        html += '<tr>' +
                            '<td>' + value.s_no + '</td>' +
                            '<td>' + value.bar_code + '</td>' +
                            '<td>' + value.machine_type_name + '</td>' +
                            '<td>' + value.machine_model_name + '</td>' +
                            '<td>' + value.in_type_name + '</td>' +
                            '<td>' + value.next_service_date + '</td>' +
                            '<td>' + value.origin_date + '</td>' +
                            // '<td>' + value.factory_name + '</td>' +
                            '<td>' + value.repair_in_date + '</td>' +
                            '</tr>';
                    });

                    html += '</tbody>' +
                        '</table>' +
                        '</div>';

                    $('#repairingMachinesResponse').html(html);
                    $('#r_machine_type_name').html(machine_type_name);
                    $('#repairingMachinesModal').modal('show');

                },
                error: function (response) {
                    alert(response);
                }

            });

        });

    });

</script>