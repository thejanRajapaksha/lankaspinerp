<script type="text/javascript">
var base_url = "<?php echo base_url(); ?>";


$(document).ready(function() {
	$('#factory_id').select2({
        placeholder: 'Select...',
        width: '100%',
        allowClear: true,
        ajax: {
            url:  base_url + 'factories/get_factories_select',
            dataType: 'json',
            data: function(params) {
                return {
                    term: params.term || '',
                    page: params.page || 1
                }
            },
            cache: true
        }
    });

    /*$('#department_id').select2({
        placeholder: 'Select...',
        width: '100%',
        allowClear: true,
        ajax: {
            url:  base_url + 'departments/get_departments_select',
            dataType: 'json',
            data: function(params) {
                return {
                    term: params.term || '',
                    page: params.page || 1,
                    factory_id: $('#factory_id').val()
                }
            },
            cache: true
        }
    });*/

    $('#section_id').select2({
        placeholder: 'Select...',
        width: '100%',
        allowClear: true,
        ajax: {
            url:  base_url + 'sections/get_sections_select',
            dataType: 'json',
            data: function(params) {
                return {
                    term: params.term || '',
                    page: params.page || 1,
                    department_id: ''//$('#department_id').val()
                }
            },
            cache: true
        }
    });

    $('#line_id').select2({
        placeholder: 'Select...',
        width: '100%',
        allowClear: true,
        ajax: {
            url:  base_url + 'lines/get_lines_select',
            dataType: 'json',
            data: function(params) {
                return {
                    term: params.term || '',
                    page: params.page || 1,
                    section_id: $('#section_id').val()
                }
            },
            cache: true
        },
		templateSelection: function (data, container) {
			$(data.element).attr('data-regfactory', data.factory_id);
			return data.text;
		},
    });
	
	$('#work_hour_id').select2({
        placeholder: 'Select...',
        width: '100%',
        allowClear: true,
        ajax: {
            url:  base_url + 'IoModule/get_workhrs_select',
            dataType: 'json',
            data: function(params) {
                return {
                    term: params.term || '',
                    page: params.page || 1,
                    factory_id: $("#line_id").find(":selected").data('regfactory')//$('#factory_id').val()
                }
            },
            cache: true
        }
    });
	
	$('#sabs_style_id').select2({
        placeholder: 'Select...',
        width: '100%',
        allowClear: true,
        ajax: {
            url:  base_url + 'HourlyDoneRates/get_sabs_select',
            dataType: 'json',
            data: function(params) {
                return {
                    term: params.term || '',
                    page: params.page || 1
                }
            },
            cache: true
        }
    });
	
	var iomodule_slotInfo = $("#wmach_dataTable").DataTable({
		"info":false,
		"searching":false,
		"columns":[{data:'op_seqno'}, {data:'line_name', "className":"col_overflow"}, //{data:'name_with_initial'}, 
				   {data:'sabs_style_id'}, {data:'operation_name'}, 
				   //{data:'s_no'}, 
				   {data:'min_qty'},{data:'qty'},{data:'queue_remain_qty'},
				   //{data:'slot_name'}, 
				   {data:'date'}, {data:'time_hour'}],
		"columnDefs":[{
				"targets":5,
				render:function( data, type, row ){
					return data+"/"+row.min_qty;
				}
			}],
		"createdRow":function(row, data, index){
			var act_qty_color = (row.min_qty>row.qty)?'text-danger':'text-success';
			$('td', row).eq(5).addClass(act_qty_color);
		}
		
	});
	
	$("#searchForm").submit(function(event){
		event.preventDefault();
		var lineregno = $("#line_id").find(":selected").val();
		var workhrsno = $("#work_hour_id").find(":selected").val();
		var sabsstyleid = $("#sabs_style_id").find(":selected").val();
		
		$.ajax({
			url: base_url+'IoModule/line_wip',
			method:"POST",
			dataType:"JSON",
			data:{line_regno:lineregno, work_hrsno:workhrsno, sabs_styleid:sabsstyleid}
		}).done(function(data){
			iomodule_slotInfo.clear();
			iomodule_slotInfo.rows.add(data.line_wip_data);
			iomodule_slotInfo.draw();
			
		});
	});
	
	
});



</script>