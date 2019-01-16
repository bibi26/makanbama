<style>
    #opinionVisitors
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
<script>
    function myalert(id) {
        $("#" + id).addClass('errorClass');
        setTimeout(function () {
            $("#" + id).removeClass('errorClass');
        }, 2000);
        $("#" + id).focus();
    }
    function checkForm() {
        if ($('#response_opinion').val() == '') {
            myalert('response_opinion');
            return  false;
        }
        return  true;

    }
</script>
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


<div class = "row">
    <div class="col col-lg-12">
        <?php
        if (isset($_detailOpinion))
        {
            ?>
            <div class="panel panel-info">
                <div class="panel-heading my_pnael_head" >
                    <h3 class="panel-title panel-danger">پاسخ به دیدگاه مسافر</h3>
                </div>
                <div class="panel-body" style="background-color:white;">
                    <div class = "row">
                        <div class="col col-lg-6">
                            <span>کد ملک :</span>&nbsp;<b><?php echo $_detailOpinion[0]['id']; ?></b>
                        </div>
                        <div class="col col-lg-6">
                            <span>تاریخ ثبت دیدگاه:</span>&nbsp;<b><?php echo jdate(' H:i:s d-m-Y', strtotime($_detailOpinion[0]['create_date'])); ?></b>
                        </div>
                    </div>
                    <br>
                    <div class = "row">
                        <div class="col col-lg-12">
                            <span>دیدگاه : </span>&nbsp;<b><?php echo $_detailOpinion[0]['opinion']; ?></b>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class = "row">
                        <div class="col col-lg-1">
                            <span>پاسخ : </span>
                        </div>
                        <div class="col col-lg-11">
                            <form method="POST"   action='<?php echo base_url(); ?>deskUser/responseOpinionVisitorsC/regist' onsubmit="return checkForm()"  id="contact-form">
                                <span><textarea id="response_opinion" name="response_opinion" style="width: 100%;height: 200px;padding: 5px;"><?php
                                        if (isset($_responseOpinion) and count($_responseOpinion) == 1)
                                        {
                                            echo $_responseOpinion[0]['response'];
                                        }
                                        ?></textarea></span><br/><br/>
                                <a class="btn btn-danger btn-lg" href="<?php echo base_url() . 'deskUser/ListOpinionVisitorsC/'; ?>">بازگشت</a>
                                <input type="submit" class="btn btn-success btn-lg"  value="ثبت پاسخ"/>
                                <input type="hidden" name="opinion_id" value="<?php echo $_detailOpinion[0]['id']; ?>"/>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>