<?php
$type_visu=$this->uri->segment(4);
?>
<script>
  <?php
    if($type_visu=='villa')
       {
              $visu_name="ویلا";

       ?>
               var activeEl = 1;

           <?php
       }
       elseif($type_visu=='suit'){
                  $visu_name="سوئیت - آپارتمان";

           ?>
                   var activeEl = 0;

               <?php
       }
   ?> 
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

    return true;
    }
    $(document).ready(function () {
        
     $('#rentPrice').keyup(function(event) {
  // skip for arrow keys
  if(event.which >= 37 && event.which <= 40) return;

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
    #itemMenu<?php echo $type_visu;?>{
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
<?php
if (isset($err))
{
    echo "<script>$('#errAlert').html('{$err}');$('#errModal').modal('show');</script>";
}
?>
<?php
if (isset($result))
{
    $o     = array();
    $o     = $result['info'];
    $user  = unserialize(get_cookie('MakanBaMa'))['USERID'];
    $place = $o['folder'];

    $user_folder = FCPATH . "\assets\img\upload\\" . $user . "\\" . $place . "\\";
    $filename    = 'MAIN_' . $o['folder'] . '.jpg';
    $destPath    = $user_folder . $filename;
    ?>
<form method="POST"   action='<?php echo base_url(); ?>deskUser/editVisuC/regist/<?php echo $type_visu; ?>' onsubmit="return checkForm()"  id="contact-form">

        <div class="panel panel-info">
            <div class="panel-heading my_pnael_head" >
                <h3 class="panel-title panel-danger">اطلاعات کلی <?php echo $visu_name; ?><span style="margin-right: 200px;font-size: 12px;color: #009926;">فیلد های <b style="color: red;font-size: 18px;">*</b> ضروری می باشند.</span></h3>
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
                                        <input  class="form-control" id="rentPrice" name="rentPrice"  type="text" value="<?php echo number_format($o['rent_price']); ?>" style="direction: ltr;" placeholder="مبلغ به تومان درج شود" />

                                    </div>
                                </div>
                            </div>  
                        </div>
                        <div class="row">
                            <div class = "col-lg-12">
                                <div class="form-group">
                                    <label class="control-label col-lg-3" for="rentPriceDesc" style="padding: 0px;"> توضیحات اجاره:</label>
                                    <div class="col-lg-9">          
                                        <textarea class="form-control custom-control" cols="40" rows="7" id="rentPriceDesc" name="rentPriceDesc" ><?php echo $o['rent_price_desc']; ?></textarea>     

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
                                        <input  class="form-control" id="title" name="title" autofocus value="<?php echo $o['title']; ?>">
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
                                            <option value="">استان . . .</option>

                                            <?php
                                            if (isset($result))
                                            {
                                                foreach ($result['_province'] as $province)
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
                                            <option value="">شهرستان . . .</option>

                                            <?php
                                            if (isset($result))
                                            {
                                                foreach ($result['_city'] as $city)
                                                {
                                                    echo "<option value='{$city['id']}'>" . $city['name'] . "</option>";
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
                                    <label class="control-label col-lg-4" for="personsNormal" style="padding: 0px;"> میانگین ظرفیت <sub style="color: #005eea;">&nbsp;(نفر)</sub>:<span style="color:red;font-size: 18px;">*</span></label>
                                    <div class="col-lg-8">  
                                        <select id="personsNormal" name="personsNormal" class="input-large form-control">
                                            <option value="">میانگین ظرفیت . . .</option>
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
                                        <input  class="form-control" id="groundSpace" name="groundSpace" value="<?php echo $o['ground_space']; ?>" style="direction: ltr;" >
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <div class = "row" >
                            <div class = "col-lg-12">
                                <div class="form-group">
                                    <label class="control-label col-lg-4" for="buildingSpace" style="padding: 0px;">مساحت ساختمان<sub style="color: #005eea;">&nbsp;(متر)</sub>:<span style="color:red;font-size: 18px;">*</span></label>
                                    <div class="col-lg-8">          
                                        <input  class="form-control" id="buildingSpace" name="buildingSpace" value="<?php echo $o['building_space']; ?>" style="direction: ltr;" >
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <div class = "row">
                            <div class = "col-lg-12">
                                <div class="form-group">
                                    <label class="control-label col-lg-4" for="address" style="padding: 0px;"> آدرس:<span style="color:red;font-size: 18px;">*</span></label>
                                    <div class="col-lg-8">          
                                        <input  class="form-control" id="address" name="address" value="<?php echo $o['address']; ?>" style="direction: ltr;" >
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <div class = "row">
                            <div class = "col-lg-12">
                                <div class="form-group">
                                    <label class="control-label col-lg-4" style="padding: 0px;">انشعا های موجود:</label>
                                    <div class="col-lg-8">  
                                        <div class="row">
                                            <div class="col-lg-3" style="padding: 0px;"> 

                                                <?php
                                                if ($o['water_have'] == 1)
                                                {
                                                    ?> 
                                                <input type = "checkbox"  name="waterHave" checked><label>&nbsp;آب</label>
                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                <input type = "checkbox"  name="waterHave" ><label>&nbsp;آب</label>

                                                    <?php
                                                }
                                                ?>

                                            </div>
                                            <div class="col-lg-3" style="padding: 0px;"> 

                                                <?php
                                                if ($o['water_have'] == 1)
                                                {
                                                    ?> 
                                                <input type = "checkbox"  name="flashHave" checked><label>&nbsp;برق</label>
                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                    <input type = "checkbox"  name="flashHave" ><label>&nbsp;برق</label>

                                                    <?php
                                                }
                                                ?>

                                            </div>
                                            <div class="col-lg-3" style="padding: 0px;"> 

                                                <?php
                                                if ($o['water_have'] == 1)
                                                {
                                                    ?> 
                                                <input type = "checkbox"  name="gasHave" checked><label>&nbsp;گاز</label>
                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                <input type = "checkbox"  name="gasHave" ><label>&nbsp;گاز</label>

                                                    <?php
                                                }
                                                ?>

                                            </div>
                                            <div class="col-lg-3" style="padding: 0px;"> 

                                                <?php
                                                if ($o['water_have'] == 1)
                                                {
                                                    ?> 
                                                <input type = "checkbox"  name="phoneHave" checked><label>&nbsp;تلفن</label>
                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                <input type = "checkbox"  name="phoneHave" ><label>&nbsp;تلفن</label>

                                                    <?php
                                                }
                                                ?>

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
                                    <?php
                                    if ($o['sea'] == 1)
                                    {
                                        ?> 
                                        <span class = "input-group-addon" style="background-color: #33ff33;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="sea" name="sea" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="sea_" name="sea_" value="<?php echo $o['sea_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="sea" name="sea"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="sea_" name="sea_" >
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="forest" name="forest" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="forest_" name="forest_" value="<?php echo $o['forest_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="forest" name="forest"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="forest_" name="forest_" >
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="mountain" name="mountain" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="mountain_" name="mountain_" value="<?php echo $o['mountain_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="mountain" name="mountain" > 
                                        </span>
                                        <input type = "text" class = "form-control" id="mountain_" name="mountain_" >
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="foothill" name="foothill" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="forest_" name="forest_" value="<?php echo $o['foothill_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="foothill" name="foothill"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="foothill_" name="foothill_" >
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
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="lake" name="lake" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="lake_" name="lake_" value="<?php echo $o['lake_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="lake" name="lake"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="lake_" name="lake_" >
                                        <?php
                                    }
                                    ?>
                                </span>   
                            </div> 
                        </div> 
                    </div> 
                    <div class = "col-lg-6">
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="river" name="river" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="river_" name="river_" value="<?php echo $o['river_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="river" name="river"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="river_" name="river_" >
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
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="city" name="city" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="city_" name="city_" value="<?php echo $o['city_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="city" name="city"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="city_" name="city_" >
                                        <?php
                                    }
                                    ?>
                                </span> 

                            </div> 
                        </div> 
                    </div>
                    <div class = "col-lg-6">
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="village" name="village" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="village_" name="village_" value="<?php echo $o['village_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="village" name="village"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="village_" name="village_" >
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
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="pool" name="pool" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="pool_" name="pool_" value="<?php echo $o['pool_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="pool" name="pool"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="pool_" name="pool_" >
                                        <?php
                                    }
                                    ?>
                                </span> 
                            </div> 
                        </div> 
                    </div> 
                    <div class = "col-lg-6">
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="nearsea" name="nearsea" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="nearsea_" name="nearsea_" value="<?php echo $o['nearsea_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="nearsea" name="nearsea"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="nearsea_" name="nearsea_" >
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
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="woodsy" name="woodsy" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="woodsy_" name="woodsy_" value="<?php echo $o['woodsy_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="woodsy" name="woodsy"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="woodsy_" name="woodsy_" >
                                        <?php
                                    }
                                    ?>
                                </span>  
                            </div>
                        </div>
                    </div>

                    <div class = "col-lg-6">
                        <div class = 'row '>
                            <div class = "col-lg-3">
                                <span>
                                    <label>ییلاق - کوهستانی</label>
                                </span>
                            </div>
                            <div class = "col-lg-9">

                                <span class = "input-group">
                                    <?php
                                    if ($o['mountainous'] == 1)
                                    {
                                        ?> 
                                        <span class = "input-group-addon" style="background-color: #33ff33;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="mountainous" name="mountainous" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="mountainous_" name="mountainous_" value="<?php echo $o['mountainous_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="mountainous" name="mountainous"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="mountainous_" name="mountainous_" >
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
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="veryNearsea" name="veryNearsea" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="veryNearsea_" name="veryNearsea_"value="<?php echo $o['very_nearsea_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="veryNearsea" name="veryNearsea"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="veryNearsea_" name="veryNearsea_" >
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
                <h3 class="panel-title " style="color:black;">حریم خصوصی و امنیت</h3>
                <span class="pull-left clickable"><i class="glyphicon glyphicon-minus"></i></span>
            </div>
            <div class="panel-body">
                <div class = 'row row_property'>
                    <div class = "col-lg-6">
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="intotwon" name="intotwon" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="intotwon_" name="intotwon_" value="<?php echo $o['into_twon_']; ?>" >

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="intotwon" name="intotwon"  > 
                                        </span>
                                        <input type = "text" class = "form-control" id="intotwon_" name="intotwon_">
                                        <?php
                                    }
                                    ?>
                                </span>  
                            </div> 
                        </div> 
                    </div> 
                    <div class = "col-lg-6">
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="exclusive" name="exclusive" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="exclusive_" name="exclusive_" value="<?php echo $o['exclusive_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="exclusive" name="exclusive"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="exclusive_" name="exclusive_">
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
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="nonexclusive" name="nonexclusive" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="nonexclusive_" name="nonexclusive_" value="<?php echo $o['nonexclusive_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="nonexclusive" name="nonexclusive"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="nonexclusive_" name="nonexclusive_" >
                                        <?php
                                    }
                                    ?>
                                </span>
                            </div> 
                        </div> 
                    </div> 
                    <div class = "col-lg-6">
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="janitor" name="janitor" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="janitor_" name="janitor_" value="<?php echo $o['janitor_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="janitor" name="janitor"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="janitor_" name="janitor_" >
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
                <h3 class="panel-title" style="color:black;">امکانات</h3>
                <span class="pull-left clickable"><i class="glyphicon glyphicon-minus"></i></span>
            </div>
            <div class="panel-body">
                <div class = 'row row_property'>
                    <div class = "col-lg-6">
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="consoleGames" name="consoleGames" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="consoleGames_" name="consoleGames_" value="<?php echo $o['console_games_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="consoleGames" name="consoleGames"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="consoleGames_" name="consoleGames_">
                                        <?php
                                    }
                                    ?>
                                </span>
                            </div> 
                        </div> 
                    </div> 
                    <div class = "col-lg-6">
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="furniture" name="furniture" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="furniture_" name="furniture_" value="<?php echo $o['furniture_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="furniture" name="furniture"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="furniture_" name="furniture_" >
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
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="diningTable" name="diningTable" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="diningTable_" name="diningTable_" value="<?php echo $o['dining_table_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="diningTable" name="diningTable"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="diningTable_" name="diningTable_" >
                                        <?php
                                    }
                                    ?>
                                </span>  
                            </div> 
                        </div> 
                    </div> 
                    <div class = "col-lg-6">
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="tv" name="tv" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="tv_" name="tv_" value="<?php echo $o['tv_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="tv" name="tv"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="tv_" name="tv_">
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
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="antenna" name="antenna" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="antenna_" name="antenna_" value="<?php echo $o['antenna_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="antenna" name="antenna"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="antenna_" name="antenna_">
                                        <?php
                                    }
                                    ?>
                                </span>  
                            </div> 
                        </div>
                    </div>

                    <div class = "col-lg-6">
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="internet" name="internet" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="internet_" name="internet_" value="<?php echo $o['internet_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="internet" name="internet"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="internet_" name="internet_" >
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
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="elevator" name="elevator" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="elevator_" name="elevator_" value="<?php echo $o['elevator_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="elevator" name="elevator"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="elevator_" name="elevator_">
                                        <?php
                                    }
                                    ?>
                                </span>  
                            </div> 
                        </div> 
                    </div> 
                    <div class = "col-lg-6">
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="soundSystem" name="soundSystem" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="soundSystem_" name="soundSystem_" value="<?php echo $o['sound_system_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="soundSystem" name="soundSystem"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="soundSystem_" name="soundSystem_" >
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
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="vacumeCleaner" name="vacumeCleaner" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="vacumeCleaner_" name="vacumeCleaner_" value="<?php echo $o['vacume_cleaner_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="vacumeCleaner" name="vacumeCleaner"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="vacumeCleaner_" name="vacumeCleaner_">
                                        <?php
                                    }
                                    ?>
                                </span> 
                            </div> 
                        </div> 
                    </div> 
                    <div class = "col-lg-6">
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="iron" name="iron" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="iron_" name="iron_" value="<?php echo $o['iron_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="iron" name="iron"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="iron_" name="iron_">
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
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="cabinet" name="cabinet" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="cabinet_" name="cabinet_" value="<?php echo $o['cabinet_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="cabinet" name="cabinet"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="cabinet_" name="cabinet_" >
                                        <?php
                                    }
                                    ?>
                                </span>  
                            </div> 
                        </div> 
                    </div> 
                    <div class = "col-lg-6">
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="kitchenWare" name="kitchenWare" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="kitchenWare_" name="kitchenWare_" value="<?php echo $o['kitchen_ware_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="kitchenWare" name="kitchenWare"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="kitchenWare_" name="kitchenWare_">
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
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="refrigerator" name="refrigerator" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="refrigerator_" name="refrigerator_" value="<?php echo $o['refrigerator_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="refrigerator" name="refrigerator"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="refrigerator_" name="refrigerator_">
                                        <?php
                                    }
                                    ?>
                                </span>

                            </div> 
                        </div> 
                    </div> 
                    <div class = "col-lg-6">
                        <div class = 'row '>
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
                                        <input type = "text" class = "form-control" id="dishWasher_" name="dishWasher_" value="<?php echo $o['dish_washer_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="dishWasher" name="dishWasher"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="dishWasher_" name="dishWasher_" >
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
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="washingMachine" name="washingMachine" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="washingMachine_" name="washingMachine_" value="<?php echo $o['washing_machine_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="washingMachine" name="washingMachine"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="washingMachine_" name="washingMachine_">
                                        <?php
                                    }
                                    ?>
                                </span> 
                            </div> 
                        </div> 
                    </div> 
                    <div class = "col-lg-6">
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="microwave" name="microwave" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="microwave_" name="microwave_" value="<?php echo $o['microwave_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="microwave" name="microwave"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="microwave_" name="microwave_">
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
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="teaMaker" name="teaMaker" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="teaMaker_" name="teaMaker_" value="<?php echo $o['tea_maker_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="teaMaker" name="teaMaker"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="teaMaker_" name="teaMaker_">
                                        <?php
                                    }
                                    ?>
                                </span>
                            </div> 
                        </div> 
                    </div> 
                    <div class = "col-lg-6">
                        <div class = 'row '>
                            <div class = "col-lg-3">
                                <span>
                                    <label>دستگاه تصفیه آب خانگی</label>
                                </span>
                            </div>                            <div class = "col-lg-9">

                                <span class = "input-group">
                                    <?php
                                    if ($o['water_purifier'] == 1)
                                    {
                                        ?> 
                                        <span class = "input-group-addon" style="background-color: #33ff33;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="waterPurifier" name="waterPurifier" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="waterPurifier_" name="waterPurifier_" value="<?php echo $o['water_purifier_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="waterPurifier" name="waterPurifier"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="waterPurifier_" name="waterPurifier_" >
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
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="bed" name="bed" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="bed_" name="bed_" value="<?php echo $o['bed_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="bed" name="bed"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="bed_" name="bed_">
                                        <?php
                                    }
                                    ?>
                                </span> 
                            </div> 
                        </div> 
                    </div> 
                    <div class = "col-lg-6">
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="bathroom" name="bathroom" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="bathroom_" name="bathroom_" value="<?php echo $o['bathroom_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="bathroom" name="bathroom"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="bathroom_" name="bathroom_" >
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
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="toiletBowls" name="toiletBowls" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="toiletBowls_" name="toiletBowls_" value="<?php echo $o['toilet_bowls_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="toiletBowls" name="toiletBowls"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="toiletBowls_" name="toiletBowls_" >
                                        <?php
                                    }
                                    ?>
                                </span>
                            </div> 
                        </div> 
                    </div> 
                    <div class = "col-lg-6">  
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="iranianHealthService" name="iranianHealthService" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="iranianHealthService_" name="iranianHealthService_" value="<?php echo $o['iranian_health_service_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="iranianHealthService" name="iranianHealthService"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="iranianHealthService_" name="iranianHealthService_">
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
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="indoorSwimmingPool" name="indoorSwimmingPool" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="indoorSwimmingPool_" name="indoorSwimmingPool_" value="<?php echo $o['indoor_swimming_pool_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="indoorSwimmingPool" name="indoorSwimmingPool"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="indoorSwimmingPool_" name="indoorSwimmingPool_" >
                                        <?php
                                    }
                                    ?>
                                </span>
                            </div> 
                        </div> 
                    </div> 
                    <div class = "col-lg-6">
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="souna" name="souna" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="souna_" name="souna_" value="<?php echo $o['souna_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="souna" name="souna"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="souna_" name="souna_">
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
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="jakuzzi" name="jakuzzi" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="jakuzzi_" name="jakuzzi_" value="<?php echo $o['jakuzzi_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="jakuzzi" name="jakuzzi"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="jakuzzi_" name="jakuzzi_" >
                                        <?php
                                    }
                                    ?>
                                </span>  
                            </div> 
                        </div> 
                    </div> 
                    <div class = "col-lg-6">
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="outdoorSwimmingPool" name="outdoorSwimmingPool" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="outdoorSwimmingPool_" name="outdoorSwimmingPool_" value="<?php echo $o['outdoor_swimming_pool_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="outdoorSwimmingPool" name="outdoorSwimmingPool"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="outdoorSwimmingPool_" name="outdoorSwimmingPool_">
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
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="showerInTheYard" name="showerInTheYard" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="showerInTheYard_" name="showerInTheYard_" value="<?php echo $o['shower_in_the_yard_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="showerInTheYard" name="showerInTheYard"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="showerInTheYard_" name="showerInTheYard_">
                                        <?php
                                    }
                                    ?>
                                </span> 
                            </div> 
                        </div> 
                    </div> 
                    <div class = "col-lg-6">
                        <div class = 'row '>

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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="gymEquipment" name="gymEquipment" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="gymEquipment_" name="gymEquipment_" value="<?php echo $o['gym_equipment_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="gymEquipment" name="gymEquipment"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="gymEquipment_" name="gymEquipment_" >
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
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="massageChairs" name="massageChairs" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="massageChairs_" name="massageChairs_" value="<?php echo $o['massage_chairs_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="massageChairs" name="massageChairs"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="massageChairs_" name="massageChairs_">
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
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="poolTable" name="poolTable" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="poolTable_" name="poolTable_" value="<?php echo $o['pool_table_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="poolTable" name="poolTable"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="poolTable_" name="poolTable_" >
                                        <?php
                                    }
                                    ?>
                                </span> 
                            </div> 
                        </div> 
                    </div> 
                    <div class = "col-lg-6">  
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="pingpongTable" name="pingpongTable" checked> 
                                        </span>
                                        <input type = "tex" class = "form-control" id="pingpongTable_" name="pingpongTable_" value="<?php echo $o['pingpong_table_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="pingpongTable" name="pingpongTable"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="pingpongTable_" name="pingpongTable_">
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
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="soccer" name="soccer" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="soccer_" name="soccer_" value="<?php echo $o['soccer_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="soccer" name="soccer"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="soccer_" name="soccer_" >
                                        <?php
                                    }
                                    ?>
                                </span> 
                            </div> 
                        </div> 
                    </div> 
                    <div class = "col-lg-6">        
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="backGammon" name="backGammon" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="backGammon_" name="backGammon_" value="<?php echo $o['back_gammon_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="backGammon" name="backGammon"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="backGammon_" name="backGammon_" >
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
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="chestTable" name="chestTable" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="chestTable_" name="chestTable_" value="<?php echo $o['chest_table_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="chestTable" name="chestTable"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="chestTable_" name="chestTable_">
                                        <?php
                                    }
                                    ?>
                                </span> 
                            </div> 
                        </div> 
                    </div> 
                    <div class = "col-lg-6">
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="volleyballCourt" name="volleyballCourt" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="volleyballCourt_" name="volleyballCourt_" value="<?php echo $o['volleyball_court_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="volleyballCourt" name="volleyballCourt"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="volleyballCourt_" name="volleyballCourt_" >
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
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="footballCourt" name="footballCourt" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="footballCourt_" name="footballCourt_" value="<?php echo $o['football_court_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="footballCourt" name="footballCourt"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="footballCourt_" name="footballCourt_" >
                                        <?php
                                    }
                                    ?>
                                </span> 
                            </div> 
                        </div> 
                    </div> 
                    <div class = "col-lg-6">
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="tennisCourt" name="tennisCourt" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="tennisCourt_" name="tennisCourt_" value="<?php echo $o['tennis_court_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="tennisCourt" name="tennisCourt"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="tennisCourt_" name="tennisCourt_">
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
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="badmintonCourt" name="badmintonCourt" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="badmintonCourt_" name="badmintonCourt_" value="<?php echo $o['badminton_court_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="badmintonCourt" name="badmintonCourt"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="badmintonCourt_" name="badmintonCourt_">
                                        <?php
                                    }
                                    ?>
                                </span> 
                            </div> 
                        </div> 
                    </div> 
                    <div class = "col-lg-6">
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="childerenPlayArea" name="childerenPlayArea" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="childerenPlayArea_" name="childerenPlayArea_" value="<?php echo $o['childeren_play_area_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="childerenPlayArea" name="childerenPlayArea"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="childerenPlayArea_" name="childerenPlayArea_">
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
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="terrace" name="terrace" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="terrace_" name="terrace_" value="<?php echo $o['terrace_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="terrace" name="terrace"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="terrace_" name="terrace_">
                                        <?php
                                    }
                                    ?>
                                </span> 
                            </div> 
                        </div> 
                    </div> 
                    <div class = "col-lg-6">
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="parking" name="parking" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="parking_" name="parking_" value="<?php echo $o['parking_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="parking" name="parking"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="parking_" name="parking_" >
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
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="yard" name="yard" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="yard_" name="yard_" value="<?php echo $o['yard_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="yard" name="yard"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="yard_" name="yard_" >
                                        <?php
                                    }
                                    ?>  
                                </span> 
                            </div> 
                        </div> 
                    </div> 
                    <div class = "col-lg-6">
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="greenSpace" name="greenSpace" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="greenSpace_" name="greenSpace_" value="<?php echo $o['green_space_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="greenSpace" name="greenSpace"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="greenSpace_" name="greenSpace_" >
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
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="pergola" name="pergola" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="pergola_" name="pergola_" value="<?php echo $o['pergola_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="pergola" name="pergola"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="pergola_" name="pergola_" >
                                        <?php
                                    }
                                    ?>  
                                </span> 
                            </div> 
                        </div> 
                    </div> 
                    <div class = "col-lg-6">
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="barbecue" name="barbecue" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="barbecue_" name="barbecue_"  value="<?php echo $o['barbecue_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="barbecue" name="barbecue"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="barbecue_" name="barbecue_" >
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
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="fountain" name="fountain" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="fountain_" name="fountain_" value="<?php echo $o['fountain_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="fountain" name="fountain"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="fountain_" name="fountain_" >
                                        <?php
                                    }
                                    ?>  
                                </span> 
                            </div> 
                        </div> 
                    </div> 
                    <div class = "col-lg-6">   
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="splitCooler" name="splitCooler" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="splitCooler_" name="splitCooler_" value="<?php echo $o['split_cooler_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="splitCooler" name="splitCooler"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="splitCooler_" name="splitCooler_">
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
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="gasCooler" name="gasCooler" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="gasCooler_" name="gasCooler_" value="<?php echo $o['gase_cooler_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="gasCooler" name="gasCooler"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="gasCooler" name="gasCooler_" >
                                        <?php
                                    }
                                    ?>  
                                </span>
                            </div> 
                        </div> 
                    </div> 
                    <div class = "col-lg-6"> 
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="waterCooler" name="waterCooler" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="waterCooler_" name="waterCooler_" value="<?php echo $o['water_cooler_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="waterCooler" name="waterCooler"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="waterCooler_" name="waterCooler_">
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
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="ceilingFan" name="ceilingFan" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="ceilingFan_" name="ceilingFan_" value="<?php echo $o['ceiling_fan_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="ceilingFan" name="ceilingFan"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="ceilingFan_" name="ceilingFan_">
                                        <?php
                                    }
                                    ?>  
                                </span> 
                            </div> 
                        </div> 
                    </div> 
                    <div class = "col-lg-6">
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="gasHeater" name="gasHeater" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="gasHeater_" name="gasHeater_" value="<?php echo $o['gas_heater_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="gasHeater" name="gasHeater"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="gasHeater_" name="gasHeater_">
                                        <?php
                                    }
                                    ?>  
                                </span>  
                            </div> 
                        </div> 
                    </div> 
                    <div class = "col-lg-6">
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="radiators" name="radiators" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="radiators_" name="radiators_" value="<?php echo $o['radiators_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="radiators" name="radiators"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="radiators_" name="radiators_">
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
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="wallPackage" name="wallPackage" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="wallPackage_" name="wallPackage_" value="<?php echo $o['wall_package_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="wallPackage" name="wallPackage"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="wallPackage_" name="wallPackage_">
                                        <?php
                                    }
                                    ?>  
                                </span>
                            </div> 
                        </div> 
                    </div> 
                    <div class = "col-lg-6">
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="fireplaceWood" name="fireplaceWood" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="fireplaceWood_" name="fireplaceWood_" value="<?php echo $o['fireplace_wood_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="fireplaceWood" name="fireplaceWood"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="fireplaceWood_" name="fireplaceWood_">
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
                        <div class = 'row '>
                            <div class = "col-lg-3">
                                <span>
                                    <label>شومینه گازی</label>
                                </span>
                            </div>                            <div class = "col-lg-9">

                                <span class = "input-group">
                                    <?php
                                    if ($o['fireplace_gas'] == 1)
                                    {
                                        ?> 
                                        <span class = "input-group-addon" style="background-color: #33ff33;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="fireplaceGas" name="fireplaceGas" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="fireplaceGas_" name="fireplaceGas_" value="<?php echo $o['fireplace_gas_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="fireplaceGas" name="fireplaceGas"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="fireplaceGas_" name="fireplaceGas_">
                                        <?php
                                    }
                                    ?>  
                                </span>
                            </div> 
                        </div> 
                    </div> 
                    <div class = "col-lg-6">
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="oven" name="oven" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="oven_" name="hairdryer_" value="<?php echo $o['oven_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="oven" name="oven"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="oven_" name="oven_">
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
                        <div class = 'row '>
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
                                            <input type = "checkbox" class="checkbox checkbox-success" id="hairdryer" name="hairdryer" checked> 
                                        </span>
                                        <input type = "text" class = "form-control" id="hairdryer_" name="hairdryer_" value="<?php echo $o['hairdryer_']; ?>">

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class = "input-group-addon" style="background-color: #ff0000;">
                                            <input type = "checkbox" class="checkbox checkbox-success" id="hairdryer" name="hairdryer"> 
                                        </span>
                                        <input type = "text" class = "form-control" id="hairdryer_" name="hairdryer_">
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
                <h3 class="panel-title panel-danger" style="color:black;">توضیحات تکمیلی</h3>
                <span class="pull-left clickable"><i class="glyphicon glyphicon-minus"></i></span>
            </div>
            <div class="panel-body">
                <div class = "row">
                    <div class = "col-lg-12">
                        <div class="input-group">
                            <textarea class="form-control custom-control" cols="150" rows="7" id="finalDesc" name="finalDesc"><?php echo $o['final_desc']; ?></textarea>     
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <a class="btn btn-danger btn-lg" href="<?php echo base_url() . 'deskUser/listVisuC/visu/'.$type_visu; ?>">بازگشت</a>
        <input type="submit" class="btn btn-success btn-lg"  value="ویرایش اطلاعات"/>


    </form>
    <script>
                function myMap() {

                var mapCanvas = document.getElementById("map");
                        var myCenter = new google.maps.LatLng(<?php echo $o['lat']; ?>, <?php echo $o['lng']; ?>);
                        var mapProp = {center: myCenter, zoom: 11};
                        var map = new google.maps.Map(mapCanvas, mapProp);
                        var myMarker = new google.maps.Marker({
                        position: myCenter,
                                draggable: true,
                                animation: google.maps.Animation.BOUNCE,
                                                            zoom: 11,
                            title: "شما دقیقا اینجا هستید ، برای تغییر مکان نما، شی زیر را جابجا نمایید.  "
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

    <script>
            $(document).ready(function () {
    $('#optProvince').val('<?php echo $o['province_id']; ?>');
            $('#optCity').val('<?php echo $o['city_id']; ?>');
            $('#personsNormal').val('<?php echo $o['persons_normal']; ?>');
            $('#personsMax').val('<?php echo $o['persons_max']; ?>');
            $('#roomCount').val('<?php echo $o['room_count']; ?>');
            $('#floorCount').val('<?php echo $o['floor_count']; ?>');
            
    });</script>
    <?php
}
?>
<script>
            $('#fileMain').fileinput({
    uploadUrl: '<?php echo base_url(); ?>deskUser/editvisuC/uploadImgMain/upload',
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
            uploadExtraData: { 'fn': <?php echo $o['folder']; ?>},
<?php
if (file_exists($destPath))
{
    echo "initialPreview: ['" . base_url() . "assets/img/upload/{$user}/{$place}/MAIN_{$place}.jpg'],";
    echo "initialPreviewConfig:[ { 'url' : '" . base_url() . "deskUser/editvisuC/uploadImgMain/delete','key': '" . $o['folder'] . "'}],";
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
    uploadUrl: '<?php echo base_url(); ?>deskUser/editvisuC/uploadImgAdditional/upload',
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
            uploadExtraData: { 'fn': <?php echo $o['folder']; ?>},
<?php
if(file_exists($user_folder)){
    $fi = new FilesystemIterator($user_folder, FilesystemIterator::SKIP_DOTS);
    if (iterator_count($fi) != 0)
{
    if ($handle = opendir($user_folder))
    {
        $e = 'initialPreview: [';
        $d = 'initialPreviewConfig: [';

        while (false !== ($file = readdir($handle)))
        {
            if (($file != ".") && ($file != "..") && ($file != "MAIN_{$o['folder']}.jpg"))
            {
                $e.= "'" . base_url() . "assets/img/upload/{$user}/{$place}/{$file}',";
                $param= $file.','.$place;
                $d.=" { 'url' : '" . base_url() . "deskUser/editvisuC/uploadImgAdditional/delete','key':'{$param}'},";
            }
        }
        echo $e . '],';
        echo $d . '],';
        closedir($handle);
    }
}
}


?>
    }).on("filebatchselected", function (event, files) {
    $('#fileAdditional').fileinput("upload");
    });
</script>
