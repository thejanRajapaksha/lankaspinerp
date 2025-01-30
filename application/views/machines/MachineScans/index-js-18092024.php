<script type="text/javascript">
var manageTable;
var base_url = "<?php echo base_url(); ?>";


$(document).ready(function() {

    $('#machines_main_nav_link').prop('aria-expanded', 'true').removeClass('collapsed');
    $('#collapseLayoutsMachines').addClass('show');
    $('#machines_main_nav_link').addClass('active');

    $('#s_no').select2({
        placeholder: 'Select...',
        width: '100%',
        allowClear: true,
        ajax: {
            url: base_url + 'MachineIns/get_machine_ins_select',
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
        dropdownParent: $('#allocateModal'),
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
        dropdownParent: $('#allocateModal'),
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
        dropdownParent: $('#allocateModal'),
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
        dropdownParent: $('#allocateModal'),
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

    $('#slot_id').select2({
        placeholder: 'Select...',
        width: '100%',
        allowClear: true,
        dropdownParent: $('#allocateModal'),
        ajax: {
            url:  base_url + 'slots/get_slots_select',
            dataType: 'json',
            data: function(params) {
                return {
                    term: params.term || '',
                    page: params.page || 1,
                    line_id: $('#line_id').val()
                }
            },
            cache: true
        }
    });


    // $('#af_factory_id').select2({
    //     placeholder: 'Select an option',
    //     allowClear: true,
    //     width: '100%'
    // });

    $('#af_factory_id').select2({
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

    $('#af_department_id').select2({
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
                    factory_id: $('#af_factory_id').val()
                }
            },
            cache: true
        }
    });

    $('#af_section_id').select2({
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
                    department_id: $('#af_department_id').val()
                }
            },
            cache: true
        }
    });

    $('#af_line_id').select2({
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
                    section_id: $('#af_section_id').val()
                }
            },
            cache: true
        }
    });

    $('#af_slot_id').select2({
        placeholder: 'Select...',
        width: '100%',
        allowClear: true,
        dropdownParent: $('#addModal'),
        ajax: {
            url:  base_url + 'slots/get_slots_select',
            dataType: 'json',
            data: function(params) {
                return {
                    term: params.term || '',
                    page: params.page || 1,
                    line_id: $('#af_line_id').val()
                }
            },
            cache: true
        }
    });


    function scan(){
        let btn = $('.btn-scan');
        let btn_txt = btn.html();
        btn.html('<i class="fa fa-spinner fa-spin"></i>');
        btn.prop('disabled', true);

        // remove the text-danger
        $(".text-danger").remove();
        $('#machine_in_details').html('');
        $('#machine_allocation_current').html('');
        $('#machine_repair_current').html('');
        $('#released_machines').html('');

        $.ajax({
            url: "<?php echo base_url('MachineScans/scan') ?>",
            type: 'post',
            data: {s_no: $('#s_no').val()},
            dataType: 'json',
            success:function(response) {

                if(response.success === true) {

                    let machine_in_data = response.machine_in_data;

                    let html = '';
                    html += '<div class="card">';
                    html += '<div class="card-header">';
                    html += '<h5 class="card-title">Machine In Details</h5>';
                    html += '</div>';
                    html += '<div class="card-body" style="padding: 10px !important;">';
                    html += '<table class=" table-sm ">';
                    html += '<tr>';
                    html += '<td> <label> Machine Type </label> </td>';
                    html += '<td>'+machine_in_data.machine_type_name+'</td>';
                    html += '</tr>';
                    html += '<tr>';
                    html += '<td> <label> Machine Model </label> </td>';
                    html += '<td>'+machine_in_data.machine_model_name+'</td>';
                    html += '</tr>';
                    html += '<tr>';
                    html += '<td> <label> Machine Serial No </label> </td>';
                    html += '<td>'+machine_in_data.s_no+'</td>';
                    html += '</tr>';
                    html += '<tr>';
                    html += '<td><label> Machine Bar Code </label> </td>';
                    html += '<td>'+machine_in_data.bar_code+'</td>';
                    html += '</tr>';
                    html += '</table>';
                    html += '</div>';
                    html += '</div>';

                    let html3 = '';
                    html3 += '<table class="table table-sm">';
                    html3 += '<tr>';
                    html3 += '<td> <label> Machine Type </label> </td>';
                    html3 += '<td>'+machine_in_data.machine_type_name+'</td>';
                    html3 += '</tr>';
                    html3 += '<tr>';
                    html3 += '<td> <label> Machine Model </label> </td>';
                    html3 += '<td>'+machine_in_data.machine_model_name+'</td>';
                    html3 += '</tr>';
                    html3 += '<tr>';
                    html3 += '<td> <label> Machine Serial No </label> </td>';
                    html3 += '<td>'+machine_in_data.s_no+'</td>';
                    html3 += '</tr>';
                    html3 += '<tr>';
                    html3 += '<td><label> Machine Bar Code </label> </td>';
                    html3 += '<td>'+machine_in_data.bar_code+'</td>';
                    html3 += '</tr>';
                    html3 += '</table>';

                    let machine_repair_data = response.machine_repair_data;

                    if(machine_repair_data != 0) {
                        html3 += '<input type="hidden" id="allocate_from_repair_repair_id" name="repair_id" value="'+machine_repair_data.id+'"> ';
                    }

                    $('#machine_in_details').html(html);
                    $('#allocate_modal_machine_in_details').html(html3);
                    $('#allocate_from_repair_modal_machine_in_details').html(html3);

                    let machine_allocation_data = response.machine_allocation_data;

                    let html2 = '';

                    if(machine_allocation_data != 0) {

                        html2 += '<div class="card">';
                        html2 += '<div class="card-header">';
                        html2 += '<h5 class="card-title">Machine Current Allocation</h5>';
                        html2 += '</div>';
                        html2 += '<div class="card-body" style="padding: 10px !important;">';
                        html2 += '<table class="table table-sm table-striped">';
                        html2 += '<tr>';
                        html2 += '<td> <label> Slot </label> </td>';
                        html2 += '<td>'+machine_allocation_data.slot_name+'</td>';
                        html2 += '</tr>';
                        html2 += '<tr>';
                        html2 += '<td> <label> Line </label> </td>';
                        html2 += '<td>'+machine_allocation_data.line_name+'</td>';
                        html2 += '</tr>';
                        html2 += '<tr>';
                        html2 += '<td> <label> Section </label> </td>';
                        html2 += '<td>'+machine_allocation_data.section_name+'</td>';
                        html2 += '</tr>';
                        html2 += '<tr>';
                        html2 += '<td><label> Department </label> </td>';
                        html2 += '<td>'+machine_allocation_data.department_name+'</td>';
                        html2 += '</tr>';
                        html2 += '<tr>';
                        html2 += '<td><label> Factory </label> </td>';
                        html2 += '<td>'+machine_allocation_data.factory_name+'</td>';
                        html2 += '</tr>';
                        html2 += '<tr>';
                        html2 += '<td><label> Allocated Date </label> </td>';
                        html2 += '<td>'+machine_allocation_data.allocated_date+'</td>';
                        html2 += '</tr>';
                        html2 += '</table>';

                        html2 += '<div class="row">';
                        html2 += '<div class="col">';
                        html2 += '<a href="#" class="btn btn-warning btn-sm m-1 machine_release" data-machine_in_id="'+machine_allocation_data.machine_in_id+'" data-toggle="modal" data-target="#removeModal" > Release</a>';
                        html2 += '<a href="#" class="btn btn-success btn-sm m-1 allocate" data-machine_in_id="'+machine_allocation_data.machine_in_id+'" data-toggle="modal" data-target="#allocateModal"> Re-Allocate</a>';
                        html2 += '<a href="#" class="btn btn-danger btn-sm m-1 repair" data-machine_in_id="'+machine_allocation_data.machine_in_id+'" data-toggle="modal" data-target="#repairModal" >  Repair</a>';
                        html2 += '</div>';
                        html2 += '</div>';

                        html2 += '</div>';
                        html2 += '</div>';
                    }

                    $('#machine_allocation_current').html(html2);
                    $('#machine_in_id_allocate').val(machine_in_data.id);

                    let html4 = '';

                    if(machine_repair_data != 0) {

                        html4 += '<div class="card mt-3">';
                        html4 += '<div class="card-header">';
                        html4 += '<h5 class="card-title">Machine Current Repair </h5>';
                        html4 += '</div>';
                        html4 += '<div class="card-body" style="padding: 10px !important;">';
                        html4 += '<table class="table table-sm table-striped">';
                        html4 += '<td><label> Repair Date </label> </td>';
                        html4 += '<td>'+machine_repair_data.repair_in_date+'</td>';
                        html4 += '</tr>';
                        html4 += '</table>';

                        html4 += '<div class="row">';
                        html4 += '<div class="col">';
                        html4 += '<a href="#" class="btn btn-warning btn-sm m-1 repair_release" data-id="'+machine_repair_data.id+'" data-machine_in_id="'+machine_repair_data.machine_in_id+'" data-toggle="modal" data-target="#repairReleaseModal" > Release</a>';
                        html4 += '<a href="#" class="btn btn-success btn-sm m-1 allocate_from_repair" data-id="'+machine_repair_data.id+'" data-machine_in_id="'+machine_repair_data.machine_in_id+'" data-toggle="modal" data-target="#allocateFromRepairModal"> Re-Allocate</a>';
                        html4 += '</div>';
                        html4 += '</div>';

                        html4 += '</div>';
                        html4 += '</div>';

                    }

                    $('#machine_repair_current').html(html4);
                    $('#af_machine_in_id_allocate').val(machine_in_data.id);

                    if( (machine_allocation_data === 0) && (machine_repair_data === 0)) {

                        //released_machines
                        let html5 = '';
                        html5 += '<div class="card">';
                        html5 += '<div class="card-header">';
                        html5 += '<h5 class="card-title">Released Machine </h5>';
                        html5 += '</div>';
                        html5 += '<div class="card-body" style="padding: 10px !important;">';

                        html5 += '<div class="row">';
                        html5 += '<div class="col">';
                        html5 += '<a href="#" class="btn btn-success btn-sm m-1 allocate" data-machine_in_id="'+machine_in_data.id+'" data-toggle="modal" data-target="#allocateModal"> Allocate</a>';
                        html5 += '<a href="#" class="btn btn-danger btn-sm m-1 repair" data-machine_in_id="'+machine_in_data.id+'" data-toggle="modal" data-target="#repairModal" >  Repair</a>';
                        html5 += '</div>';
                        html5 += '</div>';

                        html5 += '</div>';
                        html5 += '</div>';

                        $('#released_machines').html(html5);

                    }

                    let html_mah = '';
                    html_mah += '<div class="card mt-3">';
                    html_mah += '<div class="card-header">';
                    html_mah += '<h5 class="card-title">Machine Allocation History</h5>';
                    html_mah += '</div>';
                    html_mah += '<div class="card-body table-responsive" style="padding: 10px !important;">';
                    html_mah += '<table class="table table-sm table-striped" id="tbl_allocation_history">';
                    html_mah += '<thead>';
                    html_mah += '<tr>';
                    html_mah += '<th> Slot </th>';
                    html_mah += '<th> Line </th>';
                    html_mah += '<th> Section </th>';
                    html_mah += '<th> Department </th>';
                    html_mah += '<th> Factory </th>';
                    html_mah += '<th> Allocated Date </th>';
                    html_mah += '<th> Released Date </th>';
                    html_mah += '</tr>';
                    html_mah += '</thead>';
                    html_mah += '<tbody>';
                    html_mah += '</tbody>';
                    html_mah += '</table>';
                    html_mah += '</div>';
                    html_mah += '</div>';

                    $('#machine_allocation_history').html(html_mah);

                    manageTable = $('#tbl_allocation_history').DataTable({
                        ajax: {

                            url: base_url + 'machineScans/fetchAllocationHistoryData',
                            type: 'post',
                            data: {
                                machine_in_id: machine_in_data.id
                            }

                        },
                        'order': [],
                        destroy: true,
                    });


                    let html_mar = '';
                    html_mar += '<div class="card mt-3">';
                    html_mar += '<div class="card-header">';
                    html_mar += '<h5 class="card-title">Machine Repair History</h5>';
                    html_mar += '</div>';
                    html_mar += '<div class="card-body table-responsive" style="padding: 10px !important;">';
                    html_mar += '<table class="table table-sm table-striped" id="tbl_repair_history">';
                    html_mar += '<thead>';
                    html_mar += '<tr>';
                    html_mar += '<th> Repair In Date </th>';
                    html_mar += '<th> Repair Out Date </th>';
                    html_mar += '</tr>';
                    html_mar += '</thead>';
                    html_mar += '<tbody>';
                    html_mar += '</tbody>';
                    html_mar += '</table>';
                    html_mar += '</div>';
                    html_mar += '</div>';

                    $('#machine_repair_history').html(html_mar);

                    manageTable = $('#tbl_repair_history').DataTable({
                        ajax: {

                            url: base_url + 'machineScans/fetchRepairHistoryData',
                            type: 'post',
                            data: {
                                machine_in_id: machine_in_data.id
                            }

                        },
                        'order': [],
                        destroy: true,
                    });


                } else {

                    if(response.messages instanceof Object) {
                        $.each(response.messages, function(index, value) {
                            var id = $("#"+index);
                            if (index == 's_no') {
                                id = $("#s_no_error");
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
                btn.html(btn_txt);
                btn.prop('disabled', false);
            }
        });

        return false;
    }

      // submit the create from
      $("#scanForm").unbind('submit').on('submit', function(e) {
          e.preventDefault();
          scan();
      });

    //document .machine_release click event
    $(document).on('click', '.machine_release', function(){
        let machine_in_id = $(this).data('machine_in_id');

        $("#removeForm").on('submit', function() {

            var form = $(this);

            let btn = $('.btn-remove');
            let btn_txt = btn.html();
            btn.html('<i class="fa fa-spinner fa-spin"></i>');
            btn.prop('disabled', true);

            // remove the text-danger
            $(".text-danger").remove();

            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                data: { machine_in_id:machine_in_id },
                dataType: 'json',
                success:function(response) {

                    //manageTable.ajax.reload(null, false);
                    // hide the modal
                    $("#removeModal").modal('hide');

                    if(response.success === true) {
                        $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                            '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
                            '</div>');

                        scan();

                    } else {

                        $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                            '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
                            '</div>');
                    }
                    btn.html(btn_txt);
                    btn.prop('disabled', false);

                }
            });

            return false;
        });

    });

    $(document).on('click', '.repair_release', function(){
        let machine_in_id = $(this).data('machine_in_id');
        let id = $(this).data('id');

        $("#repairReleaseForm").on('submit', function() {

            var form = $(this);

            let btn = $('.btn-repair-release');
            let btn_txt = btn.html();
            btn.html('<i class="fa fa-spinner fa-spin"></i>');
            btn.prop('disabled', true);

            // remove the text-danger
            $(".text-danger").remove();

            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                data: { machine_in_id:machine_in_id, repair_id : id },
                dataType: 'json',
                success:function(response) {

                    //manageTable.ajax.reload(null, false);
                    // hide the modal
                    $("#repairReleaseModal").modal('hide');

                    if(response.success === true) {
                        $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                            '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
                            '</div>');

                        scan();

                    } else {

                        $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                            '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
                            '</div>');
                    }
                    btn.html(btn_txt);
                    btn.prop('disabled', false);

                }
            });

            return false;
        });

    });

    $(document).on('click', '.repair', function(){
        let machine_in_id = $(this).data('machine_in_id');

        $("#repairForm").on('submit', function() {

            var form = $(this);

            let btn = $('.btn-repair');
            let btn_txt = btn.html();
            btn.html('<i class="fa fa-spinner fa-spin"></i>');
            btn.prop('disabled', true);

            // remove the text-danger
            $(".text-danger").remove();

            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                data: { machine_in_id:machine_in_id },
                dataType: 'json',
                success:function(response) {

                    //manageTable.ajax.reload(null, false);
                    // hide the modal
                    $("#repairModal").modal('hide');

                    if(response.success === true) {
                        $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                            '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
                            '</div>');

                        scan();

                    } else {

                        $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                            '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
                            '</div>');
                    }
                    btn.html(btn_txt);
                    btn.prop('disabled', false);

                }
            });

            return false;
        });

    });

    //btn-allocate-submit
    $("#allocateForm").unbind('submit').on('submit', function() {
        var form = $(this);
        let create_btn = $(this).find('.btn-allocate-submit');
        let btn_txt = $('.btn-allocate-submit').text();
        create_btn.html('<i class="fa fa-spinner fa-spin"></i> Loading');
        create_btn.attr('disabled', true);

        // remove the text-danger
        $(".text-danger").remove();

        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: form.serialize(), // /converting the form data into array and sending it to server
            dataType: 'json',
            success:function(response) {

                if(response.success === true) {

                    $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                        '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
                        '</div>');

                    // hide the modal
                    $("#allocateModal").modal('hide');

                    // reset the form
                    $("#allocateForm")[0].reset();
                    $("#allocateForm .form-group").removeClass('has-error').removeClass('has-success');
                    scan();
                    $('#factory_id').val('').trigger('change');
                    $('#department_id').val('').trigger('change');
                    $('#section_id').val('').trigger('change');
                    $('#line_id').val('').trigger('change');
                    $('#slot_id').val('').trigger('change');

                } else {

                    if(response.messages instanceof Object) {
                        $.each(response.messages, function(index, value) {

                            let id = $("#"+index);
                            if(index == 'section_id'){
                                id = $('#section_id_error');
                            }
                            if(index == 'department_id'){
                                id = $('#department_id_error');
                            }
                            if(index == 'factory_id'){
                                id = $('#factory_id_error');
                            }
                            if(index == 'line_id'){
                                id = $('#line_id_error');
                            }
                            if(index == 'slot_id'){
                                id = $('#slot_id_error');
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
                create_btn.html(btn_txt);
                create_btn.attr('disabled', false);
            }
        });

        return false;
    });

    $("#allocateFromRepairForm").unbind('submit').on('submit', function() {
        var form = $(this);
        let create_btn = $(this).find('.af-btn-allocate-submit');
        let btn_txt = $('.af-btn-allocate-submit').text();
        create_btn.html('<i class="fa fa-spinner fa-spin"></i> Loading');
        create_btn.attr('disabled', true);

        // remove the text-danger
        $(".text-danger").remove();

        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: form.serialize(), // /converting the form data into array and sending it to server
            dataType: 'json',
            success:function(response) {

                if(response.success === true) {

                    $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                        '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
                        '</div>');

                    // hide the modal
                    $("#allocateFromRepairModal").modal('hide');

                    // reset the form
                    $("#allocateFromRepairForm")[0].reset();
                    $("#allocateFromRepairModal .form-group").removeClass('has-error').removeClass('has-success');
                    scan();
                    $('#af_factory_id').val('').trigger('change');
                    $('#af_department_id').val('').trigger('change');
                    $('#af_section_id').val('').trigger('change');
                    $('#af_line_id').val('').trigger('change');
                    $('#af_slot_id').val('').trigger('change');

                } else {

                    if(response.messages instanceof Object) {
                        $.each(response.messages, function(index, value) {

                            let id = $("#af_"+index);
                            if(index == 'section_id'){
                                id = $('#af_section_id_error');
                            }
                            if(index == 'department_id'){
                                id = $('#af_department_id_error');
                            }
                            if(index == 'factory_id'){
                                id = $('#af_factory_id_error');
                            }
                            if(index == 'line_id'){
                                id = $('#af_line_id_error');
                            }
                            if(index == 'slot_id'){
                                id = $('#af_slot_id_error');
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
                create_btn.html(btn_txt);
                create_btn.attr('disabled', false);
            }
        });

        return false;
    });


});





</script>