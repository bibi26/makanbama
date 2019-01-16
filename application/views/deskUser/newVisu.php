<?php
$type_visu = $this->uri->segment(4);
if ($type_visu == "villa")
{
    $name_visu = "ویلا";
}
else
{
    $name_visu = "سوئیت - آپارتمان";
}
$user = unserialize(get_cookie('MakanBaMa'))['USERID'];
$place = $this->session->userdata('VISUFOLDERNEW');
$user_folder = FCPATH . "\assets\img\upload\\" . $user . "\\" . $place . "\\";
$filename = 'MAIN_' . $user . '.jpg';
$destPath = $user_folder . $filename;
?>
<script>
    function myalert(id, alert) {
    $('#errAlert').html(alert);
            $('#errModal').modal('show');
            $('html, body').animate({
    scrollTop: id.offset().top
    }, 2000);
            setTimeout(function () {
            id.css('border-color', ' red ');
            }, 1000);
            return false;
    }
    function checkForm() {
    if ($('#title').val() == '') {
    myalert($('#title'), 'لطفا عنوان آگهی خود را وارد نمایید.')
            return  false;
    }
    if ($('#optProvince').val() == '') {
    myalert($('#optProvince'), 'لطفا استان را وارد نمایید.');
            return  false;
    }
    if ($('#optCity').val() == '') {
    myalert($('#optCity'), 'لطفا شهرستان را وارد نمایید.');
            return  false;
    }
    if ($('#personsNormal').val() == '') {
    myalert($('#personsNormal'), 'لطفا میانگین ظرفیت را وارد نمایید.');
            return  false;
    }
    if ($('#personsMax').val() == '') {
    myalert($('#personsMax'), 'لطفا حداکثر ظرفیت را وارد نمایید.');
            return  false;
    }
    if ($('#floorCount').val() == '') {
    myalert($('#floorCount'), 'لطفا تعداد طبقات را وارد نمایید.');
            return  false;
    }

    var bd = /^\d{1,2}$/;
            if (!$('#floorCount').val().match(bd))
    {
    myalert($('#floorCount'), 'مقدار وارد شده برای تعداد طبقات صحیح نمی باشد.');
            return false;
    }


    if ($('#roomCount').val() == '') {
    myalert($('#floorCount'), 'لطفا تعداد اتاق را وارد نمایید.');
            return  false;
    }

    var bd = /^\d{1,2}$/;
            if (!$('#roomCount').val().match(bd))
    {
    myalert($('#roomCount'), 'مقدار وارد شده برای تعداد اتاق صحیح نمی باشد.');
            return false;
    }

    if ($('#groundSpace').val() == '') {
    myalert($('#groundSpace'), 'لطفا مساحت زمین را وارد نمایید.');
            return  false;
    }
    var bd = /^\d{1,6}$/;
            if (!$('#roomCount').val().match(bd))
    {
    myalert($('#roomCount'), 'مقدار وارد شده برای مساحت زمین صحیح نمی باشد.');
            return false;
    }
    if ($('#buildingSpace').val() == '') {
    myalert($('#buildingSpace'), 'لطفا مساحت ساختمان را وارد نمایید.');
            return  false;
    }

    if (!$('#buildingSpace').val().match(bd))
    {
    myalert($('#buildingSpace'), 'مقدار وارد شده برای مساحت ساختمان صحیح نمی باشد.');
            return false;
    }
    if ($('#address').val() == '') {
    myalert($('#address'), 'لطفا آدرس را وارد نمایید.');
            return  false;
    }

    return true;
    }

    $(document).ready(function () {

    $('#rentPrice').keyup(function(event) {
    // skip for arrow keys
    if (event.which >= 37 && event.which <= 40) return;
            // format number
            $(this).val(function(index, value) {
    return value
            .replace(/\D/g, "")
            .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            ;
    });
    });
            $("input:checkbox").change(function () {
    var f = $(this).attr("id");
            if ($(this).is(":checked")) {
    $('#contact-form').find('#' + f.toString()).parent().last().css("background-color", "#33ff33");
    } else {
    $('#contact-form').find('#' + f.toString()).parent().last().css("background-color", "#ff0000");
    }
    });
            $("#optProvince").change(function (event) {
    var selected = $('#optProvince').val();
            event.preventDefault();
            $.ajax({
            url: '<?php echo base_url(); ?>mainC/getCity',
                    type: 'post',
                    data: {'provinceId': selected},
            })
            .success(function (resp) {
            var res = jQuery.parseJSON(resp);
                    var items;
                    items += "<option selected value=''>شهرستان . . .</option>";
                    $.each(res.msg, function (index, item)
                    {

                    items += "<option value='" + item.id + "'>" + item.name + "</option>";
                    });
                    $("#optCity").html(items);
            });
    });
    });</script>
