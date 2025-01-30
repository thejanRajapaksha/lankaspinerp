<script type="text/javascript">
  var manageTable;
  var viewTable;
  var tempTable;
  var base_url = "<?php echo base_url(); ?>";

  // ********create function********
  function create_js() {
    var data = tempTable.rows().data().toArray();
    requests = [];

    for (let index = 0; index < data.length; index++) {
      const element = data[index];
      request = {}
      request["request_by"] = '';
      request["request_date"] = '';
      request["machine_model"] = element[2];
      request["machine_type"] = element[0];
      request["from_date"] = element[4];
      request["to_date"] = element[5];
      request["quantity"] = element[6];
      request["remark"] = element[7];
      requests.push(request);
    }

    $.ajax({
      url: '<?php echo base_url('MachineRequest/create_batch') ?>',
      type: 'POST',
      data: {
        requests: requests
      },
      success: function(response) {
        $("#addModal").modal('hide');
        location.reload();
      }
    });
  }
  // *************************************

  // ********create temp table rec********
  $("#createnewForm").unbind('submit').on('submit', function() {
    var machine_type = $('#machine_type_id').select2('data');
    var machine_model = $('#machine_model_id').select2('data');
    var form = $(this);

    // remove the text-danger
    $(".text-danger").remove();

    $.ajax({
      url: form.attr('action'),
      type: form.attr('method'),
      data: form.serialize(), // /converting the form data into array and sending it to server
      dataType: 'json',
      success: function(response) {

        if (response.success === true) {
          var rowNode = tempTable
            .row.add([
              $('#machine_type_id').val(),
              machine_type[0].text,
              $('#machine_model_id').val(),
              machine_model[0].text,
              $('#from_date').val(),
              $('#to_date').val(),
              $('#quantity').val(),
              $('#remark').val()
            ])
            .draw()
            .node();
          $('#create').prop('disabled', false);
          // reset the form
          $("#createnewForm")[0].reset();
          $("#createnewForm .form-group").removeClass('has-error').removeClass('has-success');
        } else {
          if (response.messages instanceof Object) {
            $.each(response.messages, function(index, value) {
              var id = $("#" + index);

              if (index == 'machine_type_id') {
                id = $("#machine_type_id_error");
              }

              if (index == 'machine_model_id') {
                id = $("#machine_model_id_error");
              }

              id.closest('.form-group')
                .removeClass('has-error')
                .removeClass('has-success')
                .addClass(value.length > 0 ? 'has-error' : 'has-success');

              id.after(value);

            });
          }
        }
      }
    });
    return false;
  });
  // *************************************

  $(document).ready(function() {

    $('#machinerequest_main_nav_link').prop('aria-expanded', 'true').removeClass('collapsed');
    $('#collapseLayoutsMachineRequest').addClass('show');

    // initialize the datatable 
    manageTable = $('#manageTable').DataTable({
      'ajax': base_url + 'MachineRequestHeader/fetchMachineRequestData',
      'order': []
    });

    tempTable = $('#tempTable').DataTable({
      "columnDefs": [{
        "targets": [0],
        "visible": false,
        "searchable": false
      }, {
        "targets": [2],
        "visible": false
      }],
      "paging": false,
      "searching": false,
      "bInfo": false
    });

    edit_tempTable = $('#edit_tempTable').DataTable({
      "columnDefs": [{
        "targets": [0],
        "visible": false,
        "searchable": false
      }, {
        "targets": [2],
        "visible": false
      }],
      "paging": false,
      "searching": false,
      "bInfo": false
    });

    $('#update').prop('disabled', true);

    // create button disable/enable
    if (tempTable.rows().count() < 1) {
      $('#create').prop('disabled', true);
    } else {
      $('#create').prop('disabled', false);
    }

    $('.select2').select2({
      placeholder: 'Select an option',
      allowClear: true,
      width: '100%'
    });

    // update function
    $("#updateForm").unbind('submit').on('submit', function() {
      var form = $(this);
      var url = form.attr('action') + "/" + $("#id").val();

      $.ajax({
        url: url,
        type: form.attr('method'),
        data: form.serialize(), // /converting the form data into array and sending it to server
        dataType: 'json',
        success: function(response) {

          if (response.success === true) {
            $("#edit_messages").html('<div class="alert alert-success alert-dismissible" role="alert">' +
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
              '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>' + response.messages +
              '</div>');

            edit_viewFunc(localStorage.getItem('header_id'));
          } else {
            if (response.messages instanceof Object) {
              $.each(response.messages, function(index, value) {
                var id = $("#" + index);

                if (index == 'edit_machine_type_id') {
                  id = $("#edit_machine_type_id_error");
                }

                if (index == 'edit_machine_model_id') {
                  id = $("#edit_machine_model_id_error");
                }

                id.closest('.form-group')
                  .removeClass('has-error')
                  .removeClass('has-success')
                  .addClass(value.length > 0 ? 'has-error' : 'has-success');

                id.after(value);
              });
            } else {
              $("#edit_messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>' + response.messages +
                '</div>');
            }
          }
        }
      });
      return false;
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
        success: function(response) {
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
            $("#createForm .form-group").removeClass('has-error').removeClass('has-success');
          } else {
            if (response.messages instanceof Object) {
              $.each(response.messages, function(index, value) {
                var id = $("#" + index);

                if (index == 'machine_type_id') {
                  id = $("#machine_type_id_error");
                }

                if (index == 'machine_model_id') {
                  id = $("#machine_model_id_error");
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

  });
  

  // edit function (new)
  function edit_viewFunc(id) {
    $.ajax({
      url: base_url + 'MachineRequest/fetchMachineRequestByHeaderId/' + id,
      type: 'post',
      dataType: 'json',
      success: function(response) {
        table = $('#edit_tempTable').DataTable();
        table.clear();
        $('#update').prop('disabled', true);

        $("#updateForm")[0].reset();
        $("#edit_machine_type_id").val("").trigger('change');
        $("#edit_machine_model_id").val("").trigger('change');
        $("#updateForm .form-group").removeClass('has-error').removeClass('has-success');
        localStorage.setItem('header_id', id);
        response.forEach(element => {
          var rowNode = table
            .row.add([
              // element['header_id'],
              element['machine_type'],
              element['machine_type_name'],
              element['machine_model'],
              element['machine_model_name'],
              element['from_date'],
              element['to_date'],
              element['quantity'],
              element['remark'],
              '<button type="button" class="btn btn-default btn-sm" onclick="loadToForm(' + element['id'] + ')" ><i class="text-primary fa fa-edit"></i></button>'
            ])
            .draw()
            .node();
        });
      }
    });
  }

 

  //load data to form
  function loadToForm(id) {
    $.ajax({
      url: base_url + 'MachineRequest/fetchMachineRequestById/' + id,
      type: 'post',
      dataType: 'json',
      success: function(response) {
        $("#updateForm")[0].reset();
        $("#updateForm .form-group").removeClass('has-error').removeClass('has-success');
        $('#update').prop('disabled', false);
        $("p.text-danger").remove();
        response.forEach(element => {
          $("#id").val(response[0]['id']);
          $("#edit_machine_type_id").val(response[0]['machine_type']).trigger('change');
          $("#edit_machine_model_id").val(response[0]['machine_model']).trigger('change');
          $("#edit_from_date").val(response[0]['from_date']);
          $("#edit_to_date").val(response[0]['to_date']);
          $("#edit_quantity").val(response[0]['quantity']);
          $("#edit_remark").val(response[0]['remark']);
          $("#edit_active").val(response[0]['active']);

        });
      }
    });

  }

  // view function
  function viewFunc(id) {
    $.ajax({
      url: base_url + 'MachineRequest/fetchMachineRequestByHeaderId/' + id,
      type: 'post',
      dataType: 'json',
      success: function(response) {
        viewTable = $('#viewTable').DataTable();
        viewTable.clear();

        response.forEach(element => {
          var rowNode = viewTable
            .row.add([
              // element['header_id'],
              element['machine_type_name'],
              element['machine_model_name'],
              element['from_date'],
              element['to_date'],
              element['quantity'],
              element['remark']
            ])
            .draw()
            .node();
        });
      }
    });
  }

  // remove functions 
  function removeFunc(id) {
    if (id) {
      $("#removeForm").on('submit', function() {
        var form = $(this);
        // remove the text-danger
        $(".text-danger").remove();

        $.ajax({
          url: form.attr('action'),
          type: form.attr('method'),
          data: {
            machine_request_id: id
          },
          dataType: 'json',
          success: function(response) {
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
</script>