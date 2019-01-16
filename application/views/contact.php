<script>
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
                        $.each(res.msg, function (index, item)
                        {
                            items += "<option value='" + item.id + "'>" + item.name + "</option>";
                        });
                        $("#optCity").html(items);
                    });
        });
        $("#refesh_captcha").click(function (event) {
            event.preventDefault();

            $.ajax({
                url: BASE_URL + 'contactC/captcha?' + Math.random(),
                type: 'post',
            }).success(function (resp) {
                var fileName = resp.replace('"', '').slice(0, -1);
                $("#captcha_image").attr("src", BASE_URL + 'assets/img/captcha/' + fileName);
            });
        });
    });
</script>
<div class="row " >
    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 "  ></div>
    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 "  >
    
<div class="row " >
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col_contact_message"  >
        ّ
        <div class="offer offer-success" id="dv_contact_message" style="min-height: 650px;">
            <div class="shape">
                <div class="shape-text">

                </div>
            </div>
            <div class="offer-content">
                <h3 class="lead" style="color:green;">
                    <i class="glyphicon glyphicon-envelope"></i>
                    تماس با مکان با ما
                </h3>
                <hr class="hr_green" />
                <?php
                if (isset($err))
                {
                    echo "<div class='alert alert-danger' style='color:red;height:50px;padding:5px;text-align:center;font-size:16px;'>{$err}</div>";
                }
                elseif (isset($ok))
                {
                    echo "<div class='alert alert-success' >{$ok}</div>";
                }
                ?>
                <?php echo form_open('contactC/regist', array('role' => 'form')); ?>

                <div class="form-group">
                    <label for="full_name" class="control-label col-lg-3 ">نام و نام خانوادگی :</label>
                    <div class="col-lg-9">
                        <input type="text" id="full_name"  name="full_name" class="form-control" tabindex="4" value="<?php echo set_value('full_name'); ?>" autofocus style="width: 100%;" >
                        <?php echo form_error('full_name', '<p style="color:#F83A18;font-size:12px;padding-right:5px;">', '</p>'); ?>

                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3" for="provicne">استان:</label>
                    <div class="col-lg-9"> 
                        <select id="optProvince" name="optProvince"  class="input-large form-control">
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


                <div class="form-group">
                    <label class="control-label col-lg-3" for="city">شهرستان:</label>
                    <div class="col-lg-9">          
                        <select id="optCity" name="optCity" class="input-large form-control">
                            <option value="">شهرستان . . .</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="mobile" class=" control-label col-lg-3">شماره تماس :</label>
                    <div class="col-lg-9">
                        <input type="text" id="mobile"  name="mobile" class="form-control" value="<?php echo set_value('mobile'); ?>"  tabindex="4"  style="direction: ltr;width: 100%;" >
                        <?php echo form_error('mobile', '<p style="color:#F83A18;font-size:12px;padding-right:5px;">', '</p>'); ?>

                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="control-label col-lg-3 ">ایمیل :<span style="color:red;font-size: 18px;">*</span></label>
                    <div class="col-lg-9">
                        <input type="text" id="email"  name="email" class="form-control" tabindex="4" value="<?php echo set_value('email'); ?>" style="direction: ltr;width: 100%;" >
                        <?php echo form_error('email', '<p style="color:#F83A18;font-size:12px;padding-right:5px;">', '</p>'); ?>

                    </div>
                </div>

                <div class="form-group">
                    <label for="message" class="control-label col-lg-3 ">شرح پیام :<span style="color:red;font-size: 18px;">*</span></label>
                    <div class="col-lg-9">
                        <textarea id="message"  name="message" class="form-control" tabindex="4" value="" style="height: 120px;" ><?php echo set_value('message'); ?></textarea>
                        <?php echo form_error('message', '<p style="color:#F83A18;font-size:12px;padding-right:5px;">', '</p>'); ?>

                    </div>
                </div>


                <div class="form-group">
                    <label for="email" class="col-lg-3 control-label"></label>
                    <div class="col-lg-9">
                        <label for="captcha"><?php if (isset($captcha)) echo $captcha['image']; ?></label>   <input  type="button" id='refesh_captcha'  tabindex="16" href=""/>                         

                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-lg-3 control-label">کد امنیتی :<span style="color:red;font-size: 18px;">*</span></label>
                    <div class="col-lg-9">
                        <input type="text" autocomplete="off" name="userCaptcha" class="form-control" style="direction: ltr;width: 150px;" maxlength="10" tabindex="8" value="<?php if (!empty($userCaptcha)) echo $userCaptcha; ?>" />
                            <?php echo form_error('userCaptcha', '<p style="color:#F83A18;font-size:12px;padding-right:5px;">', '</p>'); ?>

                    </div>
                </div>


                <div class="form-group">
                    <label for="email" class="col-lg-3 control-label"> </label>
                    <div class="col-lg-9">
                        <input type="submit" name="submit" id="submit" value="ارسال پیام" class="btn btn-success btn-lg " tabindex="9" >

                    </div>
                </div>

                <?php echo form_close(); ?>

            </div>
        </div>

    </div>   

    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col_contact_info "  >
        ّ
        <div class="offer offer-primary dv_contact_info" style="min-height: 650px;"> 
            <div class="shape">
                <div class="shape-text">

                </div>
            </div>
            <div class="offer-content">
                <h3 class="lead" style="color: #005eea;" >
                    <i class="glyphicon glyphicon-bullhorn"></i>
                    اطلاعات تماس
                </h3><hr class="hr_blue"/>



                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">


                    <span><b style="color:blue;"><i class="glyphicon glyphicon-link"></i> ایمیل مکان با ما  :</b><span style="margin-right: 5px;" >contact@makanbama.com</span></span><br/><br/>
                    <span><b style="color:blue;"><i class="glyphicon glyphicon-phone-alt"></i> شماره تماس:</b><span style="margin-right: 35px;">09375065519</span></span>
                </div>
            </div>
        </div>

    </div>    

</div>
</div>
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 "  ></div>
</div>