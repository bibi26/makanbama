<?php
$type_visu = $this->uri->segment(4);
?>
<script type="text/javascript">
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
?>

    function addCommas(nStr)
    {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }
    $(function () {
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
                    data: {'ID': id, 'type': '<?php echo $type_visu ?>'},
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
                    data: {'ID': id, 'type': '<?php echo $type_visu ?>'},
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
        $('#example-multiple-selected').multiselect({
            buttonWidth: '100%',
            nonSelectedText: 'امکانات و ویژگی ها ',
        });
        $("#amount").slider({});
        $("#rooms").slider({});
        $("#persons").slider({});


        $("#amount").on("slide", function (slideEvt) {
            var convertToDash = slideEvt.value;
            $("#amount_label").text(addCommas(convertToDash[1]) + ' - ' + addCommas(convertToDash[0]));
        });


        $("#rooms").on("slide", function (slideEvt) {
            var convertToDash = slideEvt.value;
            $("#rooms_label").text(convertToDash[1] + ' - ' + convertToDash[0]);
        });


        $("#persons").on("slide", function (slideEvt) {
            var convertToDash = slideEvt.value;
            $("#persons_label").text(convertToDash[1] + ' - ' + convertToDash[0]);
        });

        $(".product_img").hover(function () {
//            $(this).find('.product_img').hide();
            $(this).find('.product_img_hover').show();
            $(this).find('.circle').css('background-color', 'red');

        }, function () {
            $(this).find('.product_img').show();
            $(this).find('.circle').css('background-color', '#8fe0f5');

            $(this).find('.product_img_hover').hide();
        }
        );




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
                        items += "<option value='' selected>همه شهر ها</option>";
                        $.each(res.msg, function (index, item)
                        {
                            items += "<option value='" + item.id + "'>" + item.name + "</option>";
                        });
                        $("#optCity").html(items);
                    });
        });

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
<style>

    .product{
        height: 380px;margin-bottom: 35px;padding-right: 25px;

    }
    .product_row_main{
        height: 380px;background-color: white;      -webkit-box-shadow: -2px 6px 12px -1px rgba(0,0,0,0.52);
        -moz-box-shadow: -2px 6px 12px -1px rgba(0,0,0,0.52);
        box-shadow: -2px 6px 12px -1px rgba(0,0,0,0.52);
    }

    .product_img{
        height: 270px;margin: 0px;padding: 0px;position: relative; 
    }
    .product_img_hover{
        height: 270px;margin: 0px;padding: 10px;display: none;background-color: black;color: #005eea;opacity: .8;position: absolute;top: 0px;
    }

    .product_title{
        height: 35px;font-size: 20px;padding-top: 5px;color: black;
    }
    .triangle_logo {
        position: absolute;
        right: 0px;
        top: 0px;   
        border-left: 30px solid transparent;
        border-bottom: 30px solid transparent;
        border-right: 30px solid #ff5a5f ;   
        border-top: 30px solid #ff5a5f;
        opacity: .7;  
    }   
    .triangle_text {
        font-size: 16px;
        color: white;
        position: absolute;
        top: 15px;
        right: -5px;
        transform: rotate(+45deg);
        -ms-transform: rotate(+45deg);
        -moz-transform: rotate(+45deg);
        -o-transform: rotate(+45deg);
        -webkit-transform: rotate(+45deg);
    }   

    .circle { 
        width: 90px;
        height: 30px;
        padding: 2px;
        background: #ff5a5f;
        text-align: center;

        -moz-border-radius-bottomleft:  15px; 
        -moz-border-radius-bottomright: 15px; 
        -moz-border-radius-bottomleft:  15px; 
        -moz-border-radius-bottomright: 15px; 
        -webkit-border-bottom-left-radius: 15px;
        -webkit-border-bottom-right-radius: 15px;
        -moz-border-top-left-radius:  15px; 
        -moz-border-top-right-radius:  15px; 
        -moz-border-top-left-radius:  15px; 
        -moz-border-top-right-radius:  15px; 
        -webkit-border-top-left-radius: 15px;
        -webkit-border-top-right-radius: 15px;
    }

    .circle_text{
        color: floralwhite;font-size: 18px;
    }
    .product_feature{color: white;font-size: 14px;text-align: center;}
    .search_area{
        height: auto; 
        background-color:white;
        border: 1px solid #b0dbf4;
        margin-bottom: 10px;
        padding: 10px 0;
    }

    .multiselect-container , .dropdown-menu{
        padding: 5px;border: 1px black solid;
        width: 100%;
    }

    #btnSearch{
        background-color: #437def;
    }
