<script type="text/javascript">
    var manageTable;
    var base_url = "<?php echo base_url(); ?>";

    $(document).ready(function() {

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

        $('#filter_button').click(function() {
            load_dt();
        });

        load_dt();

        function load_dt(){

            let spare_part_id = $('#part_no_filter').val();
            let supplier_id = $('#supplier_filter').val();
            let machine_type_id = $('#machine_type_filter').val();

            manageTable = $('#manageTable').DataTable({
                'ajax': {
                    'url': base_url + 'Goodreceive/fetchGoodReceiveDataReport',
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

        $('table tbody').on('click', '.btnview', function () {
            var id = $(this).attr('id');
            $.ajax({
                type: "POST",
                data: {
                    recordID: id
                },
                url: '<?php echo base_url() ?>Goodreceive/Goodreceiveview',
                success: function (result) { //alert(result);
                    $('#porderviewmodal').modal('show');
                    $('#viewhtml').html(result);
                }
            });
        });

    });


</script>