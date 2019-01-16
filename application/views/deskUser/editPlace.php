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
    if ($('#address').val() == '') {
    myalert($('#address'), 'لطفا آدرس را وارد نمایید.');
            return  false;
    }
    if ($('#description').val() == '') {
    myalert($('#description'), 'لطفا توضیحات را وارد نمایید.');
            return  false;
    }

    return true;
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
    #itemListPlace{
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
    $o           = array();
    $o           = $result['info'];
    $user        = unserialize(get_cookie('MakanBaMa'))['USERID'];
    $user_folder = FCPATH . "/assets/img/upload/places/" . $user . "/" . $o['folder'] . "/";
    $filename    = 'MAIN_' . $o['folder'] . '.jpg';
    $destPath    = $user_folder . $filename;
    ?>
    <form method="POST"   action='<?php echo base_url(); ?>deskUser/editPlaceC/edit' onsubmit="return checkForm()"  id="contact-form">

        <div class="panel panel-info">
            <div class="panel-heading my_pnael_head" >
                <h3 class="panel-title panel-danger">درج مطلب گردشگری<span style="margin-right: 200px;font-size: 12px;color: #009926;">فیلد های <b style="color: red;font-size: 18px;">*</b> ضروری می باشند.</span></h3>
                <span class="pull-left clickable"><i class="glyphicon glyphicon-minus"></i></span>
            </div>
            <div class="panel-body" style="background-color:white;">
                <div class = "row">
                    <div class="col col-lg-6 col-md-6">
                        <div class="row">
                            <div class = "col-lg-12">
                                              <?php
                            if (isset($errUp))
                            {
                                echo '<p style="color:#F83A18;font-size:12px;padding-right:5px;">' . $errUp . '</p>';
                            }
                            ?>
                                <input id="fileMain" name="fileMain" class="file" type="file"  />
                                <input value="<?php echo $o['id']; ?>" type="hidden" name="ID"  />
                            </div> 
                        </div> 
                    </div>
                    <div class="col col-lg-6 col-md-6">
                        <div class = "row">
                            <div class = "col-lg-12">
                                <div class="form-group">
                                    <label class="control-label col-lg-4" for="title" >عنوان:<span style="color:red;font-size: 18px;">*</span></label>
                                    <div class="col-lg-8">          
                                        <input  class="form-control" id="title" name="title" autofocus value="<?PHP echo $o['title']; ?>" >
                                        <?php echo form_error('title', '<p style="color:#F83A18;font-size:12px;padding-right:5px;">', '</p>'); ?>

                                    </div>
                                </div> 
                            </div>  
                        </div>
                        <div class = "row">
                            <div class = "col-lg-12">
                                <div class="form-group">
                                    <label class="control-label col-lg-4" for="provicne">استان:<span style="color:red;font-size: 18px;">*</span></label>
                                    <div class="col-lg-8"> 
                                        <select id="optProvince" name="optProvince" class="input-large form-control">
                                            <option value="">نام استان. . .</option>
                                            <?php
                                            foreach ($result['_province'] as $province)
                                            {
                                                echo "<option value='{$province['id']}'>" . $province['name'] . "</option>";
                                            }
                                            ?>
                                            <option selected="selected" value="<?PHP echo $o['province_id']; ?>" ><?PHP echo $o['_province']; ?></option>
                                        </select>
                                        <?php echo form_error('province', '<p style="color:#F83A18;font-size:12px;padding-right:5px;">', '</p>'); ?>

                                    </div>
                                </div> 
                            </div> 
                        </div>
                        <div class = "row">
                            <div class = "col-lg-12">
                                <div class="form-group">
                                    <label class="control-label col-lg-4" for="city">شهرستان:<span style="color:red;font-size: 18px;">*</span></label>
                                    <div class="col-lg-8">          
                                        <select id="optCity" name="optCity" class="input-large form-control">
                                            <option value="">شهرستان . . .</option>

                                            <?php
                                            foreach ($result['_city'] as $city)
                                            {
                                                echo "<option value='{$city['id']}'>" . $city['name'] . "</option>";
                                            }
                                            ?>
                                            <option selected="selected" value="<?PHP echo $o['city_id']; ?>" ><?PHP echo $o['_city']; ?></option> 
                                        </select>
                                        <?php echo form_error('city', '<p style="color:#F83A18;font-size:12px;padding-right:5px;">', '</p>'); ?>

                                    </div>
                                </div>
                            </div> 
                        </div>
                        <div class = "row">
                            <div class = "col-lg-12">
                                <div class="form-group">
                                    <label class="control-label col-lg-4" for="address">آدرس :<span style="color:red;font-size: 18px;">*</span></label>
                                    <div class="col-lg-8">          
                                        <input  class="form-control" id="address" name="address" style="direction: rtl;" value="<?PHP echo $o['address']; ?>" >
                                        <?php echo form_error('address', '<p style="color:#F83A18;font-size:12px;padding-right:5px;">', '</p>'); ?>

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
                <h3 class="panel-title " style="color:black;">توضیحات</h3>
                <span class="pull-left clickable"><i class="glyphicon glyphicon-minus"></i></span>
            </div>
            <div class="panel-body">
                <div class="col-lg-12">    
                    <?php echo form_error('description', '<p style="color:#F83A18;font-size:12px;padding-right:5px;">', '</p>'); ?>
                    <textarea style="height: 250px;width:100%;" cols="80"  rows="10"id="description" name="description"><?PHP echo $o['description']; ?></textarea>

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
        <input type="submit" class="btn btn-success btn-lg"  value="ثبت اطلاعات"/>

    </form>
    <script>
                $('#fileMain').fileinput({
        uploadUrl: '<?php echo base_url(); ?>deskUser/editPlaceC/uploadImgMain/upload',
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
    if (file_exists($destPath))
    {
        echo "initialPreview: ['" . base_url() . "assets/img/upload/places/{$user}/{$o['folder']}/MAIN_{$o['folder']}.jpg'],";
        echo "initialPreviewConfig:[ { 'url' : '" . base_url() . "deskUser/editPlaceC/uploadImgMain/delete'}],";
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
        uploadUrl: '<?php echo base_url(); ?>deskUser/editPlaceC/uploadImgAdditional/upload',
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
    //            uploadExtraData: { 'fn': <?php echo $o['folder']; ?>},
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
                    $e.= "'" . base_url() . "assets/img/upload/places/{$user}/{$o['folder']}/{$file}',";
                    $param = $file . ',' . $o['folder'];
                    $d.=" { 'url' : '" . base_url() . "deskUser/editPlaceC/uploadImgAdditional/delete','key':'{$param}'},";
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
                });</script>

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

<?php } ?>
<script>

            // Replace the <textarea id="editor"> with an CKEditor
            // instance, using default configurations.
            CKEDITOR.replace('description', {
            uiColor: '#14B8C4',
                    toolbar: [
                            [ 'Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink' ],
                            [ 'FontSize', 'TextColor', 'BGColor', 'Justify' ],
                            [ 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', ],
                    ]
            });
            CKEDITOR.editorConfig = function(config)
            {
            config.language = 'fa';
            };
</script>