<div class="container-fluid mt-2 p-0 p-2">
    <div class="card">
        <div class="card-body p-0 p-2">
            <div class="row">
                <div class="col-6">
                    <h2 class="">Good Receive</h2>
                </div>
                <div class="col-6 text-right">
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                            data-target="#staticBackdrop" <?php if ($addcheck == 0) {
                        echo 'disabled';
                    } ?>><i class="fas fa-plus mr-2"></i>Create Good Receive Note
                    </button>
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="scrollbar pb-3" id="style-2">
                        <table class="table table-bordered table-striped table-sm nowrap" id="dataTable" width="100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>GRN Type</th>
                                <th>Date</th>
                                <th>Batch No</th>
                                <th>Supplier</th>
                                <th>Location</th>
                                <th>Invoice No</th>
                                <th>Dispatch No</th>
                                <th>Total</th>
                                <th>Approved Status</th>
                                <th>Quality Status</th>
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
                <h5 class="modal-title" id="staticBackdropLabel">Create Good Receive Note</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
                        <form id="createorderform" autocomplete="off">
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Order Date*</label>
                                    <input type="date" class="form-control form-control-sm" placeholder=""
                                           name="grndate" id="grndate" value="<?php echo date('Y-m-d') ?>" required>
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
                                    <label class="small font-weight-bold text-dark">Purchase Order</label>
                                    <select class="form-control form-control-sm" name="porder" id="porder">
                                        <option value="">Select</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Supplier*</label>
                                    <select class="form-control form-control-sm" name="supplier" id="supplier" required>
                                        <option value="">Select</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group mb-1">
                                <label class="small font-weight-bold text-dark">GRN Type*</label>
                                <select class="form-control form-control-sm" name="grntype" id="grntype" required>
                                    <option value="">Select</option>
                                </select>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Product*</label>
                                    <select class="form-control form-control-sm" name="spare_part_id" id="spare_part_id"
                                            required>
                                        <option value="">Select</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">MF Date*</label>
                                    <input type="date" id="mfdate" name="mfdate" class="form-control form-control-sm"
                                           value="<?php echo date('Y-m-d') ?>" required>
                                </div>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Shelf Life*</label>
                                    <input type="checkbox" id="enableShelfLife" onclick="toggleShelfLife()">
                                    <select class="form-control form-control-sm" name="quater" id="quater" disabled required>
                                        <option value="">Select</option>
                                        <option value="1">3 Month</option>
                                        <option value="2">6 Month</option>
                                        <option value="3">9 Month</option>
                                        <option value="4">12 Month</option>
                                        <option value="5">18 Month</option>
                                        <option value="6">24 Month</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">EXP Date*</label>
                                    <input type="date" id="expdate" name="expdate" class="form-control form-control-sm" disabled required>
                                </div>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Qty*</label>
                                    <input type="text" id="newqty" name="newqty"
                                           class="form-control form-control-sm" <?php if ($editcheck == 0) {
                                        echo 'readonly';
                                    } ?> required>
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Unit Price</label>
                                    <input type="text" id="unitprice" name="unitprice"
                                           class="form-control form-control-sm" <?php if ($editcheck == 0) {
                                        echo 'readonly';
                                    } ?> value="0">
                                </div>
                            </div>
                            <div class="form-group mb-1">
                                <label class="small font-weight-bold text-dark">Comment</label>
                                <textarea name="comment" id="comment"
                                          class="form-control form-control-sm" <?php if ($editcheck == 0) {
                                    echo 'readonly';
                                } ?>></textarea>
                            </div>
                            <div class="form-group mt-3 text-right">
                                <button type="button" id="formsubmit"
                                        class="btn btn-primary btn-sm px-4" <?php if ($addcheck == 0) {
                                    echo 'disabled';
                                } ?>><i class="fas fa-plus"></i>&nbsp;Add to list
                                </button>
                                <input name="submitBtn" type="submit" value="Save" id="submitBtn" class="d-none">
                            </div>
                            <div class="form-group mb-1">
                                <label class="small font-weight-bold text-dark">Batch No</label>
                                <input type="text" id="batchno" name="batchno" class="form-control form-control-sm"
                                       readonly>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Invoice No*</label>
                                    <input type="text" id="invoice" name="invoice" class="form-control form-control-sm">
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Dispatch No</label>
                                    <input type="text" id="dispatch" name="dispatch"
                                           class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Transport Cost</label>
                                    <input type="number" step="0.01" id="transportcost" name="transportcost"
                                           class="form-control form-control-sm">
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Unload COst</label>
                                    <input type="number" step="0.01" id="unloadcost" name="unloadcost"
                                           class="form-control form-control-sm">
                                </div>
                            </div>
                            
                            <input type="hidden" name="refillprice" id="refillprice" value="">
                        </form>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8">
                        <div class="scrollbar pb-3" id="style-3">
                            <table class="table table-striped table-bordered table-sm small" id="tableorder">
                                <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Comment</th>
                                    <th>MF Date</th>
                                    <th>EXP Date</th>
                                    <th class="d-none">Quater</th>
                                    <th class="d-none">ProductID</th>
                                    <th class="d-none">Unitprice</th>
                                    <th class="d-none">Saleprice</th>
                                    <th class="text-center">Qty</th>
                                    <th class="d-none">HideTotal</th>
                                    <th class="text-right">Total</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
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
                                Good Receive Note
                            </button>
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
                <h5 class="modal-title" id="staticBackdropLabel">View Good Receive Note</h5>
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

