<link href="<?php echo base_url(); ?>/assets/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>/assets/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>/assets/css/fileinput.min.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo base_url(); ?>/assets/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/assets/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/assets/js/fileinput.min.js" ></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/assets/js/fileinput_fa.js" ></script>
<style>
    #mainMenu{
        display: none;
    }
</style>
<div class="row">
    <div class="col col-lg-1 col-md-1 col-sm-1 col-xs-1"  ></div>
    <div class="col col-lg-2 col-md-2 col-sm-2 col-xs-2" style="padding: 0px;margin: 0px;" >
        <div class="panel-group" id="accordion1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion1" href="#collapseOne1" style="font-size: 12px;font-weight: bolder;"><span></span>املاک برای اجاره</a>
                    </h4>
                </div>
                <div id="collapseOne1" class="panel-collapse collapse in">
                    <ul class="list-group">
                        <li class="list-group-item" id="itemMenuVilla"><span class="glyphicon glyphicon-plus-sign text-primary"></span> <a href="<?php echo base_url() . 'deskUser/listVisuC/visu/villa'; ?>" style="font-size:12px;color: black;">ویلا</a></li>
                        <li class="list-group-item" id="itemMenuSuit"><span class="glyphicon glyphicon-plus-sign text-primary"></span> <a style="font-size:12px;color: black;" href="<?php echo base_url() . 'deskUser/listVisuC/visu/suit'; ?>">سوئیت - آپارتمان</a></li>

                    </ul>
                </div>

            </div>
        </div>
        <div class="panel-group" id="accordion2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion2" href="#collapseOne2" style="font-size: 12px;font-weight: bolder;"><span ></span>ارتباط با مسافران</a>
                    </h4>
                </div>
                <div id="collapseOne2" class="panel-collapse collapse in">
                    <ul class="list-group">

                        <li class="list-group-item" id="listRent"><span  class="glyphicon glyphicon-plus-sign text-primary"></span> <a style="font-size:12px;color: black;" href="<?php echo base_url() . 'deskUser/listRentC/'; ?>">درخواست های اجاره</a></li>
                        <li class="list-group-item" id="opinionVisitors"><span class="glyphicon glyphicon-plus-sign text-primary"></span> <a style="font-size:12px;color: black;" href="<?php echo base_url() . 'deskUser/listOpinionVisitorsC/'; ?>">دیدگاه مسافران</a></li>
                        <li class="list-group-item" id="itemListPlace"><span class="glyphicon glyphicon-plus-sign text-primary"></span> <a style="font-size:12px;color: black;" href="<?php echo base_url() . 'deskUser/listPlaceC/'; ?>">مطالب گردشگری</a></li>

                    </ul>
                </div>
            </div>
        </div>
        <div class="panel-group" id="accordion3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion3" href="#collapseOne3" style="font-size: 12px;font-weight: bolder;"><span ></span>تنظیمات</a>
                    </h4>
                </div>
                <div id="collapseOne3" class="panel-collapse collapse in">
                    <ul class="list-group">

                        <li class="list-group-item" id="itemMenuProfile"><span class="glyphicon glyphicon-plus-sign text-primary"></span> <a href="<?php echo base_url() . 'deskUser/profileC/'; ?>" style="font-size:12px;color: black;">پروفایل</a>
                        <li class="list-group-item" id="contactSupport"><span class="glyphicon glyphicon-plus-sign text-primary"></span> <a href="<?php echo base_url() . 'deskUser/contactSupportC/'; ?>" style="font-size:12px;color: black;">تماس با پشتیبانی</a></li>
                        <li class="list-group-item" id="itemMenuHelp"><span class="glyphicon glyphicon-plus-sign text-primary"></span> <a style="font-size:12px;color: black;" href="<?php echo base_url() . 'deskUser/helpC/'; ?>">راهنما</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="col col-lg-8 col-md-8 col-sm-8 col-xs-8" style="margin-bottom: 20px;"  >



