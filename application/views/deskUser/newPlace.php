<?php
$user        = unserialize(get_cookie('MakanBaMa'))['USERID'];
$place       = $this->session->userdata('rnd_place');
$user_folder = FCPATH . "\assets\img\upload\places\\" . $user . "\\" . $place . "\\";
$filename    = 'MAIN_' . $place . '.jpg';
$destPath    = $user_folder . $filename;
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
            setTimeout(function () {
            $('#errModal').modal('hide');
            }, 4000);
            return false;
    }
    function checkForm() {
    if ($('#title').val() == '') {
    myalert($('#title'), 'لطفا عنوان آگهی خود را وارد نمایید.')
            return  false;
    }
    if ($('#optProvince').val() == '') {
    myalert($('#optProvince'), 'لطفا استان را تعیین نمایید.');
            return  false;
    }
    if ($('#optCity').val() == '') {
    myalert($('#optCity'), 'لطفا شهرستان را تعیین نمایید.');
            return  false;
    }
    if ($('#address').val() == '') {
    myalert($('#address'), 'لطفا آدرس را وارد نمایید.');
            return  false;
    }
    if ($("#cke_1_contents iframe").contents().find("body").text() == '') {
    myalert($('#description'), 'لطفا توضیحات را وارد نمایید.');
            return  false;
    }
    CKEDITOR.on('instanceCreated', function(e) {
    e.editor.on('contentDom', function() {
        e.editor.document.on('keyup', function(event) {
            if(CKEDITOR.instances.TEXT_AREA_ID.getData() == ""){
                //Do something if textarea is empty
            }
        });
    });
}); 
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
<form method="POST"   action='<?php echo base_url(); ?>deskUser/newPlaceC/regist' onsubmit="return checkForm()"  id="contact-form">

    <?php
    if (isset($err))
    {
        echo "<script>$('#errAlert').html('{$err}');$('#errModal').modal('show');</script>";
    }
    ?>
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
                        </div> 
                    </div> 
                </div>
                <div class="col col-lg-6 col-md-6">
                    <div class = "row">
                        <div class = "col-lg-12">
                            <div class="form-group">
                                <label class="control-label col-lg-3" for="title" >عنوان:<span style="color:red;font-size: 18px;">*</span></label>
                                <div class="col-lg-9">          
                                    <input  class="form-control" id="title" name="title" autofocus value="<?php echo set_value('title'); ?>" >
                                    <?php echo form_error('title', '<p style="color:#F83A18;font-size:12px;padding-right:5px;">', '</p>'); ?>
                                </div>
                            </div> 
                        </div>  
                    </div>
                    <div class = "row">
                        <div class = "col-lg-12">
                            <div class="form-group">
                                <label class="control-label col-lg-3" for="provicne">استان:<span style="color:red;font-size: 18px;">*</span></label>
                                <div class="col-lg-9"> 
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
                                <label class="control-label col-lg-3" for="city">شهرستان:<span style="color:red;font-size: 18px;">*</span></label>
                                <div class="col-lg-9">          
                                                           <select id="optCity" name="optCity" class="input-large form-control">
                                            <option value="">شهرستان . . .</option>
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
                                    <?php echo form_error('optCity', '<p style="color:#F83A18;font-size:12px;padding-right:5px;">', '</p>'); ?>

                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class = "row">
                        <div class = "col-lg-12">
                            <div class="form-group">
                                <label class="control-label col-lg-3" for="address">آدرس :<span style="color:red;font-size: 18px;">*</span></label>
                                <div class="col-lg-9">          
                                    <input  class="form-control" id="address" name="address" style="direction: rtl;" value="<?php echo set_value('address'); ?>" >
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
                <textarea  cols="80"  rows="10" id="description" name="description" ><?php echo set_value('description'); ?></textarea>
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
        <a class="btn btn-danger btn-lg" href="<?php echo base_url() . 'deskUser/listPlaceC/'; ?>">بازگشت</a>
    <input type="submit" class="btn btn-success btn-lg"  value="ثبت اطلاعات"/>

</form>
                                    <script>
            $(document).ready(function () {
<?php
if (isset($_POST['optProvince']))
{
    ?>
        $('#optProvince').val('<?php echo $_POST['optProvince']; ?>');
    <?php
}
?>
<?php
if (isset($_POST['optCity']))
{
    ?>
        $('#optCity').val('<?php echo $_POST['optCity']; ?>');
    <?php
}
?>
    });</script>
<script> 
            $('#fileMain').fileinput({
    uploadUrl: '<?php echo base_url(); ?>deskUser/newPlaceC/uploadImgMain/upload',
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
    echo "initialPreview: ['" . base_url() . "assets/img/upload/places/{$user}/{$place}/MAIN_{$place}.jpg'],";
    echo "initialPreviewConfig:[ { 'url' : '" . base_url() . "deskUser/newPlaceC/uploadImgMain/delete'}],";
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
    uploadUrl: '<?php echo base_url(); ?>deskUser/newPlaceC/uploadImgAdditional/upload',
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
if (file_exists($destPath))
{
    $handle = opendir($user_folder);
    $e      = 'initialPreview: [';
    $d      = 'initialPreviewConfig: [';
    while (false !== ($file   = readdir($handle)))
    {
        if (($file != ".") && ($file != "..") && ($file != "MAIN_{$place}.jpg"))
        {
            $e.= "'" . base_url() . "assets/img/upload/places/{$user}/{$place}/{$file}',";
            $d.=" { 'url' : '" . base_url() . "deskUser/newPlaceC/uploadImgAdditional/delete','key':'{$file}'},";
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
</script>


<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?callback=myMap&key=AIzaSyDCyDdZc_us4lssx3rBuTV1P5El_Geprcw"></script>
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


