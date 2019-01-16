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
        ّ
        <div class="offer offer-success" id="dv_register_user" style="min-height: 600px;">
            <div class="shape">
                <div class="shape-text">

                </div>
            </div>
            <div class="offer-content">
                <h3 class="lead" style="color: #00cc00;">
                    <i class="glyphicon glyphicon-user"></i>
                   تغییر رمز عبور   
                </h3><hr class="hr_green"/>
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
                else if (isset ($err))
                {
                    echo  "<div class='alert alert-danger' style='color:red;height:30px;padding:2px;text-align:center;'>{$err}</div>";
                }
                ?>
                <?php echo form_open('account/changePassC/cp', array('role' => 'form')); ?>     
                <div class="form-group">
                    <label for="email" class="col-sm-3 control-label">ایمیل</label>
                    <div class="col-sm-9">
                        <label style="font-size: 18px;direction: ltr;text-align: center;"><?php if ($this->session->has_userdata('EMAIL_H')) echo $this->session->userdata('EMAIL_H')?></label>

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
                        <span ><input type="submit" name="submit" id="submit" value="تغییر رمز عبور" class="btn btn-success btn-lg " tabindex="9" ></span>
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>

    </div>   
  

</div>
