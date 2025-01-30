<script type="text/javascript">
var manageTable;
var base_url = "<?php echo base_url(); ?>";


$(document).ready(function() {

    $('#machine_repair_main_nav_link').prop('aria-expanded', 'true').removeClass('collapsed');
    $('#collapseLayoutsMachineRepairs').addClass('show');

    get_service_no();

    function get_service_no(){
        $.ajax({
            url: base_url + 'MachineServices/getServiceNo',
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                $('#service_no').val(response);
            }
        });
    }

    $('#machine_in_id').select2({
        placeholder: 'Select...',
        width: '100%',
        allowClear: true,
        dropdownParent: $('#addModal'),
        ajax: {
            url: base_url + 'MachineIns/get_machine_ins_select_id',
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

    $('#edit_machine_in_id').select2({
        placeholder: 'Select...',
        width: '100%',
        allowClear: true,
        dropdownParent: $('#editModal'),
        ajax: {
            url: base_url + 'MachineIns/get_machine_ins_select_id',
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

    //machine_in_id change event get factory code for machine_in_id from machine_ins table
    $('#machine_in_id').on('change', function() {
        var machine_in_id = $(this).val();
        if (machine_in_id) {
            $.ajax({
                url: base_url + 'MachineIns/getFactoryCodeByMachineInId',
                type: 'POST',
                data: {
                    machine_in_id: machine_in_id
                },
                dataType: 'json',
                success: function(response) {
                    $('#factory_code').val(response);
                }
            });
        }
    });

    $('#edit_machine_in_id').on('change', function() {
        var machine_in_id = $(this).val();
        if (machine_in_id) {
            $.ajax({
                url: base_url + 'MachineIns/getFactoryCodeByMachineInId',
                type: 'POST',
                data: {
                    machine_in_id: machine_in_id
                },
                dataType: 'json',
                success: function(response) {
                    $('#edit_factory_code').val(response);
                }
            });
        }
    });

    // initialize the datatable
  manageTable = $('#manageTable').DataTable({
    'ajax': base_url + 'MachineRepairRequests/fetchCategoryData',
    'order': []
  });

  // submit the create from 
  $("#createForm").unbind('submit').on('submit', function() {
    var form = $(this);

    // remove the text-danger
    $(".text-danger").remove();

    $.ajax({
      url: form.attr('action'),
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
          $("#addModal").modal('hide');

          // reset the form
          $("#createForm")[0].reset();
          $('#machine_in_id').val('').trigger('change');
          get_service_no();
          $("#createForm .form-group").removeClass('has-error').removeClass('has-success');

        } else {

          if(response.messages instanceof Object) {
            $.each(response.messages, function(index, value) {
              let id = $("#"+index);

                if (index == 'buyer_id') {
                    id = $("#buyer_id_error");
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

    $(document).on('click', '.repair_add_btn', function() {

        let id = $(this).data('id');
        //let service_no = $(this).data('service_no');
        let machine_type_name = $(this).data('machine_type_name');

        //$('#service_no_span').html(service_no);
        $('#machine_type_span').html(machine_type_name);

        //save_btn click event
        $('#save_btn').on('click', function() {
            let repair_details = [];
            $('#service_detail_table tbody tr').each(function(index, element) {
                let repair_detail = {};
                repair_detail.repair_id = id;
                repair_detail.repair_item_name = $(element).find('td:eq(0)').text();
                repair_detail.quantity = $(element).find('td:eq(1)').text();
                repair_detail.price = $(element).find('td:eq(2)').text();
                repair_detail.total = $(element).find('td:eq(3)').text();
                repair_details.push(repair_detail);
            });
            let sub_total = $('#sub_total').text();
            let repair_done_by = $('#repair_done_by').val();
            let repair_charge = $('#repair_charge').val();
            let transport_charge = $('#transport_charge').val();
            let repair_type = $('input[name=repair_type]:checked').val();
            let remarks = $('#remarks').val();

            $('#modal_msg').html('');

            if(repair_details.length == 0){
                //modal_msg
                $("#modal_msg").html('<div class="alert alert-danger alert-dismissible" role="alert">'+
                    '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+
                    'Please Add at least one Item'
                    +
                    '</div>');
                return false;
            }
            if(repair_done_by == ''){
                $("#modal_msg").html('<div class="alert alert-danger alert-dismissible" role="alert">'+
                    '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+
                    'Repair Done By required'
                    +
                    '</div>');
                return false;
            }

            if(repair_charge == ''){
                $("#modal_msg").html('<div class="alert alert-danger alert-dismissible" role="alert">'+
                    '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+
                    'Repair Charge required'
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

            if(repair_type == ''){
                $("#modal_msg").html('<div class="alert alert-danger alert-dismissible" role="alert">'+
                    '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+
                    'Repair Type required'
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
                url: base_url + 'MachineRepairs/createRepair',
                type: 'POST',
                data: {
                    repair_details: repair_details,
                    sub_total: sub_total,
                    repair_done_by: repair_done_by,
                    repair_charge: repair_charge,
                    transport_charge: transport_charge,
                    repair_type: repair_type,
                    remarks: remarks,
                    repair_request_id: id
                },
                dataType: 'json',
                success: function(response) {
                    if(response.success) {
                        $('#repairAddModal').modal('hide');
                        $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                            '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
                            '</div>');
                        $("#service_detail_table tbody").empty();
                        $('#sub_total').val('');
                        $('#repair_done_by').val('');
                        $('#repair_charge').val('');
                        $('#transport_charge').val('');
                        $('#remarks').val('');
                        $('input[name=repair_type]').attr('checked',false);

                        //reload page after 2 second
                        setTimeout(function() {
                            location.reload();
                        }, 2000);

                    }
                }
            });

        });

    });

    $('#repair_done_by').select2({
        placeholder: 'Select...',
        width: '100%',
        allowClear: true,
        dropdownParent: $('#repairAddModal'),
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

    $('#service_item_id').select2({
        placeholder: 'Select...',
        width: '100%',
        allowClear: true,
        dropdownParent: $('#repairAddModal'),
        ajax: {
            url: base_url + 'ServiceItems/get_items_select',
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

    $('#service_item_add_form').on('submit', function(event) {
        event.preventDefault();
        let service_item_id = $('#service_item_id').val();
        let service_item_name = $('#service_item_id option:selected').text();
        let price = $('#price').val();
        let qty = $('#quantity').val();
        let total = price * qty;
        total = total.toFixed(2);
        let service_item_row = '<tr>' +
            '<td>' + service_item_name + '</td>' +
            '<td>' + qty + '</td>' +
            '<td>' + price + '</td>' +
            '<td>' + total + '</td>' +
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

    $(document).on('click', '.btn_postpone', function() {

        let id = $(this).data('id');
        let machine_type_name = $(this).data('machine_type_name');

        $('#postpone_machine_type_span').html(machine_type_name);

        $('#postponeModal').modal('show');

        $('#postpone_repair_form').on('submit', function(event) {
            event.preventDefault();
            let repair_in_date = $('#repair_in_date').val();
            let reason = $('#reason').val();
            $.ajax({
                url: base_url + 'MachineRepairs/postponeRepair',
                type: 'POST',
                data: {
                    id: id,
                    repair_in_date: repair_in_date,
                    reason: reason
                },
                dataType: 'json',
                success: function(response) {
                    if(response.success) {
                        $('#postponeModal').modal('hide');
                        $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                            '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
                            '</div>');
                        $('#repair_in_date').val('');
                        $('#reason').val('');
                        //refresh page after 3 seconds
                        setTimeout(function(){
                            location.reload();
                        }, 3000);
                    }
                }
            });
        });

    });

});

// edit function
function editFunc(id)
{ 
  $.ajax({
    url: base_url + 'MachineRepairRequests/fetchMachineRepairRequestsDataById/'+id,
    type: 'post',
    dataType: 'json',
    success:function(response) {

        let option = new Option(response.s_no, response.machine_in_id, true, true);
        $('#edit_machine_in_id').append(option);
        $('#edit_machine_in_id').trigger('change');

        $("#edit_repair_date").val(response.repair_in_date);

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
                  var id = $("#edit_"+index);
                    if (index == 'edit_machine_in_id') {
                        id = $("#edit_machine_in_id_error");
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
        data: { machine_repair_id:id },
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