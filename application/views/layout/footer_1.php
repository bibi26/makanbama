
<style>

    .full {
        width: 100%;
    }
    .gap {
        height: 30px;
        width: 100%;
        clear: both;
        display: block;
    }
    .footer {
        background-color: #3a3a3a;	
        position: relative;
        width: 100%;
        border-bottom: 1px solid #CCCCCC;
        border-top: 1px solid #DDDDDD;height: 100%;
        margin: 0px;
    }
    .footer p {
        margin: 0;
    }
    .footer img {
        max-width: 100%;
    }
    .footer h3 {
        color: #fff;
        font-size: 18px;
        font-weight: 600;
        line-height: 27px;
        padding: 40px 0 10px;
        text-transform: uppercase;
    }
    .footer ul {
        font-size: 13px;
        list-style-type: none;
        padding: 0px;
        margin: 0px;
        margin-top: 15px;
        color: #7F8C8D;
    }
    .footer ul li a {
        margin-bottom: 8px;

        display: block;
        color: #d1d1d1;

    }
    .footer ul li a:hover {
/*        text-decoration: none;
        color: #FFFFFF;
        background-color: #3366ff;
        transform: scale(1.15) rotate(360deg);
        -webkit-transform: scale(1.1) rotate(360deg);
        -moz-transform: scale(1.1) rotate(360deg);
        -ms-transform: scale(1.1) rotate(360deg);
        -o-transform: scale(1.1) rotate(360deg);
        border: 2px solid #2c3e50;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        -o-border-radius: 50%;
        -ms-border-radius: 50%;
        border-radius: 50%;
        border-radius: 50%;
        float: left;
        height: 34px;
        line-height: 36px;
        margin: 0 8px 0 0;
        padding: 0;
        text-align: center;
        width: 35px;*/
    }
    .links ul li {
        list-style-type: circle;
        padding-right: 10px;


    }

    .supportLi h4 {
        font-size: 20px;
        font-weight: lighter;
        line-height: normal;
        margin-bottom: 0 !important;
        padding-bottom: 0;
    }
    .newsletter-box input#appendedInputButton {
        background: #FFFFFF;
        display: inline-block;
        float: left;
        height: 30px;
        clear: both;
        width: 100%;
    }
    .newsletter-box .btn {
        border: medium none;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        -o-border-radius: 3px;
        -ms-border-radius: 3px;
        border-radius: 3px;
        display: inline-block;
        height: 40px;
        padding: 0;
        width: 100%;
        color: #fff;
    }
    .newsletter-box {
        overflow: hidden;
    }
    .bg-gray {
        background-image: -moz-linear-gradient(center bottom, #BBBBBB 0%, #F0F0F0 100%);
        box-shadow: 0 1px 0 #B4B3B3;
    }
    .footer-bottom {
        background: #E3E3E3;
        border-top: 1px solid #DDDDDD;
        padding-top: 10px;
        padding-bottom: 10px;
    }
    .footer-bottom p.pull-left {
        padding-top: 6px;
    }
    .payments {
        font-size: 1.5em;
    }



    .back-to-top {
        cursor: pointer;
        position: fixed;
        bottom: 20px;
        right: 20px;
        display:none;
        border-radius: 28px;
        border: 1px white solid;
        background-color: #ff3333;
        z-index: 10000;
    }

</style>
<script>
    $(document).ready(function () {

        $(window).scroll(function () {
            if ($(this).scrollTop() > 50) {
                $('#back-to-top').fadeIn();
            } else {
                $('#back-to-top').fadeOut();
            }
        });
        // scroll body to 0px on click
        $('#back-to-top').click(function () {
            $('#back-to-top').tooltip('hide');
            $('body,html').animate({
                scrollTop: 0
            }, 800);
            return false;
        });

        $('#back-to-top').tooltip('show');

    });
</script>
<div class="row footer" >
    <!--    <div class="col col-lg-3" >
            <div class="row" style="height: 100%;">
                <div class="col col-lg-3" >
                    <div class="row" style="height: 120px;background-color: #444;"></div>
                    <div class="row" ></div>
                </div>
                <div class="col col-lg-9" style="background-color: #555;height: 410px;" >
                    <ul class="social">
                        <li> <a href="#"> <i class=" fa fa-facebook">   </i> </a> </li>
                        <li> <a href="#"> <i class="fa fa-twitter">   </i> </a> </li>
                        <li> <a href="#"> <i class="fa fa-google-plus">   </i> </a> </li>
                        <li> <a href="#"> <i class="fa fa-pinterest">   </i> </a> </li>
                        <li> <a href="#"> <i class="fa fa-youtube">   </i> </a> </li>
                    </ul>
                </div>
            </div>
        </div>-->
    <div class="col col-lg-12">
        <div class="row" >
            <div class="col-lg-1 col-md-1 hidden-sm hidden-xs">
            </div>
            <div class="col col-lg-10">
                <div class="row" style="background-color: #444; padding-top: 25px;">
                    <div class="col-md-12" >
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-lg-4">
                                    <a style="color: white;text-decoration: none;" target="_blank" href="https://telegram.me/makanbama"><img class="pull-right" src="<?php echo base_url() . 'assets/img/telegram.png'; ?>" alt="" title=""></a>

                                </div>
                                <div class="col-lg-8"  style="padding-top: 20px;">
                                    <strong style="color: white;"><a style="color: white;text-decoration: none;" target="_blank" href="https://telegram.me/makanbama">در تلگرام ما را دنبال کنید</a></strong>
                                    <br/>
                                    <span style="color:  #DDDDDD;">معرفی محصولات جدید</span>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-lg-4">
                                    <img class="pull-right" src="<?php echo base_url() . 'assets/img/mail.png'; ?>" alt="" title="">

                                </div>
                                <div class="col-lg-8"  style="padding-top: 20px;">
                                    <strong style="color: white;margin-bottom: 10px;"> نظرات خود را ارسال نمایید</strong>
                                    <br/>

                                    <span style="color: #DDDDDD;">contact@makanbama.ir</span>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-lg-4">
                                    <img class="pull-right" src="<?php echo base_url() . 'assets/img/phone.png'; ?>" alt="" title="">

                                </div>
                                <div class="col-lg-8" style="padding-top: 20px;">
                                    <strong style="color: white;margin-bottom: 10px;" >شماره تماس</strong>
                                    <br/>

                                    <span style="color:  #DDDDDD;">09375065519</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-1 col-md-1 hidden-sm hidden-xs" >
            </div>
        </div>
        <div class="row">
            <div class="col col-lg-1" >
            </div>
            <div class="col col-lg-8">
                <div class="row links">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                        <h3>مکان با ما</h3>
                        <ul>
                            <li> <a  href="<?php echo base_url() . 'contactC/'; ?>"> تماس با ما </a> </li>
                            <li> <a href="<?php echo base_url() . 'aboutC/'; ?>">درباره مکان با ما </a> </li>
                            <li> <a href="<?php echo base_url() . 'whyMakanBamaC/'; ?>">چرا مکان با ما</a> </li>
                        </ul>
                    </div>
                    <div class="col-lg-3  col-md-3 col-sm-3 col-xs-3">
                        <h3>شرایط استفاده</h3>
                        <ul>
                            <li> <a href="<?php echo base_url() . 'lawC/'; ?>">قوانین و مقررات</a> </li>
                            <li> <a href="<?php echo base_url() . 'securityC/'; ?>">شرایط و رازداری</a> </li>
                            <li> <a href="<?php echo base_url() . 'warningC/'; ?>">هشدار مکان با ما</a> </li>
                        </ul>
                    </div>
                    <div class="col-lg-3  col-md-3 col-sm-3 col-xs-3">
                        <h3>راهنما</h3>
                        <ul>
                            <li> <a href="<?php echo base_url() . 'howToRegisterC/'; ?>">نحوه ثبت نام</a> </li>
                            <li> <a href="<?php echo base_url() . 'questionsC/'; ?>">سوالات متداول</a> </li>
                        </ul>
                    </div>
                    <div class="col-lg-3  col-md-3 col-sm-3 col-xs-3">
                        <h3>تبلیغات در سایت</h3>
                        <ul>
                            <li> <a href="<?php echo base_url() . 'advertisingC/'; ?>">درج آگهی در مکان با ما</a> </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col col-lg-3" style="padding-top: 50px;">
                <img class="pull-right " src="<?php echo base_url() . 'assets/img/namad.png'; ?>" alt="" title="" >

            </div>
        </div>
        <div class="row" style="height: 25px;margin-top: 40px;padding: 8px;">
            <div class="col-lg-1  col-md-1 col-sm-1 col-xs-1 "></div>
            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 ">
                <div  style="border-top:1px #7F8C8D solid;text-align: center;"><b style="color:white;">www.makanbama.ir Copyright © 1395</b></div>
            </div>
            <div class="col-lg-1  col-md-1 col-sm-1 col-xs-1 "></div>
        </div>
    </div>
</div>
<a id="back-to-top" href="#" class="btn btn-danger btn-lg back-to-top" role="button" title="برای رفتن به بالای صفحه کلیک کنید." data-toggle="tooltip" data-placement="left"><span class="glyphicon glyphicon-chevron-up"></span></a>
</body>
</html>

