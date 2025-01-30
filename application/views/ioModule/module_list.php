<style>
    :root{
        --color1: #FD8F33;
        --color2: #0DC8AB;
        --color3: #05B0DE;
        --color4: #8E7CCC;
        --color5: #F08080;
    }
    .main-timeline{
        font-family: 'Source Sans Pro', sans-serif;
        position: relative;
    }
    .main-timeline:after{
        content: '';
        display: block;
        clear: both;
    }
    .main-timeline .timeline{
        width: 50.1%;
        padding: 20px 0 20px 100px;
        float: right;
        position: relative;
        z-index: 1;
    }
    .main-timeline .timeline-danger:before,
    .main-timeline .timeline-danger:after{
        content: '';
        background: var(--color5);
        height: 100%;
        width: 28px;
        position: absolute;
        left: -11px;
        top: 0;
    }
    .main-timeline .timeline-danger:after{
        background: var(--color5);
        height: 18px;
        width: 200px;
        box-shadow: 0 0 10px -5px #000;
        transform:  translateY(-50%);
        top: 50%;
        left: -90px;
    }

    .main-timeline .timeline-success:before,
    .main-timeline .timeline-success:after{
        content: '';
        background: var(--color2);
        height: 100%;
        width: 28px;
        position: absolute;
        left: -11px;
        top: 0;
    }
    .main-timeline .timeline-success:after{
        background: var(--color2);
        height: 18px;
        width: 200px;
        box-shadow: 0 0 10px -5px #000;
        transform:  translateY(-50%);
        top: 50%;
        left: -90px;
    }


    .timeline-danger .timeline-content{
        color: #517d82;
        background-color: var(--color5);
        padding: 0 0 0 80px;
        box-shadow: 0 0 20px -10px #000;
        border-radius: 10px;
        display: block;
    }

    .timeline-success .timeline-content{
        color: #517d82;
        background-color: var(--color2);
        padding: 0 0 0 80px;
        box-shadow: 0 0 20px -10px #000;
        border-radius: 10px;
        display: block;
    }

    .main-timeline .timeline-content:hover{
        color: #517d82;
        text-decoration: none;
    }
    .timeline-danger .timeline-icon{
        color: #fff;
        background-color: var(--color5);
        font-size: 35px;
        text-align: center;
        line-height: 62px;
        height: 60px;
        width: 60px;
        border-radius: 50%;
        transform: translateY(-50%);
        position: absolute;
        left: -100px;
        top: 50%;
        z-index: 1;
    }

    .timeline-success .timeline-icon{
        color: #fff;
        background-color: var(--color2);
        font-size: 35px;
        text-align: center;
        line-height: 62px;
        height: 60px;
        width: 60px;
        border-radius: 50%;
        transform: translateY(-50%);
        position: absolute;
        left: -100px;
        top: 50%;
        z-index: 1;
    }

    .timeline-danger .timeline-year{
        color: #517d82;
        background-color: #fff;
        font-size: 25px;
        font-weight: 600;
        text-align: center;
        line-height: 93px;
        height: 113px;
        width: 113px;
        border: 6px solid var(--color5);
        box-shadow: 0 0 10px -5px #000;
        border-radius: 50%;
        transform: translateY(-50%);
        position: absolute;
        left: 50px;
        top: 50%;
        z-index: 1;
    }

    .timeline-success .timeline-year{
        color: #517d82;
        background-color: #fff;
        font-size: 25px;
        font-weight: 600;
        text-align: center;
        line-height: 93px;
        height: 113px;
        width: 113px;
        border: 6px solid var(--color2);
        box-shadow: 0 0 10px -5px #000;
        border-radius: 50%;
        transform: translateY(-50%);
        position: absolute;
        left: 50px;
        top: 50%;
        z-index: 1;
    }

    .main-timeline .inner-content{
        background-color: #fff;
        padding: 10px;
    }
    .timeline-danger .title{
        color: var(--color5);
        font-size: 22px;
        font-weight: 600;
        margin: 0 0 5px 0;
    }

    .timeline-success .title{
        color: var(--color2);
        font-size: 22px;
        font-weight: 600;
        margin: 0 0 5px 0;
    }

    .main-timeline .description{
        font-size: 14px;
        letter-spacing: 1px;
        margin: 0;
    }
    .main-timeline .timeline:nth-child(even){
        padding: 20px 100px 20px 0;
        float: left;
    }
    .main-timeline .timeline:nth-child(even):before{
        left: auto;
        right: -14.5px;
    }
    .main-timeline .timeline:nth-child(even):after{
        left: auto;
        right: -90px;
    }
    .main-timeline .timeline:nth-child(even) .timeline-content{ padding: 0 80px 0 0; }
    .main-timeline .timeline:nth-child(even) .timeline-icon{
        left: auto;
        right: -100px;
    }
    .main-timeline .timeline:nth-child(even) .timeline-year{
        left: auto;
        right: 50px;
    }
    /*.main-timeline .timeline:nth-child(4n+2):before,*/
    /*.main-timeline .timeline:nth-child(4n+2):after{*/
    /*    background: var(--color2);*/
    /*}*/
    /*.main-timeline .timeline:nth-child(4n+2) .timeline-content,*/
    /*.main-timeline .timeline:nth-child(4n+2) .timeline-icon{*/
    /*    background-color: var(--color2);*/
    /*}*/
    /*.main-timeline .timeline:nth-child(4n+2) .timeline-year{ border-color: var(--color2); }*/
    /*.main-timeline .timeline:nth-child(4n+2) .title{ color: var(--color2); }*/
    /*.main-timeline .timeline:nth-child(4n+3):before,*/
    /*.main-timeline .timeline:nth-child(4n+3):after{*/
    /*    background: var(--color3);*/
    /*}*/
    /*.main-timeline .timeline:nth-child(4n+3) .timeline-content,*/
    /*.main-timeline .timeline:nth-child(4n+3) .timeline-icon{*/
    /*    background-color: var(--color3);*/
    /*}*/
    /*.main-timeline .timeline:nth-child(4n+3) .timeline-year{ border-color: var(--color3); }*/
    /*.main-timeline .timeline:nth-child(4n+3) .title{ color: var(--color3); }*/
    /*.main-timeline .timeline:nth-child(4n+4):before,*/
    /*.main-timeline .timeline:nth-child(4n+4):after{*/
    /*    background: var(--color4);*/
    /*}*/
    /*.main-timeline .timeline:nth-child(4n+4) .timeline-content,*/
    /*.main-timeline .timeline:nth-child(4n+4) .timeline-icon{*/
    /*    background-color: var(--color4);*/
    /*}*/
    /*.main-timeline .timeline:nth-child(4n+4) .timeline-year{ border-color: var(--color4); }*/
    /*.main-timeline .timeline:nth-child(4n+4) .title{ color: var(--color4); }*/
    @media only screen and (max-width:1200px){
        .main-timeline .timeline:before{ left: -12.5px; }
        .main-timeline .timeline:nth-child(even):before{ right: -14px; }
    }
    @media only screen and (max-width:990px){
        .main-timeline .timeline:before{ left: -12.5px; }
    }
    @media only screen and (max-width:767px){
        .main-timeline .timeline,
        .main-timeline .timeline:nth-child(even){
            width: 100%;
            padding: 20px 0 20px 37px;
        }
        .main-timeline .timeline:before{ left: 0; }
        .main-timeline .timeline:nth-child(even):before{
            right: auto;
            left: 0;
        }
        .main-timeline .timeline:after,
        .main-timeline .timeline:nth-child(even) .timeline:after{
            display: none;
        }
        .main-timeline .timeline-icon,
        .main-timeline .timeline:nth-child(even) .timeline-icon{
            left: 0;
            display: none;
        }
        .main-timeline .timeline-year,
        .main-timeline .timeline:nth-child(even) .timeline-year{
            height: 75px;
            width: 75px;
            line-height: 60px;
            font-size: 25px;
            left: 1px;
        }
        .main-timeline .timeline-content,
        .main-timeline .timeline:nth-child(even) .timeline-content{
            padding: 0 0 0 40px;
        }
    }
