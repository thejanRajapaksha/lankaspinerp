<script>
	$(document).ready(function () {

		$('#crmorder_main_nav_link').prop('aria-expanded', 'true').removeClass('collapsed');
        $('#collapseMaterialData').addClass('show');

		var addcheck = '<?php echo (in_array('createRowmaterials', $user_permission)) ? 1 : 0; ?>';
        var editcheck = '<?php echo (in_array('updateRowmaterials', $user_permission)) ? 1 : 0; ?>';
        var statuscheck = '<?php echo (in_array('updateRowmaterials', $user_permission) || in_array('deleteRowmaterials', $user_permission)) ? 1 : 0; ?>';
        var deletecheck = '<?php echo (in_array('deleteRowmaterials', $user_permission)) ? 1 : 0; ?>';

        $('.selecter2').select2();


		$('#tblmeasurment').DataTable({
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
					title: 'Supplier Category Information',
					text: '<i class="fas fa-file-csv mr-2"></i> CSV',
				},
				{
					extend: 'pdf',
					className: 'btn btn-danger btn-sm',
					title: 'Supplier Category Information',
					text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
				},
				{
					extend: 'print',
					title: 'Supplier Category Information',
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
				url: "<?php echo base_url() ?>scripts/rowmateriallist.php",
				type: "POST", // you can use GET
				// data: function(d) {}
			},
			"order": [
				[0, "desc"]
			],
			"columns": [{
					"data": "idtbl_row_material"
				},
				{
					"data": "material_name"
				},
				{
					"data": "suppliername"
				},
				{
					"data": "measure_type"
				},
				{
					"data": "categoryname"
				},
				{
					"data": "rol"
				},
				{
					"targets": -1,
					"className": 'text-right',
					"data": null,
					"render": function (data, type, full) {
						var button = '';
						button += '<button class="btn btn-primary btn-sm btnEdit mr-1 ';
						if (editcheck != 1) {
							button += 'd-none';
						}
						button += '" id="' + full['idtbl_row_material'] +
							'"><i class="fas fa-pen"></i></button>';
						if (full['status'] == 1) {
							button += '<a href="<?php echo base_url() ?>Rowmaterials/Rowmaterialsstatus/' +
								full['idtbl_row_material'] +
								'/2" onclick="return deactive_confirm()" target="_self" class="btn btn-success btn-sm mr-1 ';
							if (statuscheck != 1) {
								button += 'd-none';
							}
							button += '"><i class="fas fa-check"></i></a>';
						} else {
							button += '<a href="<?php echo base_url() ?>Rowmaterials/Rowmaterialsstatus/' +
								full['idtbl_row_material'] +
								'/1" onclick="return active_confirm()" target="_self" class="btn btn-warning btn-sm mr-1 ';
							if (statuscheck != 1) {
								button += 'd-none';
							}
							button += '"><i class="fas fa-times"></i></a>';
						}
						button += '<a href="<?php echo base_url() ?>Rowmaterials/Rowmaterialsstatus/' +
							full['idtbl_row_material'] +
							'/3" onclick="return delete_confirm()" target="_self" class="btn btn-danger btn-sm ';
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
		$('#tblmeasurment tbody').on('click', '.btnEdit', function () {
			var r = confirm("Are you sure, You want to Edit this ? ");
			if (r == true) {
				var id = $(this).attr('id');
				$.ajax({
					type: "POST",
					data: {
						recordID: id
					},
					url: '<?php echo base_url() ?>Rowmaterials/Rowmaterialsedit',
					success: function (result) { //alert(result);
						var obj = JSON.parse(result);
						$('#recordID').val(obj.id);
						$('#materialname').val(obj.materialname);
						$('#materialmaincategory').val(obj.maincat).trigger('change');;
						$('#supplier').val(obj.supplier).trigger('change');
						$('#measurment').val(obj.measurment).trigger('change');;
						$('#rol').val(obj.rol);
						$('#saleprice').val(obj.saleprice);
						$('#unitprice').val(obj.unitprice);

						$('#recordOption').val('2');
						$('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');
					}
				});
			}
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
</script>

