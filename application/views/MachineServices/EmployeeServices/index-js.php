<script type="text/javascript">
    var manageTable;
    var base_url = "<?php echo base_url(); ?>";


    $(document).ready(function () {

        $('#rpt_main_nav_link').prop('aria-expanded', 'true').removeClass('collapsed');
        $('#collapseLayoutsRPT').addClass('show');

        $('#employee_filter').select2({
            placeholder: 'Select...',
            width: '100%',
            allowClear: true,
            ajax: {
                url: base_url + 'MachineServicesEmployee/get_employees_select',
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

            let employee_id = $('#employee_filter').val();
            let date_from = $('#date_from_filter').val();
            let date_to = $('#date_to_filter').val();

            manageTable = $('#manageTable').DataTable({
                'ajax': {
                    'url': base_url + 'MachineServicesEmployee/fetchCategoryData',
                    'type': 'GET',
                    'data': {
                        'employee_id': employee_id,
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
    function viewFunc(id, date_from, date_to, employee_name)
    {
        $.ajax({
            url: base_url + 'MachineServicesEmployee/fetchServiceDataById',
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
                    '<th>Machine Type</th>' +
                    '<th>BarCode</th> ' +
                    '<th> Serial No </th> ' +
                    '<th> Service No </th> ' +
                    '<th> Service Date From </th> ' +
                    '<th> Service Date To </th> ' +
                    '<th> Service Type </th> ' +
                    '<th> Sub Total </th> ' +
                    '<th> Remarks </th> ' +
                    '</tr>' +
                    '</thead> ' +
                    '<tbody>';
                $.each(response, function(index, value) {
                    res_tr += '<tr>' +
                        '<td>' + value.machine_type_name + '</td>' +
                        '<td>' + value.bar_code + '</td>' +
                        '<td>' + value.s_no + '</td>' +
                        '<td>' + value.service_no + '</td>' +
                        '<td>' + value.service_date_from + '</td>' +
                        '<td>' + value.service_date_to + '</td>' +
                        '<td>' + value.service_type + '</td>' +
                        '<td>' + value.sub_total + '</td>' +
                        '<td>' + value.remarks + '</td>' +

                        '</tr>';
                });
                res_table += res_tr + '</tbody> </table>';
                 $('#viewModal').modal('show');
                 $('#employee_name').text(employee_name);
                $("#viewModal .modal-body #viewResponse").html(res_table);
                $('#viewTable').DataTable();

            }
        });
    }

</script>