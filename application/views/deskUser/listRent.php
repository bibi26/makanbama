<style>
    #listRent{
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
                    "ajax": BASE_URL + 'deskUser/listRentC/getRents',
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
                    "bSort": true,
                    "bInfo": false,
                    "bAutoWidth": true,
                                                             "aaSorting": [[ 9, "desc" ]],

                    "aoColumns": [
                        {"mDataProp": "id", "visible": false,"orderable": false,},
                        {"mDataProp": "user_id", "visible": false,"orderable": false},
                        {"mDataProp": "folder", "visible": false,"orderable": false},
                        {"mDataProp": "building_id", width: "10%","orderable": true},
                        {"mDataProp": "full_name", width: "20%","orderable": true,
                            "mRender": function (data, type, full) {
                                var s = '<a data-toggle="tooltip" class="tooltip_image" style="color:black;cursor: pointer;" title="<img width=&quot;250px;&quot; height=&quot;250px;&quot; src=&quot;' + BASE_URL + 'assets/img/upload/' + full.user_id + '/' + full.folder + '/MAIN_' + full.folder + '.jpg&quot; />" >' + full.full_name + '</a> ';
                                return s;
                            }
                        },
                        {"mDataProp": "mobile", width: "15%","orderable": false},
                        {"mDataProp": "from_date_j", width: "15%","orderable": true},
                        {"mDataProp": "to_date_j", width: "15%","orderable": true},
                        {"mDataProp": "RentDays", width: "10%","orderable": true,
                            "mRender": function (data, type, full) {
                                return full.RentDays + ' شب';
                            }},
                        {"mDataProp": "_persian_date", width: "15%","orderable": true}
                    ]
                }
        );
    });

</script>

<div class="panel panel-info">
    <div class="panel-heading my_pnael_head" >
        <h3 class="panel-title panel-danger">لیست  درخواست های اجاره</h3>
    </div>
    <div class="panel-body" style="background-color:white;">
        <div class = "row">

            <div class="col col-lg-12">
                <table id="grid"  cellspacing="0" class="display" style="direction: rtl">
                    <thead class="my_thead">
                        <tr>
                            <th>id</th>
                            <th>user_id</th>
                            <th>folder</th>
                            <th>کد ملک</th>
                            <th>نام و نام خانوادگی متقاضی</th>
                            <th>شماره همراه</th>
                            <th>شروع از</th>
                            <th>تا</th>
                            <th>مدت اقامت</th>
                            <th>تاریخ درخواست</th>
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