</style>
<div class="row" style="min-height: 800px;">
    <div class="col-lg-1 col-md-1 col-sm-2 col-xs-1" >
    </div>
    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-10" >
        <div class="row search_area" >
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
                <div class="row">
                    <div class="col-lg-3" >
                        <div class="form-group">
                            <div class="col-lg-12"> 
                                <select id="optProvince" name="optProvince" class="input-large form-control">
                                    <option value=''>همه استان ها</option>
                                    <?php
                                    if (isset($_province))
                                    {
                                        foreach ($_province as $province)
                                        {
                                            echo "<option value='{$province['id']}' >" . $province['name'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>

                            </div>
                        </div> 
                    </div>
                    <div class="col-lg-3" >
                        <div class="form-group">
                            <div class="col-lg-12">          
                                <select id="optCity" name="optCity" class="input-large form-control">
                                    <option value='' selected>همه شهر ها</option>

                                    <?php
                                    if (isset($_city))
                                    {
                                        foreach ($_city as $city)
                                        {
                                            echo "<option value='{$city['id']}'>" . $city['name'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>   

                    <div class="col-lg-3" >
                        <div class="form-group">
                            <div class="col-lg-12" >
                                <select  class="input-large form-control" id="priority" name="priority">
                                    <option value=''>به ترتیب . . .</option>
                                    <option value='newest'>به روز ترین</option>
                                    <option value='expensive'>گرانترین</option>
                                    <option value='cheapest'>ارزانترین</option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-3" >
                        <div class="form-group">
                            <div class="col-lg-12">    
                                <select id="example-multiple-selected"  name="example-multiple-selected[]" multiple="multiple">
                                    <option value="pool" <?php echo set_select('example-multiple-selected', 'pool'); ?> >استخر دار </option>
                                    <option value="nearsea" <?php echo set_select('example-multiple-selected', 'nearsea'); ?> >نزدیک دریا</option>
                                    <option value="woodsy" <?php echo set_select('example-multiple-selected', 'woodsy'); ?> >جنگلی</option>
                                    <option value="very_nearsea" <?php echo set_select('example-multiple-selected', 'very_nearsea'); ?> >چسبیده به دریا</option>
                                    <option value="jakuzzi" <?php echo set_select('example-multiple-selected', 'jakuzzi'); ?> >جکوزی</option>
                                    <option value="sounapool_table" <?php echo set_select('example-multiple-selected', 'souna'); ?> >سونا</option>
                                    <option value="very_nearsea" <?php echo set_select('example-multiple-selected', 'pool_table'); ?> >میز بیلیارد</option>
                                    <option value="gym_equipment" <?php echo set_select('example-multiple-selected', 'gym_equipment'); ?> >وسایل بدنسازی</option>
                                    <option value="fountain" <?php echo set_select('example-multiple-selected', 'fountain'); ?> >آب نما</option>
                                    <option value="fireplace_wood" <?php echo set_select('example-multiple-selected', 'fireplace_wood'); ?> >شومینه هیزمی</option>
                                    <option value="pergola" <?php echo set_select('example-multiple-selected', 'pergola'); ?> >آلاچیق </option>
                                </select>
                            </div>
                        </div>
                    </div>








                </div>
                <div class="row">


                    <div class="col-lg-3" >
                        <div class="row">
                            <div class="col-lg-12" style="text-align: center;">
                                <label class="control-label ">محدوده قیمت<sub style="color: #666666;">&nbsp;&nbsp;(تومان)</sub></label>&nbsp;&nbsp;[<b id="amount_label" style="font-size: 12px;" ><?php
                                    if (isset($srch_amount))
                                    {
                                        $e = explode('-', $srch_amount);
                                        echo number_format($e[0]) . "-" . number_format($e[1]);
                                    }
                                    ?></b>]<br/>
                                <input id="amount" type="amount"  style="width: 100%;" class="span2" value="" data-slider-min="100000" data-slider-max="3000000" data-slider-step="100000" data-slider-value="[<?php
                                if (isset($srch_amount))
                                {
                                    $e = explode('-', $srch_amount);
                                    echo $e[0] . "," . $e[1];
                                }
                                else
                                {
                                    echo "100000,3000000";
                                }
                                ?>]"/> 

                            </div>
                        </div>
                    </div>


                    <div class="col-lg-3" >
                        <div class="row">
                            <div class="col-lg-12" style="text-align: center;">
                                <label class="control-label " >تعداد افراد</label>&nbsp;&nbsp;[<b id="persons_label" style="font-size: 12px;"><?php
                                    if (isset($srch_person))
                                    {
                                        $e = explode('-', $srch_person);
                                        echo "$e[0]-$e[1]";
                                    }
                                    ?></b>]<br/>
                                <input id="persons" type="persons" style="width: 100%;" class="span2" value="" data-slider-min="1" data-slider-max="20" data-slider-step="2" data-slider-value="[<?php
                                if (isset($srch_person))
                                {
                                    $e = explode('-', $srch_person);
                                    echo "$e[0],$e[1]";
                                }
                                else
                                {
                                    echo "1,20";
                                }
                                ?>]"/>
                            </div>
                        </div>

                    </div>


                    <div class="col-lg-3" >
                        <div class="row">
                            <div class="col-lg-12" style="text-align: center;">
                                <label class="control-label ">تعداد اتاق</label>&nbsp;&nbsp;[<b id="rooms_label" style="font-size: 12px;"><?php
                                    if (isset($srch_room))
                                    {
                                        $e = explode('-', $srch_room);
                                        echo "$e[0]-$e[1]";
                                    }
                                    ?></b>]<br/>
                                <input id="rooms" type="rooms" style="width: 100%;" class="span2"  data-slider-min="1" data-slider-max="10" data-slider-step="1" data-slider-value="[<?php
                                if (isset($srch_room))
                                {
                                    $e = explode('-', $srch_room);
                                    echo "$e[0],$e[1]";
                                }
                                else
                                {
                                    echo "1,10";
                                }
                                ?>]" />
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-3" >
                        <div class="row">
                            <div class="col-lg-12" >

                                <input type="button" value="جستجو" class="btn-info btn-sm" id="btnSearch"/>

                            </div>
                        </div>
                    </div>
                </div>
                <br/>
            </div>
        </div>
        <div id="spin" style="    display:    none;
             position:   fixed;
             z-index:    1000;
             top:        0;
             left:       0;
             height:     100%;
             width:      100%;
             background: rgba( 255, 255, 255, .8 ) 
             url('<?php echo base_url() . 'assets/img/ajax-loader2.gif'; ?>') 
             50% 50% 
             no-repeat;"></div>

        <?php
        $b = base_url();
        if (isset($_visu) and count($_visu) > 0)
        {
            ?>
            <div class="row" id="divShowVisu">
                <?php
                foreach ($_visu as $_visu_row)
                {
                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 product" >
                        <div class="row">
                            <div class="col-lg-12 product_row_main" >
                                <div class="row">
                                    <a href="<?php echo base_url() . "main/visuC/detail/$type_visu/" . $_visu_row['ID']; ?>">
                                        <div class="col-lg-12 product_img" >
                                            <span class="triangle_logo"></span>
                                            <span class="triangle_text">مکان با ما</span>
                                            <?php
                                            echo "<img alt='{$_visu_row["title"]}' style='height: 270px;width:100%;' src='{$b}assets/img/upload/{$_visu_row['user_id']}/{$_visu_row['folder']}/MAIN_{$_visu_row['folder']}.jpg'/>";
                                            ?>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 product_img_hover" >
                                                <div class="row">
                                                    <div class="col-lg-4"  style="color: white;"><span class="glyphicon glyphicon-<?php
                                                        if ($_visu_row["nearsea"])
                                                            echo 'check';
                                                        else
                                                            echo 'unchecked';
                                                        ?>" style="color: <?php
                                                                                                       if ($_visu_row["nearsea"])
                                                                                                           echo 'greenyellow';
                                                                                                       else
                                                                                                           echo 'red';
                                                                                                       ?>;"></span>&nbsp;نزدیک دریا</div> 
                                                    <div class="col-lg-4"  style="color: white;"><span class="glyphicon glyphicon-<?php
                                                        if ($_visu_row["very_nearsea"])
                                                            echo 'check';
                                                        else
                                                            echo 'unchecked';
                                                        ?>" style="color: <?php
                                                                                                       if ($_visu_row["very_nearsea"])
                                                                                                           echo 'greenyellow';
                                                                                                       else
                                                                                                           echo 'red';
                                                                                                       ?>;"></span>&nbsp;چسبیده به دریا</div> 
                                                    <div class="col-lg-4"  style="color: white;"><span class="glyphicon glyphicon-<?php
                                                        if ($_visu_row["woodsy"])
                                                            echo 'check';
                                                        else
                                                            echo 'unchecked';
                                                        ?>" style="color: <?php
                                                                                                       if ($_visu_row["woodsy"])
                                                                                                           echo 'greenyellow';
                                                                                                       else
                                                                                                           echo 'red';
                                                                                                       ?>;"></span>&nbsp;جنگلی</div> 

                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-4"  style="color: white;"><span class="glyphicon glyphicon-<?php
                                                        if ($_visu_row["pool"])
                                                            echo 'check';
                                                        else
                                                            echo 'unchecked';
                                                        ?>" style="color: <?php
                                                                                                       if ($_visu_row["pool"])
                                                                                                           echo 'greenyellow';
                                                                                                       else
                                                                                                           echo 'red';
                                                                                                       ?>;"></span>&nbsp;استخر دار</div> 
                                                    <div class="col-lg-4"  style="color: white;"><span class="glyphicon glyphicon-<?php
                                                        if ($_visu_row["jakuzzi"])
                                                            echo 'check';
                                                        else
                                                            echo 'unchecked';
                                                        ?>" style="color: <?php
                                                                                                       if ($_visu_row["jakuzzi"])
                                                                                                           echo 'greenyellow';
                                                                                                       else
                                                                                                           echo 'red';
                                                                                                       ?>;">
                                                        </span>&nbsp;جکوزی</div> 
                                                    <div class="col-lg-4"  style="color: white;">
                                                        <span class="glyphicon glyphicon-<?php
                                                        if ($_visu_row["pool_table"])
                                                            echo 'check';
                                                        else
                                                            echo 'unchecked';
                                                        ?>" style="color: <?php
                                                              if ($_visu_row["pool_table"])
                                                                  echo 'greenyellow';
                                                              else
                                                                  echo 'red';
                                                              ?>;">
                                                        </span>&nbsp;میز بیلیارد</div> 

                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-4"  style="color: white;"><span class="glyphicon glyphicon-<?php
                                                        if ($_visu_row["souna"])
                                                            echo 'check';
                                                        else
                                                            echo 'unchecked';
                                                        ?>" style="color: <?php
                                                                                                       if ($_visu_row["souna"])
                                                                                                           echo 'greenyellow';
                                                                                                       else
                                                                                                           echo 'red';
                                                                                                       ?>;"></span>&nbsp;سونا</div> 
                                                    <div class="col-lg-4"  style="color: white;"><span class="glyphicon glyphicon-<?php
                                                        if ($_visu_row["gym_equipment"])
                                                            echo 'check';
                                                        else
                                                            echo 'unchecked';
                                                        ?>" style="color: <?php
                                                                                                       if ($_visu_row["gym_equipment"])
                                                                                                           echo 'greenyellow';
                                                                                                       else
                                                                                                           echo 'red';
                                                                                                       ?>;">
                                                        </span>&nbsp;وسایل بدنسازی</div> 
                                                    <div class="col-lg-4"  style="color: white;">
                                                        <span class="glyphicon glyphicon-<?php
                                                        if ($_visu_row["fountain"])
                                                            echo 'check';
                                                        else
                                                            echo 'unchecked';
                                                        ?>" style="color: <?php
                                                              if ($_visu_row["fountain"])
                                                                  echo 'greenyellow';
                                                              else
                                                                  echo 'red';
                                                              ?>;">
                                                        </span>&nbsp;آب نما</div> 

                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-4"  style="color: white;"><span class="glyphicon glyphicon-<?php
                                                        if ($_visu_row["fireplace_wood"])
                                                            echo 'check';
                                                        else
                                                            echo 'unchecked';
                                                        ?>" style="color: <?php
                                                                                                       if ($_visu_row["fireplace_wood"])
                                                                                                           echo 'greenyellow';
                                                                                                       else
                                                                                                           echo 'red';
                                                                                                       ?>;"></span>&nbsp;شومینه هیزمی</div> 
                                                    <div class="col-lg-4"  style="color: white;"><span class="glyphicon glyphicon-<?php
                                                        if ($_visu_row["pergola"])
                                                            echo 'check';
                                                        else
                                                            echo 'unchecked';
                                                        ?>" style="color: <?php
                                                                                                       if ($_visu_row["pergola"])
                                                                                                           echo 'greenyellow';
                                                                                                       else
                                                                                                           echo 'red';
                                                                                                       ?>;">
                                                        </span>&nbsp;آلاچیق</div> 
                                                    <div class="col-lg-4"  style="color: white;">
                                                    </div> 

                                                </div>
                                                <hr class="hr_blue" >
                                                <div class="row product_feature">
                                                    <div class="col-lg-3"><?php echo $_visu_row["building_space"]; ?><br>مساحت</div> 
                                                    <div class="col-lg-3"><?php echo $_visu_row["floor_count"]; ?><br>طبقه</div> 
                                                    <div class="col-lg-3"><?php echo $_visu_row["room_count"]; ?><br>اتاق</div> 
                                                    <div class="col-lg-3"><?php echo $_visu_row["persons_normal"] . ' - ' . $_visu_row["persons_max"]; ?><br>ظرفیت</div> 
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="row">
                                    <a href="<?php echo base_url() . "main/visuC/detail/{$type_visu}/" . $_visu_row['ID']; ?>">
                                        <div class="col-lg-12 product_title" ><?php echo $_visu_row["title"]; ?></div> 
                                    </a>
                                </div>
                                <div class="row">
                                    <div class="col-lg-8" style="padding-top: 10px;">
                                        <span class=" glyphicon glyphicon-map-marker" style="color: #ff5a5f;">
                                        </span><?php echo $_visu_row["city"]; ?>
                                    </div>
                                    <?php
                                    if (isset($_visu_row["favoriteBuilding"]) and $_visu_row["favoriteBuilding"] != NULL and $_visu_row['favoriteHosteler'] == unserialize(get_cookie('MakanBaMa'))['USERID'])
                                    {
                                        ?>
                                        <div class="col-lg-2"  ><a class="favorite_love" id="fav<?php echo $_visu_row["ID"]; ?>" href="javascript:void(0);" onclick="javascrit:addToFavorite('<?php echo $_visu_row["ID"]; ?>');"><div class="alert-danger alert_favorite">لطفا ابتدا وارد سایت شوید!</div></a></div> 

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <div class="col-lg-2"  ><a class="favorite" id="fav<?php echo $_visu_row["ID"]; ?>" href="javascript:void(0);" onclick="javascrit:addToFavorite('<?php echo $_visu_row["ID"]; ?>');"><div class="alert-danger alert_favorite">لطفا ابتدا وارد سایت شوید!</div></a></div> 
                                        <?php
                                    }
                                    ?>
                                    <div class="col-lg-2" >
                                        <i class="fa fa-star fa-2x" aria-hidden="true" style="color: #ff5a5f;"></i>
                                    </div>

                                </div>
                                <div class="row" style="margin-top: 5px;border-top:1px #efefef solid;padding: 4px;padding-right: 0px; background-color: white;">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" ><div class='circle' ><span  class='circle_text' ><?php echo $_visu_row["rent_discount"]; ?>%</span><span style="color: white;">&nbsp;تخفیف</span></div></div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="row" style="line-height: .6;">
                                            <div class="col-lg-12" style="color: #45ef7e;font-size: 24px;text-align: center;font-weight: bolder;"><?php echo number_format($_visu_row["rent_final"]); ?><span style="font-size: 12px;">تومان</span></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12" style="font-size: 16px;text-align: center;" ><del><?php echo number_format($_visu_row["rent_price"]); ?></del></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>

            </div>
            <div class="row" >
                <div class="col-lg-12" id="pagination" ><?php echo $pages; ?></div>
            </div>

            <?php
        }
        else
        {
            ?>
            <div class="notice notice-warning notice-lg">
                <strong><li class="glyphicon glyphicon-remove-circle" style="color: red;"></li>&nbsp;&nbsp;متاسفانه  <?php echo $visu_name; ?> مورد نظر یافت نشد!</strong>
            </div>
            <?php
        }
        ?>
    </div>
    <div class="col-lg-1 col-md-1 col-sm-2 col-xs-2" >
    </div>
</div>

<script>
    $(document).ready(function () {
<?php
if (isset($srch_province))
{
    echo "$('#optProvince').val('" . $srch_province . "');";
}

if (isset($srch_city))
{
    echo "$('#optProvince').val('" . $_Province_city . "');";
    echo "$('#optCity').val('" . $srch_city . "');";
}
if (isset($srch_priority))
{
    echo "$('#priority').val('" . $srch_priority . "');";
}
if (isset($srch_property))
{
    ?>
            var data = '<?php echo $srch_property; ?>';
            var dataarray = data.split("-");
            $("#example-multiple-selected").val(dataarray);
            $("#example-multiple-selected").multiselect("refresh");
    <?php
}
?>

        function rep(val, search, replacement) {
            return val.split(search).join(replacement);
        }
        $("#btnSearch").click(function (event) {
            var provinceId = $('#optProvince').val();
            var cityId = $('#optCity').val();
            var amount = $('#amount_label').html();
            var rooms = $('#rooms_label').html();
            var persons = $('#persons_label').html();
            var property = $('#example-multiple-selected').val();
            var priority = $('#priority').val();
            var query = '';
            var am = rep(amount, ',', '').replace(/\s+/g, "").split('-');
            var amo = am[1] + '-' + am[0];
            var ro = rooms.replace(/\s+/g, "").split('-');
            var roo = ro[1] + '-' + ro[0];
            var pe = persons.replace(/\s+/g, "").split('-');
            var per = pe[1] + '-' + pe[0];
            (provinceId == '') ? query += '' : query += 'prv=' + provinceId + '&';
            (cityId == '') ? query += '' : query += 'cty=' + cityId + '&';
            (amount == '') ? query += '' : query += 'amt=' + amo + '&';
            (rooms == '') ? query += '' : query += 'rom=' + roo + '&';
            (persons == '') ? query += '' : query += 'prs=' + per + '&';
            (property == '' || property == null) ? query += '' : query += 'prt=' + property.toString() + '&';
            (priority == '') ? query += '' : query += 'pri=' + priority + '&';
            window.location = BASE_URL + 'main/visuC/visu/<?php echo $type_visu; ?>/?' + query.slice(0, -1);
        });
    });

</script>
