<script type="text/javascript">
var base_url = "<?php echo base_url(); ?>";


$(document).ready(function() {
	var mach_info = $("#wmach_dataTable").DataTable({
			"destroy": true,
            "processing": true,
            "serverSide": true,
            ajax: {
                url: base_url+"scripts/mobiledevices.php",
                type: "POST", // you can use GET
				"data":function(data){
					//data.set_code=1;
				}
            },
            "info":false,
			"searching":false,
			//"paging":false,
			"order":[[0, "asc"]],
			"autoWidth":false,
			"columns":[{data:'track_addr', "width":"10%"}, {data:'mach_instid', "width":"10%"}, 
					   {data:'line_code', "width":"10%"}, {data:'line_name', "width":"60%"}, 
					   {data:'reg_cancel', "width":"10%", "class":"text-center"}],
			"columnDefs":[{
					"targets":4,
					render:function( data, type, row ){
						var sel_str = (data=='0')?' checked="checked"':'';
						var btn_str = '<span class="evacts" data-regnum="'+row.reg_num+'">';
						btn_str+='<a class="nav-link" data-toggle="modal" data-target="#iotInfoModal" data-acttype="review" data-navtype="nav_iotinfo">';
						btn_str+='<i class="fa fa-edit"></i>';
						btn_str+='</a>';
						btn_str+='<label class="switch" data-regnum="'+row.reg_num+'">';
						btn_str+=('<input type="checkbox"'+sel_str+'>');
						btn_str+='<span class="slider round"></span>';
						btn_str+='</label>';
						btn_str+='</span>';
						return btn_str;
					}
				}], 
			"createdRow": function( row, data, dataIndex ){
				$( row ).attr('id', 'addr-'+data.reg_num);
				
			}
		});
	
    /*$('#factories_main_nav_link').prop('aria-expanded', 'true').removeClass('collapsed');
    $('#collapseLayoutsFactories').addClass('show');*/

    /*$('#insttype').select2({
        placeholder: 'Select...',
        width: '100%',
        allowClear: true,
        ajax: {
            url:  base_url + 'IoModule/get_device_type_select',
            dataType: 'json',
            data: function(params) {
                return {
                    term: params.term || '',
                    page: params.page || 1
                }
            },
            cache: true
        }
    });*/
	
	// basic
	$('#insttype').select2({
		width:'100%'
	}); 
	
    
	$(document).on("click", ".nav-link", function () {
		 var act_type = $(this).data('acttype');
		 var nav_type = $(this).data('navtype');
		 if(nav_type=="nav_iotinfo"){
			 if(act_type=="blanks"){
				 //$("#txtinstid").prop("disabled", false);
				 $("#txtinstid").val("");
				 $("#txttrackcode").val("");
				 $("#hregnum").val( '' ); //$("#wmach_dataTable").data("hframe", "-1");
				 $("#insttype").val("-1").trigger('change');
			 }else{
				 var instrefcode = $(this).parent().data('regnum');
				 
				 $.ajax({
					method: "POST",
					url: base_url+'IoModule/find',
					dataType:'json',
					data: {mm_instref:instrefcode},
					beforeSend: function(){
						/*
						
						*/
					}
				 }).done(function(data){
					 //$("#txtinstid").prop("disabled", true);
					 $("#txtinstid").val( data.inst_name );
					 $("#txttrackcode").val( data.inst_trackaddr );
					 $("#hregnum").val( instrefcode ); //$("#wmach_dataTable").data("hframe", par.index());
					 
					 /*var data = {id:"2", text:'a1aaa'};
					 var newOption = new Option(data.text, data.id, false, false);
					 $("#insttype").append(newOption);*/
					 
					 $("#insttype").val( data.device_type ).trigger('change');
					 
				 });
				 
				 
			 }
		 }
	});
	
	$(document).on("change", ".evacts .switch", function() {
		var par = $(this).parent().parent().parent();
		var coltxt = par.children("td:nth-child(2)").html();
		var instrefcode = $(this).data('regnum');//par.children("td:nth-child(2)").html(); // inst-ref-code
		
		var msgact = "deactivated";
		var optact = "1";
		var curobj = $(this).children("input[type='checkbox']");
		
		if(curobj.is(":checked")){
			msgact = "active";
			optact = "0";
		}
		
		$.ajax({
			method: "POST",
			url: base_url+"IoModule/toggle",
			data: {mm_actsw:instrefcode, opt_act:optact},
			
			beforeSend: function(){
				//
			}
		}).done(function(data){
			var rres = data.resMsg;
			if(data.msgErr){
				curobj.prop("checked", !(curobj.is(":checked")));
				alert(rres[1]);//"something wrong"
				
			}else{
				alert(coltxt + " is " + msgact);
			}
		});
	});
	
	var iotinfo_form = $('#frm_iotinfo');
	iotinfo_form.submit(function(event){
		event.preventDefault();
		/*
		var form_status = $('<div class="form_status"></div>');
		*/
		var regnum = '';
		var instrefcode = $('#txtinstid').val(); // inst-ref-code
		var instaddr = $('#txttrackcode').val(); // inst-addr
		var insttype = $('#insttype').find(":selected").val();
		
		var id='';
		
		//if($("#txtinstid").prop("disabled")){
			id = instrefcode;
			regnum = $("#hregnum").val();
		//}
		
		$.ajax({
			method: "POST",
			url: base_url+'IoModule/store',
			data: {tmachref:instrefcode, tinsttrack:instaddr, devicetype:insttype, mm_mach:regnum}, // mm_mach:id
			dataType:"JSON",
			beforeSend: function(){
				$("#inststatus").html('<i class="fa fa-spinner fa-spin"></i> Record is being saved...').fadeIn();
				
			}
		}).done(function(data){
			var res_msg = data.resMsg;
			var rres = (res_msg=='')?'success':'';//data.rescode; 
			if(rres=="success"){
				if(regnum==""){//(id=="")
					var rowNode = mach_info.row.add( {
							"reg_num":data.reg_num,
							"track_addr":instaddr,
							"mach_instid":instrefcode,
							"line_code":'',
							"line_name":'',
							"reg_cancel":0
						}).draw( false ).node();
					
					res_msg = "New device registered";
				}else{
					var selected_tr=mach_info.row('#addr-'+regnum);
					var d=selected_tr.data();
					d.track_addr=instaddr;//
					mach_info.row(selected_tr).data(d).draw();
					
					res_msg = "Device details updated";
				}
				
			}
			
			$("#inststatus").html('<p class="text-success">' + res_msg + '</p>').delay(3000).fadeOut();
			
		});
	});
	
	
});



</script>