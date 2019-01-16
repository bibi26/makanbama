<div class="row" >
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 "   >
        ّ
        <div class="offer offer-primary" id="dv_register_user" style="min-height: 600px;">
            <div class="shape">
                <div class="shape-text">

                </div>
            </div>
            <div class="offer-content">
                <h3 class="lead" style="color: #0096ff;">
                    <i class="glyphicon glyphicon-user"></i>
                    بازیابی رمزعبور  
                </h3><hr class="hr_blue"/>
                <?php
                if (isset($err))
                {
                    echo "<div class='alert alert-danger' style='color:red;height:30px;padding:2px;text-align:center;'>{$err}</div>";
                }
                elseif (isset($ok))
                {
                    echo '<div class="alert alert-success" >'.$ok.'</div><script>    $(document).ready(function ( {$("#email").hide();$("submit").hide();});</script>';
                }
                ?>
<?php echo form_open('account/forgetPasswordC/retrieval', array('role' => 'form')); ?>     
                <div class="form-group">
                    <label for="email" class="col-sm-3 control-label">ایمیل</label>
                    <div class="col-sm-9">
                        <input type="text" id="email"  name="email" class="form-control" tabindex="4" value="<?php echo set_value('email'); ?>" autofocus  style="direction: ltr;width: 300px;" >
<?php echo form_error('email', '<p style="color:#F83A18;font-size:12px;padding-right:5px;">', '</p>'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label  class="col-sm-3 control-label"></label>
                    <div class="col-sm-9">
                        <span ><input type="submit" name="submit" id="submit" value="بازیابی کلمه عبور" class="btn btn-success btn-lg " tabindex="9" ></span>
                    </div>
                </div>
            </div>
<?php echo form_close(); ?>
        </div>

    </div>   

    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6  "  >

    </div>    

</div>