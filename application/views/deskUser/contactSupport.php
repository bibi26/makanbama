
<style>
    #contactSupport
    {
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

    <div class="panel panel-info">
    <div class="panel-heading my_pnael_head" >
        <h3 class="panel-title panel-danger">تماس با پشتیبانی</h3>
    </div>
    <div class="panel-body" style="background-color:white;">

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
                                <?php echo form_error('request_txt', '<p style="color:#F83A18;font-size:12px;padding-right:5px;">', '</p>'); ?>

        <form method="post" action="<?php echo base_url() . "deskUser/contactSupportC/registRequest" ?>">

              <div class = "row">
                <div class="col col-lg-12">
                    <textarea class="form-control custom-control" cols="150" rows="10" id="request_txt" name="request_txt"></textarea><br/> 
                    <input type="submit" class="btn btn-success btn-lg"  value="ارسال پیام"/>

                </div>
            </div>
        </form>

    </div>
</div>