<div class="modal fade" id="pordereditmodal" data-backdrop="static" data-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel11" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel11">Edit Good Receive Note</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="edithtml"></div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        var base_url = "<?php echo base_url(); ?>";

        $('#grn_main_nav_link').prop('aria-expanded', 'true').removeClass('collapsed');
        $('#collapseLayoutsGRN').addClass('show');

        $(document).on("click",".print-btn",function(e) {
            let id = $(this).data('id');
            //print_table(id);
            window.location.href = '<?php echo base_url() ?>Goodreceive/GoodreceiveviewPrint/' + id;
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

        $('#porder').select2({
            placeholder: 'Select...',
            width: '100%',
            allowClear: true,
            dropdownParent: $('#staticBackdrop'),
            ajax: {
                url: base_url + 'Purchaseorder/get_porder_select',
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

        $('#grntype').select2({
            placeholder: 'Select...',
            width: '100%',
            allowClear: true,
            dropdownParent: $('#staticBackdrop'),
            ajax: {
                url: base_url + 'Purchaseorder/get_grn_types_select',
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

        $('#spare_part_id').select2({
            placeholder: 'Select...',
            width: '100%',
            allowClear: true,
            dropdownParent: $('#staticBackdrop'),
            ajax: {
                url: base_url + 'Purchaseorder/get_po_spare_part_select',
                dataType: 'json',
                data: function (params) {
                    return {
                        term: params.term || '',
                        page: params.page || 1,
                        po_id: $('#porder').val()
                    }
                },
                cache: true
            }
        });


        $("#spare_part_id").on("change", function (e) {
            let spare_part_id = $(this).val();
            if (spare_part_id == '') {
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
                data: {spare_part_id: spare_part_id},
                success: function (response) {
                    $('#unitprice').val(response.unit_price);
                    btn.html(btn_text);
                    btn.removeAttr('disabled');

                }
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
                {
                    extend: 'csv',
                    className: 'btn btn-success btn-sm',
                    title: 'Good Receive Note Information',
                    text: '<i class="fas fa-file-csv mr-2"></i> CSV',
                },
                {
                    extend: 'pdf',
                    className: 'btn btn-danger btn-sm',
                    title: 'Good Receive Note Information',
                    text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
                },
                {
                    extend: 'print',
                    title: 'Good Receive Note Information',
                    className: 'btn btn-primary btn-sm',
                    text: '<i class="fas fa-print mr-2"></i> Print',
                    customize: function (win) {
                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    },
                },
                // 'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            ajax: {
                url: "<?php echo base_url() ?>scripts/goodreceivelist.php",
                type: "POST", // you can use GET
                // data: function(d) {}
            },
            "order": [[0, "desc"]],
            "columns": [
                {
                    "data": "idtbl_grn"
                },
                {
                    "data": "type"
                },
                {
                    "data": "grndate"
                },
                {
                    "data": "batchno"
                },
                {
                    "data": "suppliername"
                },
                {
                    "data": "location"
                },
                {
                    "data": "invoicenum"
                },
                {
                    "data": "dispatchnum"
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function (data, type, full) {
                        return addCommas(parseFloat(full['total']).toFixed(2));
                    }
                },
                {
                    "targets": -1,
                    "className": '',
                    "data": null,
                    "render": function (data, type, full) {
                        if (full['approvestatus'] == 1) {
                            return '<i class="fas fa-check text-success mr-2"></i>Approved GRN';
                        } else {
                            return 'Not Approved GRN';
                        }
                    }
                },
                {
                    "targets": -1,
                    "className": '',
                    "data": null,
                    "render": function (data, type, full) {
                        if (full['qualitycheck'] == 1) {
                            return '<i class="fas fa-check text-success mr-2"></i>Quality Checked';
                        } else if (full['qualitycheck'] == 0) {
                            return '<i class="fas fa-times text-danger mr-2"></i>Pending';
                        }
                    }
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function (data, type, full) {
                        var button = '';
                        button += '<button class="btn btn-dark btn-sm btnview mr-1" id="' + full['idtbl_grn'] + '"><i class="fas fa-eye"></i></button>';
                        button += '<button class="btn btn-primary btn-sm btn_edit mr-1" id="' + full['idtbl_grn'] + '"><i class="fas fa-edit"></i></button>';
                        button += '<button class="btn btn-danger btn-sm btn_delete mr-1" id="' + full['idtbl_grn'] + '"><i class="fas fa-trash"></i></button>';

                        return button;
                    }
                }
            ],
            drawCallback: function (settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
        $('#dataTable tbody').on('click', '.btnview', function () {
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

        $("#formsubmit").click(function () {
            if (!$("#createorderform")[0].checkValidity()) {
                // If the form is invalid, submit it. The form won't actually submit;
                // this will just cause the browser to display the native HTML5 error messages.
                $("#submitBtn").click();
            } else {
                var productID = $('#spare_part_id').val();
                var product = $("#spare_part_id option:selected").text();
                var comment = $('#comment').val();
                var unitprice = parseFloat($('#unitprice').val());
                var newqty = parseFloat($('#newqty').val());
                var mfdate = $('#mfdate').val();
                var quater = $('#quater').val();
                var expdate = $('#expdate').val();

                var newtotal = parseFloat(unitprice * newqty);

                var total = parseFloat(newtotal);
                var showtotal = addCommas(parseFloat(total).toFixed(2));

                $('#tableorder > tbody:last').append('<tr class="pointer"><td>' + product + '</td><td>' + comment + '</td><td>' + mfdate + '</td><td>' + expdate + '</td><td class="d-none">' + quater + '</td><td class="d-none">' + productID + '</td><td class="d-none">' + unitprice + '</td><td class="text-center">' + newqty + '</td><td class="total d-none">' + total + '</td><td class="text-right">' + showtotal + '</td></tr>');

                $('#spare_part_id').val('').trigger('change');
                $('#unitprice').val('');
                $('#saleprice').val('');
                $('#comment').val('');
                $('#newqty').val('');
                $('#mfdate').val('<?php echo date('Y-m-d') ?>');
                $('#quater').val('');
                $('#expdate').val('');

                var sum = 0;
                $(".total").each(function () {
                    sum += parseFloat($(this).text());
                });

                var showsum = addCommas(parseFloat(sum).toFixed(2));

                $('#divtotal').html('Rs. ' + showsum);
                $('#hidetotalorder').val(sum);
                $('#spare_part_id').focus();
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
            $('#btncreateorder').prop('disabled', true).html('<i class="fas fa-circle-notch fa-spin mr-2"></i> Create Good Receive Note')
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

                var grndate = $('#grndate').val();
                var remark = $('#remark').val();
                var total = $('#hidetotalorder').val();
                var supplier = $('#supplier').val();
                var location = $('#location').val();
                var porder = $('#porder').val();
                var batchno = $('#batchno').val();
                var invoice = $('#invoice').val();
                var dispatch = $('#dispatch').val();
                var grntype = $('#grntype').val();
                var transportcost = $('#transportcost').val();
                var unloadcost = $('#unloadcost').val();
                // alert(orderdate);
                $.ajax({
                    type: "POST",
                    data: {
                        tableData: jsonObj,
                        grndate: grndate,
                        total: total,
                        remark: remark,
                        supplier: supplier,
                        location: location,
                        porder: porder,
                        invoice: invoice,
                        dispatch: dispatch,
                        batchno: batchno,
                        grntype: grntype,
                        transportcost: transportcost,
                        unloadcost: unloadcost
                    },
                    url: '<?php echo base_url() ?>Goodreceive/Goodreceiveinsertupdate',
                    success: function (result) { //alert(result);
                        // console.log(result);
                        var obj = JSON.parse(result);
                        if (obj.status == 1) {
                            $('#modalgrnadd').modal('hide');
                            setTimeout(window.location.reload(), 3000);
                        }
                        action(obj.action);
                    }
                });
            }

        });

        $('#quater').change(function () {
            var quaterID = $(this).val();
            var mfdate = $('#mfdate').val();

            $.ajax({
                type: "POST",
                data: {
                    recordID: quaterID,
                    mfdate: mfdate
                },
                url: 'Goodreceive/Getexpdateaccoquater',
                success: function (result) { //alert(result);
                    $('#expdate').val(result);
                }
            });
        });

        $('#dataTable tbody').on('click', '.btn_edit', function () {
            var id = $(this).attr('id');
            $.ajax({
                type: "POST",
                data: {
                    recordID: id
                },
                url: '<?php echo base_url() ?>Goodreceive/Goodreceiveedit',
                success: function (result) { //alert(result);
                    $('#pordereditmodal').modal('show');
                    $('#edithtml').html(result);

                    $('#edit_location').select2({
                        placeholder: 'Select...',
                        width: '100%',
                        allowClear: true,
                        dropdownParent: $('#pordereditmodal'),
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

                    $('#edit_porder').select2({
                        placeholder: 'Select...',
                        width: '100%',
                        allowClear: true,
                        dropdownParent: $('#pordereditmodal'),
                        ajax: {
                            url: base_url + 'Purchaseorder/get_porder_select',
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
                        dropdownParent: $('#pordereditmodal'),
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

                    $('#edit_grntype').select2({
                        placeholder: 'Select...',
                        width: '100%',
                        allowClear: true,
                        dropdownParent: $('#pordereditmodal'),
                        ajax: {
                            url: base_url + 'Purchaseorder/get_grn_types_select',
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
                        dropdownParent: $('#pordereditmodal'),
                        ajax: {
                            url: base_url + 'Purchaseorder/get_po_spare_part_select',
                            dataType: 'json',
                            data: function (params) {
                                return {
                                    term: params.term || '',
                                    page: params.page || 1,
                                    po_id: $('#edit_porder').val()
                                }
                            },
                            cache: true
                        }
                    });


                    $("#edit_spare_part_id").on("change", function (e) {
                        let spare_part_id = $(this).val();
                        if (spare_part_id == '') {
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
                            data: {spare_part_id: spare_part_id},
                            success: function (response) {
                                $('#edit_unitprice').val(response.unit_price);
                                btn.html(btn_text);
                                btn.removeAttr('disabled');

                            }
                        });

                    });

                    $("#edit_formsubmit").click(function () {
                        if (!$("#edit_createorderform")[0].checkValidity()) {
                            // If the form is invalid, submit it. The form won't actually submit;
                            // this will just cause the browser to display the native HTML5 error messages.
                            $("#edit_submitBtn").click();
                        } else {
                            var productID = $('#edit_spare_part_id').val();
                            var product = $("#edit_spare_part_id option:selected").text();
                            var comment = $('#edit_comment').val();
                            var unitprice = parseFloat($('#edit_unitprice').val());
                            var newqty = parseFloat($('#edit_newqty').val());
                            var mfdate = $('#edit_mfdate').val();
                            var quater = $('#edit_quater').val();
                            var expdate = $('#edit_expdate').val();

                            var newtotal = parseFloat(unitprice * newqty);

                            var total = parseFloat(newtotal);
                            var showtotal = addCommas(parseFloat(total).toFixed(2));

                            $('#edit_tableorder > tbody:last').append('<tr class="pointer"><td>' + product + '</td><td>' + comment + '</td><td>' + mfdate + '</td><td>' + expdate + '</td><td class="d-none">' + quater + '</td><td class="d-none">' + productID + '</td><td class="d-none">' + unitprice + '</td><td class="text-center">' + newqty + '</td><td class="edit_total d-none">' + total + '</td><td class="text-right">' + showtotal + '</td></tr>');

                            $('#edit_spare_part_id').val('').trigger('change');
                            $('#edit_unitprice').val('');
                            $('#edit_saleprice').val('');
                            $('#edit_comment').val('');
                            $('#edit_newqty').val('');
                            $('#edit_mfdate').val('<?php echo date('Y-m-d') ?>');
                            $('#edit_quater').val('');
                            $('#edit_expdate').val('');

                            var sum = 0;
                            $(".edit_total").each(function () {
                                sum += parseFloat($(this).text());
                            });

                            var showsum = addCommas(parseFloat(sum).toFixed(2));

                            $('#edit_divtotal').html('Rs. ' + showsum);
                            $('#edit_hidetotalorder').val(sum);
                            $('#edit_spare_part_id').focus();
                        }
                    });

                    $('#edit_btncreateorder').click(function () { //alert('IN');
                        $('#edit_btncreateorder').prop('disabled', true).html('<i class="fas fa-circle-notch fa-spin mr-2"></i> Create Good Receive Note')
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

                            var recordID = $('#recordID').val();
                            var grndate = $('#edit_grndate').val();
                            var remark = $('#edit_remark').val();
                            var total = $('#edit_hidetotalorder').val();
                            var supplier = $('#edit_supplier').val();
                            var location = $('#edit_location').val();
                            var porder = $('#edit_porder').val();
                            var batchno = $('#edit_batchno').val();
                            var invoice = $('#edit_invoice').val();
                            var dispatch = $('#edit_dispatch').val();
                            var grntype = $('#edit_grntype').val();
                            var transportcost = $('#edit_transportcost').val();
                            var unloadcost = $('#edit_unloadcost').val();
                            // alert(orderdate);
                            $.ajax({
                                type: "POST",
                                data: {
                                    tableData: jsonObj,
                                    grndate: grndate,
                                    total: total,
                                    remark: remark,
                                    supplier: supplier,
                                    location: location,
                                    porder: porder,
                                    invoice: invoice,
                                    dispatch: dispatch,
                                    batchno: batchno,
                                    grntype: grntype,
                                    transportcost: transportcost,
                                    unloadcost: unloadcost,
                                    recordID: recordID
                                },
                                url: '<?php echo base_url() ?>Goodreceive/Goodreceiveupdate',
                                success: function (result) { //alert(result);
                                    // console.log(result);
                                    var obj = JSON.parse(result);
                                    if (obj.status == 1) {
                                        $('#edit_modalgrnadd').modal('hide');
                                        setTimeout(window.location.reload(), 3000);
                                    }
                                    action(obj.action);
                                }
                            });
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
                    url: '<?php echo base_url() ?>Goodreceive/Goodreceivedelete',
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

    function toggleShelfLife() {
        var checkbox = document.getElementById('enableShelfLife');
        var quater = document.getElementById('quater');
        var expdate = document.getElementById('expdate');

        quater.disabled = !checkbox.checked;
        expdate.disabled = !checkbox.checked;
    }

    function toggleShelfLifeEdit() {
        var isChecked = $('#edit_enableShelfLife').is(':checked');
        $('#edit_quater').prop('disabled', !isChecked);
        $('#edit_expdate').prop('disabled', !isChecked);
    }

    function deactive_confirm() {
        return confirm("Are you sure you want to deactive this?");
    }

    function active_confirm() {
        return confirm("Are you sure you want to approve this good receive note?");
    }

    function delete_confirm() {
        return confirm("Are you sure you want to reject this good receive note?");
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

    function getbatchno() {
        var base_url = "<?php echo base_url(); ?>";
        var supplierID = $('#supplier').val();
        $.ajax({
            type: "POST",
            data: {
                recordID: supplierID
            },
            url: base_url + 'Goodreceive/Getbatchnoaccosupplier',
            success: function (result) { //alert(result);
                // console.log(result);
                $('#batchno').val(result);
            }
        });
    }
</script>
