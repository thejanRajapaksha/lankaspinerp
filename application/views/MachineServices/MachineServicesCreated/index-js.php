<script type="text/javascript">
var manageTable;
var base_url = "<?php echo base_url(); ?>";

$(document).ready(function() {

    $('#machine_services_main_nav_link').prop('aria-expanded', 'true').removeClass('collapsed');
    $('#collapseLayoutsMachineServices').addClass('show');

    $('.select2').select2({
        placeholder: 'Select...',
        allowClear: true
    });

    $('#machine_type_filter').select2({
        placeholder: 'Select...',
        width: '100%',
        allowClear: true,
        ajax: {
            url: base_url + 'MachineServicesCreated/get_machine_types_select',
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

    $('#s_no_filter').select2({
        placeholder: 'Select...',
        width: '100%',
        allowClear: true,
        ajax: {
            url: base_url + 'MachineServicesCreated/get_machine_ins_select',
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

    //service_no_filter
    $('#service_no_filter').select2({
        placeholder: 'Select...',
        width: '100%',
        allowClear: true,
        ajax: {
            url: base_url + 'MachineServicesCreated/get_service_no_select',
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

    //filter_button click event
    $('#filter_button').click(function() {
        load_dt();
    });

    // initialize the datatable
    load_dt();

    function load_dt(){

        let status = $('#status_filter').val();
        let service_type = $('#service_type_filter').val();
        let machine_type = $('#machine_type_filter').val();
        let machine_in_id = $('#s_no_filter').val();
        let service_no = $('#service_no_filter').val();
        let date_from = $('#date_from_filter').val();
        let date_to = $('#date_to_filter').val();

        manageTable = $('#manageTable').DataTable({
            'ajax': {
                'url': base_url + 'MachineServicesCreated/fetchCategoryData',
                'type': 'GET',
                'data': {
                    'status': status,
                    'service_type': service_type,
                    'machine_type': machine_type,
                    'machine_in_id': machine_in_id,
                    'service_no': service_no,
                    'date_from': date_from,
                    'date_to': date_to
                }
            },
            'order': [],
            destroy: true,
        });
    }


});

// edit function
function editFunc(id)
{ 
  $.ajax({
    url: base_url + 'MachineServicesCreated/fetchMachineServicesCreatedDataById/'+id,
    type: 'post',
    dataType: 'json',
    success:function(response) {

        $("#service_detail_table tbody").empty();

        let service_no = response.service_details.service_no;
        let service_id = response.service_details.service_id;
        let machine_type_name = response.service_details.machine_type_name;

        $('#service_no_span').html(service_no);
        $('#service_id_span').val(service_id);
        $('#machine_type_span').html(machine_type_name);
        $('#service_charge').val(response.service_details.service_charge);
        $('#transport_charge').val(response.service_details.transport_charge);
        $('#remarks').val(response.service_details.remarks);

        let employee_id = response.service_details.service_done_by;
        let employee_name = response.service_details.name_with_initial;

        let option = new Option(employee_name, employee_id, true, true);
        $('#service_done_by').append(option);
        $('#service_done_by').trigger('change');

        if(response.service_details.service_type == 'inside') {
            $('#service_type_inside').prop('checked', true);
        } else {
            $('#service_type_outside').prop('checked', true);
        }

        //each service_items
        let service_items = response.service_items;
        service_items.forEach(function(item) {
            let service_item_row = '<tr>';
            service_item_row += '<td> <input class="sp_id" type="hidden" value="'+item.spare_part_id+'"> '+item.item_name+ item.part_no+'</td>';
            service_item_row += '<td>'+item.quantity+'</td>';
            service_item_row += '<td>'+item.price+'</td>';
            service_item_row += '<td align="right">'+item.total+'</td>';
            service_item_row += '<td><button type="button" class="btn btn-danger btn-sm btn_remove_service_item" data-id="'+item.id+'"><i class="fa fa-trash"></i></button></td>';
            service_item_row += '</tr>';
            $('#service_detail_table tbody').append(service_item_row);
        });

        calculate_sub_total();

        $('#service_item_id').select2({
            placeholder: 'Select...',
            width: '100%',
            allowClear: true,
            ajax: {
                url: base_url + 'MachineServicesCalendar/get_sp_for_service_id_select',
                dataType: 'json',
                data: function (params) {
                    return {
                        term: params.term || '',
                        page: params.page || 1,
                        service_id: $('#service_id_span').val()
                    }
                },
                cache: true
            }
        });

        //service_item_id change event
        $('#service_item_id').on('change', function() {
            let service_item_id = $(this).val();
            $.ajax({
                url: base_url + 'ServiceItems/get_service_item_price',
                type: 'POST',
                data: {
                    service_item_id: service_item_id
                },
                dataType: 'json',
                success: function(response) {
                    $('#price').val(response);
                }
            });
        });

        $('#service_done_by').select2({
            placeholder: 'Select...',
            width: '100%',
            allowClear: true,
            dropdownParent: $('#editModal'),
            ajax: {
                url: base_url + 'MachineServicesCalendar/get_employees_select',
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

        $(document).on('click', '.btn_remove_service_item', function() {
            $(this).closest('tr').remove();
            calculate_sub_total();
        });

        $('#service_item_add_form').on('submit', function(event) {
            event.preventDefault();
            let service_item_id = $('#service_item_id').val();
            let service_item_name = $('#service_item_id option:selected').text();
            let price = $('#price').val();
            let qty = $('#quantity').val();
            let total = price * qty;
            total = total.toFixed(2);
            let service_item_row = '<tr>' +
                '<td> <input class="sp_id" type="hidden" value="'+service_item_id+'"> ' + service_item_name + '</td>' +
                '<td>' + qty + '</td>' +
                '<td>' + price + '</td>' +
                '<td align="right">' + total + '</td>' +
                '<td><button class="btn btn-danger btn-sm btn_remove_service_item" data-id="' + service_item_id + '"><i class="fa fa-trash"></i></button></td>' +
                '</tr>';
            $('#service_detail_table tbody').append(service_item_row);
            $('#service_item_id').val('').trigger('change');
            $('#price').val('');
            $('#quantity').val('');
            calculate_sub_total();
        });

        $(document).on('click', '.btn_remove_service_item', function() {
            $(this).closest('tr').remove();
            calculate_sub_total();
        });

        function calculate_sub_total(){
            let sub_total = 0;
            $('#service_detail_table tbody tr').each(function(index, element) {
                sub_total += parseFloat($(element).find('td:eq(3)').text());
            });
            sub_total = sub_total.toFixed(2);
            $('#sub_total').html(sub_total);
        }

        $('#save_btn').on('click', function() {
            let service_details = [];
            $('#service_detail_table tbody tr').each(function(index, element) {
                let service_detail = {};
                service_detail.service_id = id;
                service_detail.service_item_id = $(element).find('td:eq(0) .sp_id').val();
                service_detail.service_item_name = $(element).find('td:eq(0)').text();
                service_detail.quantity = $(element).find('td:eq(1)').text();
                service_detail.price = $(element).find('td:eq(2)').text();
                service_detail.total = $(element).find('td:eq(3)').text();
                service_details.push(service_detail);
            });
            let sub_total = $('#sub_total').text();
            let service_done_by = $('#service_done_by').val();
            let service_charge = $('#service_charge').val();
            let transport_charge = $('#transport_charge').val();
            let service_type = $('input[name=service_type]:checked').val();
            let remarks = $('#remarks').val();

            $('#modal_msg').html('');

            if(service_details.length == 0){
                //modal_msg
                $("#modal_msg").html('<div class="alert alert-danger alert-dismissible" role="alert">'+
                    '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+
                    'Please Add at least one Item'
                    +
                    '</div>');
                return false;
            }
            if(service_done_by == ''){
                $("#modal_msg").html('<div class="alert alert-danger alert-dismissible" role="alert">'+
                    '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+
                    'Service Done By required'
                    +
                    '</div>');
                return false;
            }

            if(service_charge == ''){
                $("#modal_msg").html('<div class="alert alert-danger alert-dismissible" role="alert">'+
                    '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+
                    'Service Charge required'
                    +
                    '</div>');
                return false;
            }

            if(transport_charge == ''){
                $("#modal_msg").html('<div class="alert alert-danger alert-dismissible" role="alert">'+
                    '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+
                    'Transport Charge required'
                    +
                    '</div>');
                return false;
            }

            if(service_type == ''){
                $("#modal_msg").html('<div class="alert alert-danger alert-dismissible" role="alert">'+
                    '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+
                    'Service Type required'
                    +
                    '</div>');
                return false;
            }

            if(remarks == ''){
                $("#modal_msg").html('<div class="alert alert-danger alert-dismissible" role="alert">'+
                    '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+
                    'Remarks required'
                    +
                    '</div>');
                return false;
            }

            $.ajax({
                url: base_url + 'MachineServicesCreated/updateService',
                type: 'POST',
                data: {
                    service_details: service_details,
                    sub_total: sub_total,
                    service_done_by: service_done_by,
                    service_charge: service_charge,
                    transport_charge: transport_charge,
                    service_type: service_type,
                    remarks: remarks,
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    if(response.success) {
                        $('#editModal').modal('hide');
                        $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                            '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
                            '</div>');
                        $("#service_detail_table tbody").empty();
                        $('#sub_total').val('');
                        $('#service_done_by').val('');
                        $('#service_charge').val('');
                        $('#transport_charge').val('');
                        $('#remarks').val('');
                        $('input[name=service_type]').attr('checked',false);

                        $('#manageTable').DataTable().ajax.reload(null, false);

                    }
                }
            });

        });

    }
  });
}

function viewFunc(id)
{
    $.ajax({
        url: base_url + 'MachineServicesCreated/fetchMachineServicesCreatedDataById/'+id,
        type: 'post',
        dataType: 'json',
        success:function(response) {

            $("#view_service_detail_table tbody").empty();

            let service_no = response.service_details.service_no;
            let machine_type_name = response.service_details.machine_type_name;

            $('#view_service_no_span').html(service_no);
            $('#view_machine_type_span').html(machine_type_name);
            $('#service_done_by_span').html(response.service_details.name_with_initial);
            $('#service_charge_span').html(response.service_details.service_charge);
            $('#transport_charge_span').html(response.service_details.transport_charge);
            $('#remarks_span').html(response.service_details.remarks);
            $('#sub_total_span').html(response.service_details.sub_total);
            $('#service_type_span').html(response.service_details.service_type);

            //each service_items
            let service_items = response.service_items;
            service_items.forEach(function(item) {
                let service_item_row = '<tr>';
                service_item_row += '<td>'+item.item_name+ ' - ' +item.part_no+'</td>';
                service_item_row += '<td>'+item.quantity+'</td>';
                service_item_row += '<td>'+item.price+'</td>';
                service_item_row += '<td align="right">'+item.total+'</td>';
                service_item_row += '</tr>';
                $('#view_service_detail_table tbody').append(service_item_row);
            });

        }
    });
}

// remove functions 
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

function completeFunc(id)
{
    if(id) {
        $("#completeForm").on('submit', function() {

            var form = $(this);

            // remove the text-danger
            $(".text-danger").remove();

            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                data: { id:id, remarks:$('#complete_remarks').val() },
                dataType: 'json',
                success:function(response) {

                    manageTable.ajax.reload(null, false);
                    // hide the modal
                    $("#completeModal").modal('hide');

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

function removeCompleteFunc(id)
{
    if(id) {
        $("#removeCompleteForm").on('submit', function() {

            var form = $(this);

            // remove the text-danger
            $(".text-danger").remove();

            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                data: { id:id, remarks:$('#remove_complete_remarks').val() },
                dataType: 'json',
                success:function(response) {

                    manageTable.ajax.reload(null, false);
                    // hide the modal
                    $("#removeCompleteModal").modal('hide');

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