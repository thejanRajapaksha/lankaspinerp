<script type="text/javascript">
var manageTable;
var base_url = "<?php echo base_url(); ?>";


$(document).ready(function() {

    //$('#machines_main_nav_link').prop('aria-expanded', 'true').removeClass('collapsed');
   // $('#collapseLayoutsMachines').addClass('show');

    var addcheck = '<?php echo (in_array('createSupplierInfo', $user_permission)) ? 1 : 0; ?>';
		var editcheck = '<?php echo (in_array('updateSupplierInfo', $user_permission)) ? 1 : 0; ?>';
		var statuscheck = '<?php echo (in_array('updateSupplierInfo', $user_permission) || in_array('deleteSupplierInfo', $user_permission)) ? 1 : 0; ?>';
		var deletecheck = '<?php echo (in_array('deleteSupplierInfo', $user_permission)) ? 1 : 0; ?>';

    var manageTable = $('#manageTable').DataTable({
			"destroy": true,
			"processing": true,
			"serverSide": true,

			ajax: {
				url: "<?php echo base_url() ?>scripts/sparepartslist.php",
				type: "POST", // you can use GET
			},
			"order": [
				[0, "desc"]
			],
			"columns": [
        {
					"className": 'd-none',
					"data": "id"
        },
        {
					"data": "name"
				},
				{
					"data": "machine_models"
				},
				{
					"data": "machine_types"
				},
				{
          "data": "suppliername",
          "render": function(data, type, row) {
              return '<span class="badge badge-info">' + row.suppliername + '</span>';
          }
        },
        {
					"data":  "part_no"
				},
        {
					"data":  "rack_no"
				},
        {
					"data":  "unit_price"
				},
        {
            "data": "active",
            "render": function(data, type, row) {
                return (data == 1) 
                    ? '<span class="badge badge-success">Active</span>' 
                    : '<span class="badge badge-warning">Inactive</span>';
            }
        },
				{
					"targets": -1,
          "className": 'text-right',
          "data": null,
          "render": function (data, type, full) {
              var button = '';
              if (editcheck == 1) {
                  button += '<button type="button" class="btn btn-default btn-sm btnEdit mr-1" onclick="editFunc(' + full['id'] + ')" data-toggle="modal" data-target="#editModal">' +
                      '<i class="text-primary fa fa-edit"></i></button>';
              }
              if (deletecheck == 1) {
                  button += '<button type="button" class="btn btn-default btn-sm" onclick="removeFunc(' + full['id'] + ')" data-toggle="modal" data-target="#removeModal">' +
                      '<i class="text-danger fa fa-trash"></i></button>';
              }

              return button;
					}
				}
			],
			drawCallback: function (settings) {
				$('[data-toggle="tooltip"]').tooltip();
			}
		});

    $('#machine_type_id').select2({
        placeholder: 'Select...',
        width: '100%',
        allowClear: true,
        dropdownParent: $('#addModal'),
        ajax: {
            url:  base_url + 'MachineTypes/get_machine_types_select',
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

    $('#machine_model_id').select2({
        placeholder: 'Select...',
        width: '100%',
        allowClear: true,
        dropdownParent: $('#addModal'),
        ajax: {
            url:  base_url + 'MachineModels/get_machine_models_select',
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

    $('#supplier_id').select2({
        placeholder: 'Select...',
        width: '100%',
        allowClear: true,
        dropdownParent: $('#addModal'),
        multiple: true,
        ajax: {
            url:  base_url + 'Suppliers/get_suppliers_select',
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

    $('#edit_machine_type_id').select2({
        placeholder: 'Select...',
        width: '100%',
        allowClear: true,
        dropdownParent: $('#editModal'),
        ajax: {
            url:  base_url + 'MachineTypes/get_machine_types_select',
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

    $('#edit_machine_model_id').select2({
        placeholder: 'Select...',
        width: '100%',
        allowClear: true,
        dropdownParent: $('#editModal'),
        ajax: {
            url:  base_url + 'MachineModels/get_machine_models_select',
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

    $('#edit_supplier_id').select2({
        placeholder: 'Select...',
        width: '100%',
        allowClear: true,
        dropdownParent: $('#editModal'),
        multiple: true,
        ajax: {
            url:  base_url + 'Suppliers/get_suppliers_select',
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




  // // initialize the datatable 
  // manageTable = $('#manageTable').DataTable({
  //   'ajax': base_url + 'SpareParts/fetchCategoryData',
  //   'order': []
  // });

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
          $("#createForm .form-group").removeClass('has-error').removeClass('has-success');

        } else {

          if(response.messages instanceof Object) {
            $.each(response.messages, function(index, value) {
              var id = $("#"+index);

                if (index == 'machine_type_id'){
                    id = $("#machine_type_id_error");
                }

                if (index == 'machine_model_id'){
                    id = $("#machine_model_id_error");
                }

                if (index == 'supplier_id'){
                    id = $("#supplier_id_error");
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

});

// edit function
function editFunc(id)
{
    $('#edit_supplier_id').val('').trigger('change');
  $.ajax({
    url: base_url + 'SpareParts/fetchSparePartsDataById/'+id,
    type: 'post',
    dataType: 'json',
    success:function(data) {

        let response = data.main_data;

      $("#edit_name").val(response.name);
      $("#edit_active").val(response.active);
      $("#edit_part_no").val(response.part_no);
      $("#edit_rack_no").val(response.rack_no);
      $("#edit_unit_price").val(response.unit_price);

        let optionSection3 = new Option(response.machine_type_name, response.type, true, true);
        $('#edit_machine_type_id').append(optionSection3).trigger('change');

        let optionSection4 = new Option(response.machine_model, response.model, true, true);
        $('#edit_machine_model_id').append(optionSection4).trigger('change');

        var op = data.sc;

        $.each(op, function(key, value) {
            let supplier_id = value.id;
            let supplier_name = value.sup_name;

            let optionSection5 = new Option(supplier_name, supplier_id, true, true);
            $('#edit_supplier_id').append(optionSection5).trigger('change');
        });

      // submit the edit from 
      // $("#updateForm").unbind('submit').bind('submit', function()
      $("#updateForm").off('submit').on('submit', function(e) {
        e.preventDefault();

        var form = $(this);

        // remove the text-danger
        $(".text-danger").remove();

        $.ajax({
          url: form.attr('action') + '/' + id,
          type: form.attr('method'),
          data: form.serialize(), // /converting the form data into array and sending it to server
          dataType: 'json',
          success: function(response) {

          //   manageTable.ajax.reload(null, false); 

          //   if(response.success === true) {
              // $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
              //   '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              //   '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
              // '</div>');
          if (response.success === true) {
                        // Reload DataTable
                        if ($.fn.DataTable.isDataTable("#manageTable")) {
                            $("#manageTable").DataTable().ajax.reload(null, false);
                        }


              // hide the modal
              $("#editModal").modal('hide');
              // reset the form 
              $("#updateForm .form-group").removeClass('has-error').removeClass('has-success');

              $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
              '</div>');

            } else {

              if(response.messages instanceof Object) {
                $.each(response.messages, function(index, value) {
                  var id = $("#"+index);

                    if (index == 'edit_machine_type_id'){
                        id = $("#edit_machine_type_id_error");
                    }

                    if (index == 'edit_machine_model_id'){
                        id = $("#edit_machine_model_id_error");
                    }

                    if (index == 'edit_supplier_id'){
                        id = $("#edit_supplier_id_error");
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
function removeFunc(id) {
    if (id) {
        $("#removeForm").off('submit').on('submit', function(e) {
            e.preventDefault();

            console.log("Deleting ID:", id);

            var form = $(this);
            $(".text-danger").remove();

            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                data: { machine_type_id: id },
                dataType: 'json',
                success: function(response) {
                    if (response.success === true) {
                        // Reload DataTable
                        if ($.fn.DataTable.isDataTable("#manageTable")) {
                            $("#manageTable").DataTable().ajax.reload(null, false);
                        }

                        // Hide the modal
                        $("#removeModal").modal('hide');
                        $(".modal-backdrop").remove();

                        // Show success message
                        $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                            '<span aria-hidden="true">&times;</span></button>'+
                            '<strong><span class="glyphicon glyphicon-ok-sign"></span></strong> ' + response.messages +
                        '</div>');
                    } else {
                        $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                            '<span aria-hidden="true">&times;</span></button>'+
                            '<strong><span class="glyphicon glyphicon-exclamation-sign"></span></strong> ' + response.messages +
                        '</div>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", error);
                }
            });
        });
    }
}



</script>