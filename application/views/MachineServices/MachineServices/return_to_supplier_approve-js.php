<script type="text/javascript">
var manageTable;
var base_url = "<?php echo base_url(); ?>";

$(document).ready(function() {

    $('#return_main_nav_link').prop('aria-expanded', 'true').removeClass('collapsed');
    $('#collapseLayoutsReturn').addClass('show');

  // initialize the datatable 
  manageTable = $('#manageTable').DataTable({
    'ajax': base_url + 'MachineServices/return_to_supplier_fetchDataApprove',
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

    $(document).on('click', '#btn_approve', function (e) {
        e.preventDefault();
        let id = $(this).data('id');
        let save_btn = $(this);
        let r = confirm("Approve ?");
        if (r == true) {
            save_btn.prop("disabled", true);
            save_btn.html('<i class="fa fa-spinner fa-spin"></i> loading...' );
            $.ajax({
                url: base_url + 'MachineServices/return_to_supplier_approve',
                method: "POST",
                dataType: "json",
                data: {
                    'id': id,
                },
                success: function (data) {
                    if(data.status == true){
                        $('#messages').html("<div class='alert alert-success'>"+data.msg+"</div>");
                        $('#manageTable').DataTable().ajax.reload();
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

function viewFunc(id)
{
    $.ajax({
        url: base_url + 'MachineServices/fetchReturnToSupplierServiceItems/'+id,
        type: 'post',
        dataType: 'json',
        success:function(data) {

            let res_table = '<table class="table table-striped table-sm" id="viewTable">';
            let res_tr = '<thead><tr><th>Service Item</th><th>Quantity</th> <th style="text-align: right">Unit Price</th>  </tr></thead> <tbody>';
            let response = data.sc;
            let total = 0;
            $.each(response, function(index, value) {
                res_tr += '<tr>' +
                    '<td>' + value.name + ' - ' + value.part_no +  '</td>' +
                    '<td>' + value.qty + '</td>' +
                    '<td style="text-align: right">' + value.unit_price + '</td>' +
                    '</tr>';
                total += (parseFloat(value.qty)) * ( parseFloat(value.unit_price));
            });
            res_table += res_tr + '</tbody>';

            res_table += '<tfoot>';
            res_table += '<tr> ' +
                '<td> </td>' +
                '<th style="text-align: right"> Total </th>' +
                '<th style="text-align: right"> '+ total.toFixed(2) +' </th>' +
                '</tr>';
            res_table += '</tfoot>';

            res_table += '</table>';

            let machine_type_name = data.main_data.suppliername;
            $('#machine_type_name').html(machine_type_name);

            $("#viewModal .modal-body #viewResponse").html(res_table);
            $('#viewTable').DataTable({
                searching: false, paging: false, info: false
            });

            let btn = "<button class='btn btn-sm btn-primary' id='btn_approve' data-id='"+data.main_data.id+"' > Approve </button> ";
            $("#viewModal #approve_res").html(btn);

        }
    });
}


</script>