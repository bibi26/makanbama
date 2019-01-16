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
</script>
<div class="row" >
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 "   >
        <div class="offer offer-success" id="dv_register_user" style="min-height: 600px;">
            <div class="shape">
                <div class="shape-text">
                </div>
            </div>
            <div class="offer-content">
                <h3 class="lead" style="color: #00cc00;">
                    <i class="glyphicon glyphicon-user"></i>
                    ثبت نام  
                </h3><hr class="hr_green"/>
                <div class="row" >
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 "   >
                        <?php
                        if (form_error('email'))
                        {
                            echo form_error('email', '<div class="alert alert-danger" style="color:red;height:30px;padding:2px;text-align:center;">', '</div>');
                        }
                        else if (form_error('pass1'))
                        {
                            echo form_error('pass1', '<div class="alert alert-danger" style="color:red;height:30px;padding:2px;text-align:center;">', '</div>');
                        }
                        else if (form_error('pass2'))
                        {
                            echo form_error('pass2', '<div class="alert alert-danger" style="color:red;height:30px;padding:2px;text-align:center;">', '</div>');
                        }
                        else if (form_error('chkUniqEmail'))
                        {
                            echo form_error('chkUniqEmail', '<div class="alert alert-danger" style="color:red;height:30px;padding:2px;text-align:center;">', '</div>');
                        }
                        else if (isset($err))
                        {
                            echo "<div class='alert alert-danger' style='color:red;height:30px;padding:2px;text-align:center;'>{$err}</div>";
                        }
                        else if (isset($type))
                        {
                            echo "<div class='alert alert-danger' style='color:red;height:30px;padding:2px;text-align:center;'>{$type}</div>";
                        }
                        ?>
                        <?php echo form_open('account/registerUserC/signUP', array('role' => 'form')); ?> 
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="radio" id="rdo_hodteler" name="type"  value="hosteler" >&nbsp;<label for="rdo_hodteler" class="form-control-label">من میزبان هستم</label><br/>
                                <input type="radio" id="rdo_passenger" name="type" value="passenger">&nbsp;<label for="rdo_passenger" class="form-control-label">من مسافر هستم</label><br/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-3 control-label">ایمیل</label>
                            <div class="col-sm-9">
                                <input type="text" id="email"  name="email" class="form-control" tabindex="4" autofocus style="direction: ltr;width: 100%;"  value="<?php echo set_value('email'); ?>">

                            </div>
                        </div>
                        <br/>
                        <br/>
                        <br/>
                        <div class="form-group">
                            <label for="pass1" class="col-sm-3 control-label">رمزعبور</label>
                            <div class="col-sm-9">
                                <input type="password" id="pass1" name="pass1" class="form-control" tabindex="4" style="direction: ltr;width: 100%;" >
                            </div>
                        </div>
                        <br/>
                        <br/>
                        <div class="form-group">
                            <label for="pass2" class="col-sm-3 control-label">تکرار رمز عبور</label>
                            <div class="col-sm-9">
                                <input type="password" id="pass2" name="pass2" class="form-control" tabindex="4" style="direction: ltr;width: 100%;" >
                            </div>
                        </div>
                        <br/>

                        <div class="form-group">
                            <label  class="col-sm-3 control-label"></label>
                            <div class="col-sm-9">
                                <center ><input type="submit" name="submit" id="submit" value="ثبت نام" class="btn btn-success btn-lg " tabindex="9" ></center>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 "   >
                    </div>
                </div>
            </div>
        </div>
    </div>   

    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6  "  >
        <div class="offer offer-primary dv_register_user_notify" style="min-height: 600px;">
            <div class="shape">
                <div class="shape-text">

                </div>
            </div>
            <div class="offer-content">
                <h3 class="lead" style="color: #0096ff;;">
                    <i class="glyphicon glyphicon-eye-open"></i>
                    اهداف مکان با ما
                </h3><hr class="hr_blue"/>

            </div>
        </div>
    </div>    

</div>
