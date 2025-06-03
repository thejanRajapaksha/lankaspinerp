<script>
    $(document).ready(function(){
        
    });

    $(document).ready(function () {
        $('#crmorder_main_nav_link').prop('aria-expanded', 'true').removeClass('collapsed');
        $('#collapseLayoutsRPT').addClass('show');

        var table = $('#allocationTable').DataTable({
            "processing": true,
            "serverSide": true,
            "destroy": true,
            "responsive": true,
            dom: "<'row'<'col-sm-5'B><'col-sm-2'l><'col-sm-5'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [
                { extend: 'csv', className: 'btn btn-success btn-sm', title: 'WIP Machine Report', text: '<i class="fas fa-file-csv mr-2"></i> CSV' },
                {
                    extend: 'pdf', 
                    className: 'btn btn-danger btn-sm',
                    title: 'WIP Machine Report',
                    text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
                    orientation: 'portrait',
                    pageSize: 'A4',
                    exportOptions: {
                        columns: ':visible'
                    },
                    customize: function (doc) {
                        doc.content[0].alignment = 'left';
                        doc.content[1].alignment = 'left';
                        doc.defaultStyle.fontSize = 9;
                        var tableBody = doc.content[1].table.body;
                        var columnCount = tableBody[0].length;
                        doc.content[1].table.widths = Array(columnCount).fill('*');
                    }
                },
                {
                    extend: 'print',
                    title: 'WIP Machine Report',
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
                url: "<?php echo base_url() ?>scripts/MachineWIPlist.php",
                type: "POST",
                data: function (d) {
                    d.machineId = $('#machine').val();
                    d.date = $('#date').val();
                }
            },
            "order": [[0, "desc"]],
            "columns": [
                { "data": "name" },
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

        $('#machine, #date').on('change', function () {
            table.ajax.reload();
        });
    });

</script>
