<script type="text/javascript">
    var manageTable;
    var base_url = "<?php echo base_url(); ?>";


    $(document).ready(function () {

        $('#rpt_main_nav_link').prop('aria-expanded', 'true').removeClass('collapsed');
        $('#collapseLayoutsRPT').addClass('show');

        $('#part_no_filter').select2({
            placeholder: 'Select...',
            width: '100%',
            allowClear: true,
            ajax: {
                url: base_url + 'Goodreceive/get_part_no_select_from_stock',
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

        $('#supplier_filter').select2({
            placeholder: 'Select...',
            width: '100%',
            allowClear: true,
            ajax: {
                url: base_url + 'Goodreceive/get_supplier_select_from_stock',
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

        $('#machine_type_filter').select2({
            placeholder: 'Select...',
            width: '100%',
            allowClear: true,
            ajax: {
                url: base_url + 'Goodreceive/get_machine_type_select_from_stock',
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

        $('#spare_part_name_filter').select2({
            placeholder: 'Select...',
            width: '100%',
            allowClear: true,
            ajax: {
                url: base_url + 'Goodreceive/get_spare_part_name_from_stock',
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

        $('#filter_button').click(function() {
            load_dt();
        });

        // initialize the datatable
        load_dt();

        function load_dt(){

            let spare_part_id = $('#part_no_filter').val();
            let supplier_id = $('#supplier_filter').val();
            let machine_type_id = $('#machine_type_filter').val();

            manageTable = $('#manageTable').DataTable({
                'ajax': {
                    'url': base_url + 'Goodreceive/fetchStockReport',
                    'type': 'POST',
                    'data': {
                        'spare_part_id': spare_part_id,
                        'supplier_id': supplier_id,
                        'machine_type_id': machine_type_id
                    }
                },
                'order': [],
                destroy: true,
            });
        }

        $(document).on("click", ".btn_view", function (e) {
            e.preventDefault();
            let id = $(this).data('spare_part_id');

            $.ajax({
                url: base_url + 'MachineServices/fetchViewStock/'+id,
                type: 'post',
                dataType: 'json',
                success:function(data) {
                    let res_table = "<div class='table-responsive mt-3'>";
                    res_table += '<table class="table table-striped table-sm" id="viewTable">';
                    let res_tr = '<thead><tr><th>Service No</th> <th> Estimated Quantity </th> <th>Allocated Quantity</th> <th> </th> </tr></thead> <tbody>';
                    let response = data.ac;
                    $.each(response, function(index, value) {
                        let allocate_id = value.allocate_id;
                        res_tr += '<tr>' +
                            '<td>' + value.service_no + '</td>' +
                            '<td>' + value.estimated_qty + '</td>' +
                            '<td>' + value.allocated_qty + '</td>' +
                            '<td> <button type="button" class="btn btn-sm btn-danger btn-delete-edit" data-id="" onclick="removeFunc('+allocate_id+')" data-toggle="modal" data-target="#removeModal" ><i class="fa fa-trash text-white"></i></button> </td> ' +
                            '</tr>';
                    });

                    res_table += res_tr + '</tbody> ';

                    res_table += '</table>';
                    res_table += '</div>  ';

                    let machine_type_name = data.main_data.part_no + ' - ' + data.main_data.name;
                    $('#service_item_name').html(machine_type_name);

                    $("#viewModal .modal-body #viewResponse").html(res_table);
                    $('#viewTable').DataTable();

                }
            });

        });

    });

    $("#removeModal").on("hide.bs.modal", function (e) {
        //hide viewModal
        //$('#viewModal').modal('show');
    });

    $("#removeModal").on("show.bs.modal", function (e) {
        //hide viewModal
        $('#viewModal').modal('hide');
    });

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

                        let service_id = response.service_id;

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