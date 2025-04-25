<?php 
include "include/header.php";  
include "include/topnavbar.php"; 
?>
<div id="layoutSidenav">
	<div id="layoutSidenav_nav">
		<?php include "include/menubar.php"; ?>
	</div>
	<div id="layoutSidenav_content">
		<main>
			<div class="page-header page-header-light bg-white shadow">
				<div class="container-fluid">
					<div class="page-header-content py-3">
						<h1 class="page-header-title font-weight-light">
							<div class="page-header-icon"><i class="fas fa-list"></i></div>
							<span>Production Order List</span>
						</h1>
					</div>
				</div>
			</div>
			<div class="container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">
						<div class="row">
							<div class="col-12">
								<div class="scrollbar pb-3" id="style-2">
									<table class="table table-bordered table-striped table-sm nowrap"
										id="productionorderTable">
										<thead>
											<tr>
												<th>#</th>
												<th>Product</th>
												<th>Production Code</th>
												<th>Production Qty</th>
												<th>Production Date</th>
												<th>Start Date</th>
												<th>End Date</th>
												<th>Unit Price</th>
												<th>Total</th>
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
		</main>
		<?php include "include/footerbar.php"; ?>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="machineallocatemodal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Machine Allocation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="alert"></div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-4">
                        <form action="" autocomplete="off">
                            <div class="form-row mb-1">
                            <input type="hidden" class="form-control form-control-sm" name="productionorderid" id="productionorderid" required>
                                <label class="small font-weight-bold text-dark">Machine*</label><br>
                                <select class="form-control form-control-sm" style="width: 100%;"
                                    name="machine" id="machine" required>
                                    <option value="">Select</option>
                                    <?php foreach($machine->result() as $rowmachine){ ?>
                                    <option value="<?php echo $rowmachine->idtbl_machine ?>">
                                        <?php echo $rowmachine->machine.' - '.$rowmachine->machinecode ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-row mb-1">
                                    <label class="small font-weight-bold">Start Date*</label>
                                        <input type="date" class="form-control form-control-sm" placeholder=""
                                         name="startdate" id="startdate" required>
                            </div>
                            <div class="form-row mb-1">
                                    <label class="small font-weight-bold">End Date*</label>
                                        <input type="date" class="form-control form-control-sm" placeholder=""
                                         name="enddate" id="enddate" required>
                            </div>
                            <div class="form-group mt-3 px-2 text-right">
										<button type="button" name="BtnAddmachine" id="BtnAddmachine"
											class="btn btn-primary btn-m  fa-pull-right"><i
												class="fas fa-plus"></i>&nbsp;Add</button>
									</div>
                        </form>
                    </div>
                    <div class="col-8">
						<div class="row mt-4">
							<div class="col-12 col-md-12">
								<div class="table" id="style-2">
									<table class="table table-bordered table-striped  nowrap display" id="tblmachinelist">
										<thead>
                                            <th class="d-none">Costing ID</th>
											<th>Machine</th>
											<th>Start Date</th>
											<th>End Date</th>
										</thead>
										<tbody id="tblmachinebody">

										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="form-group mt-3 text-right">
                                <button type="submit" id="submitBtn2"
                                    class="btn btn-outline-primary btn-sm fa-pull-right"
                                    <?php if($addcheck==0){echo 'disabled';} ?>><i
                                        class="far fa-save"></i>&nbsp;Allocate Machine</button>
                            </div>
					</div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Prodcution Material Issue -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <div class="row mb-3">
                    <div class="col-sm-12 col-md-12 col-lg-7 col-xl-7">
                        <label class="small font-weight-bold text-dark">Order Finish Good*</label>
                        <select class="form-control form-control-sm" name="orderfinishgood" id="orderfinishgood" required>
                            <option value="">Select</option>
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2">
                        <label class="small font-weight-bold text-dark">Order Qty*</label>
                        <input type="text" name="orderqty" id="orderqty" class="form-control form-control-sm" readonly>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3">
                        <label class="small font-weight-bold text-dark">Issued Qty*</label>
                        <input type="text" name="issueqty" id="issueqty" class="form-control form-control-sm" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div id="datalayout"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 text-right">
                        <button type="button" class="btn btn-primary btn-sm" id="btnstartproduction"><i class="far fa-play-circle mr-2"></i>Issue Materials</button>
                    </div>
                </div>
                <input type="hidden" name="hideprodcutionorder" id="hideprodcutionorder">
			</div>
		</div>
	</div>
</div>
<!-- Modal Production Material -->
<div class="modal fade" id="modalproductionmaterial" data-backdrop="static" data-keyboard="false" tabindex="-1"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <table class="table table-striped table-bordered table-sm small" id="tablestockinfo">
                            <thead>
                                <tr>
                                    <th>Batch No</th>
                                    <th>Available Qty</th>
                                    <th>Qty</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <hr>
                        <div class="text-right">
                            <button type="button" class="btn btn-primary btn-sm" id="btnaddmaterialinfo">Issue Qty</button>
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>
<?php include "include/footerscripts.php"; ?>
<script>

$("#tblmachinelist").on('click', '.btnDeleterow', function () {
    $(this).closest('tr').remove();
});

$(document).on("click", "#BtnAddmachine", function () {
    	var machine = $('#machine').val();
        var machinelist = $("#machine option:selected").text();
    	var startdate = $('#startdate').val();
    	var enddate = $('#enddate').val();

    	$('#tblmachinelist> tbody:last').append('<tr><td class="text-center">' 
        + machinelist + '</td><td class="d-none text-center">' + machine + 
        '</td><td class="text-center">' + startdate + '</td><td class="text-center">' + enddate +
    		'</td><td> <button type="button" class="btnDeleterow btn btn-danger btn-sm float-right"><i class="fas fa-trash-alt"></i></button></td></tr>');
   
            $('#machine').val('');
            $('#startdate').val('');
            $('#enddate').val('');
        });

    $(document).on("click", "#submitBtn2", function () {

    	var productionorderId = $('#productionorderid').val();

    	// get table data into array
    	var tbody = $('#tblmachinelist tbody');
    	if (tbody.children().length > 0) {
    		var jsonObj = []
    		$("#tblmachinelist tbody tr").each(function () {
    			item = {}
    			$(this).find('td').each(function (col_idx) {
    				item["col_" + (col_idx + 1)] = $(this).text();
    			});
    			jsonObj.push(item);
    		});
    	}
    	//console.log(jsonObj);

    	$.ajax({
    		type: "POST",
    		data: {
    			tableData: jsonObj,
    			productionorderId: productionorderId
    		},
    		url: '<?php echo base_url() ?>Productionorderview/Machineinsertupdate',
    		success: function (result) {
    			//console.log(result);
    			location.reload();
    		}
    	});


    });

	$(document).ready(function () {
		var addcheck = '<?php echo $addcheck; ?>';
		var editcheck = '<?php echo $editcheck; ?>';
		var statuscheck = '<?php echo $statuscheck; ?>';
		var deletecheck = '<?php echo $deletecheck; ?>';

        setdatalayout();

		$('#productionorderTable').DataTable({
			"destroy": true,
			"processing": true,
			"serverSide": true,
			dom: "<'row'<'col-sm-5'B><'col-sm-2'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" +
				"<'row'<'col-sm-5'i><'col-sm-7'p>>",
			responsive: true,
			lengthMenu: [
				[10, 25, 50, -1],
				[10, 25, 50, 'All'],
			],
			"buttons": [{
					extend: 'csv',
					className: 'btn btn-success btn-sm',
					title: 'Production View Information',
					text: '<i class="fas fa-file-csv mr-2"></i> CSV',
				},
				{
					extend: 'pdf',
					className: 'btn btn-danger btn-sm',
					title: 'Production View Information',
					text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
				},
				{
					extend: 'print',
					title: 'Production View Information',
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
				url: "<?php echo base_url() ?>scripts/productionorderlist.php",
				type: "POST", // you can use GET
				// data: function(d) {}
			},
			"order": [
				[0, "desc"]
			],
			"columns": [{
					"data": "idtbl_production_orderdetail"
				},
				{
					"data": "productcode"
				},
				{
					"data": "procode"
				},
				{
					"data": "qty"
				},
				{
					"data": "prodate"
				},
				{
					"data": "prostartdate"
				},
				{
					"data": "proenddate"
				},
				{
					"data": "unitprice"
				},
				{
					"data": "total"
				},
				{
					"targets": -1,
					"className": 'text-right',
					"data": null,
					"render": function (data, type, full) {
						var button = '';
						button += '<button class="btn btn-primary btn-sm btnIssueMaterial mr-1" id="' + full[ 'idtbl_production_orderdetail'] + '"><i class="fas fa-pallet"></i></button>';
						button += '<button class="btn btn-dark btn-sm btnAdd mr-1" id="' + full[ 'idtbl_production_orderdetail'] + '"><i class="fas fa-tools"></i></button>';
                        
						button += '<a href="<?php echo base_url() ?>Productionorderview/Productionorderstatus/' + full['idtbl_production_orderdetail'] + '/3" onclick="return delete_confirm()" target="_self" class="btn btn-danger btn-sm ';
						if (deletecheck != 1) {
							button += 'd-none';
						}
						button += '"><i class="fas fa-trash-alt"></i></a>';

						return button;
					}
				}
			],
			drawCallback: function (settings) {
				$('[data-toggle="tooltip"]').tooltip();
			}
		});

		$('#productionorderTable tbody').on('click', '.btnAdd', function () {
			var id = $(this).attr('id');
			$.ajax({
				type: "POST",
				data: {
					recordID: id
				},
				url: '<?php echo base_url() ?>Productionorderview/Getproductionorderid',
				success: function (result) { //alert(result);
					var obj = JSON.parse(result);
					$('#productionorderid').val(obj[0]
						.tbl_production_order_idtbl_production_order);
					$('#machineallocatemodal').modal('show');
				}
			});
		});

        $("#startdate").change(function (event) {
        	event.preventDefault();
        	var machineid = $('#machine').val();
        	var startdate = $('#startdate').val();
            var enddate = $('#enddate').val();
        	$.ajax({
        		type: "POST",
        		data: {
        			machineid: machineid,
        			startdate: startdate,
                    enddate: enddate,
        		},
        		url: '<?php echo base_url() ?>Productionorderview/Checkmachineavailability',
        		success: function (result) { //alert(result);
        			var obj = JSON.parse(result);
                    var html = '';

        			if (obj.actiontype == 1) {
                        html += '<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Sorry!</strong> Machine is Not Available.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';      
                        $('#alert').html(html); 			
                    }

        		}
        	});
        });

		$('#productionorderTable tbody').on('click', '.btnIssueMaterial', function () {
            var id = $(this).attr('id');
            $('#hideprodcutionorder').val(id);
            $('#staticBackdrop').modal('show');
            
            $.ajax({
                type: "POST",
                data: {
                    recordID: id
                },
                url: '<?php echo base_url() ?>Productionorderview/Productiondetailaccoproduction',
                success: function(result) { //alert(result);
                    var obj = JSON.parse(result);
                    var html1 = '';
                    html1 += '<option value="">Select</option>';
                    $.each(obj, function (i, item) {
                        html1 += '<option value="' + obj[i].idtbl_production_orderdetail + '">';
                        html1 += obj[i].materialname + ' - ' + obj[i].productcode;
                        html1 += '</option>';
                    });
                    $('#orderfinishgood').empty().append(html1);                    
                }
            });
		});

        $('#orderfinishgood').change(function(){
            var id = $(this).val();

            $.ajax({
                type: "POST",
                data: {
                    recordID: id
                },
                url: '<?php echo base_url() ?>Productionorderview/Getqtyinfoaccoproductiondetail',
                success: function(result) { //alert(result);
                    var obj = JSON.parse(result);
                    
                    $.each(obj, function (i, item) {
                        $('#orderqty').val(obj[i].qty);
                        $('#issueqty').val(obj[i].issueqty);
                    });
                }
            });

            $.ajax({
                type: "POST",
                data: {
                    recordID: id
                },
                url: '<?php echo base_url() ?>Productionorderview/Getrowmateriallist',
                success: function(result) { //alert(result);
                    var obj = JSON.parse(result);
                    var html1 = '';
                    html1 += '<option value="">Row Material</option>';
                    $.each(obj, function (i, item) {
                        html1 += '<option value="' + obj[i].idtbl_print_material_info + '">';
                        html1 += obj[i].materialname + ' - ' + obj[i].materialinfocode;
                        html1 += '</option>';
                    });
                    $('.rowmaterial').empty().append(html1);
                }
            });
            
            $.ajax({
                type: "POST",
                data: {
                    recordID: id
                },
                url: '<?php echo base_url() ?>Productionorderview/Getpackmateriallist',
                success: function(result) { //alert(result);
                    var obj = JSON.parse(result);
                    var html1 = '';
                    html1 += '<option value="">Packing Material</option>';
                    $.each(obj, function (i, item) {
                        html1 += '<option value="' + obj[i].idtbl_print_material_info + '">';
                        html1 += obj[i].materialname + ' - ' + obj[i].materialinfocode;
                        html1 += '</option>';
                    });
                    $('.packingmaterial').empty().append(html1);
                }
            });

            $.ajax({
                type: "POST",
                data: {
                    recordID: id
                },
                url: '<?php echo base_url() ?>Productionorderview/Getlablemateriallist',
                success: function(result) { //alert(result);
                    var obj = JSON.parse(result);
                    var html1 = '';
                    html1 += '<option value="">Labling Material</option>';
                    $.each(obj, function (i, item) {
                        html1 += '<option value="' + obj[i].idtbl_print_material_info + '">';
                        html1 += obj[i].materialname + ' - ' + obj[i].materialinfocode;
                        html1 += '</option>';
                    });
                    $('.lablematerial').empty().append(html1);
                }
            });
        });
        $('#btnstartproduction').click(function(){
            $('#btnstartproduction').prop('disabled', true).html('<i class="fas fa-circle-notch fa-spin mr-2"></i> Issue Materials');
            var tbodymaterial = $("#rowmaterialtable tbody");
            jsonObjmaterial = [];

            if (tbodymaterial.children().length > 0) {
                $("#rowmaterialtable tbody tr").each(function () {
                    var statusmaterial=0;
                    itemmaterial = {}
                    $(this).find('td').each(function (col_idx) {
                        itemmaterial["col_" + (col_idx + 1)] = $(this).text();
                        if(col_idx==1 && $(this).text()==''){
                            statusmaterial=1;
                        }
                    });

                    if(statusmaterial==0){
                        jsonObjmaterial.push(itemmaterial);
                    }
                });
            }
            // console.log(jsonObjmaterial);

            var tbodypacking = $("#packingmaterialtable tbody");
            jsonObjpacking = [];

            if (tbodypacking.children().length > 0) {
                $("#packingmaterialtable tbody tr").each(function () {
                    var statuspacking=0;
                    item = {}
                    $(this).find('td').each(function (col_idx) {
                        item["col_" + (col_idx + 1)] = $(this).text();
                        if(col_idx==1 && $(this).text()==''){
                            statuspacking=1;
                        }
                    });
                    
                    if(statuspacking==0){
                        jsonObjpacking.push(item);
                    }
                });
            }
            console.log(jsonObjpacking);

            var tbodylabling = $("#lablingmaterialtable tbody");
            jsonObjlabling = [];

            if (tbodylabling.children().length > 0) {
                $("#lablingmaterialtable tbody tr").each(function () {
                    var statuslabeling=0;
                    item = {}
                    $(this).find('td').each(function (col_idx) {
                        item["col_" + (col_idx + 1)] = $(this).text();
                        if(col_idx==1 && $(this).text()==''){
                            statuslabeling=1;
                        }
                    });

                    if(statuslabeling==0){
                        jsonObjlabling.push(item);
                    }
                });
            }
            // console.log(jsonObjlabling);

            var productionorder = $('#hideprodcutionorder').val();
            var orderqty = $('#orderqty').val();
            var orderfinishgood = $('#orderfinishgood').val();
            
            $.ajax({
                type: "POST",
                data: {
                    tableDataMaterial: jsonObjmaterial,
                    tableDataPacking: jsonObjpacking,
                    tableDataLabeling: jsonObjlabling,
                    orderqty: orderqty,
                    orderfinishgood: orderfinishgood,
                    productionorder: productionorder
                },
                url: 'Productionorderview/Issuematerialforproduction',
                success: function (result) { //alert(result);
                    // console.log(result);
                    var obj = JSON.parse(result);
                    if(obj.status==1){
                        setdatalayout();
                        $('#orderfinishgood').val('');
                        $('#orderqty').val('');
                        $('#issueqty').val('');
                        $('#btnstartproduction').prop('disabled', false).html('<i class="far fa-play-circle mr-2"></i> Issue Materials');
                    }
                    action(obj.action);
                }
            });
        });  
	});

	function deactive_confirm() {
		return confirm("Are you sure you want to deactive this?");
	}

	function active_confirm() {
		return confirm("Are you sure you want to active this?");
	}

	function delete_confirm() {
		return confirm("Are you sure you want to remove this?");
	}

    function setdatalayout(){
        $.ajax({
            type: "POST",
            data: {},
            url: '<?php echo base_url() ?>Productionorderview/Getmaterialenterlayout',
            success: function(result) { //alert(result);
                $('#datalayout').empty().html(result);
                dataenteroption();
            }
        });
    }
    function dataenteroption(){
        // Material change start
        $('#rowmaterialtable').on('change', '.rowmaterial', function() {
            let materialID=$(this).val();
            materialselectID=$(this).val();
            rowinfo = $(this);
            materialcategory = 1;
            var productionmaterialinfoID=$('#orderfinishgood').val();
            
            if(materialID!=''){
                $.ajax({
                    type: "POST",
                    data: {
                        materialID: materialID
                    },
                    url: '<?php echo base_url() ?>Productionorderview/Getmaterialstockinfoaccomaterial',
                    success: function(result) { //alert(result);
                        $('#tablestockinfo > tbody').html(result);
                        $('#modalproductionmaterial').modal('show');
                    }
                });

                $.ajax({
                    type: "POST",
                    data: {
                        recordID: materialID,
                        productionmaterialinfoID: productionmaterialinfoID
                    },
                    url: '<?php echo base_url() ?>Productionorderview/Checkissueqty',
                    success: function(result) { //alert(result);
                        let orderqty = $('#orderqty').val();
                        if(parseFloat(result)==orderqty){
                            $('#btnaddmaterialinfo').prop('disabled', true);
                        }
                        else{
                            $('#btnaddmaterialinfo').prop('disabled', false);
                        }
                    }
                });
            }
        });

        $('#packingmaterialtable').on('change', '.packingmaterial', function() {
            let materialID=$(this).val();
            materialselectID=$(this).val();
            rowinfo = $(this);
            materialcategory = 2;
            var productionmaterialinfoID=$('#orderfinishgood').val();
            
            if(materialID!=''){
                $.ajax({
                    type: "POST",
                    data: {
                        materialID: materialID
                    },
                    url: '<?php echo base_url() ?>Productionorderview/Getmaterialstockinfoaccomaterial',
                    success: function(result) { //alert(result);
                        $('#tablestockinfo > tbody').html(result);
                        $('#modalproductionmaterial').modal('show');
                    }
                });
                $.ajax({
                    type: "POST",
                    data: {
                        recordID: materialID,
                        productionmaterialinfoID: productionmaterialinfoID
                    },
                    url: '<?php echo base_url() ?>Productionorderview/Checkissueqty',
                    success: function(result) { //alert(result);
                        let orderqty = $('#orderqty').val();
                        if(parseFloat(result)==orderqty){
                            $('#btnaddmaterialinfo').prop('disabled', true);
                        }
                        else{
                            $('#btnaddmaterialinfo').prop('disabled', false);
                        }
                    }
                });
            }
        });

        $('#lablingmaterialtable').on('change', '.lablematerial', function() {
            let materialID=$(this).val();
            materialselectID=$(this).val();
            rowinfo = $(this);
            materialcategory = 3;
            var productionmaterialinfoID=$('#orderfinishgood').val();
            
            if(materialID!=''){
                $.ajax({
                    type: "POST",
                    data: {
                        materialID: materialID
                    },
                    url: '<?php echo base_url() ?>Productionorderview/Getmaterialstockinfoaccomaterial',
                    success: function(result) { //alert(result);
                        $('#tablestockinfo > tbody').html(result);
                        $('#modalproductionmaterial').modal('show');
                    }
                });
                $.ajax({
                    type: "POST",
                    data: {
                        recordID: materialID,
                        productionmaterialinfoID: productionmaterialinfoID
                    },
                    url: '<?php echo base_url() ?>Productionorderview/Checkissueqty',
                    success: function(result) { //alert(result);
                        let orderqty = $('#orderqty').val();
                        if(parseFloat(result)==orderqty){
                            $('#btnaddmaterialinfo').prop('disabled', true);
                        }
                        else{
                            $('#btnaddmaterialinfo').prop('disabled', false);
                        }
                    }
                });
            }
        });

        $('#tablestockinfo tbody').on('click', '.enterqty', function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            $this = $(this);
            if ($this.data('editing')) return;

            var val = $this.text();
            var selectedrowID=$this.closest("td").parent()[0].rowIndex;

            $this.empty();
            $this.data('editing', true);

            $('<input type="Text" class="form-control form-control-sm issueqty" style="width: 100%">').val(val).appendTo($this);
            textremove('.issueqty', selectedrowID);
        });

        $('#btnaddmaterialinfo').click(function(){
            var tbody = $("#tablestockinfo tbody");

            if (tbody.children().length > 0) {
                var batchnolist='';
                var qtylist='';
                var issueqtytotal=parseFloat(0);
                var issueqtyenter=0;
                $("#tablestockinfo tbody tr").each(function () {
                    var issueqtyenter=parseFloat(0);
                    $(this).find('td').each(function (col_idx) {
                        // if(col_idx==0){batchnolist+=$(this).text()+',';}
                        if(col_idx==2){
                            if($(this).text()!=''){
                                issueqtyenter=$(this).text();
                                issueqtytotal=issueqtytotal+parseFloat($(this).text());
                                qtylist+=$(this).text()+',';
                            }
                        }
                        if(col_idx==3){
                            if(issueqtyenter>0){
                                batchnolist+=$(this).text()+',';
                            }
                        }
                    });
                });
                
                var rowID = rowinfo.closest("td").parent()[0].rowIndex;
                if(materialcategory==1){
                    $('#rowmaterialtable').find('tr').eq(rowID).find('td:eq(1)').text(batchnolist);
                    $('#rowmaterialtable').find('tr').eq(rowID).find('td:eq(2)').text(issueqtytotal);
                    $('#rowmaterialtable').find('tr').eq(rowID).find('td:eq(3)').text(materialselectID);
                    $('#rowmaterialtable').find('tr').eq(rowID).find('td:eq(4)').text(qtylist);
                }
                if(materialcategory==2){
                    $('#packingmaterialtable').find('tr').eq(rowID).find('td:eq(1)').text(batchnolist);
                    $('#packingmaterialtable').find('tr').eq(rowID).find('td:eq(2)').text(issueqtytotal);
                    $('#packingmaterialtable').find('tr').eq(rowID).find('td:eq(3)').text(materialselectID);
                    $('#packingmaterialtable').find('tr').eq(rowID).find('td:eq(4)').text(qtylist);
                }
                if(materialcategory==3){
                    $('#lablingmaterialtable').find('tr').eq(rowID).find('td:eq(1)').text(batchnolist);
                    $('#lablingmaterialtable').find('tr').eq(rowID).find('td:eq(2)').text(issueqtytotal);
                    $('#lablingmaterialtable').find('tr').eq(rowID).find('td:eq(3)').text(materialselectID);
                    $('#lablingmaterialtable').find('tr').eq(rowID).find('td:eq(4)').text(qtylist);
                }

                $('#modalproductionmaterial').modal('hide');
            }
        });
        // Material change end
    }
    function textremove(classname, selectedrowID) {
        $('#tablestockinfo tbody').on('keyup', classname, function(e) {
            if (e.keyCode === 13) { 
                $this = $(this);
                var rowclick = $(this);
                var val = parseFloat($this.val());
                // var rowclickID = rowclick.closest("td").parent()[0].rowIndex;
                
                var stockqty = parseFloat($('#tablestockinfo').find('tr').eq(selectedrowID).find('td:eq(1)').text());
                
                if(stockqty<val){
                    $(classname).addClass('bg-danger text-white');
                }
                else{
                    $(classname).removeClass('bg-danger text-white');
                    var td = $this.closest('td');
                    td.empty().html(val).data('editing', false);
                }
            }
        });
    }
</script>
<?php include "include/footer.php"; ?>
