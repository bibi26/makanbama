
    <?php

    if (isset($pursuitLinkActivation))
    {
        ?> 
        <div class="notice notice-success notice-lg" style=" margin-top: 40px;">
            <strong><li class="glyphicon glyphicon-check" ></li>&nbsp;&nbsp;<span style="color: black;">براي فعالسازي حساب کاربري  خود وارد حساب کاربری خود شوید و روی لینک سامانه کلیک نمایید.</span></strong><br><br>
            <strong><li class="glyphicon glyphicon-check" ></li>&nbsp;&nbsp;<span style="color: black;">جهت ورود به سامانه از طریق منوی بالای سایت اقدام نمائید.</span></strong><br>
        </div>
        <?php
    }
    if (isset($$activeAccount_1))
    {
        ?> 
        <div class="notice notice-success notice-lg" style=" margin-top: 40px;">
            <strong><li class="glyphicon glyphicon-check" ></li>&nbsp;&nbsp;<span style="color: black;">$activeAccount_1</span></strong><br><br>
            <strong><li class="glyphicon glyphicon-check" ></li>&nbsp;&nbsp;<span style="color: black;">$activeAccount_2</span></strong><br>
        </div>
        <?php
    }
    if (isset($errUpdate))
    {
        ?>
       <div class="notice notice-danger notice-lg" style=" margin-top: 40px;">
            <strong><li class="glyphicon glyphicon-check" ></li>&nbsp;&nbsp;<span style="color: black;" >$errUpdate</span></strong>
        </div>
        <?php
    }
    if (isset($noVercode))
    {
        ?>
        <div class="notice notice-danger notice-lg" style=" margin-top: 40px;">
            <strong><li class="glyphicon glyphicon-check" ></li>&nbsp;&nbsp;<span style="color: black;" >$noVercode</span></strong>
        </div>
        <?php
    }
    if (isset($badUrl))
    {
        ?> 
     <div class="notice notice-danger notice-lg" style=" margin-top: 40px;">
            <strong><li class="glyphicon glyphicon-check" ></li>&nbsp;&nbsp;<span style="color: black;" >$badUrl</span></strong>
        </div>
        <?php
    }
    ?> 

