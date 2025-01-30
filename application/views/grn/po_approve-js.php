<script type="text/javascript">
var manageTable;
var base_url = "<?php echo base_url(); ?>";

$(document).ready(function() {

    $('#po_main_nav_link').prop('aria-expanded', 'true').removeClass('collapsed');
    $('#collapseLayoutsPo').addClass('show');


  // initialize the datatable 
  manageTable = $('#manageTable').DataTable({
    'ajax': base_url + 'Purchaseorder/fetchPurchaseOrderDataApprove',
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
                url: base_url + 'Purchaseorder/approve',
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

    $('table').on('click', '.btnview', function() {
        var id = $(this).attr('id');
        $.ajax({
            type: "POST",
            data: {
                recordID: id
            },
            url: '<?php echo base_url() ?>Purchaseorder/Purchaseorderview',
            success: function(result) { //alert(result);
                $('#porderviewmodal').modal('show');
                $('#viewhtml').html(result);
            }
        });
    });

    $(document).on("click",".print-btn",function(e) {
        let id = $(this).data('id');
        //print_table(id);
        window.location.href = '<?php echo base_url() ?>Purchaseorder/PurchaseorderviewPrint/' + id;
    });

});


</script>