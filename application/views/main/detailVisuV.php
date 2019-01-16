<?php
$type_visu = $this->uri->segment(4);
?>
<script>

<?php
if ($type_visu == 'villa')
{
    $visu_name = "ویلا";
    ?>
        var activeEl = 1;

    <?php
}
elseif ($type_visu == 'suit')
{
    $visu_name = "سوئیت - آپارتمان";
    ?>
        var activeEl = 0;

    <?php
}
?>    $(function () {
        var items = $('.btn-nav');
        $(items[activeEl]).addClass('active');
        $(".btn-nav").click(function () {
            $(items[activeEl]).removeClass('active');
            $(this).addClass('active');
            activeEl = $(".btn-nav").index(this);
        });
    });
    function addToFavorite(id) {
<?php
if (!isset($_COOKIE['MakanBaMa']))
{
    ?>
            $(".favorite").click(function (event) {
                $(this).find(".alert_favorite").alert();
                $(this).find(".alert_favorite").fadeTo(2000, 500).slideUp(500, function () {
                    $(this).find(".alert_favorite").slideUp(500);
                });
            });
    <?php
}
else
{
    ?>
            if ($('#fav' + id).hasClass('favorite_love'))
            {
                $.ajax({
                    url: '<?php echo base_url(); ?>main/visuC/addToFavorite',
                    type: 'post',
                    data: {'ID': id, 'type': '<?php echo $type_visu; ?>'},
                    success: function (data, textStatus) {
                        $('#fav' + id).removeClass("favorite_love").addClass("favorite");
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        var err = eval("(" + xhr.responseText + ")");
                        alert(err.Message);
                    }
                });

            }
            else
            {
                $.ajax({
                    url: '<?php echo base_url(); ?>main/visuC/addToFavorite',
                    type: 'post',
                    data: {'ID': id, 'type': '<?php echo $type_visu; ?>'},
                    success: function (data, textStatus) {
                        $('#fav' + id).removeClass("favorite").addClass("favorite_love");
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        var err = eval("(" + xhr.responseText + ")");
                        alert(err.Message);
                    }
                });
            }

<?php } ?>

    }

    $(document).ready(function () {

        $('[data-toggle="tooltip"]').tooltip();

        jQuery(function ($) {
            $('#btn_report_violation').on('click', function (e) {
                e.preventDefault();

                if ($('#reason_option').val() == '') {
                    $("#reason_option").addClass('errorClass');
                    setTimeout(function () {
                        $("#reason_option").removeClass('errorClass');

                    }, 2000);
                    $("#reason_option").focus();
                    return false;
                }
                $('#btn_report_violation').addClass('active');
                $('#btn_report_violation').attr("disabled", true);
                $("#btn_report_violation").css("cursor", "not-allowed");
                $.ajax({
                    type: 'post',
                    url: BASE_URL + 'main/visuC/reportViolation',
                    dataType: "json",
                    data: {building_id:<?php echo $this->uri->segment(5); ?>, reason_option: $('#reason_option').val(), 'reason_txt': $('#reason_txt').val()},
                    success: function (data) {
                        if (data.success == true) {
                            $("#btn_report_violation").removeClass('active');
                            $("#btn_report_violation").css("cursor", "default");
                            $('#btn_report_violation').attr("disabled", false);
                            $('#reason_txt').val('');
                            $('#exampleModal').modal('hide');
                        }
                        if (data.success == false)
                        {
                            $('#errAlert').html(data.message);
                            $('#errModal').modal('show');
                            $('#btnRequestRent').attr("disabled", false);

                        }
                    },
                    error: function (er) {
                        alert('request failed');
                    }
                });
            });

            $('#frm_request_rent').on('submit', function (e) {
                e.preventDefault();
                if ($('#from_date').val() == '') {
                    $("#from_date").addClass('errorClass');
                    setTimeout(function () {
                        $("#from_date").removeClass('errorClass');
                    }, 3000);
                }
                if ($('#to_date').val() == '') {
                    $("#to_date").addClass('errorClass');
                    setTimeout(function () {
                        $("#to_date").removeClass('errorClass');
                    }, 3000);
                }
                if ($('#mobile').val() == '') {
                    $("#mobile").addClass('errorClass');
                    setTimeout(function () {
                        $("#mobile").removeClass('errorClass');
                    }, 3000);
                }
                else if (!$('#mobile').val().match(/^09\d{9}$/))
                {
                    $("#mobile").addClass('errorClass');
                    $("#err_mobile").html('شماره همراه معتبر نمی باشد.');

                    setTimeout(function () {
                        $("#mobile").removeClass('errorClass');
                    }, 3000);
                    setTimeout(function () {
                        $("#err_mobile").html('');
                    }, 5000);
                }


                if ($('#full_name').val() == '') {
                    $("#full_name").addClass('errorClass');
                    setTimeout(function () {
                        $("#full_name").removeClass('errorClass');
                    }, 3000);
                }
                if ($('#from_date').val() == '' || $('#to_date').val() == '' || $('#mobile').val() == '' || $('#full_name').val() == '' || !$('#mobile').val().match(/^09\d{9}$/)) {
                    return false;
                }
                $(this).addClass('active');

                $('#btnRequestRent').attr("disabled", true);

                $("#btnRequestRent").css("cursor", "not-allowed");

                $.ajax({
                    type: 'post',
                    url: BASE_URL + 'main/visuC/requestRentVisu',
                    dataType: "json",
                    data: {building_id:<?php echo $this->uri->segment(5); ?>, from_date: $('#from_date').val(), to_date: $('#to_date').val(), mobile: $('#mobile').val(), full_name: $('#full_name').val()},
                    success: function (data) {
                        if (data.success == true) {
                            $("#btnRequestRent").removeClass('active');
                            $("#btnRequestRent").css("cursor", "default");
                            $('#btnRequestRent').attr("disabled", false);
                            $('#btnRequestRent').hide();
                            $('#successRequestRent').show();
                            $('#successRequestRent').html(data.message);
                            $('#okAlert3').html(data.message);
                            $('#okModal3').modal('show');
                            setTimeout(function () {
                                $('#okModal3').modal('hide');
                            }, 4000);

                        }
                        if (data.success == false)
                        {
                            $('#errAlert').html(data.message);
                            $('#errModal').modal('show');
                            $('#btnRequestRent').attr("disabled", false);
                            $('#btnRequestRent').val('ارسال درخواست');
                        }
                    },
                    error: function (er) {
                        alert('request failed');
                    }
                });
            });

        });
        $('#myCarousel').carousel({
            interval: 5000
        });

        $('#carousel-text').html($('#slide-content-0').html());

        //Handles the carousel thumbnails
        $('[id^=carousel-selector-]').click(function () {
            var id = this.id.substr(this.id.lastIndexOf("-") + 1);
            var id = parseInt(id);
            $('#myCarousel').carousel(id);
        });


        $("#btnSendOpinion").click(function (event) {

            if ($('#opinion').val() == '')
            {
                $('#errAlert').html("لطفا دیدگاه خود را در کادر مربوطه وارد نمایید.");
                $('#errModal').modal('show');

                setTimeout(function () {
                    $('#errModal').modal('hide');
                }, 4000);
                return false;
            }
            $(this).addClass('active');
            $('#btnSendOpinion').attr("disabled", true);
            $('#opinion').attr("disabled", true);
            $("#btnSendOpinion").css("cursor", "not-allowed");

            event.preventDefault();
            $.ajax({
                url: BASE_URL + 'main/visuC/registVisitorOpinion',
                type: 'post',
                data: {building_id:<?php echo $this->uri->segment(5); ?>, opinion: $("#opinion").val(), 'type': '<?php echo $type_visu; ?>'},
            }).success(function (resp) {
                $("#btnSendOpinion").removeClass('active');
                $("#btnSendOpinion").css("cursor", "default");
                $('#okAlert3').html("با تشکر از شما، دیدگاه درج شده پس از تایید مدیر سایت نمایش داده میشود.");
                $('#okModal3').modal('show');
                setTimeout(function () {
                    $('#okModal3').modal('hide');
                }, 3000);
                $('#btnSendOpinion').attr("disabled", false);
                $('#opinion').attr("disabled", false);
                $('#opinion').val('');
            });
        });


        $("#from_date").datepicker({
            minDate: 0,
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            isRTL: true,
            dateFormat: "yy/mm/dd",
            onSelect: function (dateText, inst) {
                $('#to_date').datepicker('option', 'minDate', new JalaliDate(inst['selectedYear'], inst['selectedMonth'], inst['selectedDay']));

            }
        });
        $('#to_date').datepicker({
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            isRTL: true,
            dateFormat: "yy/mm/dd",
        });
    });
</script>

