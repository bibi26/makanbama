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
                    data: {'placeID': id, 'type': 'place'},
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
                    data: {'placeID': id, 'type': 'place'},
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
    });
</script>
<style type="text/css">
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

    .triangle_logo {
        position: absolute;right: 0px;top: 0px;   
        border-left: 30px solid transparent;
        border-bottom: 30px solid transparent;
        border-right: 30px solid #66ccff;   
        border-top: 30px solid #66ccff;
        opacity: .7;    }   
    .triangle_text {
        font-size: 16px;color: white;
        position: absolute;
        top: 8px;
        right: 3px;
        transform: rotate(+45deg);
        -ms-transform: rotate(+45deg);
        -moz-transform: rotate(+45deg);
        -o-transform: rotate(+45deg);
        -webkit-transform: rotate(+45deg);
    }   

    .circle { 
        width: 50px;
        height: 50px;
        background: #8fe0f5;
        -moz-border-radius: 25px; 
        -webkit-border-radius: 25px;
        border-radius: 25px;
    }



</style>

</head>

<?php
if (isset($_detailPlace))
{
    $o = array();
    $o = $_detailPlace[0];
    ?>
    <div class="row">
        <div class="col col-lg-1"></div>
        <div class="col col-lg-7">
            <div class="row" style="background-color:white;         -webkit-box-shadow: -2px 6px 12px -1px rgba(0,0,0,0.52);
                 -moz-box-shadow: -2px 6px 12px -1px rgba(0,0,0,0.52);
                 box-shadow: -2px 6px 12px -1px rgba(0,0,0,0.52);margin: 3px;margin-bottom: 10px; ">
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
                                <div class="col-lg-1"></div>
                                <div class="col-lg-10">
                                    <div class='carousel-outer'>
                                        <div class='carousel-inner'>
                                            <div class='item active'>
                                                <img src="<?php echo base_url() . 'assets/img/upload/places/' . $o['user_id'] . '/' . $o['folder'] . '/MAIN_' . $o['folder'] . '.jpg'; ?>" style="width: 100%;height: 400px;" alt='' />
                                            </div>
                                            <?php
                                            $user_folder = FCPATH . "/assets/img/upload/places/" . $o['user_id'] . "/" . $o['folder'] . "/";
                                            $fi          = new FilesystemIterator($user_folder, FilesystemIterator::SKIP_DOTS);
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
                                                            if (($file != ('MAIN_' . $o['folder'] . '.jpg')))
                                                            {
                                                                ?>
                                                                <div class='item'>
                                                                    <img style="width: 100%;height: 400px;" src="<?php echo base_url() . 'assets/img/upload/places/' . $o['user_id'] . '/' . $o['folder'] . '/' . $file; ?>">
                                                                </div>

                                                                <?php
                                                            }
                                                        }
                                                        ++$i;
                                                    }
                                                    closedir($handle);
                                                }
                                            }
                                            ?>

                                        </div>
                                        <a class='left carousel-control' href='#carousel-custom' data-slide='next'>
                                            <span class='glyphicon glyphicon-chevron-right'></span>
                                        </a>
                                        <a class='right carousel-control' href='#carousel-custom' data-slide='prev'>
                                            <span class='glyphicon glyphicon-chevron-left'></span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-1"></div>

                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <ol class='carousel-indicators mCustomScrollbar'>
                                        <li data-target='#carousel-custom' data-slide-to='0' class='active'><img src="<?php echo base_url() . 'assets/img/upload/places/' . $o['user_id'] . '/' . $o['folder'] . '/MAIN_' . $o['folder'] . '.jpg'; ?>" style="width: 100px;height: 70px;" alt='' /></li>
                                        <?php
                                        $user_folder = FCPATH . "/assets/img/upload/places/" . $o['user_id'] . "/" . $o['folder'] . "/";
                                        $fi          = new FilesystemIterator($user_folder, FilesystemIterator::SKIP_DOTS);
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
                                                        if (($file != ('MAIN_' . $o['folder'] . '.jpg')))
                                                        {
                                                            ?>
                                                            <li data-target='#carousel-custom' data-slide-to="<?php echo $i; ?>"><img style="width: 100px;height: 70px;"  src="<?php echo base_url() . 'assets/img/upload/places/' . $o['user_id'] . '/' . $o['folder'] . '/' . $file; ?>" alt='' /></li>

                                                            <?php
                                                        }
                                                    }
                                                    ++$i;
                                                }
                                                closedir($handle);
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
                    <h3 class="panel-title panel-danger" >توضیحات</h3>
                    <span class="pull-left clickable"><i class="glyphicon glyphicon-minus"></i></span>
                </div>
                <div class="panel-body" style="line-height: 3;font-size: 14px;text-align: justify;padding: 20px;">
                    <?php echo $o['description']; ?>
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

        </div>
        <div class="col col-lg-3">
            <?php
            if (count($_suits) < 5)
            {
                $show_villa = 20 - count($_suits);
                $show_suit = count($_suits);
            }
            else
            {
                $show_villa = 15;
                 $show_suit = 5;
            }
            $b = base_url();
            if (isset($_villas) and count($_villas) > 0)
            {
                ?>
                <div class="row" id="divShowVillas">
                    <?php
                    $i = 0;
                    foreach ($_villas as $_villa)
                    {
                        if ($i == $show_villa)
                        {
                            break;
                        }
                        ++$i;
                        ?>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="height: 250px;margin-bottom: 25px;padding-right: 25px;">
                            <div class="row">
                                <div class="col-lg-12 product" style="height: 250px;background-color: white;border: 2px #66ccff solid;">
                                    <div class="row">
                                        <a href="<?php echo base_url() . 'main/villaC/detail/villa/' . $_villa['id']; ?>">
                                            <div class="col-lg-12 product_img"  style="height: 215px;margin: 0px;padding: 0px;position: relative; ">
                                                <span class="triangle_logo"></span>
                                                <span class="triangle_text">ویلا</span>
                                                <?php
                                                echo "<img alt='{$_villa["title"]}' style='height: 215px;width:100%;' src='{$b}assets/img/upload/{$_villa['user_id']}/{$_villa['folder']}/MAIN_{$_villa['folder']}.jpg'/>";
                                                ?>
                                                <div class="col-lg-12 im2" style="height: 230px;margin: 0px;padding: 0px;display: none;background-color: black;color: #005eea;opacity: .5;position: absolute;top: 0px;">
                                                    <div class="cover">
                                                        <div style="padding: 10px;margin-top: 50px;"><hr class="hr_blue" ></div>

                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="row">
                                        <a href="<?php echo base_url() . 'main/villaC/detail/villa/' . $_villa['id']; ?>">
                                            <div class="col-lg-12 fff" style="height: 35px;font-size: 16px;padding-top: 5px;color: black;"><?php echo $_villa["title"]; ?></div> 
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>

                </div>

                <?php
            }
            if (isset($_suits) and count($_suits) > 0)
            {
                ?>
                <div class="row" id="divShowVillas">
                    <?php
                    $j=0;
                    foreach ($_suits as $_suit)
                    {
                                if ($j == $show_suit)
                        {
                            break;
                        }
                        ++$j;
                        ?>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="height: 250px;margin-bottom: 25px;padding-right: 25px;">
                            <div class="row">
                                <div class="col-lg-12 product" style="height: 250px;background-color: white;border: 2px #66ccff solid;">
                                    <div class="row">
                                        <a href="<?php echo base_url() . 'main/visuC/detail/suit/' . $_suit['id']; ?>">
                                            <div class="col-lg-12 product_img"  style="height: 215px;margin: 0px;padding: 0px;position: relative; ">
                                                <span class="triangle_logo"></span>
                                                <span class="triangle_text">سوئیت</span>
                                                <?php
                                                echo "<img alt='{$_suit["title"]}' style='height: 215px;width:100%;' src='{$b}assets/img/upload/{$_suit['user_id']}/{$_suit['folder']}/MAIN_{$_suit['user_id']}.jpg'/>";
                                                ?>
                                                <div class="col-lg-12 im2" style="height: 270px;margin: 0px;padding: 0px;display: none;background-color: black;color: #005eea;opacity: .5;position: absolute;top: 0px;">
                                                    <div class="cover">
                                                        <div style="padding: 10px;margin-top: 50px;"><hr class="hr_blue" ></div>

                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="row">
                                        <a href="<?php echo base_url() . 'main/visuC/detail/suit/' . $_suit['id']; ?>">
                                            <div class="col-lg-12 fff" style="height: 35px;font-size: 16px;padding-top: 5px;color: black;"><?php echo $_suit["title"]; ?></div> 
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>

                </div>

                <?php
            }
            ?>
        </div>
        <div class="col col-lg-1"></div>

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

<?php } ?>
<script src="https://maps.googleapis.com/maps/api/js?callback=myMap&key=AIzaSyDCyDdZc_us4lssx3rBuTV1P5El_Geprcw"></script>





