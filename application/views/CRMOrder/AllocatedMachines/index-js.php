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
                                        <button class="btn btn-sm btn-primary add-completed-btn" 
                                            data-id="${item.idtbl_machine_allocation}">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger add-rejected-btn" 
                                            data-id="${item.idtbl_machine_allocation}">
                                            <i class="fa fa-times"></i>
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

    $('#addCompletedModal').on('show.bs.modal', function () {
        $.ajax({
            url: '<?php echo base_url(); ?>AllocatedMachines/getTimeslots',
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                const $startDropdown = $('#startTime');
                const $endDropdown = $('#endTime');
                $startDropdown.empty().append('<option value="">-- Select Start Time --</option>');
                $endDropdown.empty().append('<option value="">-- Select End Time --</option>');

                $.each(data, function (i, slot) {
                    const label = slot.hour.slice(0, 5); // format HH:mm
                    $startDropdown.append('<option value="' + slot.idtbl_timeslots + '">' + label + '</option>');
                    $endDropdown.append('<option value="' + slot.idtbl_timeslots + '">' + label + '</option>');
                });
            },
            error: function () {
            alert('Failed to load time slots.');
            }
        });
    });
    $('#addRejectedModal').on('show.bs.modal', function () {
        $.ajax({
            url: '<?php echo base_url(); ?>AllocatedMachines/getTimeslots',
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                const $RstartDropdown = $('#RstartTime');
                const $RendDropdown = $('#RendTime');
                $RstartDropdown.empty().append('<option value="">-- Select Start Time --</option>');
                $RendDropdown.empty().append('<option value="">-- Select End Time --</option>');

                $.each(data, function (i, slot) {
                    const label = slot.hour.slice(0, 5); // format HH:mm
                    $RstartDropdown.append('<option value="' + slot.idtbl_timeslots + '">' + label + '</option>');
                    $RendDropdown.append('<option value="' + slot.idtbl_timeslots + '">' + label + '</option>');
                });
            },
            error: function () {
            alert('Failed to load time slots.');
            }
        });
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
                        <td>${item.wastageqty || 'N/A'}</td>
                    </tr>`;
                    $('#tableBody').append(row);
                });
                calculateBalanceQty();
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
$(document).on('click', '.add-rejected-btn', function() {
    const allocationId = $(this).data('id');
    $('#addRejectedModal #allocationMid').val(allocationId);
   $('#addRejectedModal').modal('show');
});

$('#saveCompletedAmount').click(function() {
    const allocationId = $('#allocationId').val();
    const amount = $('#completedAmount').val();
    const startTime = $('#startTime').val();
    const endTime = $('#endTime').val();
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
            startTime: startTime,
            endTime: endTime,
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

$('#saveRejectedAmount').click(function() {
    const allocationId = $('#allocationMid').val();
    const amount = $('#rejectedAmmount').val();
    const RstartTime = $('#RstartTime').val();
    const RendTime = $('#RendTime').val();
    const reason = $('#rejectReason').val();
    const comment = $('#comment').val();
    
    if (!amount) {
        alert('Please fill all fields');
        return;
    }

    $.ajax({
        url: '<?= base_url('AllocatedMachines/InsertRejectedAmmount') ?>',
        method: 'POST',
        data: {
            allocationId: allocationId,
            amount: amount,
            startTime: RstartTime,
            endTime: RendTime,
            reason: reason,
            comment: comment
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                alert('Rejected amount saved successfully');
                $('#addRejectedModal').modal('hide');
                // You might want to refresh the data here
            } else {
                alert(response.message || 'Error saving rejected amount');
            }
        },
        error: function() {
            alert('Error saving Rejected amount');
        }
    });
});

function calculateBalanceQty() {
    let totalAllocated = 0;
    let totalCompleted = 0;

    $('#tableBody tr').each(function() {
        const allocated = parseInt($(this).find('td:eq(3)').text()) || 0; 
        const completed = parseInt($(this).find('td:eq(4)').text()) || 0;

        totalAllocated += allocated;
        totalCompleted += completed;
    });

    const balance = totalAllocated - totalCompleted;
    $('#balanceQty').text(balance);
}

</script>
