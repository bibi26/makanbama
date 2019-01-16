<script>
      var activeEl = 2;
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
                    url: '<?php echo base_url(); ?>main/placeC/addToFavorite',
                    type: 'post',
                    data: {'placeID': id,'type':'place'},
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
                    url: '<?php echo base_url(); ?>main/placeC/addToFavorite',
                    type: 'post',
                    data: {'placeID': id,'type':'place'},
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
    });
</script>
<style type="text/css">
    
    .div_show_places{
        background-color: white ;
        -webkit-box-shadow: -2px 6px 12px -1px rgba(0,0,0,0.52);
        -moz-box-shadow: -2px 6px 12px -1px rgba(0,0,0,0.52);
        box-shadow: -2px 6px 12px -1px rgba(0,0,0,0.52);
        margin-bottom: 10px;
    }
    .div_show_places_frame{
        padding: 4px;-webkit-box-shadow: 0px 3px 6px 0px rgba(0,0,0,0.75);
        -moz-box-shadow: 0px 3px 6px 0px rgba(0,0,0,0.75);
        box-shadow: 0px 3px 6px 0px rgba(0,0,0,0.75);
        border: 0px solid #000000;
    }
    .div_show_places_frame img{
        width: 100%;height: 170px;
    }
    .div_show_content{
        padding: 20px;
/*    }
    .search-form .form-group {
        float: right !important;
        transition: all 0.35s, border-radius 0s;
        width: 32px;
        height: 32px;
        background-color: #fff;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
        border-radius: 25px;
        border: 1px solid #ccc;
    }
    .search-form .form-group input.form-control {
        padding-right: 20px;
        border: 0 none;
        background: transparent;
        box-shadow: none;
        display:block;
    }
    .search-form .form-group input.form-control::-webkit-input-placeholder {
        display: none;
    }
    .search-form .form-group input.form-control:-moz-placeholder {
         Firefox 18- 
        display: none;
    }
    .search-form .form-group input.form-control::-moz-placeholder {
         Firefox 19+ 
        display: none;
    }
    .search-form .form-group input.form-control:-ms-input-placeholder {
        display: none;
    }
    .search-form .form-group:hover,
    .search-form .form-group.hover {
        width: 100%;
        border-radius: 4px 25px 25px 4px;
    }
    .search-form .form-group span.form-control-feedback {
        position: absolute;
        top: -1px;
        right: -2px;
        z-index: 2;
        display: block;
        width: 34px;
        height: 34px;
        line-height: 34px;
        text-align: center;
        color: #3596e0;
        left: initial;
        font-size: 14px;
    }*/

</style>
<!--<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-3">
            <form action="" class="search-form">
                <div class="form-group has-feedback">
                    <label for="search" class="sr-only">جستجو</label>
                    <input type="text" class="form-control" name="search" id="search" placeholder="جستجو">
                    <span class="glyphicon glyphicon-search form-control-feedback"></span>
                </div>
            </form>
        </div>
    </div>
</div>-->
<div class="row" style="min-height: 1000px;">   
    <div class="col-lg-1" >

    </div>
    <div class="col-lg-8" >
        <?php
        if (isset($_places) and count($_places) > 0)
        {
            ?>
            <div class="row" >   

                <?php
                foreach ($_places as $_place)
                {
                    ?>
                    <div class="row div_show_places"   >
                        <div class="col-lg-4" style="padding: 8px;" >
                            <div  class="div_show_places_frame">
                                <img  src="<?php echo base_url() . "assets/img/upload/places/{$_place['user_id']}/{$_place['folder']}/MAIN_{$_place['folder']}.jpg"; ?>"/>
                            </div>
                        </div>
                        <div class="col-lg-8 div_show_content"  >
                            <div class="row" style="padding: 0px;margin: 0px; color: #ff3366;">
                            <div class="col-lg-11">
                                <span style="font-size: 20px;"><?php echo $_place['title'] ?></span>
                            </div>
                                          <?php
                                    if (isset($_place["favoriteBuilding"]) and $_place["favoriteBuilding"] != NULL and $_place['favoriteHosteler'] == unserialize(get_cookie('MakanBaMa'))['USERID'])
                                    {
                                        ?>
                                        <div class="col-lg-1"  ><a class="favorite_love" id="fav<?php echo $_place["ID"]; ?>" href="javascript:void(0);" onclick="javascrit:addToFavorite('<?php echo $_place['ID']; ?>');"><div class="alert-danger alert_favorite">لطفا ابتدا وارد سایت شوید!</div></a></div> 

                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <div class="col-lg-1"  ><a class="favorite" id="fav<?php echo $_place["ID"]; ?>" href="javascript:void(0);" onclick="javascrit:addToFavorite('<?php echo $_place["ID"]; ?>');"><div class="alert-danger alert_favorite">لطفا ابتدا وارد سایت شوید!</div></a></div> 
                                        <?php
                                    }
                                    ?>
                            </div>
                            <div class="row" style="padding: 0px;margin: 0px;font-size: 12px;color: #ff3366;">
                                <span><?php echo $_place['_province'] ?> / <?php echo $_place['_city'] ?></span>
                            </div>
                            <div class="row" style="min-height: 106px;">
                                <p style="text-align: justify;font-size: 16px;line-height: 1.5;"><?php echo limitword($_place['description'], 70); ?> . . .<a class="btn btn-info btn-xs" style="position: absolute;left: 0px;bottom: 0px;margin-left: 2px; " href="<?php echo base_url(); ?>main/placeC/detail/<?php echo $_place['id']; ?>">ادامه مطلب</a></p>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <div class="row" >
                <div class="col-lg-1" ></div>
                <div class="col-lg-9" id="pagination" ><?php echo $pages; ?></div>
                <div class="col-lg-3" ></div>
            </div>

        <?php
    }
    else
    {
        ?>
        <div class="row" >
            <div class="col-lg-12" >
                <div class="notice notice-warning notice-lg">
                    <strong><li class="glyphicon glyphicon-remove-circle" style="color: red;"></li>&nbsp;&nbsp;متاسفانه  مطلب گردشگری مورد نظر یافت نشد!</strong>
                </div>
            </div>
        </div>

        <?php
    }
    ?>
        </div>


    <div class="col-lg-3">
        <div class="panel panel-info" style="margin-right: 10px;">
            <div class="panel-heading my_pnael_head" >
                <h3 class="panel-title panel-danger" style="color:black;"><i class="fa fa-search" aria-hidden="true"></i>
                    جستجو بر اساس استان و شهر</h3>
            </div>
            <div class="panel-body" style="background-color:white;">
                <div class = "row">
                    <div class="col col-lg-12 col-md-12">
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
                        <input type="button" value="جستجو" class="btn-info btn-sm" id="btnSearch"/>

                    </div>
                </div>
            </div>
        </div>
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
    echo "$('#optCity').val('" . $srch_city . "');";
}
?>
        $("#btnSearch").click(function (event) {
            var provinceId = $('#optProvince').val();
            var cityId = $('#optCity').val();
            var query = '';
            (provinceId == '') ? query += '' : query += 'prv='+provinceId+'&';
            (cityId == '') ? query += '' : query +='cty='+ cityId+'&';
            window.location = BASE_URL + 'main/placeC/index/?' + query.slice(0,-1);
        });
    });

</script>
