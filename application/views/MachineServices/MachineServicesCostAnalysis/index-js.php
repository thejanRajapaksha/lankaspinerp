<script type="text/javascript">
var manageTable;
var base_url = "<?php echo base_url(); ?>";

$(document).ready(function() {

    $('#machine_services_main_nav_link').prop('aria-expanded', 'true').removeClass('collapsed');
    $('#collapseLayoutsMachineServices').addClass('show');

    $('.select2').select2({
        placeholder: 'Select...',
        allowClear: true
    });

    $('#machine_type_filter').select2({
        placeholder: 'Select...',
        width: '100%',
        allowClear: true,
        ajax: {
            url: base_url + 'MachineServicesCreated/get_machine_types_select',
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

    $('#s_no_filter').select2({
        placeholder: 'Select...',
        width: '100%',
        allowClear: true,
        ajax: {
            url: base_url + 'MachineServicesCreated/get_machine_ins_select',
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

    //service_no_filter
    $('#service_no_filter').select2({
        placeholder: 'Select...',
        width: '100%',
        allowClear: true,
        ajax: {
            url: base_url + 'MachineServicesCreated/get_service_no_select',
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

    //filter_button click event
    $('#filter_button').click(function() {
        load_dt();
    });

    // initialize the datatable
    load_dt();

    function load_dt(){

        let status = $('#status_filter').val();
        let service_type = $('#service_type_filter').val();
        let machine_type = $('#machine_type_filter').val();
        let machine_in_id = $('#s_no_filter').val();
        let service_no = $('#service_no_filter').val();
        let date_from = $('#date_from_filter').val();
        let date_to = $('#date_to_filter').val();

        manageTable = $('#manageTable').DataTable({
            'ajax': {
                'url': base_url + 'MachineServicesCostAnalysis/fetchCategoryData',
                'type': 'GET',
                'data': {
                    'status': status,
                    'service_type': service_type,
                    'machine_type': machine_type,
                    'machine_in_id': machine_in_id,
                    'service_no': service_no,
                    'date_from': date_from,
                    'date_to': date_to
                }
            },
            'order': [],
            destroy: true,
        });
    }


    //get service cost for each month
    $.ajax({
        url: base_url + 'MachineServicesCostAnalysis/fetchMonthlyServiceCost',
        type: 'post',
        dataType: 'json',
        success:function(response) {

            let xValues = response.months;
            var yValues = response.costs;

            new Chart("monthly_service_cost_chart", {
                type: "line",
                data: {
                    labels: xValues,
                    datasets: [{
                        fill: false,
                        lineTension: 0,
                        backgroundColor: "rgba(0,0,255,1.0)",
                        borderColor: "rgba(0,0,255,0.1)",
                        data: yValues
                    }]
                },
                options: {
                    legend: {display: false},
                    title: {
                        display: true,
                        text: 'Monthly Service Cost'
                    }

                }
            });

        },
        error:function(response) {
           alert(response);
        }
    });

    show_tooltip();

    function show_tooltip()
    {
        $('input[rel="txtTooltip"]').tooltip();
        $('#machine_type_chart_date_filter').tooltip('show');
    }

    $('#machine_type_chart_date_filter').change(function() {
        init_service_items_chart();
    });

    //onhover hide tooltip
    $('#machine_type_chart_date_filter').mouseover(function() {
        $('#machine_type_chart_date_filter').tooltip('hide');
    });

    //on focus
    $('#machine_type_chart_date_filter').focus(function() {
        $('#machine_type_chart_date_filter').tooltip('hide');
    });

    init_service_items_chart();

    function init_service_items_chart()
    {
        $.ajax({
            url: base_url + 'MachineServicesCostAnalysis/fetchMachineTypeServiceItems',
            type: 'post',
            dataType: 'json',
            data: {
                'date': $('#machine_type_chart_date_filter').val()
            },
            success:function(response) {

                var xValues = response.machine_types;
                var yValues = response.total_counts;
                var barColors = response.colors;

                new Chart("machine_type_chart", {
                    type: "bar",
                    data: {
                        labels: xValues,
                        datasets: [{
                            backgroundColor: barColors,
                            data: yValues
                        }]
                    },
                    options: {
                        legend: {display: false},
                        title: {
                            display: true,
                            text: "Machine Types Service Count " + $('#machine_type_chart_date_filter').val(),
                        },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }],
                            xAxes: [{
                                barPercentage: 0.4
                            }]
                        }
                    }
                });

            },
            error:function(response) {
                alert(response);
            }
        });
    }


});

function viewFunc(id)
{
    $.ajax({
        url: base_url + 'MachineServicesCreated/fetchMachineServicesCreatedDataById/'+id,
        type: 'post',
        dataType: 'json',
        success:function(response) {

            $("#view_service_detail_table tbody").empty();

            let service_no = response.service_details.service_no;
            let machine_type_name = response.service_details.machine_type_name;

            $('#view_service_no_span').html(service_no);
            $('#view_machine_type_span').html(machine_type_name);
            $('#service_done_by_span').html(response.service_details.name_with_initial);
            $('#service_charge_span').html(response.service_details.service_charge);
            $('#transport_charge_span').html(response.service_details.transport_charge);
            $('#remarks_span').html(response.service_details.remarks);
            $('#sub_total_span').html(response.service_details.sub_total);
            $('#service_type_span').html(response.service_details.service_type);

            let total = parseFloat(response.service_details.service_charge) + parseFloat(response.service_details.transport_charge) + parseFloat(response.service_details.sub_total);
            $('#total_span').html(total);

            //each service_items
            let service_items = response.service_items;
            service_items.forEach(function(item) {
                let service_item_row = '<tr>';
                service_item_row += '<td>'+item.item_name+'</td>';
                service_item_row += '<td>'+item.quantity+'</td>';
                service_item_row += '<td>'+item.price+'</td>';
                service_item_row += '<td align="right">'+item.total+'</td>';
                service_item_row += '</tr>';
                $('#view_service_detail_table tbody').append(service_item_row);
            });

        }
    });
}

// remove functions 
function removeFunc(id)
{
  if(id) {
    $("#removeForm").on('submit', function() {

      var form = $(this);

      // remove the text-danger
      $(".text-danger").remove();

      $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: { id:id },
        dataType: 'json',
        success:function(response) {

          manageTable.ajax.reload(null, false); 
          // hide the modal
            $("#removeModal").modal('hide');

          if(response.success === true) {
            $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
            '</div>');


          } else {

            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
            '</div>'); 
          }
        }
      }); 

      return false;
    });
  }
}

function completeFunc(id)
{
    if(id) {
        $("#completeForm").on('submit', function() {

            var form = $(this);

            // remove the text-danger
            $(".text-danger").remove();

            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                data: { id:id, remarks:$('#complete_remarks').val() },
                dataType: 'json',
                success:function(response) {

                    manageTable.ajax.reload(null, false);
                    // hide the modal
                    $("#completeModal").modal('hide');

                    if(response.success === true) {
                        $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                            '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
                            '</div>');

                    } else {

                        $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                            '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
                            '</div>');
                    }
                }
            });

            return false;
        });
    }
}

function removeCompleteFunc(id)
{
    if(id) {
        $("#removeCompleteForm").on('submit', function() {

            var form = $(this);

            // remove the text-danger
            $(".text-danger").remove();

            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                data: { id:id, remarks:$('#remove_complete_remarks').val() },
                dataType: 'json',
                success:function(response) {

                    manageTable.ajax.reload(null, false);
                    // hide the modal
                    $("#removeCompleteModal").modal('hide');

                    if(response.success === true) {
                        $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                            '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
                            '</div>');

                    } else {

                        $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                            '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
                            '</div>');
                    }
                }
            });

            return false;
        });
    }
}


</script>