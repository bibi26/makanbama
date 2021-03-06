<style>
    #itemMenuVilla{
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
                    "ajax": BASE_URL + 'deskAdmin/listItemC/getItems',
                    "processing": true,
                    "bJQueryUI": true,
                    "serverSide": true,
                    "iDisplayLength": 10,
                    "sPaginationType": "full_numbers",
                    "oLanguage": {
                        "sLoadingRecords": "درحال بارگزاری اطلاعات...",
                        "sEmptyTable": "<b style='color:red;'>هیچ سوئیتی تاکنون ثبت نگردیده است.</b>",
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
                    "bSort": false,
                    "bInfo": false,
                    "bAutoWidth": false,
                    "aoColumns": [
                        {"mDataProp": "id", "visible": false},
                        {"mDataProp": "folder", "visible": false},
                        {"mDataProp": "user_id", "visible": false},
                        {"mDataProp": "key",
                            width: "10%",
                            "mRender": function (data, type, full) {
                                return full.id;
                            }
                        },
                        {"mDataProp": "title", width: "33%",
                            "mRender": function (data, type, full) {
                                var s = '<a data-toggle="tooltip" class="tooltip_image" style="color:black;cursor: pointer;" title="<img width=&quot;250px;&quot; height=&quot;250px;&quot; src=&quot;' + BASE_URL + 'assets/img/upload/' + full.user_id + '/' + full.folder + '/MAIN_' + full.folder + '.jpg&quot; />" >' + full.title + '</a> ';
                                return s;
                            }},
                        {"mDataProp": "visit", width: "8%"},
                        {"mDataProp": "request", width: "8%"},
                        {"mDataProp": "status",
                            width: "10%",
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
                        {"mDataProp": "_persian_date", width: "18%"},
                                                {"mDataProp": "type",
                            width: "7%",
                            "mRender": function (data, type, full) {

                                if (full.type == 'villa') {
                                    return 'ویلا';
                                }
                                else if (full.type == 'suit') {
                                    return 'سوئیت';
                                }
                                else  {
                                    return '??!!';
                                }
                            }},
                        {
                            "aTargets": [5],
                            "mData": null,
                            width: "7%",
                            "mRender": function (data, type, full) {
                                return '<a class="btn btn-info btn-sm" href="' + BASE_URL + 'deskAdmin/detailItemC/detail/' + full.id + '" >جزئیات</a>';
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
    echo "<script>$('#errAlert').html('{$err}');$('#errModal').modal('show');</script>";
}
?>

<div class="panel panel-info">
       <div class="panel-heading my_pnael_head" >
        <h3 class="panel-title panel-danger">لیست  ویلا و سوئیت-آپارتمان ها</h3>
    </div>
    <div class="panel-body" style="background-color:white;">
        <div class = "row">
            <div class="col col-lg-12">

                <table id="grid"  cellspacing="0" class="display" style="direction: rtl">
                    <thead class="my_thead">
                        <tr>
                            <th>id</th>
                            <th>image</th>
                            <th>user_id</th>
                            <th>کد ملک</th>
                            <th>عنوان آگهی</th>
                            <th>بازدیدها</th>
                            <th> درخواست</th>
                            <th>وضعیت</th>
                            <th>آخرین بروزرسانی</th>
                            <th>نوع</th>
                            <th >جزئیات</th>


                        </tr>
                    </thead>

                    <tbody class="my_body">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<div id="okModal2" class="modal fade" role="dialog" style="width: 70%;">
    <div class="modal-dialog" >
        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-body" id="okAlert2">
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal"  type="button" class="btn btn-success" >تایید</button>
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