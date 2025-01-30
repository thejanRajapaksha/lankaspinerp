<script type="text/javascript">
    var manageTable;
    var base_url = "<?php echo base_url(); ?>";


    $(document).ready(function () {


        $('#machine_operation_desc_main_nav_link').prop('aria-expanded', 'true').removeClass('collapsed');
        $('#collapseLayoutsMachineOperationDescs').addClass('show');


        // initialize the datatable
        manageTable = $('#manageTable').DataTable({
            'ajax': base_url + 'MachineOperationProduct/fetchCategoryDataApprove',
            'order': []
        });

        let selected_cb = [];

        $(document).on("click","#check_all:checkbox",function(e) {
            $('input:checkbox').prop('checked', this.checked);

            $('input:checkbox').each(function() {
                let id = $(this).data("id");

                let b = {};
                b["id"] = id;

                if($(this).is(':checked')){
                    if(jQuery.inArray(b, selected_cb) === -1){
                        selected_cb.push(b);

                        let selector = $('.cb[data-id="' + id + '"]');
                        //selector.parent().parent().parent().css('background-color', '#f7c8c8');
                    }
                }else {
                    removeA(selected_cb, id)
                }

            });

        });

        $('body').on('click', '.cb', function (){
            let id = $(this).data('id');

            let b = {};
            b["id"] = id;

            if($(this).is(':checked')){
                if(jQuery.inArray(b, selected_cb) === -1){
                    selected_cb.push(b);

                    let selector = $('.cb[data-id="' + id + '"]');
                    //selector.parent().parent().parent().css('background-color', '#f7c8c8');
                }
            }else {
                removeA(selected_cb, id)
            }
            //show_selected_po_nos(selected_cb)
        });

        function removeA(arr, id) {
            $.each(arr , function(index, val) {
                if(id == val.id){
                    //remove val
                    selected_cb.splice(index,1);
                    let selector = $('.cb[data-id="' + id + '"]');
                    //selector.parent().parent().parent().css('background-color', 'inherit');
                }
            });
        }

        $(document).on('click', '#approve_batch', function (e) {
            e.preventDefault();
            let save_btn = $(this);
            let r = confirm("Approve ?");
            if (r == true) {
                save_btn.prop("disabled", true);
                save_btn.html('<i class="fa fa-spinner fa-spin"></i> loading...' );
                $.ajax({
                    url: base_url + 'MachineOperationProduct/approve',
                    method: "POST",
                    dataType: "json",
                    data: {
                        'selected_cb': selected_cb,
                    },
                    success: function (data) {
                        if(data.status == true){
                            $('#messages').html("<div class='alert alert-success'>"+data.msg+"</div>");
                            $('#manageTable').DataTable().ajax.reload();
                            selected_cb = [];
                            $('#view_msg').html("");
                            $('#viewModal').modal('hide');
                        }else{
                            $('#view_msg').html("<div class='alert alert-danger'>"+data.msg+"</div>");
                        }
                        save_btn.prop("disabled", false);
                        save_btn.html('Approve' );
                    }
                });
            }
        });


    });


    function viewFunc(id) {
        $.ajax({
            url: base_url + 'MachineOperationProduct/fetchProductOperationsByMopId',
            type: 'post',
            dataType: 'json',
            data: {mop_id: id},
            success: function (response) {

                let res_table = '<table class="table table-striped table-sm" id="viewTable">';
                let res_tr = '<thead><tr> <th> Component Sequence </th> <th> Component </th> <th>Operation Name</th> <th> Machine </th> <th> SMV </th>  <th>Target Per Hour</th> <th> Rate </th>  </tr></thead> <tbody>';
                $.each(response.op, function (index, value) {
                    let tph = value.smv / 60;
                    res_tr += '<tr>' +
                        '<td>' + value.sequence + '</td>' +
                        '<td>' + value.component_name + '</td>' +
                        '<td>' + value.operation_name + '</td>' +
                        '<td>' + value.machine_type_name + '</td>' +
                        '<td>' + value.smv + '</td>' +
                        '<td>' + tph.toFixed(2)+ '</td>' +
                        '<td>' + value.rate + '</td>' +

                        '</tr>';
                });
                res_table += res_tr + '</tbody> </table>';

                let style_name = response.main_data.product_name;
                $('#view_product_name').html(style_name);

                $("#viewModal .modal-body #viewResponse").html(res_table);
                $('#viewTable').DataTable();

            }
        });
    }






</script>