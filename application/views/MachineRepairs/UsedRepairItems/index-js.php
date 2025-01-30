<script type="text/javascript">
    var manageTable;
    var base_url = "<?php echo base_url(); ?>";


    $(document).ready(function () {

        $('#machine_repairs_main_nav_link').prop('aria-expanded', 'true').removeClass('collapsed');
        $('#collapseLayoutsMachineRepairs').addClass('show');

        $('#service_item_filter').select2({
            placeholder: 'Select...',
            width: '100%',
            allowClear: true,
            ajax: {
                url: base_url + 'UsedRepairItems/get_service_item_select',
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

            let service_item_id = $('#service_item_filter').val();
            let date_from = $('#date_from_filter').val();
            let date_to = $('#date_to_filter').val();

            manageTable = $('#manageTable').DataTable({
                'ajax': {
                    'url': base_url + 'UsedRepairItems/fetchCategoryData',
                    'type': 'GET',
                    'data': {
                        'service_item_id': service_item_id,
                        'date_from': date_from,
                        'date_to': date_to
                    }
                },
                'order': [],
                destroy: true,
            });
        }

    });

    //view function
    function viewFunc(id, date_from, date_to, service_item_name)
    {
        $.ajax({
            url: base_url + 'UsedRepairItems/fetchRepairDataById',
            data : {
                'id': id,
                'date_from': date_from,
                'date_to': date_to
            },
            type: 'post',
            dataType: 'json',
            success:function(response) {

                let res_table = '<table class="table table-striped table-sm" id="viewTable">';
                let res_tr = '<thead>' +
                    '<tr>' +
                    '<th>Service Item</th>' +
                    '<th> Repair In Date </th> ' +
                    '<th> Used Employee </th> ' +
                    '</tr>' +
                    '</thead> ' +
                    '<tbody>';
                $.each(response, function(index, value) {
                    res_tr += '<tr>' +
                        '<td>' + value.name + '</td>' +
                        '<td>' + value.repair_in_date + '</td>' +
                        '<td>' + value.name_with_initial + '</td>' +
                        '</tr>';
                });
                res_table += res_tr + '</tbody> </table>';
                 $('#viewModal').modal('show');
                 $('#service_item_name').text(service_item_name);
                $("#viewModal .modal-body #viewResponse").html(res_table);
                $('#viewTable').DataTable();

            }
        });
    }

</script>