<?php
$user        = unserialize(get_cookie('MakanBaMa'))['USERID'];
$place       = $this->session->userdata('VISUFOLDERNEW');
$user_folder = FCPATH . "\assets\img\upload\\" . $user . "\\";
$filename    = 'PROFILE_' . $user . '.jpg';
$destPath    = $user_folder . $filename;
?>

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
<script>

    $(document).ready(function () {
        var table = $('#grid').DataTable(
                {
                    "ajax": BASE_URL + 'deskUser/listPlaceC/getPlaces',
                    "processing": true,
                    "bJQueryUI": true,
                    "serverSide": true,
                    "iDisplayLength": 10,
                    "sPaginationType": "full_numbers",
                    "oLanguage": {
                        "sLoadingRecords": "درحال بارگزاری اطلاعات...",
                        "sEmptyTable": "<b style='color:red;'>هیچ مطلب گردشگری تاکنون ثبت نگردیده است.</b>",
                        "sProcessing": "درحال پردازش...",
                        "oPaginate": {
                            "sFirst": "ابتدا",
                            "sLast": "انتها",
                            "sNext": "بعدی",
                            "sPrevious": "قبلی"
                        },
                    },
                    "bLengthChange": false,
                    "bFilter": false,
                    "bSort": true,
                    "bInfo": false,
                    "bAutoWidth": false,
                                         "aaSorting": [[ 6, "desc" ]],

                    "aoColumns": [
                        {"mDataProp": "folder", "visible": false,"orderable": false},
                        {"mDataProp": "user_id", "visible": false,"orderable": false},
                        {"mDataProp": "id", width: "8%","orderable": true},
                        {"mDataProp": "title", width: "42%","orderable": true,
                            "mRender": function (data, type, full) {
                                var s = '<a data-toggle="tooltip" class="tooltip_image" style="color:black;cursor: pointer;" title="<img width=&quot;250px;&quot; height=&quot;250px;&quot; src=&quot;' + BASE_URL + 'assets/img/upload/places/' + full.user_id + '/' + full.folder + '/MAIN_' + full.folder + '.jpg&quot; />" >' + full.title + '</a> ';
                                return s;
                            }
                        },
                        {"mDataProp": "visit", width: "5%","orderable": true},
                        {"mDataProp": "status","orderable": true,
                            width: "15%",
                            "mRender": function (data, type, full) {
                                    if (full.status == 0) {
                                    return 'منتظر تایید';
                                }
                                else if (full.status == 1) {
                                    return 'رد';
                                }
                                else if (full.status == 3) {
                                    return 'تایید';
                                }
                                else {
                                    return 'تعریف نشده';
                                }
                            }},
                        {"mDataProp": "_persian_date", width: "20%","orderable": true},
                        {"mDataProp": "show","orderable": true,
                            width: "10%",
                            "mRender": function (data, type, full) {
                                if (full.show == 1) {
                                    return '<a data-toggle="tooltip"  title="با کلیک کردن روی این گزینه آگهی شما در سابت قابل بازدید <b style=&quot;color :green;&quot;>می باشد</b> . " class="btn btn-success btn-sm" href="' + BASE_URL + 'deskUser/listPlaceC/ostensible/' + full.id + '/0" ">ON</a>';
                                }
                                else
                                {
                                    return '<a data-toggle="tooltip"  title="با کلیک کردن روی این گزینه آگهی شما در سابت قابل بازدید  <b style=&quot;color :red;&quot;>نمی باشد </b> . " class="btn btn-danger btn-sm" href="' + BASE_URL + 'deskUser/listPlaceC/ostensible/' + full.id + '/1" ">OFF</a>';
                                }
                            }}, {
                            "mData": null,"orderable": false,
                            width: "10%",
                            "mRender": function (data, type, full) {
                                return '<a class="btn btn-warning btn-sm" href="' + BASE_URL + 'deskUser/editPlaceC/index/' + full.id + '" ">ویرایش</a>';
                            }
                        }                           
                    ]
                }
        );
    });

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

<div class="panel panel-info">
    <div class="panel-heading my_pnael_head" >
        <h3 class="panel-title panel-danger">لیست مطالب گردشگری</h3>
    </div>
    <div class="panel-body" style="background-color:white;">
        <div class = "row">
            <p style="text-align: center;"> <a class="btn btn-danger" href="<?php echo base_url() . 'deskUser/newPlaceC/'; ?>" >درج  مطلب گردشگری جدید</a></p>

            <div class="col col-lg-12">
                <table id="grid"  cellspacing="0" class="display" style="direction: rtl">
                    <thead class="my_thead">
                        <tr>
                            <th></th>
                            <th></th>
                            <th>کد ملک</th>
                            <th>عنوان</th>
                            <th>بازدید</th>
                            <th>وضعیت</th>
                            <th>تاریخ درج</th>
                            <th>نمایش</th>
                            <th>ویرایش</th>

                        </tr>
                    </thead>

                    <tbody class="my_body">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        setTimeout(function () {
            $('a[data-toggle="tooltip"]').tooltip({
                animated: 'fade',
                placement: 'bottom',
                html: true,
            });
        }, 2000);

    });
</script>