<div class="container-fluid p-0 p-2">
    <div class="card">
        <div class="card-body p-0 p-2">
            <hr>
            <div id="messages"></div>
            <div class="row">
                <div class="col-6">
                    <h2 class="">Purchase Order</h2>
                </div>
                <div class="col-6 text-right">
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#staticBackdrop" <?php if($addcheck==0){echo 'disabled';} ?>><i class="fas fa-plus mr-2"></i>Create Purchase Order</button>
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="scrollbar pb-3" id="style-2">
                        <table class="table table-bordered table-striped table-sm nowrap" id="dataTable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>PO NO</th>
                                <th>Order Type</th>
                                <th>Date</th>
                                <th>Supplier</th>
                                <th>Location</th>
                                <th>Total</th>
                                <th>Confirm Status</th>
                                <th>GRN Issue Status</th>
                                <th>Remark</th>
                                <th class="text-right">Actions</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Create Purchase Order</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
                        <form id="createorderform" autocomplete="off">
                            <div class="form-group mb-1">
                                <label class="small font-weight-bold text-dark">Purchase Order Type*</label>
                                <select class="form-control form-control-sm" name="ordertype" id="ordertype" required>
                                    <option value="">Select</option>
                                </select>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Order Date*</label>
                                    <input type="date" class="form-control form-control-sm" placeholder="" name="orderdate" id="orderdate" value="<?php echo date('Y-m-d') ?>" required>
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Location*</label>
                                    <select class="form-control form-control-sm" name="location" id="location" required>
                                        <option value="">Select</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Due Date*</label>
                                    <input type="date" class="form-control form-control-sm" placeholder="" name="duedate" id="duedate" value="<?php echo date('Y-m-d') ?>" required>
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Supplier*</label>
                                    <select class="form-control form-control-sm" name="supplier" id="supplier" required>
                                        <option value="">Select</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group mb-1">
                                <label class="small font-weight-bold text-dark">Product*</label>
                                <select class="form-control form-control-sm" name="spare_part_id" id="spare_part_id" required>
                                    <option value="">Select</option>
                                </select>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Qty*</label>
                                    <input type="number" id="newqty" name="newqty" class="form-control form-control-sm" required>
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Unit Price</label>
                                    <input type="number" id="unitprice"
                                           name="unitprice" class="form-control form-control-sm" value=""
                                           step="0.01"
                                    >
                                </div>
                            </div>
                            <div class="form-group mb-1">
                                <label class="small font-weight-bold text-dark">Comment</label>
                                <textarea name="comment" id="comment" class="form-control form-control-sm"></textarea>
                            </div>
                            <div class="form-group mt-3 text-right">
                                <button type="button" id="formsubmit" class="btn btn-primary btn-sm px-4" <?php if($addcheck==0){echo 'disabled';} ?>><i class="fas fa-plus"></i>&nbsp;Add to list</button>
                                <input name="submitBtn" type="submit" value="Save" id="submitBtn" class="d-none">
                            </div>
                            <input type="hidden" name="refillprice" id="refillprice" value="">
                        </form>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8">
                        <table class="table table-striped table-bordered table-sm small" id="tableorder">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Comment</th>
                                    <th class="d-none">ProductID</th>
                                    <th class="d-none">Unitprice</th>
                                    <th class="text-center">Qty</th>
                                    <th class="d-none">HideTotal</th>
                                    <th class="text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <div class="row">
                            <div class="col text-right">
                                <h1 class="font-weight-600" id="divtotal">Rs. 0.00</h1>
                            </div>
                            <input type="hidden" id="hidetotalorder" value="0">
                        </div>
                        <hr>
                        <div class="form-group">
                            <label class="small font-weight-bold text-dark">Remark</label>
                            <textarea name="remark" id="remark" class="form-control form-control-sm"></textarea>
                        </div>
                        <div class="form-group mt-2">
                            <button type="button" id="btncreateorder"
                                class="btn btn-outline-primary btn-sm fa-pull-right"><i
                                    class="fas fa-save"></i>&nbsp;Create
                                Order</button>
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="porderviewmodal" data-backdrop="static" data-keyboard="false" tabindex="-1"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">View Purchase Order</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <div id="viewhtml"></div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="porderEditModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabelE" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabelE">Edit Purchase Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="editHtml"></div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var base_url = "<?php echo base_url(); ?>";

        $('#po_main_nav_link').prop('aria-expanded', 'true').removeClass('collapsed');
        $('#collapseLayoutsPo').addClass('show');

        $('#spare_part_id').select2({
            placeholder: 'Select...',
            width: '100%',
            allowClear: true,
            dropdownParent: $('#staticBackdrop'),
            ajax: {
                url: base_url + 'SpareParts/get_parts_select',
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

        $("#spare_part_id").on("change", function (e) {
            let spare_part_id = $(this).val();
            if(spare_part_id == ''){
                return false;
            }
            let btn = $('#formsubmit');
            let btn_text = btn.html();
            btn.html('<i class="fa fa-spinner fa-spin"></i> Loading...');
            btn.attr('disabled', 'disabled');
            $.ajax({
                url: base_url + 'SpareParts/fetchUnitPrice',
                type: 'post',
                dataType: 'json',
                data: {spare_part_id: spare_part_id },
                success: function (response) {
                    $('#unitprice').val(response.unit_price);
                    btn.html(btn_text);
                    btn.removeAttr('disabled');

                }
            });

        });

        $('#ordertype').select2({
            placeholder: 'Select...',
            width: '100%',
            allowClear: true,
            dropdownParent: $('#staticBackdrop'),
            ajax: {
                url: base_url + 'Purchaseorder/get_order_type_select',
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

        $('#location').select2({
            placeholder: 'Select...',
            width: '100%',
            allowClear: true,
            dropdownParent: $('#staticBackdrop'),
            ajax: {
                url: base_url + 'Purchaseorder/get_locations_select',
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

        $('#supplier').select2({
            placeholder: 'Select...',
            width: '100%',
            allowClear: true,
            dropdownParent: $('#staticBackdrop'),
            ajax: {
                url: base_url + 'Purchaseorder/get_suppliers_select',
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

        $(document).ready(function (em) {

            $(document).on("click",".print-btn",function(e) {
                let id = $(this).data('id');
                //print_table(id);
                window.location.href = '<?php echo base_url() ?>Purchaseorder/PurchaseorderviewPrint/' + id;
            });

        });

        $('#dataTable').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            dom: "<'row'<'col-sm-5'B><'col-sm-2'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            responsive: true,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            "buttons": [
                { extend: 'csv', className: 'btn btn-success btn-sm', title: 'Purchase Order Information', text: '<i class="fas fa-file-csv mr-2"></i> CSV', },
                { extend: 'pdf', className: 'btn btn-danger btn-sm', title: 'Purchase Order Information', text: '<i class="fas fa-file-pdf mr-2"></i> PDF', },
                { 
                    extend: 'print', 
                    title: 'Purchase Order Information',
                    className: 'btn btn-primary btn-sm', 
                    text: '<i class="fas fa-print mr-2"></i> Print',
                    customize: function ( win ) {
                        $(win.document.body).find( 'table' )
                            .addClass( 'compact' )
                            .css( 'font-size', 'inherit' );
                    }, 
                },
                // 'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            ajax: {
                url: "<?php echo base_url() ?>scripts/purchaseorderlist.php",
                type: "POST", // you can use GET
                // data: function(d) {}
            },
            "order": [[ 0, "desc" ]],
            "columns": [
                {
                    "data": "idtbl_porder"
                },
                {
                    "data": "po_no"
                },
                {
                    "data": "type"
                },
                {
                    "data": "orderdate"
                },
                {
                    "data": "suppliername"
                },
                {
                    "data": "location"
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function(data, type, full) {
                        return addCommas(parseFloat(full['nettotal']).toFixed(2));
                    }
                },
                {
                    "targets": -1,
                    "className": '',
                    "data": null,
                    "render": function(data, type, full) {
                        if(full['confirmstatus']==1){return '<i class="fas fa-check text-success mr-2"></i>Confirm Order';}
                        else{return 'Not Confirm Order';}
                    }
                },
                {
                    "targets": -1,
                    "className": '',
                    "data": null,
                    "render": function(data, type, full) {
                        if(full['grnconfirm']==1){return '<i class="fas fa-check text-success mr-2"></i>Issue GRN';}
                        else{return 'Not Issue GRN';}
                    }
                },
                {
                    "data": "remark"
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function(data, type, full) {
                        var button='';
                        button+='<button class="btn btn-dark btn-sm btnview mr-1" id="'+full['idtbl_porder']+'"><i class="fas fa-eye"></i></button>';
                        button+='<button class="btn btn-primary btn-sm btn_edit mr-1" id="'+full['idtbl_porder']+'"><i class="fa fa-edit"></i></button>';
                        button+='<button class="btn btn-danger btn-sm btn_delete mr-1" id="'+full['idtbl_porder']+'"><i class="fa fa-trash"></i></button>';

                        return button;
                    }
                }
            ],
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });

        $('#dataTable tbody').on('click', '.btnview', function() {
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

        $('#supplier').change(function () {
            let supplierID = $(this).val()

            $.ajax({
                type: "POST",
                data: {
                    recordID: supplierID
                },
                url: 'Purchaseorder/Getproductaccosupplier',
                success: function (result) { //alert(result);
                    var obj = JSON.parse(result);
                    var html1 = '';
                    html1 += '<option value="">Select</option>';
                    $.each(obj, function (i, item) {
                        html1 += '<option value="' + obj[i].idtbl_material_info + '">';
                        html1 += obj[i].materialname + ' / ' + obj[i].materialinfocode;
                        html1 += '</option>';
                    });
                    $('#product').empty().append(html1);
                }
            });
        });

        $("#formsubmit").click(function () {
            if (!$("#createorderform")[0].checkValidity()) {
                // If the form is invalid, submit it. The form won't actually submit;
                // this will just cause the browser to display the native HTML5 error messages.
                $("#submitBtn").click();
            } else {
                var spare_part_id = $('#spare_part_id').val();
                var comment = $('#comment').val();
                var spare_part_text = $("#spare_part_id option:selected").text();
                var unitprice = parseFloat($('#unitprice').val());
                var newqty = parseFloat($('#newqty').val());

                var newtotal = parseFloat(unitprice * newqty);

                var total = parseFloat(newtotal);
                var showtotal = addCommas(parseFloat(total).toFixed(2));

                $('#tableorder > tbody:last').append('<tr class="pointer"><td>' + spare_part_text + '</td><td>' + comment + '</td><td class="d-none">' + spare_part_id + '</td><td class="d-none">' + unitprice + '</td><td class="text-center">' + newqty + '</td><td class="total d-none">' + total + '</td><td class="text-right">' + showtotal + '</td></tr>');

                $('#spare_part_id').val('').trigger('change');
                $('#unitprice').val('');
                $('#saleprice').val('');
                $('#comment').val('');
                $('#newqty').val('0');

                var sum = 0;
                $(".total").each(function () {
                    sum += parseFloat($(this).text());
                });

                var showsum = addCommas(parseFloat(sum).toFixed(2));

                $('#divtotal').html('Rs. ' + showsum);
                $('#hidetotalorder').val(sum);
                //$('#product').focus();
            }
        });
        $('#tableorder').on('click', 'tr', function () {
            var r = confirm("Are you sure, You want to remove this product ? ");
            if (r == true) {
                $(this).closest('tr').remove();

                var sum = 0;
                $(".total").each(function () {
                    sum += parseFloat($(this).text());
                });

                var showsum = addCommas(parseFloat(sum).toFixed(2));

                $('#divtotal').html('Rs. ' + showsum);
                $('#hidetotalorder').val(sum);
                $('#product').focus();
            }
        });
        $('#btncreateorder').click(function () { //alert('IN');
            $('#btncreateorder').prop('disabled', true).html('<i class="fas fa-circle-notch fa-spin mr-2"></i> Create Order')
            var tbody = $("#tableorder tbody");

            if (tbody.children().length > 0) {
                jsonObj = [];
                $("#tableorder tbody tr").each(function () {
                    item = {}
                    $(this).find('td').each(function (col_idx) {
                        item["col_" + (col_idx + 1)] = $(this).text();
                    });
                    jsonObj.push(item);
                });
                // console.log(jsonObj);

                var orderdate = $('#orderdate').val();
                var duedate = $('#duedate').val();
                var remark = $('#remark').val();
                var total = $('#hidetotalorder').val();
                var supplier = $('#supplier').val();
                var location = $('#location').val();
                var ordertype = $('#ordertype').val();
                // alert(orderdate);
                $.ajax({
                    type: "POST",
                    data: {
                        tableData: jsonObj,
                        orderdate: orderdate,
                        duedate: duedate,
                        total: total,
                        remark: remark,
                        supplier: supplier,
                        location: location,
                        ordertype: ordertype
                    },
                    url: base_url + 'Purchaseorder/Purchaseorderinsertupdate',
                    success: function (result) { //alert(result);
                        // console.log(result);
                        var obj = JSON.parse(result);
                        if(obj.status==1){
                            $('#modalgrnadd').modal('hide');
                            setTimeout(window.location.reload(), 3000);
                        }
                        action(obj.action);
                    }
                });
            }

        });

        $('#dataTable tbody').on('click', '.btn_edit', function() {
            var id = $(this).attr('id');
            $.ajax({
                type: "POST",
                data: {
                    recordID: id
                },
                url: '<?php echo base_url() ?>Purchaseorder/Purchaseorderedit',
                success: function(result) { //alert(result);
                    $('#porderEditModal').modal('show');
                    $('#editHtml').html(result);

                    $('#edit_ordertype').select2({
                        placeholder: 'Select...',
                        width: '100%',
                        allowClear: true,
                        dropdownParent: $('#porderEditModal'),
                        ajax: {
                            url: base_url + 'Purchaseorder/get_order_type_select',
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

                    $('#edit_spare_part_id').select2({
                        placeholder: 'Select...',
                        width: '100%',
                        allowClear: true,
                        dropdownParent: $('#porderEditModal'),
                        ajax: {
                            url: base_url + 'SpareParts/get_parts_select',
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

                    $("#edit_spare_part_id").on("change", function (e) {
                        let spare_part_id = $(this).val();
                        if(spare_part_id == ''){
                            return false;
                        }
                        let btn = $('#edit_formsubmit');
                        let btn_text = btn.html();
                        btn.html('<i class="fa fa-spinner fa-spin"></i> Loading...');
                        btn.attr('disabled', 'disabled');
                        $.ajax({
                            url: base_url + 'SpareParts/fetchUnitPrice',
                            type: 'post',
                            dataType: 'json',
                            data: {spare_part_id: spare_part_id },
                            success: function (response) {
                                $('#edit_unitprice').val(response.unit_price);
                                btn.html(btn_text);
                                btn.removeAttr('disabled');

                            }
                        });

                    });

                    $('#edit_location').select2({
                        placeholder: 'Select...',
                        width: '100%',
                        allowClear: true,
                        dropdownParent: $('#porderEditModal'),
                        ajax: {
                            url: base_url + 'Purchaseorder/get_locations_select',
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

                    $('#edit_supplier').select2({
                        placeholder: 'Select...',
                        width: '100%',
                        allowClear: true,
                        dropdownParent: $('#porderEditModal'),
                        ajax: {
                            url: base_url + 'Purchaseorder/get_suppliers_select',
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

                    $("#edit_formsubmit").click(function () {
                        if (!$("#editorderform")[0].checkValidity()) {
                            // If the form is invalid, submit it. The form won't actually submit;
                            // this will just cause the browser to display the native HTML5 error messages.
                            $("#edit_submitBtn").click();
                        } else {
                            var spare_part_id = $('#edit_spare_part_id').val();
                            var comment = $('#edit_comment').val();
                            var spare_part_text = $("#edit_spare_part_id option:selected").text();
                            var unitprice = parseFloat($('#edit_unitprice').val());
                            var newqty = parseFloat($('#edit_newqty').val());

                            var newtotal = parseFloat(unitprice * newqty);

                            var total = parseFloat(newtotal);
                            var showtotal = addCommas(parseFloat(total).toFixed(2));

                            $('#edit_tableorder > tbody:last').append('<tr class="pointer"><td>' + spare_part_text + '</td><td>' + comment + '</td><td class="d-none">' + spare_part_id + '</td><td class="d-none">' + unitprice + '</td><td >' + newqty + '</td><td class="edit_total d-none">' + total + '</td><td class="text-right">' + showtotal + '</td></tr>');

                            $('#edit_spare_part_id').val('').trigger('change');
                            $('#edit_unitprice').val('');
                            $('#edit_saleprice').val('');
                            $('#edit_comment').val('');
                            $('#edit_newqty').val('');

                            var sum = 0;
                            $(".edit_total").each(function () {
                                sum += parseFloat($(this).text());
                            });

                            var showsum = addCommas(parseFloat(sum).toFixed(2));

                            $('#edit_divtotal').html('Rs. ' + showsum);
                            $('#edit_hidetotalorder').val(sum);
                            //$('#product').focus();
                        }
                    });

                    $('#edit_tableorder').on('click', 'tr', function () {
                        var r = confirm("Are you sure, You want to remove this product ? ");
                        if (r == true) {
                            $(this).closest('tr').remove();

                            var sum = 0;
                            $(".edit_total").each(function () {
                                sum += parseFloat($(this).text());
                            });

                            var showsum = addCommas(parseFloat(sum).toFixed(2));

                            $('#edit_divtotal').html('Rs. ' + showsum);
                            $('#edit_hidetotalorder').val(sum);
                        }
                    });

                    $('#edit_btncreateorder').click(function () { //alert('IN');
                        $('#edit_btncreateorder').prop('disabled', true).html('<i class="fas fa-circle-notch fa-spin mr-2"></i> Create Order')
                        var tbody = $("#edit_tableorder tbody");

                        if (tbody.children().length > 0) {
                            jsonObj = [];
                            $("#edit_tableorder tbody tr").each(function () {
                                item = {}
                                $(this).find('td').each(function (col_idx) {
                                    item["col_" + (col_idx + 1)] = $(this).text();
                                });
                                jsonObj.push(item);
                            });
                            // console.log(jsonObj);

                            var porder_id = $('#edit_porder_id').val();
                            var orderdate = $('#edit_orderdate').val();
                            var duedate = $('#edit_duedate').val();
                            var remark = $('#edit_remark').val();
                            var total = $('#edit_hidetotalorder').val();
                            var supplier = $('#edit_supplier').val();
                            var location = $('#edit_location').val();
                            var ordertype = $('#edit_ordertype').val();
                            // alert(orderdate);
                            $.ajax({
                                type: "POST",
                                data: {
                                    tableData: jsonObj,
                                    porder_id: porder_id,
                                    orderdate: orderdate,
                                    duedate: duedate,
                                    total: total,
                                    remark: remark,
                                    supplier: supplier,
                                    location: location,
                                    ordertype: ordertype
                                },
                                url: base_url + 'Purchaseorder/Purchaseorderupdate',
                                success: function (result) { //alert(result);
                                    // console.log(result);
                                    var obj = JSON.parse(result);
                                    if(obj.status==1){
                                        $('#modalgrnadd').modal('hide');
                                        setTimeout(window.location.reload(), 3000);
                                    }
                                    action(obj.action);
                                }
                            });
                        }

                    });



                }
            });
        });

        $('#dataTable tbody').on('click', '.btn_delete', function() {
            var id = $(this).attr('id');
            //confirm delete alert
            if (confirm('Are you sure want to delete?')) {
                $.ajax({
                    type: "POST",
                    data: {
                        id: id
                    },
                    url: '<?php echo base_url() ?>Purchaseorder/Purchaseorderdelete',
                    success: function (result) { //alert(result);
                        var obj = JSON.parse(result);
                        if(obj.status==1){
                            setTimeout(window.location.reload(), 3000);
                        }
                    }
                })
            }

        });
    });

    function deactive_confirm() {
        return confirm("Are you sure you want to deactive this?");
    }

    function active_confirm() {
        return confirm("Are you sure you want to confirm this purchase order?");
    }

    function delete_confirm() {
        return confirm("Are you sure you want to remove this?");
    }

    function addCommas(nStr) {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }

    function action(data) { //alert(data);
        var obj = JSON.parse(data);
        $.notify({
            // options
            icon: obj.icon,
            title: obj.title,
            message: obj.message,
            url: obj.url,
            target: obj.target
        }, {
            // settings
            element: 'body',
            position: null,
            type: obj.type,
            allow_dismiss: true,
            newest_on_top: false,
            showProgressbar: false,
            placement: {
                from: "top",
                align: "center"
            },
            offset: 100,
            spacing: 10,
            z_index: 1031,
            delay: 5000,
            timer: 1000,
            url_target: '_blank',
            mouse_over: null,
            animate: {
                enter: 'animated fadeInDown',
                exit: 'animated fadeOutUp'
            },
            onShow: null,
            onShown: null,
            onClose: null,
            onClosed: null,
            icon_type: 'class',
            template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
                '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                '<span data-notify="icon"></span> ' +
                '<span data-notify="title">{1}</span> ' +
                '<span data-notify="message">{2}</span>' +
                '<div class="progress" data-notify="progressbar">' +
                '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                '</div>' +
                '<a href="{3}" target="{4}" data-notify="url"></a>' +
                '</div>'
        });
    }
</script>