<style type="text/css">
    #itemMenuilla{
        background: -webkit-linear-gradient(bottom, #7fe0f8, #cef8ff);
        background: -moz-linear-gradient(bottom, #7fe0f8, #cef8ff);
        background: -o-linear-gradient(bottom, #7fe0f8, #cef8ff);
        background: -ms-linear-gradient(bottom, #7fe0f8, #cef8ff);
        font-size: 16px;

        border-right-color: red !important;
        border-right-width: 4px !important;
        border-right-style: solid !important;
    }
    .thumbnails img {
        height: 80px;
        border: 4px solid #555;
        padding: 1px;
        margin: 0 10px 10px 0;
    }

    .thumbnails img:hover {
        border: 4px solid #00ccff;
        cursor:pointer;
    }

    .preview {
        width : inherit;
        margin-bottom: 20px;
    }
    .preview img {
        border: 4px solid #444;
        padding: 1px;
        height: 330px;
        max-width: 100%;
        min-width: 100%;
    }

    .btn_warning:hover{
        color: #ffcc00;
        cursor: pointer;
    }

    .errorClass { border:  2px solid back;background-color: #ff6666; }


    .btn-custom { background-color: hsl(184, 100%, 42%) !important; background-repeat: repeat-x; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#84f6ff", endColorstr="#00c7d6"); background-image: -khtml-gradient(linear, left top, left bottom, from(#84f6ff), to(#00c7d6)); background-image: -moz-linear-gradient(top, #84f6ff, #00c7d6); background-image: -ms-linear-gradient(top, #84f6ff, #00c7d6); background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #84f6ff), color-stop(100%, #00c7d6)); background-image: -webkit-linear-gradient(top, #84f6ff, #00c7d6); background-image: -o-linear-gradient(top, #84f6ff, #00c7d6); background-image: linear-gradient(#84f6ff, #00c7d6); border-color: #00c7d6 #00c7d6 hsl(184, 100%, 33.5%); color: #333 !important; text-shadow: 0 1px 1px rgba(255, 255, 255, 0.56); -webkit-font-smoothing: antialiased; }
</style>

<div class="bd-example">
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width: 335px;">
            <div class="modal-content" style="border-left:  3px #0096ff solid;border-right :  3px #0096ff solid;border-bottom:  3px #0096ff solid;">
                <div class="modal-header" style="		background: -webkit-linear-gradient(bottom, #005eea, #0096ff 49%, #75bcff 50%, #9cafff);
                     background: -moz-linear-gradient(bottom, #005eea, #0096ff 49%, #75bcff 50%, #9cafff);
                     background: -o-linear-gradient(bottom, #005eea, #0096ff 49%, #75bcff 50%, #9cafff);
                     background: -ms-linear-gradient(bottom, #005eea, #0096ff 49%, #75bcff 50%, #9cafff);">
                    <h4 class="modal-title" id="exampleModalLabel" style="text-align: center;"><i class="fa fa-exclamation-triangle fa-2x" aria-hidden="true" style="color: white"></i></h4>
                </div>
                <form id="frm_report_violation">

                    <div class="modal-body">
                        <p style="font-size: 12px;font-weight: lighter;">
                            چنانچه معتقدید این آگهی به هر دلیلی مبهم و گمراه کننده است می توانید آن را با تیم باما در میان بگذارید. ما بوسیله ابزارهایی که در اختیار داریم سطح کیفی این آگهی را مورد سنجش قرار داده و پس از بررسی های لازم نتیجه را اعمال خواهیم کرد.</p>

                        <div class="form-group">
                            <select name="reason_option" id='reason_option'  class="input-large form-control">
                                <option value="">لطفا دلیل گزارش این آگهی را انتخاب کنید </option>
                                <option value="1"> صاحب آگهی در دسترس نیست </option>
                                <option value="2">  عکاسی نامناسب </option>
                                <option value="3">  گروه بندی نامناسب  </option>
                                <option value="4"> قیمت نادرست </option>
                                <option value="5">  شماره تماس نادرست </option>
                                <option value="6"> آگهی نامناسب  </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="form-control-label">سایر دلایل:</label>
                            <textarea class="form-control" name="reason_txt" id="reason_txt"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer" style="text-align: right;">

                        <button class="btn-success btn-custom btn-large  has-spinner" id="btn_report_violation" style="background-color: #a7f995;">
                            ارسال گزارش
                            <span class="spinner"><i class="fa fa-spinner fa-spin fa-1x"  aria-hidden="true" ></i></span>
                        </button>

                        <button type="button" class="btn btn-danger" data-dismiss="modal"  style="background-color: #fd265a;">بستن</button>

                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<style>
    .spinner {
        display: inline-block;
        opacity: 0;
        width: 0;

        -webkit-transition: opacity 0.25s, width 0.25s;
        -moz-transition: opacity 0.25s, width 0.25s;
        -o-transition: opacity 0.25s, width 0.25s;
        transition: opacity 0.25s, width 0.25s;
    }

    .has-spinner.active {
        cursor:progress;
    }

    .has-spinner.active .spinner {
        opacity: 1;
        width: auto; /* This doesn't work, just fix for unkown width elements */
    }

    .has-spinner.btn-mini.active .spinner {
        width: 10px;
    }

    .has-spinner.btn-small.active .spinner {
        width: 13px;
    }

    .has-spinner.btn.active .spinner {
        width: 16px;
    }

    .has-spinner.btn-large.active .spinner {
        width: 19px;
    }
</style>
<?php
if (isset($_detailVisu))
{
    $o = array();
    $o = $_detailVisu[0];
    ?>


    <div class="row">
        <div class="col col-lg-1"></div>
        <div class="col col-lg-8">
            <div class="row"  style="background-color:white;        -webkit-box-shadow: -2px 6px 12px -1px rgba(0,0,0,0.52);
                 -moz-box-shadow: -2px 6px 12px -1px rgba(0,0,0,0.52);
                 box-shadow: -2px 6px 12px -1px rgba(0,0,0,0.52); margin-bottom: 10px;" >
                <div class="col col-lg-12">
                    <div class="row">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-10"><span style="font-size: 40px;font-weight: bolder;"><?php echo $o['title']; ?></span></div>
                        <div class="col-lg-1"></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-8"><span style="font-size: 16px"><?php echo $o['_province'] . ' - ' . $o['_city'] . '   ( ' . $o['address'] . ' )'; ?></span></div>
                        <?php
                        if (isset($o["favoriteBuilding"]) and $o["favoriteBuilding"] != NULL and $o['favoriteHosteler'] == unserialize(get_cookie('MakanBaMa'))['USERID'])
                        {
                            ?>
                            <div class="col-lg-1"><a class="favorite_love" data-toggle="tooltip" title='افزودن به علاقه مندی ها' id="fav<?php echo $o["id"]; ?>" href="javascript:void(0);" onclick="javascrit:addToFavorite('<?php echo $o["id"]; ?>');"><div class="alert-danger alert_favorite pull-left">لطفا ابتدا وارد سایت شوید!</div></a></div> 

                            <?php
                        }
                        else
                        {
                            ?>
                            <div class="col-lg-1"><a class="favorite " data-toggle="tooltip" title='افزودن به علاقه مندی ها' id="fav<?php echo $o["id"]; ?>" href="javascript:void(0);" onclick="javascrit:addToFavorite('<?php echo $o["id"]; ?>');"><div class="alert-danger alert_favorite pull-left">لطفا ابتدا وارد سایت شوید!</div></a></div> 
                            <?php
                        }
                        ?>
                        <div class="col-lg-1"><a      data-target="#exampleModal" href="javascript:void(0);"  data-placement="right" title='گزارش اشکال ' data-toggle="modal"><span style="color: black;" class="fa fa-exclamation-triangle fa-2x pull-left btn_warning"></span></a></div> 

                        <div class="col-lg-1"></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-10"> <hr class="hr_blue"/></div>
                        <div class="col-lg-1"></div>
                    </div>
                    <div class="row">
                        <div id='carousel-custom' class='carousel slide col-lg-12' data-ride='carousel'>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class='carousel-outer'>
                                        <!-- Wrapper for slides -->
                                        <div class='carousel-inner'>
                                            <div class='item active'>
                                                <img src="<?php echo base_url() . 'assets/img/upload/' . $_detailVisu[0]['user_id'] . '/' . $_detailVisu[0]['folder'] . '/MAIN_' . $_detailVisu[0]['folder'] . '.jpg'; ?>" style="width: 100%;height: 400px;" alt='' />
                                            </div>
                                            <?php
                                            $user_folder = FCPATH . "/assets/img/upload/" . $_detailVisu[0]['user_id'] . "/" . $_detailVisu[0]['folder'] . "/";
                                            if (file_exists($user_folder))
                                            {
                                                $fi = new FilesystemIterator($user_folder, FilesystemIterator::SKIP_DOTS);
                                                if (iterator_count($fi) != 0)
                                                {
                                                    if ($handle = opendir($user_folder))
                                                    {
                                                        $file = readdir($handle);
                                                        $i    = 1;
                                                        while (false !== ($file = readdir($handle)))
                                                        {
                                                            if (($file != ".") && ($file != ".."))
                                                            {
                                                                if (($file != ('MAIN_' . $_detailVisu[0]['folder'] . '.jpg')))
                                                                {
                                                                    ?>
                                                                    <div class='item'>
                                                                        <img style="width: 100%;height: 400px;" src="<?php echo base_url() . 'assets/img/upload/' . $_detailVisu[0]['user_id'] . '/' . $_detailVisu[0]['folder'] . '/' . $file; ?>">
                                                                    </div>

                                                                    <?php
                                                                }
                                                            }
                                                            ++$i;
                                                        }
                                                        closedir($handle);
                                                    }
                                                }
                                            }
                                            ?>

                                        </div>

                                        <!-- Controls -->
                                        <a class='left carousel-control' href='#carousel-custom' data-slide='next'>
                                            <span class='glyphicon glyphicon-chevron-right'></span>
                                        </a>
                                        <a class='right carousel-control' href='#carousel-custom' data-slide='prev'>
                                            <span class='glyphicon glyphicon-chevron-left'></span>
                                        </a>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <ol class='carousel-indicators mCustomScrollbar' style="text-align:right;">
                                        <li data-target='#carousel-custom' data-slide-to='0' class='active'><img src="<?php echo base_url() . 'assets/img/upload/' . $_detailVisu[0]['user_id'] . '/' . $_detailVisu[0]['folder'] . '/MAIN_' . $_detailVisu[0]['folder'] . '.jpg'; ?>" style="width: 100px;height: 70px;" alt='' /></li>
                                        <?php
                                        $user_folder = FCPATH . "/assets/img/upload/" . $_detailVisu[0]['user_id'] . "/" . $_detailVisu[0]['folder'] . "/";
                                
				        if (file_exists($user_folder))
                                        {
					
                                            $fi = new FilesystemIterator($user_folder, FilesystemIterator::SKIP_DOTS);
                                            if (iterator_count($fi) != 0)
                                            {
	
                                                if ($handle = opendir($user_folder))
                                                {
                                                    $file = readdir($handle);
                                                    $i    = 0;
                                                    while (false !== ($file = readdir($handle)))
                                                    {
                                                        if (($file != ".") && ($file != ".."))
                                                        {
                                                            if (($file != ('MAIN_' . $_detailVisu[0]['folder'] . '.jpg')))
                                                            {
							   
                                                                ?>
								
                                                                <li data-target='#carousel-custom' data-slide-to="<?php echo $i; ?>"><img style="width: 100px;height: 70px;"  src="<?php echo base_url() . 'assets/img/upload/' . $_detailVisu[0]['user_id'] . '/' . $_detailVisu[0]['folder'] . '/' . $file; ?>" alt='' /></li>

                                                                <?php
                                                            }
                                                        }
                                                        ++$i;
                                                    }
                                                    closedir($handle);
                                                }
                                            }
                                        }
                                        ?>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-info">
                <div class="panel-heading my_pnael_head" >
                    <h3 class="panel-title panel-danger">اطلاعات کلی <?php echo $visu_name; ?></h3>
                    <span class="pull-left clickable"><i class="glyphicon glyphicon-minus"></i></span>
                </div>
                <div class="panel-body" style="background-color:white;">
                    <div class = "row">
                        <div class="col col-lg-5 col-md-5">
                            <div class = "row">
                                <div class = "col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label col-lg-6" for="groundSpace"><i class="glyphicon glyphicon-hand-right" style="color: #ff0000; margin-left: 5px;"></i>مساحت زمین:</label>
                                        <div class="col-lg-6"> 
                                            <label ><b><?php echo $o['ground_space']; ?>&nbsp;&nbsp;متر مربع</b></label>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <div class = "row">
                                <div class = "col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label col-lg-6" ><i class="glyphicon glyphicon-hand-right" style="color: #ff0000;margin-left: 5px;"></i>مساحت ساختمان:</label>
                                        <div class="col-lg-6">
                                            <label ><b><?php echo $o['building_space']; ?></b></label>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <div class = "row">
                                <div class = "col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label col-lg-6" for="personsNormal"><i class="glyphicon glyphicon-hand-right" style="color: #ff0000;margin-left: 5px;"></i>  میانگین ظرفیت :</label>
                                        <div class="col-lg-6">  
                                            <label  id="personsNormal" name='personsNormal'><b><?PHP echo $o['persons_normal']; ?>&nbsp;&nbsp;نفر</b></label>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <div class = "row">
                                <div class = "col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label col-lg-6" for="personsMax"><i class="glyphicon glyphicon-hand-right" style="color: #ff0000;margin-left: 5px;"></i> حداکثر ظرفیت:</label>
                                        <div class="col-lg-5">  
                                            <label id="personsMax" name='personsMax'><b><?PHP echo $o['persons_max']; ?>&nbsp;&nbsp;نفر</b></label>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <div class = "row">
                                <div class = "col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label col-lg-6" for="floorCount"><i class="glyphicon glyphicon-hand-right" style="color: #ff0000;margin-left: 5px;"></i> تعداد طبقات:</label>
                                        <div class="col-lg-6">  
                                            <label id="floorCount" name='floorCount' ><b><?PHP echo $o['floor_count']; ?></b></label>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <div class = "row">
                                <div class = "col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label col-lg-6" for="roomCount"><i class="glyphicon glyphicon-hand-right" style="color: #ff0000;margin-left: 5px;"></i>تعداد اتاق:</label>
                                        <div class="col-lg-6">  
                                            <label id="roomCount" name='roomCount'><b><?PHP echo $o['room_count']; ?></b></label>
                                        </div>
                                    </div> 
                                </div> 
                            </div>
                            <div class = "row">
                                <div class = "col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label col-lg-6" ><i class="glyphicon glyphicon-hand-right" style="color: #ff0000;margin-left: 5px;"></i> انشعابات:</label>
                                        <div class="col-lg-6">  
                                            <label ><b>
                                                    <?PHP
                                                    $have   = array();
                                                    if ($o['water_have'] == 1)
                                                        $have[] = 'آب';
                                                    if ($o['gas_have'] == 1)
                                                        $have[] = 'گاز';
                                                    if ($o['phone_have'] == 1)
                                                        $have[] = 'تلفن';
                                                    if ($o['flash_have'] == 1)
                                                        $have[] = 'برق';
                                                    $string = '';
                                                    foreach ($have as $h)
                                                    {
                                                        $string.= $h . ' ، ';
                                                    }
                                                    echo substr($string, 0, -3);
                                                    ?>
                                                </b> </label>
                                        </div>
                                    </div> 
                                </div> 
                            </div>
                            <div class = "row">
                                <div class = "col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label col-lg-6" for="create_at"  > تاریخ درج آگهی : </label>
                                        <div class="col-lg-6">          
                                            <label id="create_at" name='create_at'><b>
                                                    <?PHP
                                                    $date1 = new DateTime(date('Y-m-d H:i:s'));
                                                    $date2 = new DateTime($o['create_at']);
                                                    $diff  = date_diff($date1, $date2);
                                                    if ($diff->days == 0)
                                                    {
                                                        echo 'امروز';
                                                    }
                                                    elseif ($diff->days == 1)
                                                    {
                                                        echo 'دیروز';
                                                    }
                                                    else
                                                    {
                                                        echo $diff->days . ' روز قبل';
                                                    }
                                                    ?>
                                                </b> </label>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                            <div class = "row">
                                <div class = "col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label col-lg-6" for="building_id"  >کد ملک : </label>
                                        <div class="col-lg-6">          
                                            <label id="building_id" name='building_id'><b><?PHP echo $o['ID']; ?></b></label>
                                        </div>
                                    </div>
                                </div>  
                            </div>

                        </div>
                        <div class="col col-lg-7 col-md-7">
                            <div class = "row">
                                <div class = "col-lg-12">
                                    <div class="form-group">
                                        <div class="col-lg-9" style="text-align: center;">          
                                            <label style="font-size: 20px;" >اجاره روزانه از<?php echo number_format($o['rent_price']); ?>&nbsp;&nbsp;تومان</label>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                            <div class="row">
                                <div class = "col-lg-12">
                                    <div class="form-group">
                                        <div class="col-lg-12">          
                                            <textarea class="form-control custom-control" cols="40" rows="7" id="rentPriceDesc" name="rentPriceDesc" style="color: #000080;" ><?php echo $o['rent_price_desc']; ?></textarea>     

                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-info">
                <div class="panel-heading my_pnael_head">
                    <h3 class="panel-title" >چشم انداز</h3>
                    <span class="pull-left clickable"><i class="glyphicon glyphicon-minus"></i></span>
                </div>
                <div class="panel-body">
                    <div class = 'row row_property'>
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>دریا</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">

                                    <span class = "input-group">
                                        <?php
                                        if ($o['sea'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="sea" name="sea" checked> 
                                            </span>
                                            <input type = "text"  disabled class = "form-control" id="sea_" name="sea_" value="<?php echo $o['sea_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" disabled style="background-color: #ff0000;">
                                                <input type = "checkbox" class="checkbox checkbox-success" id="sea" name="sea" > 
                                            </span>
                                            <input type = "text" disabled  class = "form-control" id="sea_" name="sea_" >
                                            <?php
                                        }
                                        ?>
                                    </span>  
                                </div> 
                            </div> 
                        </div> 
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>جنگل</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['forest'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="forest" name="forest" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="forest_" name="forest_" value="<?php echo $o['forest_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled  class="checkbox checkbox-success" id="forest" name="forest"> 
                                            </span>
                                            <input type = "text" disabled  class = "form-control" id="forest_" name="forest_" >
                                            <?php
                                        }
                                        ?>
                                    </span>  
                                </div> 
                            </div> 
                        </div>
                    </div>
                    <div class = 'row row_property'>
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>کوهستان</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['mountain'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled  class="checkbox checkbox-success" id="mountain" name="mountain" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="mountain_" name="mountain_" value="<?php echo $o['mountain_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="mountain" name="mountain" > 
                                            </span>
                                            <input type = "text" disabled disabled class = "form-control" id="mountain_" name="mountain_" >
                                            <?php
                                        }
                                        ?>
                                    </span>  
                                </div> 
                            </div> 
                        </div> 
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>کوهپایه</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['foothill'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled  class="checkbox checkbox-success" id="foothill" name="foothill" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="forest_" name="forest_" value="<?php echo $o['foothill_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled  class="checkbox checkbox-success" id="foothill" name="foothill"> 
                                            </span>
                                            <input type = "text" disabled  class = "form-control" id="foothill_" name="foothill_" >
                                            <?php
                                        }
                                        ?>
                                    </span> 
                                </div> 
                            </div> 
                        </div> 
                    </div>
                    <div class = 'row row_property'>
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>دریاچه</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">

                                    <span class = "input-group">
                                        <?php
                                        if ($o['lake'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="lake" name="lake" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="lake_" name="lake_" value="<?php echo $o['lake_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="lake" name="lake"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="lake_" name="lake_" >
                                            <?php
                                        }
                                        ?>
                                    </span>   
                                </div> 
                            </div> 
                        </div> 
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>رودخانه</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['river'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="river" name="river" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="river_" name="river_" value="<?php echo $o['river_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="river" name="river"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="river_" name="river_" >
                                            <?php
                                        }
                                        ?>
                                    </span> 
                                </div> 
                            </div> 
                        </div> 
                    </div>
                    <div class = 'row row_property'>
                        <div class = "col-lg-6">
                            <div class = 'row'>
                                <div class = "col-lg-3">
                                    <span>
                                        <label>شهر</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['city'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="city" name="city" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="city_" name="city_" value="<?php echo $o['city_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="city" name="city"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="city_" name="city_" >
                                            <?php
                                        }
                                        ?>
                                    </span> 
                                </div> 
                            </div> 
                        </div> 
                        <div class = "col-lg-6">
                            <div class = 'row'>
                                <div class = "col-lg-3">
                                    <span>
                                        <label>روستا</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['village'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="village" name="village" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="village_" name="village_" value="<?php echo $o['village_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="village" name="village"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="village_" name="village_" >
                                            <?php
                                        }
                                        ?>
                                    </span>  
                                </div> 
                            </div> 
                        </div> 
                    </div>
                </div>
            </div>
            <div class="panel panel-info">
                <div class="panel-heading my_pnael_head">
                    <h3 class="panel-title" >نوع ملک</h3>
                    <span class="pull-left clickable"><i class="glyphicon glyphicon-minus"></i></span>
                </div>
                <div class="panel-body">
                    <div class = 'row row_property'>
                        <div class = "col-lg-6">
                            <div class = 'row'>
                                <div class = "col-lg-3">
                                    <span>
                                        <label>استخر دار</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['pool'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="pool" name="pool" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="pool_" name="pool_" value="<?php echo $o['pool_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="pool" name="pool"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="pool_" name="pool_" >
                                            <?php
                                        }
                                        ?>
                                    </span> 
                                </div> 
                            </div> 
                        </div> 
                        <div class = "col-lg-6">
                            <div class = 'row'>
                                <div class = "col-lg-3">
                                    <span>
                                        <label>نزدیک دریا</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['nearsea'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled  class="checkbox checkbox-success" id="nearsea" name="nearsea" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="nearsea_" name="nearsea_" value="<?php echo $o['nearsea_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled  class="checkbox checkbox-success" id="nearsea" name="nearsea"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="nearsea_" name="nearsea_" >
                                            <?php
                                        }
                                        ?>
                                    </span>  
                                </div> 
                            </div> 
                        </div> 
                    </div>
                    <div class = 'row row_property'>
                        <div class = "col-lg-6">
                            <div class = 'row'>
                                <div class = "col-lg-3">
                                    <span>
                                        <label>جنگلی</label>
                                    </span>
                                </div>                  
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['woodsy'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="woodsy" name="woodsy" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="woodsy_" name="woodsy_" value="<?php echo $o['woodsy_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="woodsy" name="woodsy"> 
                                            </span>
                                            <input type = "text" disabled  class = "form-control" id="woodsy_" name="woodsy_" >
                                            <?php
                                        }
                                        ?>
                                    </span>  
                                </div> 
                            </div> 
                        </div> 
                        <div class = "col-lg-6">
                            <div class = 'row'>
                                <div class = "col-lg-3">
                                    <span>
                                        <label>ییلاق -کوهستانی</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['mountainous'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled  class="checkbox checkbox-success" id="mountainous" name="mountainous" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="mountainous_" name="mountainous_" value="<?php echo $o['mountainous_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled  class="checkbox checkbox-success" id="mountainous" name="mountainous"> 
                                            </span>
                                            <input type = "text" disabled  class = "form-control" id="mountainous_" name="mountainous_" >
                                            <?php
                                        }
                                        ?>
                                    </span>  
                                </div> 
                            </div> 
                        </div> 
                    </div>
                    <div class = 'row row_property'>
                        <div class = "col-lg-6">
                            <div class = 'row'>
                                <div class = "col-lg-3">
                                    <span>
                                        <label>چسبیده به دریا</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['very_nearsea'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="veryNearsea" name="veryNearsea" checked> 
                                            </span>
                                            <input type = "text" disabled  class = "form-control" id="veryNearsea_" name="veryNearsea_"value="<?php echo $o['very_nearsea_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="veryNearsea" name="veryNearsea"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="veryNearsea_" name="veryNearsea_" >
                                            <?php
                                        }
                                        ?>
                                    </span> 
                                </div> 
                            </div> 
                        </div> 

                    </div>
                </div>
            </div>
            <div class="panel panel-info">
                <div class="panel-heading my_pnael_head">
                    <h3 class="panel-title ">حریم خصوصی و امنیت</h3>
                    <span class="pull-left clickable"><i class="glyphicon glyphicon-minus"></i></span>
                </div>
                <div class="panel-body">
                    <div class = "row row_property">
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>داخل شهرک</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['into_twon'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled  class="checkbox checkbox-success" id="intotwon" name="intotwon" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="intotwon_" name="intotwon_" value="<?php echo $o['into_twon_']; ?>" >

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="intotwon" name="intotwon"  > 
                                            </span>
                                            <input type = "text" disabled  class = "form-control" id="intotwon_" name="intotwon_">
                                            <?php
                                        }
                                        ?>
                                    </span>  
                                </div> 
                            </div> 
                        </div> 
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>دریست</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['exclusive'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="exclusive" name="exclusive" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="exclusive_" name="exclusive_" value="<?php echo $o['exclusive_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="exclusive" name="exclusive"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="exclusive_" name="exclusive_">
                                            <?php
                                        }
                                        ?>
                                    </span> 
                                </div> 
                            </div> 
                        </div> 
                    </div>
                    <div class = "row row_property">
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>غیر دربست</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['nonexclusive'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="nonexclusive" name="nonexclusive" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="nonexclusive_" name="nonexclusive_" value="<?php echo $o['nonexclusive_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="nonexclusive" name="nonexclusive"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="nonexclusive_" name="nonexclusive_" >
                                            <?php
                                        }
                                        ?>
                                    </span>
                                </div> 
                            </div> 
                        </div> 
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>دارای سرایداری</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['janitor'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="janitor" name="janitor" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="janitor_" name="janitor_" value="<?php echo $o['janitor_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="janitor" name="janitor"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="janitor_" name="janitor_" >
                                            <?php
                                        }
                                        ?>
                                    </span>
                                </div> 
                            </div> 
                        </div> 
                    </div>
                </div>
            </div>
            <div class="panel panel-info">
                <div class="panel-heading my_pnael_head">
                    <h3 class="panel-title" >امکانات</h3>
                    <span class="pull-left clickable"><i class="glyphicon glyphicon-minus"></i></span>
                </div>
                <div class="panel-body">
                    <div class = "row row_property">
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>کنسول بازی xboxیا ps</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['console_games'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="consoleGames" name="consoleGames" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="consoleGames_" name="consoleGames_" value="<?php echo $o['console_games_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="consoleGames" name="consoleGames"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="consoleGames_" name="consoleGames_">
                                            <?php
                                        }
                                        ?>
                                    </span>
                                </div> 
                            </div> 
                        </div> 
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>مبلمان</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['furniture'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="furniture" name="furniture" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="furniture_" name="furniture_" value="<?php echo $o['furniture_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="furniture" name="furniture"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="furniture_" name="furniture_" >
                                            <?php
                                        }
                                        ?>
                                    </span> 
                                </div> 
                            </div> 
                        </div> 
                    </div>
                    <div class = "row row_property">
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>میزناهارخوری</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['dining_table'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="diningTable" name="diningTable" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="diningTable_" name="diningTable_" value="<?php echo $o['dining_table_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="diningTable" name="diningTable"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="diningTable_" name="diningTable_" >
                                            <?php
                                        }
                                        ?>
                                    </span>  
                                </div> 
                            </div> 
                        </div> 
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>تلویزیون</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['tv'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="tv" name="tv" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="tv_" name="tv_" value="<?php echo $o['tv_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="tv" name="tv"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="tv_" name="tv_">
                                            <?php
                                        }
                                        ?>
                                    </span>  
                                </div> 
                            </div> 
                        </div> 
                    </div>
                    <div class = "row row_property">
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>آنتن</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['antenna'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="antenna" name="antenna" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="antenna_" name="antenna_" value="<?php echo $o['antenna_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="antenna" name="antenna"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="antenna_" name="antenna_">
                                            <?php
                                        }
                                        ?>
                                    </span>  
                                </div> 
                            </div> 
                        </div> 
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>اینترنت</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['internet'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="internet" name="internet" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="internet_" name="internet_" value="<?php echo $o['internet_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="internet" name="internet"> 
                                            </span>
                                            <input type = "text" disabled  class = "form-control" id="internet_" name="internet_" >
                                            <?php
                                        }
                                        ?>
                                    </span> 
                                </div> 
                            </div> 
                        </div> 
                    </div>
                    <div class = "row row_property">
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>آسانسور</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['elevator'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="elevator" name="elevator" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="elevator_" name="elevator_" value="<?php echo $o['elevator_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="elevator" name="elevator"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="elevator_" name="elevator_">
                                            <?php
                                        }
                                        ?>
                                    </span>  
                                </div> 
                            </div> 
                        </div> 
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>سیستم صوتی</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['sound_system'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="soundSystem" name="soundSystem" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="soundSystem_" name="soundSystem_" value="<?php echo $o['sound_system_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="soundSystem" name="soundSystem"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="soundSystem_" name="soundSystem_" >
                                            <?php
                                        }
                                        ?>
                                    </span> 
                                </div> 
                            </div> 
                        </div> 
                    </div>
                    <div class = "row row_property">
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>جاروبرقی</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['vacume_cleaner'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="vacumeCleaner" name="vacumeCleaner" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="vacumeCleaner_" name="vacumeCleaner_" value="<?php echo $o['vacume_cleaner_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="vacumeCleaner" name="vacumeCleaner"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="vacumeCleaner_" name="vacumeCleaner_">
                                            <?php
                                        }
                                        ?>
                                    </span> 
                                </div> 
                            </div> 
                        </div> 
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>اتو</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['iron'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="iron" name="iron" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="iron_" name="iron_" value="<?php echo $o['iron_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="iron" name="iron"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="iron_" name="iron_">
                                            <?php
                                        }
                                        ?>
                                    </span>
                                </div> 
                            </div> 
                        </div> 
                    </div>
                    <div class = "row row_property">
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>کابینت</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['cabinet'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="cabinet" name="cabinet" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="cabinet_" name="cabinet_" value="<?php echo $o['cabinet_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="cabinet" name="cabinet"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="cabinet_" name="cabinet_" >
                                            <?php
                                        }
                                        ?>
                                    </span>  
                                </div> 
                            </div> 
                        </div> 
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>ظروف آشپزخانه</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['kitchen_ware'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="kitchenWare" name="kitchenWare" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="kitchenWare_" name="kitchenWare_" value="<?php echo $o['kitchen_ware_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="kitchenWare" name="kitchenWare"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="kitchenWare_" name="kitchenWare_">
                                            <?php
                                        }
                                        ?>
                                    </span>
                                </div> 
                            </div> 
                        </div> 
                    </div>
                    <div class = "row row_property">
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>یخچال</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['refrigerator'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="refrigerator" name="refrigerator" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="refrigerator_" name="refrigerator_" value="<?php echo $o['refrigerator_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="refrigerator" name="refrigerator"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="refrigerator_" name="refrigerator_">
                                            <?php
                                        }
                                        ?>
                                    </span>
                                </div> 
                            </div> 
                        </div> 
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>ماشین ظرفشویی</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['dish_washer'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" class="checkbox checkbox-success" id="dishWasher" name="dishWasher" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="dishWasher_" name="dishWasher_" value="<?php echo $o['dish_washer_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="dishWasher" name="dishWasher"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="dishWasher_" name="dishWasher_" >
                                            <?php
                                        }
                                        ?>
                                    </span>
                                </div> 
                            </div> 
                        </div> 
                    </div>
                    <div class = "row row_property">
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>ماشین لباسشویی</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['dish_washer'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="washingMachine" name="washingMachine" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="washingMachine_" name="washingMachine_" value="<?php echo $o['washing_machine_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="washingMachine" name="washingMachine"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="washingMachine_" name="washingMachine_">
                                            <?php
                                        }
                                        ?>
                                    </span> 
                                </div> 
                            </div> 
                        </div> 
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>مایکروفر</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['microwave'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="microwave" name="microwave" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="microwave_" name="microwave_" value="<?php echo $o['microwave_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="microwave" name="microwave"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="microwave_" name="microwave_">
                                            <?php
                                        }
                                        ?>
                                    </span> 
                                </div> 
                            </div> 
                        </div> 
                    </div>
                    <div class = "row row_property">
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>چای ساز</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['tea_maker'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="teaMaker" name="teaMaker" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="teaMaker_" name="teaMaker_" value="<?php echo $o['tea_maker_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="teaMaker" name="teaMaker"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="teaMaker_" name="teaMaker_">
                                            <?php
                                        }
                                        ?>
                                    </span>
                                </div> 
                            </div> 
                        </div> 
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>دستگاه تصفیه آب خانگی</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['water_purifier'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="waterPurifier" name="waterPurifier" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="waterPurifier_" name="waterPurifier_" value="<?php echo $o['water_purifier_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="waterPurifier" name="waterPurifier"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="waterPurifier_" name="waterPurifier_" >
                                            <?php
                                        }
                                        ?>
                                    </span> 
                                </div> 
                            </div> 
                        </div> 
                    </div>
                    <div class = "row">
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>تخت و سرویس خواب</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">

                                    <span class = "input-group">
                                        <?php
                                        if ($o['bed'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="bed" name="bed" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="bed_" name="bed_" value="<?php echo $o['bed_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="bed" name="bed"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="bed_" name="bed_">
                                            <?php
                                        }
                                        ?>
                                    </span> 
                                </div> 
                            </div> 
                        </div> 
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>حمام</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['bathroom'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="bathroom" name="bathroom" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="bathroom_" name="bathroom_" value="<?php echo $o['bathroom_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="bathroom" name="bathroom"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="bathroom_" name="bathroom_" >
                                            <?php
                                        }
                                        ?>
                                    </span>
                                </div> 
                            </div> 
                        </div> 
                    </div>
                    <div class = "row row_property">
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>سرویس بهداشتی فرنگی</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['toilet_bowls'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="toiletBowls" name="toiletBowls" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="toiletBowls_" name="toiletBowls_" value="<?php echo $o['toilet_bowls_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="toiletBowls" name="toiletBowls"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="toiletBowls_" name="toiletBowls_" >
                                            <?php
                                        }
                                        ?>
                                    </span>
                                </div> 
                            </div> 
                        </div> 
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>سرویس بهداشتی ایرانی</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['iranian_health_service'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="iranianHealthService" name="iranianHealthService" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="iranianHealthService_" name="iranianHealthService_" value="<?php echo $o['iranian_health_service_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="iranianHealthService" name="iranianHealthService"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="iranianHealthService_" name="iranianHealthService_" >
                                            <?php
                                        }
                                        ?>
                                    </span>
                                </div> 
                            </div> 
                        </div> 

                    </div>
                    <div class = "row row_property">
                        <div class = "col-lg-6">   
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>استخر سرپوشیده</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['indoor_swimming_pool'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="indoorSwimmingPool" name="indoorSwimmingPool" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="indoorSwimmingPool_" name="indoorSwimmingPool_" value="<?php echo $o['indoor_swimming_pool_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="indoorSwimmingPool" name="indoorSwimmingPool"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="indoorSwimmingPool_" name="indoorSwimmingPool_" >
                                            <?php
                                        }
                                        ?>
                                    </span>
                                </div> 
                            </div> 
                        </div> 
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>سونا</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['souna'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="souna" name="souna" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="souna_" name="souna_" value="<?php echo $o['souna_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="souna" name="souna"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="souna_" name="souna_">
                                            <?php
                                        }
                                        ?>
                                    </span> 
                                </div> 
                            </div> 
                        </div> 
                    </div>
                    <div class = "row row_property">
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>جکوزی</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['jakuzzi'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox"disabled  class="checkbox checkbox-success" id="jakuzzi" name="jakuzzi" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="jakuzzi_" name="jakuzzi_" value="<?php echo $o['jakuzzi_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="jakuzzi" name="jakuzzi"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="jakuzzi_" name="jakuzzi_" >
                                            <?php
                                        }
                                        ?>
                                    </span>  
                                </div> 
                            </div> 
                        </div> 
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>استخر روباز</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['outdoor_swimming_pool'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="outdoorSwimmingPool" name="outdoorSwimmingPool" checked> 
                                            </span>
                                            <input type = "text" disabled  class = "form-control" id="outdoorSwimmingPool_" name="outdoorSwimmingPool_" value="<?php echo $o['outdoor_swimming_pool_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="outdoorSwimmingPool" name="outdoorSwimmingPool"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="outdoorSwimmingPool_" name="outdoorSwimmingPool_">
                                            <?php
                                        }
                                        ?>
                                    </span> 
                                </div> 
                            </div> 
                        </div> 
                    </div>
                    <div class = "row row_property">
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>دوش داخل حیاط</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['shower_in_the_yard'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="showerInTheYard" name="showerInTheYard" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="showerInTheYard_" name="showerInTheYard_" value="<?php echo $o['shower_in_the_yard_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="showerInTheYard" name="showerInTheYard"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="showerInTheYard_" name="showerInTheYard_">
                                            <?php
                                        }
                                        ?>
                                    </span> 
                                </div> 
                            </div> 
                        </div> 
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>وسایل بدنسازی</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['gym_equipment'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="gymEquipment" name="gymEquipment" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="gymEquipment_" name="gymEquipment_" value="<?php echo $o['gym_equipment_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="gymEquipment" name="gymEquipment"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="gymEquipment_" name="gymEquipment_" >
                                            <?php
                                        }
                                        ?>
                                    </span> 
                                </div> 
                            </div> 
                        </div> 
                    </div>
                    <div class = "row row_property">
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>صندلی ماساژور</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['massage_chairs'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="massageChairs" name="massageChairs" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="massageChairs_" name="massageChairs_" value="<?php echo $o['massage_chairs_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="massageChairs" name="massageChairs"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="massageChairs_" name="massageChairs_">
                                            <?php
                                        }
                                        ?>
                                    </span> 
                                </div> 
                            </div> 
                        </div> 
                    </div>
                    <div class = "row row_property">
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>میز بیلیارد</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['pool_table'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="poolTable" name="poolTable" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="poolTable_" name="poolTable_" value="<?php echo $o['pool_table_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="poolTable" name="poolTable"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="poolTable_" name="poolTable_" >
                                            <?php
                                        }
                                        ?>
                                    </span> 
                                </div> 
                            </div> 
                        </div> 
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>میز پینگ پونگ</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['pingpong_table'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="pingpongTable" name="pingpongTable" checked> 
                                            </span>
                                            <input type = "tex" disabled class = "form-control" id="pingpongTable_" name="pingpongTable_" value="<?php echo $o['pingpong_table_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="pingpongTable" name="pingpongTable"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="pingpongTable_" name="pingpongTable_">
                                            <?php
                                        }
                                        ?>
                                    </span> 
                                </div> 
                            </div> 
                        </div> 
                    </div>
                    <div class = "row row_property">
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>فوتبال دستی</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['soccer'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="soccer" name="soccer" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="soccer_" name="soccer_" value="<?php echo $o['soccer_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="soccer" name="soccer"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="soccer_" name="soccer_" >
                                            <?php
                                        }
                                        ?>
                                    </span> 
                                </div> 
                            </div> 
                        </div> 
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>تخته نرد</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['back_gammon'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="backGammon" name="backGammon" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="backGammon_" name="backGammon_" value="<?php echo $o['back_gammon_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="backGammon" name="backGammon"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="backGammon_" name="backGammon_" >
                                            <?php
                                        }
                                        ?>
                                    </span> 
                                </div> 
                            </div> 
                        </div> 
                    </div>
                    <div class = "row row_property">
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>میز شطرنج</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['chest_table'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="chestTable" name="chestTable" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="chestTable_" name="chestTable_" value="<?php echo $o['chest_table_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" disabled style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="chestTable" name="chestTable"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="chestTable_" name="chestTable_">
                                            <?php
                                        }
                                        ?>
                                    </span> 
                                </div> 
                            </div> 
                        </div> 
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>زمین والیبال</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['volleyball_court'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="volleyballCourt" name="volleyballCourt" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="volleyballCourt_" name="volleyballCourt_" value="<?php echo $o['volleyball_court_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="volleyballCourt" name="volleyballCourt"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="volleyballCourt_" name="volleyballCourt_" >
                                            <?php
                                        }
                                        ?>
                                    </span> 
                                </div> 
                            </div> 
                        </div> 
                    </div>
                    <div class = "row row_property">
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>زمین فوتبال</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['football_court'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="footballCourt" name="footballCourt" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="footballCourt_" name="footballCourt_" value="<?php echo $o['football_court_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="footballCourt" name="footballCourt"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="footballCourt_" name="footballCourt_" >
                                            <?php
                                        }
                                        ?>
                                    </span> 
                                </div> 
                            </div> 
                        </div> 
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>زمین تنیس</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['tennis_court'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="tennisCourt" name="tennisCourt" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="tennisCourt_" name="tennisCourt_" value="<?php echo $o['tennis_court_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="tennisCourt" name="tennisCourt"> 
                                            </span>
                                            <input type = "text"disabled  class = "form-control" id="tennisCourt_" name="tennisCourt_">
                                            <?php
                                        }
                                        ?>
                                    </span> 
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class = "row row_property">
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>زمین بدمینتون</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['badminton_court'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="badmintonCourt" name="badmintonCourt" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="badmintonCourt_" name="badmintonCourt_" value="<?php echo $o['badminton_court_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="badmintonCourt" name="badmintonCourt"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="badmintonCourt_" name="badmintonCourt_">
                                            <?php
                                        }
                                        ?>
                                    </span> 
                                </div> 
                            </div> 
                        </div> 
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>محوطه بازی کودکان</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['badminton_court'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="childerenPlayArea" name="childerenPlayArea" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="childerenPlayArea_" name="childerenPlayArea_" value="<?php echo $o['childeren_play_area_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="childerenPlayArea" name="childerenPlayArea"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="childerenPlayArea_" name="childerenPlayArea_">
                                            <?php
                                        }
                                        ?>
                                    </span>  
                                </div> 
                            </div> 
                        </div> 
                    </div>
                    <div class = "row row_property">
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>تراس - بالکن</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['terrace'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="terrace" name="terrace" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="terrace_" name="terrace_" value="<?php echo $o['terrace_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="terrace" name="terrace"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="terrace_" name="terrace_">
                                            <?php
                                        }
                                        ?>
                                    </span> 
                                </div> 
                            </div> 
                        </div> 
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>پارکینگ</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['parking'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="parking" name="parking" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="parking_" name="parking_" value="<?php echo $o['parking_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="parking" name="parking"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="parking_" name="parking_" >
                                            <?php
                                        }
                                        ?>  
                                    </span>       
                                </div> 
                            </div> 
                        </div> 
                    </div>
                    <div class = "row row_property">
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>حیاط</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['yard'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="yard" name="yard" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="yard_" name="yard_" value="<?php echo $o['yard_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="yard" name="yard"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="yard_" name="yard_" >
                                            <?php
                                        }
                                        ?>  
                                    </span> 
                                </div> 
                            </div> 
                        </div> 
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>فضای سبز</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['green_space'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled  class="checkbox checkbox-success" id="greenSpace" name="greenSpace" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="greenSpace_" name="greenSpace_" value="<?php echo $o['green_space_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="greenSpace" name="greenSpace"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="greenSpace_" name="greenSpace_" >
                                            <?php
                                        }
                                        ?>  
                                    </span>
                                </div> 
                            </div> 
                        </div> 
                    </div>
                    <div class = "row row_property">
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>آلاچیق</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['pergola'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="pergola" name="pergola" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="pergola_" name="pergola_" value="<?php echo $o['pergola_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="pergola" name="pergola"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="pergola_" name="pergola_" >
                                            <?php
                                        }
                                        ?>  
                                    </span> 
                                </div> 
                            </div> 
                        </div> 
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>باربیکیو</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['barbecue'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="barbecue" name="barbecue" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="barbecue_" name="barbecue_"  value="<?php echo $o['barbecue_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="barbecue" name="barbecue"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="barbecue_" name="barbecue_" >
                                            <?php
                                        }
                                        ?>  
                                    </span>
                                </div> 
                            </div> 
                        </div> 
                    </div>
                    <div class = "row row_property">
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>آب نما</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['fountain'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled  class="checkbox checkbox-success" id="fountain" name="fountain" checked> 
                                            </span>
                                            <input type = "text" disabled  class = "form-control" id="fountain_" name="fountain_" value="<?php echo $o['fountain_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled  class="checkbox checkbox-success" id="fountain" name="fountain"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="fountain_" name="fountain_" >
                                            <?php
                                        }
                                        ?>  
                                    </span> 
                                </div>
                            </div>
                        </div>
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>کولر اسپیلیت</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['split_cooler'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled  class="checkbox checkbox-success" id="splitCooler" name="splitCooler" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="splitCooler_" name="splitCooler_" value="<?php echo $o['split_cooler_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="splitCooler" name="splitCooler"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="splitCooler_" name="splitCooler_">
                                            <?php
                                        }
                                        ?>  
                                    </span> 
                                </div> 
                            </div> 
                        </div> 
                    </div>
                    <div class = "row row_property">
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>کولر گازی</label>
                                    </span> 
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['gase_cooler'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="gasCooler" name="gasCooler" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="gasCooler_" name="gasCooler_" value="<?php echo $o['gase_cooler_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="gasCooler" name="gasCooler"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="gasCooler" name="gasCooler_" >
                                            <?php
                                        }
                                        ?>  
                                    </span>
                                </div> 
                            </div> 
                        </div> 
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>کولر آبی</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['water_cooler'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="waterCooler" name="waterCooler" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="waterCooler_" name="waterCooler_" value="<?php echo $o['water_cooler_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="waterCooler" name="waterCooler"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="waterCooler_" name="waterCooler_">
                                            <?php
                                        }
                                        ?>  
                                    </span> 
                                </div> 
                            </div> 
                        </div> 
                    </div>
                    <div class = "row row_property">
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>پنکه سقفی</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['ceiling_fan'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="ceilingFan" name="ceilingFan" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="ceilingFan_" name="ceilingFan_" value="<?php echo $o['ceiling_fan_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="ceilingFan" name="ceilingFan"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="ceilingFan_" name="ceilingFan_">
                                            <?php
                                        }
                                        ?>  
                                    </span> 
                                </div> 
                            </div> 
                        </div> 
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>بخاری گازی</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['gas_heater'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="gasHeater" name="gasHeater" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="gasHeater_" name="gasHeater_" value="<?php echo $o['gas_heater_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="gasHeater" name="gasHeater"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="gasHeater_" name="gasHeater_">
                                            <?php
                                        }
                                        ?>  
                                    </span>  
                                </div> 
                            </div> 
                        </div> 
                    </div>
                    <div class = "row row_property">
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>شوفاژ</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['radiators'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="radiators" name="radiators" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="radiators_" name="radiators_" value="<?php echo $o['radiators_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="radiators" name="radiators"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="radiators_" name="radiators_">
                                            <?php
                                        }
                                        ?>  
                                    </span> 
                                </div> 
                            </div> 
                        </div> 
                    </div>
                    <div class = "row row_property">
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>پکیج دیواری</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['wall_package'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="wallPackage" name="wallPackage" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="wallPackage_" name="wallPackage_" value="<?php echo $o['wall_package_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="wallPackage" name="wallPackage"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="wallPackage_" name="wallPackage_">
                                            <?php
                                        }
                                        ?>  
                                    </span>
                                </div> 
                            </div> 
                        </div> 
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>شومینه هیزمی</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['fireplace_wood'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="fireplaceWood" name="fireplaceWood" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="fireplaceWood_" name="fireplaceWood_" value="<?php echo $o['fireplace_wood_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="fireplaceWood" name="fireplaceWood"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="fireplaceWood_" name="fireplaceWood_">
                                            <?php
                                        }
                                        ?>  
                                    </span>
                                </div> 
                            </div> 
                        </div> 
                    </div>
                    <div class = "row row_property">
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>شومینه گازی</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['fireplace_gas'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="fireplaceGas" name="fireplaceGas" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="fireplaceGas_" name="fireplaceGas_" value="<?php echo $o['fireplace_gas_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="fireplaceGas" name="fireplaceGas"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="fireplaceGas_" name="fireplaceGas_">
                                            <?php
                                        }
                                        ?>  
                                    </span>
                                </div> 
                            </div> 
                        </div> 
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">
                                    <span>
                                        <label>اجاق گاز</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['oven'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="oven" name="oven" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="oven_" name="hairdryer_" value="<?php echo $o['oven_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="oven" name="oven"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="oven_" name="oven_">
                                            <?php
                                        }
                                        ?>  
                                    </span>
                                </div> 
                            </div> 
                        </div> 
                    </div>
                    <div class = "row row_property">
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-3">

                                    <span>
                                        <label>سشوار</label>
                                    </span>
                                </div>
                                <div class = "col-lg-9">
                                    <span class = "input-group">
                                        <?php
                                        if ($o['hairdryer'] == 1)
                                        {
                                            ?> 
                                            <span class = "input-group-addon" style="background-color: #33ff33;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="hairdryer" name="hairdryer" checked> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="hairdryer_" name="hairdryer_" value="<?php echo $o['hairdryer_']; ?>">

                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class = "input-group-addon" style="background-color: #ff0000;">
                                                <input type = "checkbox" disabled class="checkbox checkbox-success" id="hairdryer" name="hairdryer"> 
                                            </span>
                                            <input type = "text" disabled class = "form-control" id="hairdryer_" name="hairdryer_">
                                            <?php
                                        }
                                        ?>  
                                    </span>  
                                </div> 
                            </div> 
                        </div> 

                    </div>
                </div>
            </div>
            <div class="panel panel-info">
                <div class="panel-heading my_pnael_head">
                    <h3 class="panel-title panel-danger">توضیحات تکمیلی</h3>
                    <span class="pull-left clickable"><i class="glyphicon glyphicon-minus"></i></span>
                </div>
                <div class="panel-body">
                    <div class = "row">
                        <div class = "col-lg-12">
                            <div class="input-group">
                                <p><b><?php echo nl2br($o['final_desc']); ?></b></p>     
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-info">
                <div class="panel-heading my_pnael_head" >
                    <h3 class="panel-title panel-danger" >موقعیت ملک</h3>
                    <span class="pull-left clickable"><i class="glyphicon glyphicon-minus"></i></span>
                </div>
                <div class="panel-body">
                    <div id="map" style="width:100%;height:500px"></div>
                    <input type="hidden" id="lat"  name="lat" />
                    <input type="hidden" id="lng"  name="lng" />
                </div>
            </div>
            <div class="panel panel-info">
                <div class="panel-heading my_pnael_head">
                    <h3 class="panel-title panel-danger" >دیدگاه مسافران</h3>
                    <span class="pull-left clickable"><i class="glyphicon glyphicon-minus"></i></span>
                </div>
                <div class="panel-body">
                    <div class = "row" style="padding: 10px;" >
                        <div class = "col-lg-12" >
                            <?php
                            if (isset($_opinionVisu))
                            {
                                foreach ($_opinionVisu as $opinion)
                                {
                                    ?>
                                    <div id="tb-testimonial" class="testimonial testimonial-default">
                                        <div class="testimonial-section" style="color: black;font-size: 14px;text-align: justify;line-height: 2;">
                                            <?php
                                            echo nl2br($opinion['opinion']);
                                            ?>
                                            <?php
                                            if ($opinion['response'] != NULL)
                                            {
                                                ?>
                                                <div class="row">
                                                    <div class="col-sm-2">
                                                        <div class="thumbnail">
                                                            <img  src="<?php
                                                            if (file_exists(FCPATH . "assets/img/upload/{$opinion['user_id']}/PROFILE_{$opinion['user_id']}.jpg"))
                                                            {
                                                                echo base_url() . "assets/img/upload/{$opinion['user_id']}/PROFILE_{$opinion['user_id']}.jpg";
                                                            }
                                                            else
                                                            {
                                                                echo base_url() . 'assets/img/nobody_m.original.jpg';
                                                            }
                                                            ?>" alt=""style="height: 100px;"/>
                                                        </div><!-- /thumbnail -->
                                                    </div><!-- /col-sm-1 -->
                                                    <div class="col-sm-10">
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading" style="background-color: #99d5f5;">
                                                                <span class="text-muted"><?php
                                                                    echo jdate(' H:i:s Y-m-d ', strtotime($opinion['response_date']));
                                                                    ?></span>  <strong><?php echo $opinion['full_name_passenger']; ?></strong>
                                                            </div>
                                                            <div class="panel-body"style="box-shadow:0 0px 0px 0 rgba(0, 0, 0, 0), 0 0px 0px 0 rgba(0, 0, 0, 0); background-color: #99bdf2;">
                                                                <span>پاسخ : </span><br/><?php echo $opinion['response']; ?>
                                                            </div><!-- /panel-body -->
                                                        </div><!-- /panel panel-default -->
                                                    </div><!-- /col-sm-5 -->
                                                </div><!-- /row -->
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="testimonial-desc">

                                            <img src="<?php
                                            if (file_exists(FCPATH . "assets/img/upload/{$opinion['user_id_passenger']}/PROFILE_{$opinion['user_id_passenger']}.jpg"))
                                            {
                                                echo base_url() . "assets/img/upload/{$opinion['user_id_passenger']}/PROFILE_{$opinion['user_id_passenger']}.jpg";
                                            }
                                            else
                                            {
                                                echo base_url() . 'assets/img/nobody_m.original.jpg';
                                            }
                                            ?>" alt="" />
                                            <div class="testimonial-writer">
                                                <div class="testimonial-writer-name" style="text-align: center;"><?php
                                                    echo $opinion['full_name_passenger'] != '' ? $opinion['full_name_passenger'] : 'ناشناس';
                                                    ?></div>
                                                <div class="testimonial-writer-designation" ><?php
                                                    echo jdate('H:i:s Y-m-d ', strtotime($opinion['opinion_date']));
                                                    ?></div>

                                            </div>
                                        </div>
                                    </div>   


                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <div class = "row">
                        <div class = "col-lg-12">
                            <div class="input-group" id="divSendOpinion">
                                <p >دیدگاه خود را در فرم زیر درج کنید. اگر عضو سایت باشید دیدگاه با نام شما منتشر خواهد شد.</p> 
                                <textarea class="form-control custom-control" id="opinion" name="opinion" style="color: #000080;width: 100%;height: 300px;" ></textarea>  
                                <br/>
                                <br/>


                                <button class="btn-success btn-lg has-spinner" id="btnSendOpinion">
                                    ارسال دیدگاه
                                    <span class="spinner"><i class="fa fa-spinner fa-spin fa-1x"  aria-hidden="true" ></i></span>
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col col-lg-3">
            <div class="panel panel-info">
                <div class="panel-heading my_pnael_head" >
                    <h3 class="panel-title panel-danger">تماس جهت رزرو</h3>
                    <span class="pull-left clickable"><i class="glyphicon glyphicon-minus"></i></span>
                </div>
                <div class="panel-body">
                    <div class = "row">
                        <div class = "col-lg-12">
                            <div class = "row">
                                <div class = "col-lg-2"></div>
                                <div class = "col-lg-8" style="text-align: center;">   <img src="<?php echo base_url() . "assets/img/no-image-icon2.png"; ?>" style="height: 100;width: 150px;"/></div>
                                <div class = "col-lg-2"></div>
                            </div>
                            <div style="text-align: center;font-size: 16px;"><b><?php echo $o['FULL_NAME']; ?></b></div>
                            <div style="text-align: center;font-size: 16px;"><b><?php echo $o['MOBILE']; ?></b></div>
                            <div style="text-align: center;font-size: 16px;"><b>کدملک :<?php echo $o['ID']; ?></b></div>
                        </div>

                    </div>
                    <div class = "row">
                        <div class = "col-lg-12">
                            <div>هنگام تماس تلفنی، لطفاً به نام سایت مکان با ما و کد ملک اشاره کنید تا سریع‌تر راهنمایی شوید. قبل از تماس، راهنمای معامله امن و قوانین را بخوانید. سوال یا دیدگاه خود را اینجا درج کنید.</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-info">
                <div class="panel-heading my_pnael_head" >
                    <h3 class="panel-title panel-danger">درخواست رزرو</h3>
                    <span class="pull-left clickable"><i class="glyphicon glyphicon-minus"></i></span>
                </div>
                <form id="frm_request_rent">

                    <div class="panel-body">
                        <div class = "row">
                            <div class = "col-lg-12">
                                <div class="control-group">
                                    <div class="controls">
                                        <div class="input-group">
                                            <span class="input-group-addon" style="background-color: transparent;color:black;">
                                                <i class="fa fa-calendar fa-2x" aria-hidden="true" style="color: #ff5a5f;width: 27px;"></i>
                                            </span>
                                            <input type="text"  class = "form-control " id="from_date" style="border: 1px grey solid;text-align: center; " placeholder="از"/>
                                        </div>
                                    </div>
                                </div>                        
                            </div>
                        </div>
                        <br/>
                        <div class = "row">
                            <div class = "col-lg-12">
                                <div class="control-group">
                                    <div class="controls">
                                        <div class="input-group">
                                            <span class="input-group-addon" style="background-color: transparent;color:black;">
                                                <i class="fa fa-calendar fa-2x" aria-hidden="true" style="color: #ff5a5f;width: 27px;"></i>
                                            </span>
                                            <input type="text"  class = "form-control " id="to_date" style="border: 1px grey solid;text-align: center;" placeholder="تا"/>
                                        </div>
                                    </div>
                                </div>                        
                            </div>
                        </div>
                        <br/>
                        <div class = "row">
                            <div class = "col-lg-12">
                                <div class="control-group">
                                    <div class="controls">
                                        <div class="input-group">
                                            <span class="input-group-addon" style="background-color: transparent;color:black;">
                                                <i class="fa fa-user fa-2x" aria-hidden="true" style="color: #ff5a5f;width: 27px;"></i>
                                            </span>
                                            <input type="text"  class = "form-control " id="mobile" style="border: 1px grey solid;text-align: center;" placeholder="شماره همراه"/>
                                        </div>
                                        <span style="color:red;text-align: center;" id="err_mobile"></span>

                                    </div>
                                </div>                        
                            </div>
                        </div>
                        <br/>
                        <div class = "row">
                            <div class = "col-lg-12">
                                <div class="control-group">
                                    <div class="controls">
                                        <div class="input-group">
                                            <span class="input-group-addon" style="background-color: transparent;color:black;">
                                                <i class="fa fa-mobile fa-2x" aria-hidden="true" style="color: #ff5a5f;width: 27px;"></i>
                                            </span>
                                            <input type="text"  class = "form-control " id="full_name" style="border: 1px grey solid;text-align: center;" placeholder="نام و نام خانوادگی"/>
                                        </div>
                                    </div>
                                </div>                        
                            </div>
                        </div>
                        <br/>
                        <div class = "row">
                            <div class = "col-lg-12" style="text-align: center;">

                                <?php
                                if ($_allow_rent['status'])
                                {
                                    ?>

                                    <button class="btn-success btn-lg has-spinner" id="btnRequestRent">
                                        ارسال درخواست
                                        <span class="spinner"><i class="fa fa-spinner fa-spin fa-1x"  aria-hidden="true" ></i></span>
                                    </button>
                                    <p id="successRequestRent" style="display: none;height: 40px;padding: 5px;" class="alert-success"></p>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <p  style="height: 40px;padding: 5px;" class="alert-success"><?php echo  $_allow_rent['msg'] ?></p>

                                    <?php
                                }
                                ?>

                            </div>
                        </div>
                    </div>
                </form>

            </div>
            <a href="<?php echo base_url() ?>main/visuC/visu/<?php echo $type_visu; ?>/?prv=<?php echo $o['province_id']; ?>" style="color: white;"><button class="btn-info btn-sm" ><?php echo "اجاره " . $visu_name . " در " . $o['_province']; ?></button></a> 
            <a href="<?php echo base_url() ?>main/visuC/visu/<?php echo $type_visu; ?>/?cty=<?php echo $o['city_id']; ?>" style="color: white;"><button class="btn-info btn-sm" ><?php echo "اجاره " . $visu_name . " در" . $o['_city']; ?></button></a> 

            <?php
            $prt = array();
            if ($o['sea'] == 1)
            {
                ?>
                <a href="<?php echo base_url() ?>main/visuC/visu/<?php echo $type_visu; ?>/?prt=sea" style="color: white;"><button class="btn-info btn-sm" ><?php echo "اجاره " . $visu_name . " با چشم انداز" . "دریا"; ?></button></a>
                <?php
            }
            if ($o['lake'] == 1)
            {
                ?>
                <a href="<?php echo base_url() ?>main/visuC/visu/<?php echo $type_visu; ?>/?prt=lake" style="color: white;"><button class="btn-info btn-sm" ><?php echo "اجاره " . $visu_name . "  با چشم انداز" . "دریاچه"; ?></button></a>
                <?php
            }
            if ($o['mountain'] == 1)
            {
                ?>
                <a href="<?php echo base_url() ?>main/visuC/visu/<?php echo $type_visu; ?>/?prt=mountain" style="color: white;"><button class="btn-info btn-sm" ><?php echo "اجاره " . $visu_name . "  با چشم انداز" . "کوهستان"; ?></button></a>
                <?php
            }
            if ($o['river'] == 1)
            {
                ?>
                <a href="<?php echo base_url() ?>main/visuC/visu/<?php echo $type_visu; ?>/?prt=river" style="color: white;"><button class="btn-info btn-sm" ><?php echo "اجاره " . $visu_name . "  با چشم انداز" . "رودخانه"; ?></button></a>
                <?php
            }
            if ($o['village'] == 1)
            {
                ?>
                <a href="<?php echo base_url() ?>main/visuC/visu/<?php echo $type_visu; ?>/?prt=village" style="color: white;"><button class="btn-info btn-sm" ><?php echo "اجاره " . $visu_name . "  با چشم انداز" . "روستا"; ?></button></a>
                <?php
            }
            if ($o['pool'] == 1)
            {
                ?>
                <a href="<?php echo base_url() ?>main/visuC/visu/<?php echo $type_visu; ?>/?prt=pool" style="color: white;"><button class="btn-info btn-sm" ><?php echo "اجاره " . $visu_name . "استخر دار"; ?></button></a>

                <?php
            }
            if ($o['nearsea'] == 1)
            {
                ?>
                <a href="<?php echo base_url() ?>main/visuC/visu/<?php echo $type_visu; ?>/?prt=nearsea" style="color: white;"><button class="btn-info btn-sm" ><?php echo "اجاره " . $visu_name . "نزدیک دریا" ?> </button></a>

                <?php
            }

            if ($o['woodsy'] == 1)
            {
                ?>
                <a href="<?php echo base_url() ?>main/visuC/visu/<?php echo $type_visu; ?>/?prt=woodsy" style="color: white;"><button class="btn-info btn-sm" ><?php echo "اجاره " . $visu_name . "جنگلی"; ?> </button></a>

                <?php
            }
            if ($o['very_nearsea'] == 1)
            {
                ?>
                <a href="<?php echo base_url() ?>main/visuC/visu/<?php echo $type_visu; ?>/?prt=very_nearsea" style="color: white;">      <button class="btn-info btn-sm" ><?php echo "اجاره " . $visu_name . "چسبیده به دریا"; ?> </button></a>
                <?php
            }
            if ($o['mountainous'] == 1)
            {
                ?>
                <a href="<?php echo base_url() ?>main/visuC/visu/<?php echo $type_visu; ?>/?prt=mountainous" style="color: white;">      <button class="btn-info btn-sm" ><?php echo "اجاره " . $visu_name . "کوهستانی"; ?> </button></a>
                <?php
            }
            if ($o['exclusive'] == 1)
            {
                ?>
                <a href="<?php echo base_url() ?>main/visuC/visu/<?php echo $type_visu; ?>/?prt=exclusive" style="color: white;">      <button class="btn-info btn-sm" ><?php echo "اجاره " . $visu_name . "دربست"; ?> </button></a>
                <?php
            }
            if ($o['jakuzzi'] == 1)
            {
                ?>
                <a href="<?php echo base_url() ?>main/visuC/visu/<?php echo $type_visu; ?>/?prt=jakuzzi" style="color: white;">      <button class="btn-info btn-sm" ><?php echo "اجاره " . $visu_name . " با " . "جکوزی"; ?> </button></a>
                <?php
            }
            if ($o['souna'] == 1)
            {
                ?>
                <a href="<?php echo base_url() ?>main/visuC/visu/<?php echo $type_visu; ?>/?prt=souna" style="color: white;">      <button class="btn-info btn-sm" ><?php echo "اجاره " . $visu_name . " با " . "سونا"; ?> </button></a>
                <?php
            }
            if ($o['pool_table'] == 1)
            {
                ?>
                <a href="<?php echo base_url() ?>main/visuC/visu/<?php echo $type_visu; ?>/?prt=very_nearsea" style="color: white;">      <button class="btn-info btn-sm" ><?php echo "اجاره " . $visu_name . " با " . "میز بیلیارد"; ?> </button></a>
                <?php
            }
            if ($o['pingpong_table'] == 1)
            {
                ?>
                <a href="<?php echo base_url() ?>main/visuC/visu/<?php echo $type_visu; ?>/?prt=pingpong_table" style="color: white;">      <button class="btn-info btn-sm" ><?php echo "اجاره " . $visu_name . " با " . "میز پینگ پونگ"; ?> </button></a>
                <?php
            }
            if ($o['soccer'] == 1)
            {
                ?>
                <a href="<?php echo base_url() ?>main/visuC/visu/<?php echo $type_visu; ?>/?prt=soccer" style="color: white;">      <button class="btn-info btn-sm" ><?php echo "اجاره " . $visu_name . " با " . "فوتبال دستی"; ?> </button></a>
                <?php
            }
            if ($o['volleyball_court'] == 1)
            {
                ?>
                <a href="<?php echo base_url() ?>main/visuC/visu/<?php echo $type_visu; ?>/?prt=volleyball_court" style="color: white;">      <button class="btn-info btn-sm" ><?php echo "اجاره " . $visu_name . " با " . "زمین والیبال"; ?> </button></a>
                <?php
            }
            if ($o['football_court'] == 1)
            {
                ?>
                <a href="<?php echo base_url() ?>main/visuC/visu/<?php echo $type_visu; ?>/?prt=football_court" style="color: white;">      <button class="btn-info btn-sm" ><?php echo "اجاره " . $visu_name . " با " . "زمین فوتبال"; ?> </button></a>
                <?php
            }
            if ($o['tennis_court'] == 1)
            {
                ?>
                <a href="<?php echo base_url() ?>main/visuC/visu/<?php echo $type_visu; ?>/?prt=tennis_court" style="color: white;">      <button class="btn-info btn-sm" ><?php echo "اجاره " . $visu_name . " با " . "زمین تنیس"; ?> </button></a>
                <?php
            }
            if ($o['badminton_court'] == 1)
            {
                ?>
                <a href="<?php echo base_url() ?>main/visuC/visu/<?php echo $type_visu; ?>/?prt=badminton_court" style="color: white;">      <button class="btn-info btn-sm" ><?php echo "اجاره " . $visu_name . " با " . "زمین بدمینتون"; ?> </button></a>
                <?php
            }
            if ($o['outdoor_swimming_pool'] == 1)
            {
                ?>
                <a href="<?php echo base_url() ?>main/visuC/visu/<?php echo $type_visu; ?>/?prt=outdoor_swimming_pool" style="color: white;">      <button class="btn-info btn-sm" ><?php echo "اجاره " . $visu_name . " با " . "استخر رو باز"; ?> </button></a>
                <?php
            }
            if ($o['indoor_swimming_pool'] == 1)
            {
                ?>
                <a href="<?php echo base_url() ?>main/visuC/visu/<?php echo $type_visu; ?>/?prt=indoor_swimming_pool" style="color: white;">      <button class="btn-info btn-sm" ><?php echo "اجاره " . $visu_name . " با " . "استخر سر پوشیده"; ?> </button></a>
                <?php
            }
            if ($o['fountain'] == 1)
            {
                ?>
                <a href="<?php echo base_url() ?>main/visuC/visu/<?php echo $type_visu; ?>/?prt=fountain" style="color: white;">      <button class="btn-info btn-sm" ><?php echo "اجاره " . $visu_name . " با " . "آب نما"; ?> </button></a>
                <?php
            }
            if ($o['pergola'] == 1)
            {
                ?>
                <a href="<?php echo base_url() ?>main/visuC/visu/<?php echo $type_visu; ?>/?prt=pergola" style="color: white;">      <button class="btn-info btn-sm" ><?php echo "اجاره " . $visu_name . " با " . "آلاچیق"; ?> </button></a>
                <?php
            }
            if ($o['fireplace_wood'] == 1)
            {
                ?>
                <a href="<?php echo base_url() ?>main/visuC/visu/<?php echo $type_visu; ?>/?prt=fireplace_wood" style="color: white;">      <button class="btn-info btn-sm" ><?php echo "اجاره " . $visu_name . " با " . "شومینه هیزمی"; ?> </button></a>
                <?php
            } if ($o['gym_equipment'] == 1)
            {
                ?>
                <a href="<?php echo base_url() ?>main/visuC/visu/<?php echo $type_visu; ?>/?prt=gym_equipment" style="color: white;">      <button class="btn-info btn-sm" ><?php echo "اجاره " . $visu_name . " با " . "وسایل بدنسازی"; ?> </button></a>
                <?php
            }
            ?>

        </div>
    </div>
    <script>
        function myMap() {

            var mapCanvas = document.getElementById("map");
            var myCenter = new google.maps.LatLng(<?php echo $o['lat']; ?>, <?php echo $o['lng']; ?>);
            var mapProp = {center: myCenter, zoom: 8};
            var map = new google.maps.Map(mapCanvas, mapProp);

            var myMarker = new google.maps.Marker({
                position: myCenter,
                draggable: true,
                animation: google.maps.Animation.BOUNCE,
                title: 'Set lat/lon values for this property',
            });

            google.maps.event.addListener(myMarker, 'dragend', function (evt) {
                document.getElementById('lat').value = evt.latLng.lat();
                document.getElementById('lng').value = evt.latLng.lng();
            });

            map.setCenter(myMarker.position);
            myMarker.setMap(map);

        }
    </script>


    <script src="https://maps.googleapis.com/maps/api/js?callback=myMap&key=AIzaSyDCyDdZc_us4lssx3rBuTV1P5El_Geprcw"></script>

    <?php
}
?>


<link type="text/css" href="<?php echo base_url(); ?>/assets/css/bootstrap-datepicker.min.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url(); ?>/assets/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/assets/js/bootstrap-datepicker.fa.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/assets/js/bootstrap-datepicker.fa.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/assets/js/spin.js"></script>

