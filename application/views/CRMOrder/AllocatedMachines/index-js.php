<script>
	$(document).ready(function(){
		$('#crmorder_main_nav_link').prop('aria-expanded', 'true').removeClass('collapsed');
        $('#collapseCRMOrder').addClass('show');
	});
	$("#tblmachinelist").on('click', '.btnDeleterow', function () {
		$(this).closest('tr').remove();
	});

	
$(document).ready(function () {
    $('#machine, #date').on('change', function () {
        let machineId = $('#machine').val();
        let selectedDate = $('#date').val();

        if (machineId && selectedDate) {
            $.ajax({
                url: '<?= base_url('AllocatedMachines/fetch') ?>',
                method: 'POST',
                data: {
                    machine_id: machineId,
                    date: selectedDate
                },
                success: function (response) {
                    $('#machineAllocationTableBody').empty();
                    
                    let data = typeof response === "string" ? JSON.parse(response) : response;

                    if (data.length > 0) {
                        $.each(data, function (index, item) {
                            let row = `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>PO-${item.idtbl_order}</td>
                                    <td>${item.deliveryId}</td>
                                    <td>${item.product}</td>
                                    <td>${item.name}-${item.s_no}</td>
                                    <td class="text-right">
                                         <button class="btn btn-sm btn-primary view-btn" 
                                            data-id="${item.idtbl_machine_allocation}">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>`;
                            $('#machineAllocationTableBody').append(row);
                        });
                    } else {
                        $('#machineAllocationTableBody').append('<tr><td colspan="6">No data found.</td></tr>');
                    }
                },

                error: function () {
                    alert('Error loading data.');
                }
            });
        }
    });
});
$(document).on('click', '.view-btn', function () {
    let allocationId = $(this).data('id');

    $.ajax({
        url: '<?= base_url('AllocatedMachines/getAllocationDataById') ?>',
        method: 'POST',
        data: { id: allocationId },
        dataType: 'json',
        success: function (data) {
            if (data) {
               console.log(data);
              $('#tableBody').empty();
                $.each(data, function(index, item) {
                    let row = `<tr>
                        <td>${item.name || 'N/A'}_${item.s_no || 'N/A'}</td>
                        <td>${item.startdatetime || 'N/A'}</td>
                        <td>${item.enddatetime || 'N/A'}</td>
                        <td>${item.allocatedqty || 'N/A'}</td>
                        <td>${item.completedqty || 'N/A'}</td>
                        <td>'N/A'</td>
                        <td>
                        <button class="btn btn-sm btn-primary add-completed-btn" 
                                data-id="${item.idtbl_machine_allocation}">
                            <i class="fa fa-plus"></i>
                        </button>
                    </td>
                    </tr>`;
                    $('#tableBody').append(row);
                });
                $('#allocationModal').modal('show');
              
            } else {
                alert('No data found for this allocation.');
            }
        },
        error: function () {
            alert('Error fetching allocation details.');
        }
    });
});
$(document).on('click', '.add-completed-btn', function() {
    const allocationId = $(this).data('id');
    $('#addCompletedModal #allocationId').val(allocationId);
   $('#addCompletedModal').modal('show');
});

$('#saveCompletedAmount').click(function() {
    const allocationId = $('#allocationId').val();
    const amount = $('#completedAmount').val();
    // const date = $('#completedDate').val();
    
    if (!amount) {
        alert('Please fill all fields');
        return;
    }

    $.ajax({
        url: '<?= base_url('AllocatedMachines/InsertCompletedAmmount') ?>',
        method: 'POST',
        data: {
            allocation_id: allocationId,
            amount: amount,
            // date: date
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                alert('Completed amount saved successfully');
                $('#addCompletedModal').modal('hide');
                // You might want to refresh the data here
            } else {
                alert(response.message || 'Error saving completed amount');
            }
        },
        error: function() {
            alert('Error saving completed amount');
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
