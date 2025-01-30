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
                <span>Line Output</span>
                
                <!--button type="button" class="btn btn-outline-primary btn-sm fa-pull-right dropdown-toggle" id="btnorderacts" style="position:absolute; right:30px;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-plus"></i>&nbsp;Actions</button>
                <div class="dropdown-menu m-0" aria-labelledby="btnorderacts">
                    <a class="nav-link" data-acttype="blanks" data-navtype="nav_iotinfo" data-toggle="modal" data-target="#iotInfoModal" href="#"><i class="fa fa-usb"></i> New Device</a>
                </div-->
                
            </h1>
        </div>
    </div>
</div>
<div class="container-fluid mt-2">
    <div class="card">
        <div class="card-body">
            <form method="post" id="searchForm">
                <div class="row">
                    <div class="col-md-2">
                        <label for="factory_id">Factory</label>
                        <select class="form-control form-control-sm select2" id="factory_id" name="factory_id" required>
                        </select>
                        <div id="factory_id_error"></div>
                    </div>

                    <!--div class="col-md-2">
                        <label for="department_id">Department</label>
                        <select class="form-control form-control-sm" id="department_id" name="department_id" required>
                            <option value="">Select department</option>
                        </select>
                        <div id="department_id_error"></div>
                    </div-->

                    <div class="col-md-2">
                        <label for="section_id">Section</label>
                        <select class="form-control form-control-sm" id="section_id" name="section_id" required>
                            <option value="">Select section</option>
                        </select>
                        <div id="section_id_error"></div>
                    </div>

                    <div class="col-md-2">
                        <label for="line_id">Line</label>
                        <select class="form-control form-control-sm" id="line_id" name="line_id" required>
                            <option value="">Select line</option>
                        </select>
                        <div id="line_id_error"></div>
                    </div>
                    
                    <div class="col-md-2">
                        <label for="work_hour_id">Hour</label>
                        <select class="form-control form-control-sm" id="work_hour_id" name="work_hour_id" required>
                            <option value="">Select hour</option>
                        </select>
                        <div id="work_hour_id_error"></div>
                    </div>
                    
                    <div class="col-md-2">
                        <label for="sabs_style_id">SABS Style</label>
                        <select class="form-control form-control-sm" id="sabs_style_id" name="sabs_style_id" required>
                            <option value="">Select style</option>
                        </select>
                        <div id="sabs_style_id_error"></div>
                    </div>

                    <div class="col-md-2">
                        <br>
                        <button type="submit" class="btn btn-primary btn-sm btn-submit btn-search" id="btn-search">Search</button>
                    </div>
                </div>
            </form>
            
            <div class="form-group mt-3">
                <div id="search_results">
                    <div class="alert alert-info">
                        <span> Please select a line to view data </span>
                    </div>
                </div>

            </div>
            
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
                      <th>Sequence</th>
                      <th>Line Name</th>
                      <!--th>Employee</th-->
                      <th class="">Style</th>
                      <th class="">Operation</th>
                      <!--th>Machine</th-->
                      <th>Anticipated Qty</th><!-- expected output for prod-hrs elapsed time -->
                      <th>Actual Qty/Prod. Margin</th>
                      <th>Excess Qty</th><!-- difference of input qty and output qty -->
                      <!--th>Slot Name</th-->
                      <th width="90">Date</th>
                      <th>Time/Hour</th>
                    </tr>
                  </thead>
                </table>
            </div>
        </div>
    </div>
</div>



