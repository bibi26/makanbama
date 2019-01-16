<!DOCTYPE html>
<html lang="fa">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no,maximum-scale=1.0">
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="Cache-control" content="no-cache">
        <meta http-equiv="Expires" content="0">
        <script  type="text/javascript">var BASE_URL = '<?php echo base_url(); ?>';</script>
        <link href="<?php echo base_url(); ?>/assets/css/bootstrap_rtl.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>/assets/css/bootstrap_extra.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>/assets/css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>/assets/css/my.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>/assets/css/slider.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>/assets/css/bootstrap-multiselect.css" rel="stylesheet" type="text/css"/>
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
        <script type="text/javascript" src="<?php echo base_url(); ?>/assets/js/jquery.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>/assets/js/bootstrap.js" ></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>/assets/js/menu.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>/assets/js/slider.js" ></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>/assets/js/bootstrap-multiselect.js" ></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>/assets/js/ckeditor.js" ></script>

        <?php
// $this->assetlibpro->add_css("css/bootstrap_rtl.css");
//$this->assetlibpro->add_css("css/bootstrap_extra.css");
//$this->assetlibpro->add_css("css/bootstrap.css");
//$this->assetlibpro->add_css("css/my.css");
//$this->assetlibpro->add_css("css/slider.css");
//$this->assetlibpro->add_css("css/bootstrap-multiselect.css");
//$this->assetlibpro->add_js("js/jquery.js");
//$this->assetlibpro->add_js("js/bootstrap.js");
//$this->assetlibpro->add_js("js/menu.js");
//$this->assetlibpro->add_js("js/slider.js");
//$this->assetlibpro->add_js("js/bootstrap-multiselect.js");
//$this->assetlibpro->add_js("js/ckeditor.js");
        ?>
        <script type="text/javascript">

            $(document).on('click', '.panel-heading span.clickable', function (e) {
                var $this = $(this);
                if (!$this.hasClass('panel-collapsed')) {
                    $this.parents('.panel').find('.panel-body').slideUp();
                    $this.addClass('panel-collapsed');
                    $this.find('i').removeClass('glyphicon-minus').addClass('glyphicon-plus');
                } else {
                    $this.parents('.panel').find('.panel-body').slideDown();
                    $this.removeClass('panel-collapsed');
                    $this.find('i').removeClass('glyphicon-plus').addClass('glyphicon-minus');
                }
            });
            $(document).on('click', '.panel div.clickable', function (e) {
                var $this = $(this);
                if (!$this.hasClass('panel-collapsed')) {
                    $this.parents('.panel').find('.panel-body').slideUp();
                    $this.addClass('panel-collapsed');
                    $this.find('i').removeClass('glyphicon-minus').addClass('glyphicon-plus');
                } else {
                    $this.parents('.panel').find('.panel-body').slideDown();
                    $this.removeClass('panel-collapsed');
                    $this.find('i').removeClass('glyphicon-plus').addClass('glyphicon-minus');
                }
            });
            $(document).ready(function () {
//        $('.panel-heading span.clickable').click();
//        $('.panel div.clickable').click();
            });
            var BASE_URL = '<?Php echo base_url(); ?>';
            jQuery(function ($) {
                $('#signUpForm').on('submit', function (e) {
                    e.preventDefault();
                    $.ajax({
                        type: 'post',
                        url: BASE_URL + 'mainC/signUP',
                        dataType: "json",
                        data: $('#signUpForm').serialize(),
                        success: function (data) {
                            if (data.success == true) {
                                window.location = BASE_URL + 'mainC/registedAccount';
                            }
                            if (data.success == false)
                            {
                                $('#errAlert').html(data.message);
                                $('#errModal').modal('show');
                            }
                        },
                        error: function (er) {
                            alert('request failed');
                        }
                    });
                });

            });
            jQuery(function ($) {

                $('#loginForm').on('submit', function (e) {
                    e.preventDefault();
                    if ($('#email').val() == '') {
                        $("#email").addClass('errorClass');
                        setTimeout(function () {
                            $("#email").removeClass('errorClass');


                        }, 2000);
                        $("#email").focus();
                        return false;
                    }
                    if ($('#pas').val() == '') {
                        $("#pas").addClass('errorClass');
                        setTimeout(function () {
                            $("#pas").removeClass('errorClass');

                        }, 2000);
                        $("#pas").focus();
                        return false;
                    }
                    $('#login_btn').attr("disabled", true);
                    $('#area_login_spin').show();

                    $.ajax({
                        type: 'post',
                        url: BASE_URL + 'account/loginC/auth',
                        dataType: "json",
                        data: $('#loginForm').serialize(),
                        success: function (data) {
                            if (data.success == true) {
                                if (data.user == 'passenger')
                                {
                                    window.location = BASE_URL + 'deskPassenger/profileC/';
                                }
                                else if (data.user == 'hosteler')
                                {
                                    window.location = BASE_URL + 'deskUser/homeC/';

                                }
                                else if (data.user == 'adminSuper')
                                {
                                    window.location = BASE_URL + 'deskAdmin/homeC/';

                                }
                            }
                            if (data.success == false)
                            {
                                $('#login_btn').attr("disabled", false);

                                $('#area_login_spin').hide();
                                $('#area_login_err').html(data.message);
                            }
                        },
                        error: function (er) {
                            alert('request failed');
                        }
                    });


                });
            });




        </script>
    </head>
    <body>
        <script>
            (function ($) {

                $(document)
                        .on('hidden.bs.modal', '.modal', function () {
                            $(document.body).removeClass('modal-noscrollbar');
                        })
                        .on('show.bs.modal', '.modal', function () {
                            // Bootstrap adds margin-right: 15px to the body to account for a
                            // scrollbar, but this causes a "shift" when the document isn't tall
                            // enough to need a scrollbar; therefore, we disable the margin-right
                            // when it isn't needed.
                            if ($(window).height() >= $(document).height()) {
                                $(document.body).addClass('modal-noscrollbar');
                            }
                        });

            })(window.jQuery);
            $(document).ready(function () {
                $(".dropdown").hover(
                        function () {
                            $('.dropdown-menu', this).stop(true, true).slideDown("fast");
                            $(this).toggleClass('open');
                        },
                        function () {
                            $('.dropdown-menu', this).stop(true, true).slideUp("fast");
                            $(this).toggleClass('open');
                        }
                );
            });


            $(function () {
                // Remove Search if user Resets Form or hits Escape!
                $('body, .navbar-collapse form[role="search"] button[type="reset"]').on('click keyup', function (event) {
                    console.log(event.currentTarget);
                    if (event.which == 27 && $('.navbar-collapse form[role="search"]').hasClass('active') ||
                            $(event.currentTarget).attr('type') == 'reset') {
                        closeSearch();
                    }
                });

                function closeSearch() {
                    var $form = $('.navbar-collapse form[role="search"].active')
                    $form.find('input').val('');
                    $form.removeClass('active');
                }

                // Show Search if form is not active // event.preventDefault() is important, this prevents the form from submitting
                $(document).on('click', '.navbar-collapse form[role="search"]:not(.active) button[type="submit"]', function (event) {
                    event.preventDefault();
                    var $form = $(this).closest('form'),
                            $input = $form.find('input');
                    $form.addClass('active');
                    $input.focus();

                });
                // ONLY FOR DEMO // Please use $('form').submit(function(event)) to track from submission
                // if your form is ajax remember to call `closeSearch()` to close the search container
                $(document).on('click', '.navbar-collapse form[role="search"].active button[type="submit"]', function (event) {
                    event.preventDefault();
                    var $form = $(this).closest('form'),
                            $input = $form.find('input');
                    $('#showSearchTerm').text($input.val());
                    closeSearch();
                });
            });
        </script>


        <div class="row" >
            <div class="col-lg-12" >
                <nav class="navbar navbar-default" role="navigation" style="margin: 0px;padding: 0px;border: 0px; background-color: #000000; border-radius: 0px;color: #fff;">
                    <div class="container-fluid" >
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-megadropdown-tabs">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand" href="#"></a>
                        </div>

                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse" id="bs-megadropdown-tabs">
                            <ul class="nav navbar-nav">
                                <li><a  style="color: #ffffff;margin: 0px;border-radius: 0px;height: 46px;" href="<?php echo base_url() . 'mainC/'; ?>"><i class="fa fa-home" aria-hidden="true" style="color: white;"></i>&nbsp;صفحه اصلی</a></li>
                                <?php
                                if (isset($_COOKIE['MakanBaMa']))
                                {
                                    ?>
                                    <li><a style="color: #fff;" href="<?php echo base_url() . 'account/logoutC'; ?>" ><i class="fa fa-power-off" aria-hidden="true" style="color: white;"></i>&nbsp;خروج </a></li>
                                    <li><a style="color: #fff;" href="<?php echo base_url() . 'deskUser/homeC'; ?>"><span class="fa fa-eye-slash" aria-hidden="true"> </span>&nbsp;&nbsp;<?php echo(unserialize($_COOKIE['MakanBaMa'])['EMAIL']); ?></a></li>
                                    <?php
                                    $user = unserialize(get_cookie('MakanBaMa'))['USERTYPE'];
                                    if ($user == 'hosteler')
                                    {
                                        ?>

                                        <li><a    style="color: #ffffff;margin: 0px;border-radius: 0px;height: 46px" href="<?php echo base_url() . 'deskUser/homeC'; ?>"><i class="glyphicon glyphicon glyphicon-user" style="color: white;"></i>&nbsp; پروفایل</a></li>
                                        <?php
                                    }
                                    elseif ($user == 'passenger')
                                    {
                                        ?>
                                        <li><a    style="color: #ffffff;margin: 0px;border-radius: 0px;height: 46px" href="<?php echo base_url() . 'deskpassenger/homeC'; ?>"><i class="glyphicon glyphicon glyphicon-user" style="color: white;"></i>&nbsp; پروفایل</a></li>
                                        <?php
                                    }
                                    elseif ($user == 'adminSuper')
                                    {
                                        ?>
                                        <li><a    style="color: #ffffff;margin: 0px;border-radius: 0px;height: 46px" href="<?php echo base_url() . 'deskAdmin/homeC'; ?>"><i class="glyphicon glyphicon glyphicon-user" style="color: white;"></i>&nbsp; پروفایل</a></li>
                                        <?php
                                    }
                                }
                                else
                                {
                                    ?>
                                    <li><a style="color: #fff;" href="#" data-toggle="modal" data-target="#loginModal"><span class="glyphicon glyphicon-log-in"></span>&nbsp;ورود</a></li>
                                    <li><a style="color: #fff;"   href="<?php echo base_url() . 'account/registerUserC/'; ?>"  ><span class="glyphicon glyphicon-user"></span>&nbsp;عضویت</a></li>

                                    <?php
                                }
                                ?>
                            </ul>   
                            <?php
                            if (isset($_COOKIE['MakanBaMa']))
                            {
                                $user = unserialize(get_cookie('MakanBaMa'))['USERTYPE'];
                                if ($user == 'hosteler')
                                {
                                    ?>
                                    <ul class="nav navbar-nav navbar-right">
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color: white;">علاقه مندی ها<span class="caret" ></span></a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="<?php echo base_url() . 'main/visuC/visu/villa?favorite=1&user=hosteler'; ?>">ویلا</a></li>
                                                <li><a href="<?php echo base_url() . 'main/visuC/visu/suit?favorite=1&user=hosteler'; ?>">سوئیت - آپارتمان</a></li>
                                                <li><a href="<?php echo base_url() . 'main/placeC?favorite=1&user=hosteler'; ?>">مکان گردشگری</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                    <?php
                                }
                                elseif ($user == 'passenger')
                                {
                                    ?>
                                    <ul class="nav navbar-nav navbar-right">
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color: white;">علاقه مندی ها<span class="caret"></span></a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="<?php echo base_url() . 'main/visuC/visu/villa?favorite=1&user=passenger'; ?>">ویلا</a></li>
                                                <li><a href="<?php echo base_url() . 'main/visuC/visu/villa?favorite=1&user=passenger'; ?>">سوئیت - آپارتمان</a></li>
                                                <li><a href="<?php echo base_url() . 'main/placeC?favorite=1&user=passenger'; ?>">مکان گردشگری</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                    <?php
                                }
                            }
                            ?>

                            <!--                            <form class="navbar-form navbar-right" role="search" action="../2.php">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" placeholder="جستجو . . ." style="color:#000; padding: 0px;padding-right: 5px; border-radius: 0px;width: 25%;float: left;border: 1px #99ccff solid;height: 45px;">
                                                                <span class="input-group-btn">
                                                                    <button type="reset" class="btn btn-default" style="height: 51px;border-radius: 0px;padding: 0px;padding-left: 10px;padding-right: 10px;">
                                                                        <span class="glyphicon glyphicon-remove"  style="color: red;">
                                                                            <span class="sr-only">Close</span>
                                                                        </span>
                                                                    </button>
                                                                    <button type="submit" class="btn btn-default" style="background-color:transparent;">
                                                                        <span class="glyphicon glyphicon-search" style="color: red;">
                                                                            <span class="sr-only">Search</span>
                                                                        </span>
                                                                    </button>
                                                                </span>
                                                            </div>
                                                        </form> -->

                        </div>
                    </div><!-- /.navbar-collapse -->
                </nav>   
            </div>   
        </div>   


        <div class="row  " id="mainMenu">
            <div class="col-lg-12  " >
                <div class="btn-group btn-group-justified">
                    <div class="btn-group">
                        <a  id="ccc"  href="<?php echo base_url() . 'main/visuC/visu/suit'; ?>">
                            <button type="button" class="btn btn-nav">
                                <span class="glyphicon glyphicon-home"></span>
                                <p>اجاره سوئیت - آپارتمان</p>
                            </button>
                        </a>
                    </div>
                    <div class="btn-group">
                        <a id="bbb" href="<?php echo base_url() . 'main/visuC/visu/villa'; ?>">
                            <button type="button" class="btn btn-nav">
                                <span class="glyphicon glyphicon-tree-conifer"></span>
                                <p>اجاره ویلا</p>
                            </button>
                        </a>
                    </div>
                    <div class="btn-group">
                        <a id="aaa" href="<?php echo base_url() . 'main/placeC/'; ?>">
                            <button type="button" class="btn btn-nav">
                                <span class="glyphicon glyphicon-picture"></span>
                                <p>جاذبه های گردشگری</p>
                            </button></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- SIGNUP MODAL-->
        <div id="loginModal" class="modal fade" role="dialog"  >
            <div class="modal-dialog" style="width: 335px;">

                <!-- Modal content-->
                <div class="modal-content" style="border-left:  3px #0096ff solid;border-right :  3px #0096ff solid;border-bottom:  3px #0096ff solid;">
                    <form id="loginForm"> 

                        <div class="modal-header" style="		background: -webkit-linear-gradient(bottom, #005eea, #0096ff 49%, #75bcff 50%, #9cafff);
                             background: -moz-linear-gradient(bottom, #005eea, #0096ff 49%, #75bcff 50%, #9cafff);
                             background: -o-linear-gradient(bottom, #005eea, #0096ff 49%, #75bcff 50%, #9cafff);
                             background: -ms-linear-gradient(bottom, #005eea, #0096ff 49%, #75bcff 50%, #9cafff);">
                            <h4 class="modal-title" style="text-align: center;"><i class="fa fa-sign-in fa-2x" aria-hidden="true" style="color: white"></i></h4>
                        </div>
                        <div class="modal-body" >
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class = "form-group">
                                        <table >
                                            <tr>
                                                <td>
                                                    <label class="control-label">ایمیل</label>
                                                </td>
                                                <td>
                                                    <input class="form-control" name="email" id='email' type="text" style="direction: ltr;width: 200px;"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label  class="control-label">رمزعبور</label>
                                                </td>
                                                <td>
                                                    <input class="form-control" name="pas" id='pas'  type="password" style="direction: ltr;width: 200px;"/>
                                                </td>
                                            </tr>    
                                        </table>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col col-lg-12 ">
                                    <div class="notice notice-success notice-md">
                                        <strong><li class="glyphicon glyphicon-check" style="color: #a7f995;"></li>&nbsp;<a style="color: black;" href="<?php echo base_url() . 'account/forgetPasswordC/'; ?>">رمز عبور خود را فراموش کرده اید؟</a></strong><br/>
                                        <strong><li class="glyphicon glyphicon-check" style="color: #a7f995;"></li>&nbsp;<a style="color: black;" href="<?php echo base_url() . 'account/registerUserC/'; ?>">تاکنون در مکان با ما ثبت نام نکرده ام؟<b style="color: #a7f995;">عضویت</b></a></strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" >

                            <div class="row" >
                                <div class="col col-lg-12" style="text-align: right;">
                                    <input name="text"  class = "btn btn-success" type="submit" value="ورود" id="login_btn"  style="background-color: #a7f995;" />
                                    <button data-dismiss="modal"  type="button" class="btn btn-danger"  style="background-color: #fd265a;">بستن</button>
                                </div>
                            </div>
                            <div class="row" >
                                <div id="area_login_spin" style="text-align: center;color: red;display: none;" ><i  class="fa fa-spinner fa-spin fa-2x " aria-hidden="true" ></i></div>

                                <div class="col col-lg-12" style="color: red;text-align: right;" id="area_login_err">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- ADVERTISe MODAL-->
        <div id="advertiseModal" class="modal fade" role="dialog"  >
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" style="background: #03A9F4;">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"> توجه</h4>
                    </div>
                    <div class="modal-body">
                        <h3>درج آگهی در مکان با ما</h3>

                        <p>جهت درج رایگان آگهی اجاره ویلا و سوئیت - آپارتمان، لازم است كه ابتدا به عنوان كاربر میزبان در سایت <a style="color: green;" onclick="$('#advertiseModal').modal('hide');
                                $('#signUpModal').modal('show');">ثبت نام كنید</a>.</p>

                        <h3>آگهی ویژه در مکان با ما</h3>
                        <p>پس از درج آگهی رایگان، اگر مایل بودید که آگهی شما بیشتر دیده شود می توانید با پرداخت هزینه‌ای مختصر، آگهی خود را ویژه کنید.</p>
                        <p>تعرفه آگهی ویژه در بخش پیشخوان کاربران میزبان درج شده است.</p>
                    </div>

                </div>
            </div>
        </div>

        <!-- ERROR MODAL-->
        <div id="errModal" class="modal fade" role="dialog" >
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" style="background:red;">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">خطا</h4>
                    </div>
                    <div class="modal-body" id="errAlert">
                    </div>
                </div>
            </div>
        </div>

        <!-- OK MODAL-->
        <div id="okModal" class="modal fade" role="dialog" >
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" style="background:green;">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">موفق</h4>
                    </div>
                    <div class="modal-body" id="okAlert">
                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal"  type="button" class="btn btn-success" >تایید</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="okModal3" class="modal fade" role="dialog" >
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" style="background:green;">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">موفق</h4>
                    </div>
                    <div class="modal-body" id="okAlert3">
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="background:url(<?php echo base_url(); ?>/assets/img/unnamed.png) repeat;" >
            <!--<div class="col col-lg-1 col-md-1 col-sm-1 col-xs-1" ></div>-->
            <div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #eee; min-height: 700px;margin-top: 0px;padding-left:55px; padding-top: 10px;padding-right: 25px;">



