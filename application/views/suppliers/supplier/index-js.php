<script>
	$(document).ready(function () {
		var addcheck = '<?php echo (in_array('createSupplierInfo', $user_permission)) ? 1 : 0; ?>';
		var editcheck = '<?php echo (in_array('updateSupplierInfo', $user_permission)) ? 1 : 0; ?>';
		var statuscheck = '<?php echo (in_array('updateSupplierInfo', $user_permission) || in_array('deleteSupplierInfo', $user_permission)) ? 1 : 0; ?>';
		var deletecheck = '<?php echo (in_array('deleteSupplierInfo', $user_permission)) ? 1 : 0; ?>';

		$('#tblsuppliertype').DataTable({
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
					title: 'Supplier  Information',
					text: '<i class="fas fa-file-csv mr-2"></i> CSV',
				},
				{
					extend: 'pdf',
					className: 'btn btn-danger btn-sm',
					title: 'Supplier  Information',
					text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
				},
				{
					extend: 'print',
					title: 'Supplier  Information',
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
				url: "<?php echo base_url() ?>scripts/supplierlist.php",
				type: "POST", // you can use GET
			},
			"order": [
				[0, "desc"]
			],
			"columns": [{
					"data": "idtbl_supplier"
				},
				{
					"data": "suppliername"
				},
				{
					"data": "type"
				},
				{
					"data":  "branch"
				},
				{
					"data": null,
					"render": function(data, type, row) {
						return row.address_line1 + ', ' + row.address_line2;
					}
				},
				{
					"data": "city"
				},

				{
					"targets": -1,
					"className": 'text-right',
					"data": null,
					"render": function (data, type, full) {
						var button = '';
						button += '<a href="<?php echo base_url() ?>Supplierbank/index/' + full[
								'idtbl_supplier'] +
							'" target="_self" class="btn btn-secondary btn-sm mr-1"><i class="fas fa-file"></i></a>';

						button += '<button class="btn btn-primary btn-sm btnEdit mr-1 ';
						if (editcheck != 1) {
							button += 'd-none';
						}
						button += '" id="' + full['idtbl_supplier'] +
							'"><i class="fas fa-pen"></i></button>';
						if (full['status'] == 1) {
							button += '<a href="<?php echo base_url() ?>Supplier/Supplierstatus/' +
								full['idtbl_supplier'] +
								'/2" onclick="return deactive_confirm()" target="_self" class="btn btn-success btn-sm mr-1 ';
							if (statuscheck != 1) {
								button += 'd-none';
							}
							button += '"><i class="fas fa-check"></i></a>';
						} else {
							button += '<a href="<?php echo base_url() ?>Supplier/Supplierstatus/' +
								full['idtbl_supplier'] +
								'/1" onclick="return active_confirm()" target="_self" class="btn btn-warning btn-sm mr-1 ';
							if (statuscheck != 1) {
								button += 'd-none';
							}
							button += '"><i class="fas fa-times"></i></a>';
						}
						button += '<a href="<?php echo base_url() ?>Supplier/Supplierstatus/' +
							full['idtbl_supplier'] +
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
		$('#tblsuppliertype tbody').on('click', '.btnEdit', function () {
			var r = confirm("Are you sure, You want to Edit this ? ");
			if (r == true) {
				var id = $(this).attr('id');
				$.ajax({
					type: "POST",
					data: {
						recordID: id
					},
					url: '<?php echo base_url() ?>Supplier/Supplieredit',
					success: function (result) { //alert(result);
						var obj = JSON.parse(result);
						$('#recordID').val(obj.id);
						$('#supplier_name').val(obj.name);
						// $('#business_regno').val(obj.business_regno);
						// $('#nbtno').val(obj.nbtno);
						// $('#svatno').val(obj.svatno);
						$('#telephoneno').val(obj.telephoneno);
						// $('#faxno').val(obj.faxno);
						// $('#dline1').val(obj.dline1);
						// $('#dline2').val(obj.dline2);
						// $('#dcity').val(obj.dcity);
						// $('#dstate').val(obj.dstate);
						$('#f_branch_name').val(obj.company);
						$('#line1').val(obj.line1);
						$('#line2').val(obj.line2);
						$('#city').val(obj.city);
						$('#state').val(obj.state);
						$('#credit_days').val(obj.credit_days);


						var payementmethod = obj.payementmethod;
						//alert(busstatus);
						if (payementmethod == "Cash") {
							$('#cashpayementmethod').prop('checked', true);

						} else if (payementmethod == "Bank")  {
							$('#bankpayementmethod').prop('checked', true);
						}
						// $('#nic').val(obj.nic);
						var busstatus = obj.business_status;
						//alert(busstatus);
						if (busstatus == "Proprietorship") {
							$('#Proprietorship').prop('checked', true);

						} else if (busstatus == "Partnership") {
							$('#bstatusPartnership').prop('checked', true);
						} else if (busstatus == "Incorporation") {
							$('#bstatusIncorporation').prop('checked', true);
						}
						$('#vatno').val(obj.vat_no);
						$('#suppliertype').val(obj.type);

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

<script>
	$(document).ready(function () {
		$('.zoom-image-link').magnificPopup({
			type: 'image',
			gallery: {
				enabled: true
			}
		});
	});
</script>

<script>
	/** Variables */
	let files = [],
		dragArea = document.querySelector('.drag-area'),
		input = document.querySelector('.drag-area input'),
		button = document.querySelector('.card button'),
		select = document.querySelector('.drag-area .select'),
		container = document.querySelector('.container');

	/** CLICK LISTENER */
	// select.addEventListener('click', () => input.click());

	/* INPUT CHANGE EVENT */
	// input.addEventListener('change', () => {
	// 	let file = input.files;

	// 	// if user select no image
	// 	if (file.length == 0) return;

	// 	for (let i = 0; i < file.length; i++) {
	// 		if (file[i].type.split("/")[0] != 'image') continue;
	// 		if (!files.some(e => e.name == file[i].name)) files.push(file[i])
	// 	}

	// 	showImages();
	// });

	/** SHOW IMAGES */
	// function showImages() {
	// 	container.innerHTML = files.reduce((prev, curr, index) => {
	// 		return `${prev}
	// 	    <div class="image">
	// 		    <span onclick="delImage(${index})">&times;</span>
	// 		    <img src="${URL.createObjectURL(curr)}" />
	// 		</div>`
	// 	}, '');
	// }

	/* DELETE IMAGE */
	function delImage(index) {
		files.splice(index, 1);
		showImages();
	}

	/* DRAG & DROP */
	dragArea.addEventListener('dragover', e => {
		e.preventDefault()
		dragArea.classList.add('dragover')
	})

	/* DRAG LEAVE */
	dragArea.addEventListener('dragleave', e => {
		e.preventDefault()
		dragArea.classList.remove('dragover')
	});

	/* DROP EVENT */
	dragArea.addEventListener('drop', e => {
		e.preventDefault()
		dragArea.classList.remove('dragover');

		let file = e.dataTransfer.files;
		for (let i = 0; i < file.length; i++) {
			/** Check selected file is image */
			if (file[i].type.split("/")[0] != 'image') continue;

			if (!files.some(e => e.name == file[i].name)) files.push(file[i])
		}
		showImages();
	});
</script>
<!-- <script>
  // Get the form element
  const form = document.querySelector('form');

  // Add a submit event listener to the form
  form.addEventListener('submit', function(event) {
    // Get the certificates image field
    const certificatesInput = document.getElementById('certificates');

    // Check if the field is empty
    if (!certificatesInput.files.length) {
      // Prevent form submission
      event.preventDefault();

      // Show an alert message indicating the field is required
      alert('The VAT,NBT,SVAT certificates image field is required.');
    }
  });
</script> -->