<style>
    #itemMenuVisu{
        background: -webkit-linear-gradient(bottom, #7fe0f8, #cef8ff);
        background: -moz-linear-gradient(bottom, #7fe0f8, #cef8ff);
        background: -o-linear-gradient(bottom, #7fe0f8, #cef8ff);
        background: -ms-linear-gradient(bottom, #7fe0f8, #cef8ff);
        font-size: 16px;

        border-right-color: red !important;
        border-right-width: 4px !important;
        border-right-style: solid !important;
    }

</style>
<form method="POST"   action='<?php echo base_url(); ?>deskUser/newVisuC/regist/<?php echo $type_visu; ?>' onsubmit="return checkForm()"  id="contact-form">

    <?php
    if (isset($err))
    {
        echo "<script>$('#errAlert').html('{$err}');$('#errModal').modal('show');</script>";
    }
    ?>
    <div class="panel panel-info">
        <div class="panel-heading my_pnael_head" >
            <h3 class="panel-title panel-danger">اطلاعات کلی <?php echo $name_visu; ?><span style="margin-right: 200px;font-size: 12px;color: #009926;">فیلد های <b style="color: red;font-size: 18px;">*</b> ضروری می باشند.</span></h3>
            <span class="pull-left clickable"><i class="glyphicon glyphicon-minus"></i></span>
        </div>
        <div class="panel-body" style="background-color:white;">
            <div class = "row">
                <div class="col col-lg-6 col-md-6">
                    <div class="row">
                        <div class = "col-lg-12">
                            <input id="fileMain" name="fileMain" class="file" type="file"  />
                            <hr>
                        </div> 
                    </div> 
                    <div class = "row">
                        <div class = "col-lg-12">
                            <div class="form-group">
                                <label class="control-label col-lg-3" for="rentPrice"  style="padding: 0px;"> اجاره روزانه از:<span style="color:red;font-size: 18px;">*</span></label>
                                <div class="col-lg-9">          
                                    <input  class="form-control" id="rentPrice" name="rentPrice"  type="text" style="direction: ltr;" placeholder="مبلغ به تومان درج شود" />
                                </div>
                            </div>
                        </div>  
                    </div>
                    <div class="row">
                        <div class = "col-lg-12">
                            <div class="form-group">
                                <label class="control-label col-lg-3" for="rentPriceDesc" style="padding: 0px;"> توضیحات اجاره:</label>
                                <div class="col-lg-9">          
                                    <textarea class="form-control custom-control" cols="40" rows="7" id="rentPriceDesc" name="rentPriceDesc"> قیمت اعلام شده مربوط به روزهای عادی و تا سقف میانگین ظرفیت میباشد و قیمت در روز های آخر هفته، تعطیلات، مناسبت ها، ایام نوروز و یا نفرات بیش از میانگین ظرفیت، افزایش می یابد.</textarea>     

                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="col col-lg-6 col-md-6">
                    <div class = "row">
                        <div class = "col-lg-12">
                            <div class="form-group">
                                <label class="control-label col-lg-4" for="title" style="padding: 0px;">عنوان:<span style="color:red;font-size: 18px;">*</span></label>
                                <div class="col-lg-8">          
                                    <input  class="form-control" id="title" name="title" autofocus >
                                </div>
                            </div> 
                        </div>  
                    </div>
                    <div class = "row">
                        <div class = "col-lg-12">
                            <div class="form-group">
                                <label class="control-label col-lg-4" for="provicne" style="padding: 0px;">استان:<span style="color:red;font-size: 18px;">*</span></label>
                                <div class="col-lg-8"> 
                                    <select id="optProvince" name="optProvince" class="input-large form-control">
                                        <option value="">نام استان. . .</option>
                                        <?php
                                        if (isset($_province))
                                        {
                                            foreach ($_province as $province)
                                            {
                                                echo "<option value='{$province['id']}'>" . $province['name'] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>

                                </div>
                            </div> 
                        </div> 
                    </div>
                    <div class = "row">
                        <div class = "col-lg-12">
                            <div class="form-group">
                                <label class="control-label col-lg-4" for="city" style="padding: 0px;">شهرستان:<span style="color:red;font-size: 18px;">*</span></label>
                                <div class="col-lg-8">          
                                    <select id="optCity" name="optCity" class="input-large form-control">
                                        <option value="" >شهرستان . . .</option>
                                    </select>
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class = "row">
                        <div class = "col-lg-12">
                            <div class="form-group">
                                <label class="control-label col-lg-4" for="personsNormal" style="padding: 0px;"> میانگین ظرفیت<sub style="color: #005eea;">&nbsp;(نفر)</sub>:<span style="color:red;font-size: 18px;">*</span></label>
                                <div class="col-lg-8">  
                                    <select id="personsNormal" name="personsNormal" class="input-large form-control">
                                        <option value="">میانگین ظرفیت  . . .</option>
                                        <?php
                                        for ($i = 1; $i <= 20; $i++)
                                        {
                                            echo "<option value='{$i}'>$i</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class = "row">
                        <div class = "col-lg-12">
                            <div class="form-group">
                                <label class="control-label col-lg-4" for="personsMax" style="padding: 0px;"> حداکثر ظرفیت<sub style="color: #005eea;">&nbsp;(نفر)</sub>:<span style="color:red;font-size: 18px;">*</span></label>
                                <div class="col-lg-8">  
                                    <select id="personsMax" name="personsMax" class="input-large form-control">
                                        <option value="">ظرفیت حداکثر . . .</option>
                                        <?php
                                        for ($i = 1; $i <= 20; $i++)
                                        {
                                            echo "<option value='{$i}'>$i</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class = "row">
                        <div class = "col-lg-12">
                            <div class="form-group">
                                <label class="control-label col-lg-4" for="floorCount" style="padding: 0px;"> تعداد طبقات:<span style="color:red;font-size: 18px;">*</span></label>
                                <div class="col-lg-8">          
                                    <select id="floorCount" name="floorCount" class="input-large form-control">
                                        <option value=""> تعداد طبقات  . . .</option>
                                        <?php
                                        for ($i = 1; $i <= 10; $i++)
                                        {
                                            echo "<option value='{$i}'>$i</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class = "row">
                        <div class = "col-lg-12">
                            <div class="form-group">
                                <label class="control-label col-lg-4" for="roomCount" style="padding: 0px;">تعداد اتاق:<span style="color:red;font-size: 18px;">*</span></label>
                                <div class="col-lg-8">          
                                    <select id="roomCount" name="roomCount" class="input-large form-control">
                                        <option value=""> تعداد اتاق  . . .</option>
                                        <?php
                                        for ($i = 1; $i <= 10; $i++)
                                        {
                                            echo "<option value='{$i}'>$i</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div> 
                        </div> 
                    </div>
                    <div class = "row">
                        <div class = "col-lg-12">
                            <div class="form-group">
                                <label class="control-label col-lg-4" for="groundSpace" style="padding: 0px;">مساحت زمین<sub style="color: #005eea;">&nbsp;(متر)</sub>:<span style="color:red;font-size: 18px;">*</span></label>
                                <div class="col-lg-8">          
                                    <input  class="form-control" id="groundSpace" name="groundSpace" style="direction: ltr;" >
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class = "row">
                        <div class = "col-lg-12">
                            <div class="form-group">
                                <label class="control-label col-lg-4" for="buildingSpace" style="padding: 0px;">مساحت ساختمان<sub style="color: #005eea;">&nbsp;(متر)</sub>:<span style="color:red;font-size: 18px;">*</span></label>
                                <div class="col-lg-8">          
                                    <input  class="form-control" id="buildingSpace" name="buildingSpace" style="direction: ltr;" >
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class = "row">
                        <div class = "col-lg-12">
                            <div class="form-group">
                                <label class="control-label col-lg-4" for="address" style="padding: 0px;">آدرس :<span style="color:red;font-size: 18px;">*</span></label>
                                <div class="col-lg-8">          
                                    <input  class="form-control" id="address" name="address" style="direction: rtl;" >
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class = "row">
                        <div class = "col-lg-12">
                            <div class="form-group">
                                <label class="control-label col-lg-4" style="padding: 0px;">انشعا های موجود:</label>
                                <div class="col-lg-8">  
                                    <div class="row" >
                                        <div class="col-lg-3" > 
                                            <input type = "checkbox"  name="waterHave" checked><label>&nbsp;آب</label>
                                        </div>
                                        <div class="col-lg-3" style="padding: 0px;"> 
                                            <input type = "checkbox"  name="flashHave" checked><label>&nbsp;برق</label>
                                        </div>
                                        <div class="col-lg-3" style="padding: 0px;"> 
                                            <input type = "checkbox"  name="gasHave" checked><label>&nbsp;گاز</label>
                                        </div>
                                        <div class="col-lg-3" style="padding: 0px;"> 
                                            <input type = "checkbox"  name="phoneHave" checked><label>&nbsp;تلفن</label>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class = "col-lg-12">

                    <input id="fileAdditional" name="fileAdditional" class="file" multiple type="file" >
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-info">
        <div class="panel-heading my_pnael_head" >
            <h3 class="panel-title " style="color:black;">موقعیت ملک</h3>
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
            <h3 class="panel-title" style="color:black;">چشم انداز</h3>
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
                                <span class = "input-group-addon">
                                    <input type = "checkbox" class="checkbox checkbox-success" id="sea" name="sea"> 
                                </span>
                                <input type = "text" class = "form-control" id="sea_" name="sea_">
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
                                <span class = "input-group-addon">
                                    <input type = "checkbox" id="forest" name="forest">
                                </span>
                                <input type = "text" class = "form-control"  id="forest_" name="forest_">
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
                                <span class = "input-group-addon">
                                    <input type = "checkbox"  id="mountain" name="mountain">
                                </span>
                                <input type = "text" class = "form-control"  id="mountain_" name="mountain_">
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
                                <span class = "input-group-addon">
                                    <input type = "checkbox" id="foothill" name="foothill">
                                </span>
                                <input type = "text" class = "form-control" id="foothill_" name="foothill_">
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
                                <span class = "input-group-addon">
                                    <input type = "checkbox" id="lake" name="lake">
                                </span>
                                <input type = "text" class = "form-control" id="lake_" name="lake_">
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
                                <span class = "input-group-addon">
                                    <input type = "checkbox" id="river" name="river">
                                </span>
                                <input type = "text" class = "form-control" id="river_" name="river_">
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
                                <label>شهر</label>
                            </span>
                        </div>
                        <div class = "col-lg-9">
                            <span class = "input-group">
                                <span class = "input-group-addon">
                                    <input type = "checkbox"  id="city" name="city">
                                </span>
                                <input type = "text" class = "form-control"  id="city_" name="city_">
                            </span>  
                        </div> 
                    </div> 
                </div> 
                <div class = "col-lg-6">
                    <div class = "row">
                        <div class = "col-lg-3">
                            <span>
                                <label>روستا</label>
                            </span>
                        </div>
                        <div class = "col-lg-9">
                            <span class = "input-group">
                                <span class = "input-group-addon">
                                    <input type = "checkbox" id="village" name="village">
                                </span>
                                <input type = "text" class = "form-control" id="village_" name="village_">
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
                    <div class = "row">
                        <div class = "col-lg-3">
                            <span>
                                <label>استخر دار</label>
                            </span>
                        </div>
                        <div class = "col-lg-9">
                            <span class = "input-group">
                                <span class = "input-group-addon">
                                    <input type = "checkbox" class="checkbox checkbox-success" id="pool" name="pool"> 
                                </span>
                                <input type = "text" class = "form-control" id="pool_" name="pool_">
                            </span>  
                        </div> 
                    </div> 
                </div> 
                <div class = "col-lg-6">
                    <div class = "row">
                        <div class = "col-lg-3">
                            <span>
                                <label>نزدیک دریا</label>
                            </span>
                        </div>
                        <div class = "col-lg-9">
                            <span class = "input-group">
                                <span class = "input-group-addon">
                                    <input type = "checkbox" id="nearSea" name="nearSea"  class="checkbox_check">
                                </span>
                                <input type = "text" class = "form-control" id="nearSea_" name="nearSea_">
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
                                <label>جنگلی</label>
                            </span>
                        </div>
                        <div class = "col-lg-9">
                            <span class = "input-group">
                                <span class = "input-group-addon">
                                    <input type = "checkbox" id="woodsy" name="woodsy">
                                </span>
                                <input type = "text" class = "form-control" id="woodsy_" name="woodsy_">
                            </span>  
                        </div> 
                    </div> 
                </div> 
                <div class = "col-lg-6">
                    <div class = "row">
                        <div class = "col-lg-3">
                            <span>
                                <label>ییلاق - کوهستانی</label>
                            </span>
                        </div>
                        <div class = "col-lg-9">
                            <span class = "input-group">
                                <span class = "input-group-addon">
                                    <input type = "checkbox" id="mountainous" name="mountainous">
                                </span>
                                <input type = "text" class = "form-control" id="mountainous_" name="mountainous_">
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
                                <label>چسبیده به دریا</label>
                            </span>
                        </div>
                        <div class = "col-lg-9">
                            <span class = "input-group">
                                <span class = "input-group-addon">
                                    <input type = "checkbox" id="veryNearSea" name="veryNearSea">
                                </span>
                                <input type = "text" class = "form-control" id="veryNearSea_" name="veryNearSea_">
                            </span>  
                        </div> 
                    </div> 
                </div> 

            </div>
        </div>
    </div>
    <div class="panel panel-info">
        <div class="panel-heading my_pnael_head">
            <h3 class="panel-title " style="color:black;">حریم خصوصی و امنیت</h3>
            <span class="pull-left clickable"><i class="glyphicon glyphicon-minus"></i></span>
        </div>
        <div class="panel-body">
            <div class = 'row row_property'>
                <div class = "col-lg-6">
                    <div class = "row">
                        <div class = "col-lg-3">
                            <span>
                                <label>داخل شهرک</label>
                            </span>
                        </div>
                        <div class = "col-lg-9">

                            <span class = "input-group">
                                <span class = "input-group-addon">
                                    <input type = "checkbox" class="checkbox checkbox-success" id="intoTwon" name="intoTwon"> 
                                </span>
                                <input type = "text" class = "form-control"  id="intoTwon_" name="intoTwon_">
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
                                <span class = "input-group-addon">
                                    <input type = "checkbox"  id="exclusive" name="exclusive">
                                </span>
                                <input type = "text" class = "form-control"  id="exclusive_" name="exclusive_">
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
                                <label>غیر دربست</label>
                            </span>
                        </div> 
                        <div class = "col-lg-9">
                            <span class = "input-group">
                                <span class = "input-group-addon">
                                    <input type = "checkbox"  id="nonExclusive" name="nonExclusive">
                                </span>
                                <input type = "text" class = "form-control"  id="nonExclusive_" name="nonExclusive_">
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
                                <span class = "input-group-addon"  >
                                    <input type = "checkbox" id="janitor" name="janitor">
                                </span>
                                <input type = "text" class = "form-control" id="janitor_" name="janitor_">
                            </span>  
                        </div> 
                    </div>
                </div>
            </div> 
        </div>
    </div>
    <div class="panel panel-info">
        <div class="panel-heading my_pnael_head">
            <h3 class="panel-title" style="color:black;">امکانات</h3>
            <span class="pull-left clickable"><i class="glyphicon glyphicon-minus"></i></span>
        </div>
        <div class="panel-body">
            <div class = 'row row_property'>
                <div class = "col-lg-6">
                    <div class = "row">
                        <div class = "col-lg-3">
                            <span>
                                <label>کنسول بازی xboxیا ps</label>
                            </span>
                        </div>
                        <div class = "col-lg-9">
                            <span class = "input-group">
                                <span class = "input-group-addon">
                                    <input type = "checkbox" class="checkbox checkbox-success"  id="consoleGames" name="consoleGames"> 
                                </span>
                                <input type = "text" class = "form-control" id="consoleGames_" name="consoleGames_">
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
                                <span class = "input-group-addon">
                                    <input type = "checkbox" id="furniture" name="furniture">
                                </span>
                                <input type = "text" class = "form-control" id="furniture_" name="furniture_">
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
                                <label>میزناهارخوری</label>
                            </span>
                        </div>
                        <div class = "col-lg-9">
                            <span class = "input-group">
                                <span class = "input-group-addon">
                                    <input type = "checkbox" id="diningTable" name="diningTable">
                                </span>
                                <input type = "text" class = "form-control" id="diningTable_" name="diningTable_">
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
                                <span class = "input-group-addon">
                                    <input type = "checkbox" id="tv" name="tv">
                                </span>
                                <input type = "text" class = "form-control" id="tv_" name="tv_">
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
                                <label>آنتن</label>
                            </span>
                        </div>
                        <div class = "col-lg-9">
                            <span class = "input-group">
                                <span class = "input-group-addon">
                                    <input type = "checkbox" id="antenna" name="antenna">
                                </span>
                                <input type = "text" class = "form-control" id="antenna_" name="antenna_">
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
                                <span class = "input-group-addon">
                                    <input type = "checkbox" id="internet" name="internet">
                                </span>
                                <input type = "text" class = "form-control" id="internet_" name="internet_">
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
                                <label>آسانسور</label>
                            </span>
                        </div>
                        <div class = "col-lg-9">
                            <span class = "input-group">
                                <span class = "input-group-addon" >
                                    <input type = "checkbox" id="elevator" name="elevator">
                                </span>
                                <input type = "text" class = "form-control"  id="elevator_" name="elevator_">
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
                                <span class = "input-group-addon" >
                                    <input type = "checkbox" id="soundSystem" name="soundSystem">
                                </span>
                                <input type = "text" class = "form-control" id="soundSystem_" name="soundSystem_">
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
                                <label>جاروبرقی</label>
                            </span>
                        </div>
                        <div class = "col-lg-9">
                            <span class = "input-group">
                                <span class = "input-group-addon">
                                    <input type = "checkbox" id="vacumeCleaner" name="vacumeCleaner">
                                </span>
                                <input type = "text" class = "form-control"  id="vacumeCleaner_" name="vacumeCleaner_">
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
                                <span class = "input-group-addon">
                                    <input type = "checkbox"  id="iron" name="iron">
                                </span>
                                <input type = "text" class = "form-control"  id="iron_" name="iron_">
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
                                <label>کابینت</label>
                            </span>
                        </div>
                        <div class = "col-lg-9">
                            <span class = "input-group">
                                <span class = "input-group-addon">
                                    <input type = "checkbox"   id="cabinet" name="cabinet">
                                </span>
                                <input type = "text" class = "form-control" id="cabinet_" name="cabinet_">
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
                                <span class = "input-group-addon">
                                    <input type = "checkbox" id="kitchenWare" name="kitchenWare">
                                </span>
                                <input type = "text" class = "form-control"  id="kitchenWare_" name="kitchenWare_">
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
                                <label>یخچال</label>
                            </span>
                        </div>
                        <div class = "col-lg-9">
                            <span class = "input-group">
                                <span class = "input-group-addon">
                                    <input type = "checkbox" id="refrigerator" name="refrigerator">
                                </span>
                                <input type = "text" class = "form-control"  id="refrigerator_" name="refrigerator_">
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
                                <span class = "input-group-addon">
                                    <input type = "checkbox" id="dishWasher" name="dishWasher">
                                </span>
                                <input type = "text" class = "form-control" id="dishWasher_" name="dishWasher_">
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
                                <label>ماشین لباسشویی</label>
                            </span>
                        </div>
                        <div class = "col-lg-9">
                            <span class = "input-group">
                                <span class = "input-group-addon">
                                    <input type = "checkbox" id="washingMachine" name="washingMachine">
                                </span>
                                <input type = "text" class = "form-control" id="washingMachine_" name="washingMachine_">
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
                                <span class = "input-group-addon">
                                    <input type = "checkbox" id="microWave" name="microWave">
                                </span>
                                <input type = "text" class = "form-control" id="microWave_" name="microWave_">
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
                                <label>چای ساز</label>
                            </span>
                        </div>
                        <div class = "col-lg-9">
                            <span class = "input-group">
                                <span class = "input-group-addon">
                                    <input type = "checkbox" id="teaMaker" name="teaMaker">
                                </span>
                                <input type = "text" class = "form-control" id="teaMaker_" name="teaMaker_">
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
                                <span class = "input-group-addon">
                                    <input type = "checkbox"  id="waterPurifier" name="waterPurifier">
                                </span>
                                <input type = "text" class = "form-control"  id="waterPurifier_" name="waterPurifier_">
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
                                <label>تخت و سرویس خواب</label>
                            </span>
                        </div>
                        <div class = "col-lg-9">
                            <span class = "input-group">
                                <span class = "input-group-addon">
                                    <input type = "checkbox" id="bed" name="bed">
                                </span>
                                <input type = "text" class = "form-control" id="bed_" name="bed_">
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
                                <span class = "input-group-addon">
                                    <input type = "checkbox" id="bathRoom" name="bathRoom">
                                </span>
                                <input type = "text" class = "form-control" id="bathRoom_" name="bathRoom_">
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
                                <label>سرویس بهداشتی فرنگی</label>
                            </span>
                        </div>
                        <div class = "col-lg-9">
                            <span class = "input-group">
                                <span class = "input-group-addon">
                                    <input type = "checkbox" id="toiletBowls" name="toiletBowls">
                                </span>
                                <input type = "text" class = "form-control" id="toiletBowls_" name="toiletBowls_">
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
                                <span class = "input-group-addon">
                                    <input type = "checkbox"  id="iranianHealthService" name="iranianHealthService">
                                </span>
                                <input type = "text" class = "form-control" id="iranianHealthService_" name="iranianHealthService_">
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
                                <label>استخر سرپوشیده</label>
                            </span>
                        </div>
                        <div class = "col-lg-9">
                            <span class = "input-group">
                                <span class = "input-group-addon">
                                    <input type = "checkbox" id="indoorSwimmingPool" name="indoorSwimmingPool">
                                </span>
                                <input type = "text" class = "form-control" id="indoorSwimmingPool_" name="indoorSwimmingPool_">
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
                                <span class = "input-group-addon">
                                    <input type = "checkbox" id="souna" name="souna">
                                </span>
                                <input type = "text" class = "form-control" id="souna_" name="souna_">
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
                                <label>جکوزی</label>
                            </span>
                        </div>
                        <div class = "col-lg-9">
                            <span class = "input-group">
                                <span class = "input-group-addon">
                                    <input type = "checkbox"   id="jakuzzi" name="jakuzzi">
                                </span>
                                <input type = "text" class = "form-control"  id="jakuzzi_" name="jakuzzi_">
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
                                <span class = "input-group-addon">
                                    <input type = "checkbox" id="outdoorSwimmingPool" name="outdoorSwimmingPool">
                                </span>
                                <input type = "text" class = "form-control" id="outdoorSwimmingPool_" name="outdoorSwimmingPool_">
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
                                <label>دوش داخل حیاط</label>
                            </span>
                        </div>
                        <div class = "col-lg-9">
                            <span class = "input-group">
                                <span class = "input-group-addon">
                                    <input type = "checkbox" id="showerInTheYard" name="showerInTheYard">
                                </span>
                                <input type = "text" class = "form-control"  id="showerInTheYard_" name="showerInTheYard_">
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
                                <span class = "input-group-addon">
                                    <input type = "checkbox"   id="gymEquipment" name="gymEquipment">
                                </span>
                                <input type = "text" class = "form-control"   id="gymEquipment_" name="gymEquipment_">
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
                                <label>صندلی ماساژور</label>
                            </span>
                        </div>
                        <div class = "col-lg-9">
                            <span class = "input-group">
                                <span class = "input-group-addon">
                                    <input type = "checkbox"   id="massageChairs" name="massageChairs">
                                </span>
                                <input type = "text" class = "form-control" id="massageChairs_" name="massageChairs_">
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
                                <label>میز بیلیارد</label>
                            </span>
                        </div>
                        <div class = "col-lg-9">
                            <span class = "input-group">
                                <span class = "input-group-addon">
                                    <input type = "checkbox"  id="poolTable" name="poolTable">
                                </span>
                                <input type = "text" class = "form-control" id="poolTable_" name="poolTable_">
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
                                <span class = "input-group-addon">
                                    <input type = "checkbox"  id="pingPongTable" name="pingPongTable">
                                </span>
                                <input type = "text" class = "form-control"  id="pingPongTable_" name="pingPongTable_">
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
                                <label>فوتبال دستی</label>
                            </span>
                        </div>
                        <div class = "col-lg-9">
                            <span class = "input-group">
                                <span class = "input-group-addon">
                                    <input type = "checkbox"  id="soccer" name="soccer">
                                </span>
                                <input type = "text" class = "form-control"  id="soccer_" name="soccer_">
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
                                <span class = "input-group-addon">
                                    <input type = "checkbox" id="backGammon" name="backGammon">
                                </span>
                                <input type = "text" class = "form-control" id="backGammon_" name="backGammon_">
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
                                <label>میز شطرنج</label>
                            </span>
                        </div>
                        <div class = "col-lg-9">
                            <span class = "input-group">
                                <span class = "input-group-addon">
                                    <input type = "checkbox" id="chestTable" name="chestTable">
                                </span>
                                <input type = "text" class = "form-control" id="chestTable_" name="chestTable_">
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
                                <span class = "input-group-addon">
                                    <input type = "checkbox" id="volleyballCourt" name="volleyballCourt"> 
                                </span>
                                <input type = "text" class = "form-control" id="volleyballCourt_" name="volleyballCourt_">
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
                                <label>زمین فوتبال</label>
                            </span>
                        </div>
                        <div class = "col-lg-9">

                            <span class = "input-group">
                                <span class = "input-group-addon">
                                    <input type = "checkbox" id="footballCourt" name="footballCourt">
                                </span>
                                <input type = "text" class = "form-control"  id="footballCourt_" name="footballCourt_">
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
                                <span class = "input-group-addon">
                                    <input type = "checkbox" id="tennisCourt" name="tennisCourt">
                                </span>
                                <input type = "text" class = "form-control" id="tennisCourt_" name="tennisCourt_">
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
                                <label>زمین بدمینتون</label>
                            </span>
                        </div>
                        <div class = "col-lg-9">
                            <span class = "input-group">
                                <span class = "input-group-addon">
                                    <input type = "checkbox"  id="badmintonCourt" name="badmintonCourt">
                                </span>
                                <input type = "text" class = "form-control"  id="badmintonCourt_" name="badmintonCourt_">
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
                                <span class = "input-group-addon">
                                    <input type = "checkbox"  id="childerenPlayArea" name="childerenPlayArea">
                                </span>
                                <input type = "text" class = "form-control"  id="childerenPlayArea_" name="childerenPlayArea_">
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
                                <label>تراس - بالکن</label>
                            </span>
                        </div>
                        <div class = "col-lg-9">
                            <span class = "input-group">
                                <span class = "input-group-addon">
                                    <input type = "checkbox"  id="terrace" name="terrace">
                                </span>
                                <input type = "text" class = "form-control" id="terrace_" name="terrace_">
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
                                <span class = "input-group-addon">
                                    <input type = "checkbox" id="parking" name="parking">
                                </span>
                                <input type = "text" class = "form-control" id="parking_" name="parking_">
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
                                <label>حیاط</label>
                            </span>
                        </div>
                        <div class = "col-lg-9">
                            <span class = "input-group">
                                <span class = "input-group-addon">
                                    <input type = "checkbox"  id="yard" name="yard">
                                </span>
                                <input type = "text" class = "form-control"  id="yard_" name="yard_">
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
                                <span class = "input-group-addon">
                                    <input type = "checkbox"  id="greenSpace" name="greenSpace">
                                </span>
                                <input type = "text" class = "form-control"  id="greenSpace_" name="greenSpace_">
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
                                <label>آلاچیق</label>
                            </span>
                        </div>
                        <div class = "col-lg-9">
                            <span class = "input-group">
                                <span class = "input-group-addon">
                                    <input type = "checkbox" id="pergola" name="pergola">
                                </span>
                                <input type = "text" class = "form-control" id="pergola_" name="pergola_">
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
                                <span class = "input-group-addon">
                                    <input type = "checkbox" id="barbecue" name="barbecue">
                                </span>
                                <input type = "text" class = "form-control" id="barbecue_" name="barbecue_">
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
                                <label>آب نما</label>
                            </span>
                        </div>
                        <div class = "col-lg-9">
                            <span class = "input-group">
                                <span class = "input-group-addon">
                                    <input type = "checkbox" id="fountain" name="fountain">
                                </span>
                                <input type = "text" class = "form-control" id="fountain_" name="fountain_">
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
                                <span class = "input-group-addon">
                                    <input type = "checkbox"  id="splitCooler" name="splitCooler">
                                </span>
                                <input type = "text" class = "form-control"  id="splitCooler_" name="splitCooler_">
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
                                <label>کولر گازی</label>
                            </span>
                        </div>
                        <div class = "col-lg-9">
                            <span class = "input-group">
                                <span class = "input-group-addon">
                                    <input type = "checkbox" id="gaseCooler" name="gaseCooler">
                                </span>
                                <input type = "text" class = "form-control" id="gaseCooler_" name="gaseCooler_">
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
                                <span class = "input-group-addon">
                                    <input type = "checkbox" id="waterCooler" name="waterCooler">
                                </span>
                                <input type = "text" class = "form-control" id="waterCooler_" name="waterCooler_">
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
                                <label>پنکه سقفی</label>
                            </span>
                        </div>
                        <div class = "col-lg-9">
                            <span class = "input-group">
                                <span class = "input-group-addon">
                                    <input type = "checkbox"   id="ceilingFan" name="ceilingFan">
                                </span>
                                <input type = "text" class = "form-control"  id="ceilingFan_" name="ceilingFan_">
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
                                <span class = "input-group-addon"  >
                                    <input type = "checkbox" id="gasHeater" name="gasHeater">
                                </span>
                                <input type = "text" class = "form-control"  id="gasHeater_" name="gasHeater_">
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
                                <label>شوفاژ</label>
                            </span>
                        </div>
                        <div class = "col-lg-9">
                            <span class = "input-group">
                                <span class = "input-group-addon">
                                    <input type = "checkbox" id="radiators" name="radiators">
                                </span>
                                <input type = "text" class = "form-control" id="radiators_" name="radiators_">
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
                                <label>پکیج دیواری</label>
                            </span>
                        </div>
                        <div class = "col-lg-9">
                            <span class = "input-group">
                                <span class = "input-group-addon">
                                    <input type = "checkbox"  id="wallPackage" name="wallPackage">
                                </span>
                                <input type = "text" class = "form-control" id="wallPackage_" name="wallPackage_">
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
                                <span class = "input-group-addon">
                                    <input type = "checkbox"  id="fireplaceWood" name="fireplaceWood">
                                </span>
                                <input type = "text" class = "form-control"  id="fireplaceWood_" name="fireplaceWood_">
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
                                <label>شومینه گازی</label>
                            </span>
                        </div>
                        <div class = "col-lg-9">
                            <span class = "input-group">
                                <span class = "input-group-addon">
                                    <input type = "checkbox" id="fireplaceGas" name="fireplaceGas">
                                </span>
                                <input type = "text" class = "form-control"  id="fireplaceGas_" name="fireplaceGas_">
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
                                <span class = "input-group-addon">
                                    <input type = "checkbox"  id="oven" name="oven">
                                </span>
                                <input type = "text" class = "form-control" id="oven_" name="oven_">
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
                                <label>سشوار</label>
                            </span>
                        </div>
                        <div class = "col-lg-9">
                            <span class = "input-group">
                                <span class = "input-group-addon">
                                    <input type = "checkbox"  id="hairDryer" name="hairDryer">
                                </span>
                                <input type = "text" class = "form-control" id="hairDryer_" name="hairDryer_">
                            </span>  
                        </div> 
                    </div> 

                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-info">

        <div class="panel-heading my_pnael_head">
            <h3 class="panel-title panel-danger" style="color:black;">توضیحات تکمیلی</h3>
            <span class="pull-left clickable"><i class="glyphicon glyphicon-minus"></i></span>
        </div>
        <div class="panel-body">
            <div class = "row">
                <div class = "col-lg-12">
                    <div class="input-group">
                        <textarea class="form-control custom-control" cols="150" rows="7" id="finalDesc" name="finalDesc"></textarea>     
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a class="btn btn-danger btn-lg" href="<?php echo base_url() . 'deskUser/listVisuC/visu/' . $type_visu; ?>">بازگشت</a>
    <input type="submit" class="btn btn-success btn-lg"  value="ثبت اطلاعات"/>

</form>
<script>


            $('#fileMain').fileinput({
    uploadUrl: '<?php echo base_url(); ?>deskUser/newVisuC/uploadImgMain/upload',
            uploadAsync: true,
            showUpload: false,
            showRemove: false,
            showCaption: false,
            browseLabel: 'انتخاب تصویر اصلی',
            browseClass: "btn btn-danger btn-md",
            dropZoneTitle: '',
            language: 'fa',
            validateInitialCount: true,
            showClose: false,
            initialPreviewAsData: true,
            overwriteInitial: true,
            autoReplace: true,
<?php
if (file_exists($user_folder))
{
    echo "initialPreview: ['" . base_url() . "assets/img/upload/{$user}/{$place}/MAIN_{$place}.jpg'],";
    echo "initialPreviewConfig:[ { 'url' : '" . base_url() . "deskUser/newVisuC/uploadImgMain/delete'}],";
}
else
{
    echo " initialPreview: ['" . base_url() . "assets/img/no-image-1.png']";
}
?>
    }).on("filebatchselected", function (event, files) {
    // trigger upload method immediately after files are selected
    $('#fileMain').fileinput("upload");
    });
            $('#fileAdditional').fileinput({
    uploadUrl: '<?php echo base_url(); ?>deskUser/newVisuC/uploadImgAdditional/upload',
            uploadAsync: true,
            showUpload: false,
            showRemove: false,
            showCaption: false,
            browseLabel: 'انتخاب تصاویر دیگر',
            browseClass: "btn btn-danger btn-md",
            dropZoneTitle: '',
            language: 'fa',
            validateInitialCount: true,
            showClose: false,
            maxFileCount: 12,
            initialPreviewAsData: true,
<?php
if (file_exists($user_folder))
{
    $handle = opendir($user_folder);
    $e = 'initialPreview: [';
    $d = 'initialPreviewConfig: [';
    while (false !== ($file = readdir($handle)))
    {
        if (($file != ".") && ($file != "..") && ($file != "MAIN_{$place}.jpg"))
        {
            $e.= "'" . base_url() . "assets/img/upload/{$user}/{$place}/{$file}',";
            $d.=" { 'url' : '" . base_url() . "deskUser/newVisuC/uploadImgAdditional/delete','key':'{$file}'},";
        }
    }
    echo $e . '],';
    echo $d . '],';
    closedir($handle);
}
?>
    }).on("filebatchselected", function (event, files) {
    $('#fileAdditional').fileinput("upload");
    });</script>
<script>
//            function myMap() {
//
//            var mapCanvas = document.getElementById("map");
//                    var myCenter = new google.maps.LatLng(35.691898, 51.427845);
//                    var mapProp = {center: myCenter, zoom: 8};
//                    var map = new google.maps.Map(mapCanvas, mapProp);
//                    var myMarker = new google.maps.Marker({
//                    position: myCenter,
//                            draggable: true,
//                            animation: google.maps.Animation.BOUNCE,
//                            title: 'Set lat/lon values for this property',
//                    });
//                    google.maps.event.addListener(myMarker, 'dragend', function (evt) {
//                    document.getElementById('lat').value = evt.latLng.lat();
//                            document.getElementById('lng').value = evt.latLng.lng();
//                    });
//                    map.setCenter(myMarker.position);
//                    myMarker.setMap(map);
//            }
</script>
<script type="text/javascript">
            function myMap() {
            var map;
                    var position = new google.maps.LatLng(35.691898, 51.427845); // set your own default location.
                    var myOptions = {
                    zoom: 11,
                            center: position,
                            animation: google.maps.Animation.BOUNCE,
                            title: "شما دقیقا اینجا هستید ، برای تغییر مکان نما، شی زیر را جابجا نمایید.  "

                    };
                    var map = new google.maps.Map(document.getElementById("map"), myOptions);
                    var myMarker = new google.maps.Marker({
                    position: position,
                            draggable: true,
                            zoom: 11,
                            animation: google.maps.Animation.BOUNCE,
                            title: "شما دقیقا اینجا هستید ، برای تغییر مکان نما، شی زیر را جابجا نمایید.  "

                    });
                    google.maps.event.addListener(myMarker, 'dragend', function (evt) {
                    document.getElementById('lat').value = evt.latLng.lat();
                            document.getElementById('lng').value = evt.latLng.lng();
                    });
                    // We send a request to search for the location of the user.  
                    // If that location is found, we will zoom/pan to this place, and set a marker
                    navigator.geolocation.getCurrentPosition(locationFound, locationNotFound);
                    function locationFound(position) {
                    // we will zoom/pan to this place, and set a marker
                    var location = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                            // var accuracy = position.coords.accuracy;

                            map.setCenter(location);
                            var marker = new google.maps.Marker({
                            position: location,
                                    map: map,
                                    zoom: 11,
                                    animation: google.maps.Animation.BOUNCE,
                                    draggable: true,
                                    title: "شما دقیقا اینجا هستید ، برای تغییر مکان نما، شی زیر را جابجا نمایید.  "
                            });
                            // set the value an value of the <input>
                            updateInput(location.lat(), location.lng());
                            // Add a "drag end" event handler
                            google.maps.event.addListener(marker, 'dragend', function() {
                            updateInput(this.position.lat(), this.position.lng());
                            });
                    }

            function locationNotFound() {
            // location not found, you might want to do something here
            }

            }
    function updateInput(lat, lng) {
    document.getElementById('lat').value = lat;
            document.getElementById('lng').value = lng;
    }
//    google.maps.event.addDomListener(window, 'load', myMap);
</script>


<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?callback=myMap&key=AIzaSyDCyDdZc_us4lssx3rBuTV1P5El_Geprcw"></script>
