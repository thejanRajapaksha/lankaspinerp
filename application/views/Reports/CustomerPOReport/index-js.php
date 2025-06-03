<script>
    $(document).ready(function () {
        // Sidebar active states
        $('#crmorder_main_nav_link').prop('aria-expanded', 'true').removeClass('collapsed');
        $('#collapseLayoutsRPT').addClass('show');

        let table = $('#allocationTable').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            responsive: true,
            dom: "<'row'<'col-sm-5'B><'col-sm-2'l><'col-sm-5'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [
                { extend: 'csv', className: 'btn btn-success btn-sm', title: 'Machine Allocation Data', text: '<i class="fas fa-file-csv mr-2"></i> CSV' },
                { extend: 'pdf', className: 'btn btn-danger btn-sm', title: 'Machine Allocation Data', text: '<i class="fas fa-file-pdf mr-2"></i> PDF' },
                {
                    extend: 'print',
                    title: 'Machine Allocation Data',
                    className: 'btn btn-primary btn-sm',
                    text: '<i class="fas fa-print mr-2"></i> Print',
                    customize: function (win) {
                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    }
                },
            ],
            ajax: {
                url: "<?php echo base_url() ?>scripts/CustomerPOWIPlist.php",
                type: "POST",
                data: function (d) {
                    d.customerId = $('#customername').val();
                    d.poId = $('#selectedPo').val();
                }
            },
            order: [[0, "desc"]],
            "columns": [
                { "data": "machine" },
                { "data": "order_delivery" },
                { "data": "order_date" },
                { "data": "delivery_date" },
                { "data": "quantity" },
                { "data": "deliver_quantity" },
                {
                    "data": "completedqty",
                    render: function(data, type, row) {
                        return data ? data : 0;
                    }
                }
            ]
        });

        // Reload table when dropdowns change
        $('#customername, #selectedPo').on('change', function () {
            table.ajax.reload();
        });

        $('#customername').on('change', function () {
            const customerId = $(this).val();
            $('#selectedPo').html('<option value="">Loading...</option>');

            if (customerId) {
                $.ajax({
                    url: "<?php echo site_url('CustomerPOWIP/getPOForCustomer'); ?>",
                    type: "POST",
                    data: { customerId: customerId },
                    dataType: "json",
                    success: function (data) {
                        let options = '<option value="">All POs</option>';
                        data.forEach(function (po) {
                            options += `<option value="${po.idtbl_order}">PO - ${po.idtbl_order}</option>`;
                        });
                        $('#selectedPo').html(options);
                    },
                    error: function () {
                        $('#selectedPo').html('<option value="">Error loading POs</option>');
                    }
                });
            } else {
                $('#selectedPo').html('<option value="">Select Customer First</option>');
            }
        });

    });
</script>
