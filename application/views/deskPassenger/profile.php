<?php
$user        = unserialize(get_cookie('MakanBaMa'))['USERID'];
$user_folder = FCPATH . "\assets\img\upload\\" . $user . "\\";
$filename    = 'PROFILE_' . $user . '.jpg';
$destPath    = $user_folder . $filename;
?>
<script>


    $(document).ready(function () {
          $('#btnRegist').click(function (e) {
            if ($('#first_name').val() == '') {
                $("#first_name").addClass('errorClass');
                setTimeout(function () {
                    $("#first_name").removeClass('errorClass');
                }, 3000);

            }
            if ($('#last_name').val() == '') {
                $("#last_name").addClass('errorClass');
                setTimeout(function () {
                    $("#last_name").removeClass('errorClass');
                }, 3000);

            }

            if ($('#optProvince').val() == '') {
                $("#optProvince").addClass('errorClass');
                setTimeout(function () {
                    $("#optProvince").removeClass('errorClass');
                }, 3000);

            }

            if ($('#optCity').val() == '') {
                $("#optCity").addClass('errorClass');
                setTimeout(function () {
                    $("#optCity").removeClass('errorClass');
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
                }, 3000);

            }
            if ($('#first_name').val() == '')
            {
                $("#first_name").focus();

            }
            else if ($('#last_name').val() == '')
            {
                $("#last_name").focus();

            }
            else if ($('#optProvince').val() == '')
            {
                $("#optProvince").focus();

            }
            else if ($('#optCity').val() == '')
            {
                $("#optCity").focus();

            }
            else if ($('#mobile').val() == '')
            {
                $("#mobile").focus();

            }
            else if (!$('#mobile').val().match(/^09\d{9}$/))
            {
                $("#mobile").focus();
            }
            if ($('#first_name').val() == '' || $('#last_name').val() == '' || $('#optProvince').val() == '' || $('#optCity').val() == '' || $('#mobile').val() == '' || !$('#mobile').val().match(/^09\d{9}$/)) {
                return false;
            }
            else
            {
                $('#frm_profile').submit();

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
    });
</script>
<style>
    #itemMenuProfile{
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

<form id="frm_profile" action="<?php echo base_url(); ?>deskPassenger/profileC/registInfo" method="post">
    <div class="panel panel-info">
        <div class="panel-heading my_pnael_head" >
            <h3 class="panel-title panel-danger">پروفایل</h3>
        </div>
        <div class="panel-body" style="background-color:white;">
            <div class = "row">
                <div class = "col-lg-1">
                </div>
                <div class = "col-lg-10">
                    <div class="alert" style="line-height: 2;padding: 5px; border-radius: 5px; border: 1px black solid;background-color: #ccccff;">
                        نام، نام خانوادگی، تصویر و شماره تلفن همراه شما در سایت مکان با ما نمایش داده خواهد شد. شما با فشردن دکمه ذخیره،‌ موافقت خود را با نمایش این اطلاعات اعلام می کنید. پس از درج نام و شماره تلفن،‌ منتظر تماس تلفنی از مکان با ما باشید. پس از احراز هویت شما توسط مکان با ما، نام، تصویر و تلفن شما در سایت مکان با ما نمایش داده خواهد شد
                    </div>
                </div>
                <div class = "col-lg-1">
                </div>
            </div>

            <div class = "row">
                <div class = "col-lg-1">
                </div>
                <div class = "col-lg-10">
                    <div class="row">
                        <div class = "col-lg-4" >
                            <input id="fileProfile" name="fileProfile" class="file" type="file"  />
                        </div>
                        <div class = "col-lg-6">
                            <div class = "row">
                                <div class = "col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" for="first_name" >نام:</label>
                                        <div class="col-lg-9">          
                                            <input  class="form-control" id="first_name" name="first_name" autofocus style="width: 60%;" value="<?php if (isset($_data)) echo $_data['first_name']; ?>">
                                            <?php echo form_error('first_name', '<p style="color:#F83A18;font-size:12px;padding-right:5px;">', '</p>'); ?>

                                        </div>
                                    </div>
                                    <br/>                            
                                    <br/>

                                    <div class="form-group">
                                        <label class="control-label col-lg-3" for="last_name" >نام خانوادگی:</label>
                                        <div class="col-lg-9">          
                                            <input  class="form-control" id="last_name" name="last_name" autofocus style="width: 60%;"  value="<?php if (isset($_data)) echo $_data['last_name']; ?>" >
                                            <?php echo form_error('last_name', '<p style="color:#F83A18;font-size:12px;padding-right:5px;">', '</p>'); ?>

                                        </div>
                                    </div> 
                                    <br/>                          
                                    <br/>

                                    <div class="form-group">
                                        <label class="control-label col-lg-3" for="provicne">استان:</label>
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
                                            <?php echo form_error('optProvince', '<p style="color:#F83A18;font-size:12px;padding-right:5px;">', '</p>'); ?>


                                        </div>
                                    </div> 
                                    <br/>                          
                                    <br/>

                                    <div class="form-group">
                                        <label class="control-label col-lg-3" for="city">شهرستان:</label>
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
                                    <br/>                          
                                    <br/>
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" for="address" >آدرس:</label>
                                        <div class="col-lg-9">          
                                            <input  class="form-control" id="address" name="address" autofocus value="<?php if (isset($_data)) echo $_data['address']; ?>" >
                                            <?php echo form_error('address', '<p style="color:#F83A18;font-size:12px;padding-right:5px;">', '</p>'); ?>

                                        </div>
                                    </div> 
                                    <br/>                          
                                    <br/>

                                    <div class="form-group">
                                        <label class="control-label col-lg-3" for="mobile" >شماره همراه:</label>
                                        <div class="col-lg-9">          
                                            <input  class="form-control" id="mobile" name="mobile" autofocus style="width: 60%;direction: ltr;"  value="<?php if (isset($_data)) echo $_data['mobile']; ?>" >
                                            <?php echo form_error('mobile', '<p style="color:#F83A18;font-size:12px;padding-right:5px;">', '</p>'); ?>
                                                                               <span style="color:red;text-align: center;" id="err_mobile"></span>

                                        </div>
                                    </div>
                                    <br/>                           
                                    <br/>
                                    <div class="form-group">
                                        <label class="control-label col-lg-7" for="mobile" style="font-size: 15px;"> تاریخ ثبت نام:<b><?php if (isset($_data)) echo jdate('d-m-Y', strtotime($_data['create_date'])); ?></b></label>
                                        <?php
                                        $status = '';
                                        if (isset($_data))
                                        {

                                            if ($_data['status'] == 3)
                                            {
                                                $status = 'فعال';
                                            }
                                        }
                                        ?>
                                        <label class="control-label col-lg-5" for="mobile" style="font-size: 15px;">وضعیت کاربر:<b><?php echo $status; ?></b></label>
                                    </div>
                                </div>  
                            </div>

                        </div>
                        <div class = "col-lg-2">
                        </div>
                    </div>
                    <br/>
                    <div class = "row">
                        <div class = "col-lg-1">
                        </div>
                        <div class = "col-lg-10">

                            <?php
                            if (isset($err))
                            {
                                ?>
                                <div class="notice notice-success notice-md" style="font-size: 16px;height: 42px;margin-bottom: 5px;">
                                    <strong><li class="glyphicon glyphicon-check" ></li>&nbsp;&nbsp;<span style="color: red;"><?php echo $err; ?></span></strong><br><br>
                                </div>
                                <?php
                            }
                            elseif (isset($ok))
                            {
                                ?>
                                <div class="notice notice-success notice-md" style="font-size: 16px;height: 42px;margin-bottom: 5px;">
                                    <strong><li class="glyphicon glyphicon-check" ></li>&nbsp;&nbsp;<span style="color: green;"><?php echo $ok; ?></span></strong><br><br>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <div class = "col-lg-1">
                        </div>
                    </div>

                    <div class = "row">
                        <div class = "col-lg-4">
                        </div>
                        <div class = "col-lg-4">
                            <input type="button" id='btnRegist' class="btn btn-success btn-lg"  value="ثبت"/>

                        </div>
                        <div class = "col-lg-4">
                        </div>
                    </div>
                </div>
                <div class = "col-lg-1">
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    $(document).ready(function () {
        $('#optProvince').val('<?php if (isset($_data)) echo $_data['province_id']; ?>');
        $('#optCity').val('<?php if (isset($_data)) echo $_data['city_id']; ?>');
    });
</script>
<script>

    $('#fileProfile').fileinput({
        uploadUrl: '<?php echo base_url(); ?>deskUser/profileC/uploadImgProfile/upload',
        uploadAsync: true,
        showUpload: false,
        showRemove: false,
        showCaption: false,
        browseLabel: 'ویرایش تصویر',
        browseClass: "btn btn-danger btn-md style='margin-right: 80px;'",
        dropZoneTitle: '',
        language: 'fa',
        validateInitialCount: true,
        showClose: false,
        initialPreviewAsData: true,
        overwriteInitial: true,
        defaultPreviewContent: "<img src='<?php echo base_url(); ?>assets/img/default_avatar_male.jpg' alt='Your Avatar' style='width:160px'>",
        autoReplace: true,
<?php
if (file_exists($destPath))
{
    echo "initialPreview: ['" . base_url() . "assets/img/upload/{$user}/PROFILE_{$user}.jpg'],";
    echo "initialPreviewConfig:[ { 'url' : '" . base_url() . "deskUser/profileC/uploadImgProfile/delete'}],";
}
?>
    }).on("filebatchselected", function (event, files) {
        // trigger upload method immediately after files are selected
        $('#fileProfile').fileinput("upload");
    });
</script>