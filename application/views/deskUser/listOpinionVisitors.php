<?php
$user        = unserialize(get_cookie('MakanBaMa'))['USERID'];
$place       = $this->session->userdata('VISUFOLDERNEW');
$user_folder = FCPATH . "\assets\img\upload\\" . $user . "\\";
$filename    = 'PROFILE_' . $user . '.jpg';
$destPath    = $user_folder . $filename;
?>

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

    $(document).ready(function () {

        var table = $('#grid').DataTable(
                {
                    "ajax": BASE_URL + 'deskUser/listOpinionVisitorsC/getOpinions',
                    "processing": true,
                    "bJQueryUI": true,
                    "serverSide": true,
                    "iDisplayLength": 10,
                    "sPaginationType": "full_numbers",
                    "oLanguage": {
                        "sLoadingRecords": "درحال بارگزاری اطلاعات...",
                        "sEmptyTable": "<b style='color:red;'>هیچ دیدگاهی تاکنون ثبت نگردیده است.</b>",
                        "sProcessing": "درحال پردازش...", "oPaginate": {
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
                                                             "aaSorting": [[ 3, "desc" ]],

                    "aoColumns": [
                        {"mDataProp": "folder", "visible": false, "orderable": false},
                        {"mDataProp": "ID", width: "5%", "orderable": true},
                        {"mDataProp": "opinion", width: "55%", "orderable": false,
                            "mRender": function (data, type, full) {
                                var s = '<a data-toggle="tooltip" class="tooltip_image" style="color:black;cursor: pointer;" title="<img width=&quot;250px;&quot; height=&quot;250px;&quot; src=&quot;' + BASE_URL + 'assets/img/upload/28/' + full.folder + '/MAIN_28.jpg&quot; />" >' + full.opinion + '</a> ';
                                return s;
                            }},
                        {"mDataProp": "_persian_date", width: "10%", "orderable": true},
                        {"mDataProp": "show", width: "10%", "orderable": true,
                                 "mRender": function (data, type, full) {
                                var dd = '';
                                if (full.show == 1) {
                                    dd = "<img src='"+BASE_URL+"assets/img/show.png' />";
                                }
                                else {
                                    dd = "<img src='"+BASE_URL+"assets/img/hide.png' />";
                                }
                                return  dd;
                            }
                    },
                        {
                            "mData": null,
                            "orderable": false,
                            width: "10%",
                            "mRender": function (data, type, full) {
                                var dd = '';
                                if (full.response != null) {
                                    dd = "success";
                                }
                                else {
                                    dd = "danger";
                                }
                                return '<a class="btn btn-'+dd+' btn-sm" href="' + BASE_URL + 'deskUser/responseOpinionVisitorsC/detail/' + full.id + '" ">پاسخ</a>' ;
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


<div class = "row">
    <div class="col col-lg-12">
        <table id="grid"  cellspacing="0" class="display" style="direction: rtl">
            <thead class="my_thead">
                <tr>
                    <th></th>
                    <th>کد ملک</th>
                    <th>خلاصه دیدگاه</th>
                    <th>تاریخ ثبت دیدگاه</th>
                    <th>تائید</th>
                    <th>پاسخ</th>
                </tr>
            </thead>

            <tbody class="my_body">

            </tbody>
        </table>
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