</style>

<div class="page-header page-header-light bg-white shadow">
    <div class="container-fluid">
        <div class="page-header-content py-3">
            <h1 class="page-header-title font-weight-light">
                <div class="page-header-icon"><i class="fas fa-desktop"></i></div>
                <span>Devices</span>
                
                <button type="button" class="btn btn-outline-primary btn-sm fa-pull-right dropdown-toggle" id="btnorderacts" style="position:absolute; right:30px;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-plus"></i>&nbsp;Actions</button>
                <div class="dropdown-menu m-0" aria-labelledby="btnorderacts">
                    <a class="nav-link" data-acttype="blanks" data-navtype="nav_iotinfo" data-toggle="modal" data-target="#iotInfoModal" href="#"><i class="fa fa-usb"></i> New Device</a>
                </div>
                
            </h1>
        </div>
    </div>
</div>
<div class="container-fluid mt-2">
    <div class="card">
        <div class="card-body">
            <!--div class="row">
                <div class="col">
                    <h2 class="">Devices</h2>
                </div>
            </div>
            <hr>
            <div id="messages"></div-->
            
            <div class="table-responsive datatable">
                <table class="table table-sm table-bordered" id="wmach_dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Tracking Code</th>
                      <th>Machine No.</th>
                      <th class="">Line Code</th>
                      <th class="">Line Name</th>
                      <th width="90">Actions</th>
                    </tr>
                  </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="iotInfoModal">
    <div class="modal-dialog" role="document">
        <form id="frm_iotinfo" action="" method="post">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="iotInfoModalLabel">Machine Details</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="form-group">
                    <label for="txttrackcode">Tracking Code (MAC)</label>
                    <input class="form-control form-control-sm" id="txttrackcode" type="text" aria-describedby="requirementsHelp" required="required" placeholder="" value="" maxlength="200">
                </div>
                
                <div class="form-group">
                	<label for="txtinstid">Machine No.</label>
                    <input class="form-control form-control-sm" id="txtinstid" type="text" aria-describedby="requirementsHelp" required="required" placeholder="" value="" maxlength="30">
                </div>
                  
                <div class="form-group"><hr /></div>
                  
                <div class="row">
                  	<div class="col-md-12">
                    	<div class="form-group">
                            <label for="insttype">Device Type</label>
                            <select  class="form-control dorm-control-sm" id="insttype">
                                <option value="-1" disabled="disabled">Select Type</option>
                            	
                                <?php 
								//if($totalRows_rsMachType>0){
									foreach($opt_device_types as $opt){
								?>
                                
                                <option value="<?php echo $opt->type_id; ?>"><?php echo $opt->device_type; ?></option>
                                <?php 
									}
								//}
								?>
                                
                            </select>
                    	</div>
                        
                    </div>
                </div>
                <div class="row" style="display:none;">
                    <div class="col-md-12">
                    	<div class="form-group">
                            <label for="other_info">Remarks</label>
                            <textarea class="form-control" id="other_info" type="text" placeholder="" rows="2" disabled="disabled"></textarea>
                            
                    	</div>
                    </div>
                </div>
                
                
                  
                <p id="inststatus"></p>
              </div>
              
              <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                <!--a class="btn btn-primary" href="login.html">Send</a-->
                <button type="submit" name="submit" class="btn btn-primary" required="required">Save</button>
                <input type="hidden" id="hregnum" value="" />
              </div>
            </div>
        </form>
    </div>
</div>

