@extends('layout.layout')

@section('title')
    {{__('lang.orders')}}
@endsection
@section('css')
    <link href="{{asset('dashboard/assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet"
          type="text/css"/>
    @if(Request::segment(1) == 'ar' )
        <link href="{{asset('dashboard/assets/css/pages/wizard/wizard-6.rtl.css')}}" rel="stylesheet" type="text/css"/>
    @else
        <link href="{{asset('dashboard/assets/css/pages/wizard/wizard-6.css')}}" rel="stylesheet" type="text/css"/>
    @endif
    <link href="{{asset('hijri/css/bootstrap-datetimepicker.css')}}" rel="stylesheet"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

@endsection

@section('content')

    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <!--begin::Container-->
        <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <!--begin::Mobile Toggle-->
                    <button class="burger-icon burger-icon-left mr-4 d-inline-block d-lg-none"
                            id="kt_subheader_mobile_toggle">
                        <span></span>
                    </button>
                    <!--end::Mobile Toggle-->
                    <!--begin::Page Heading-->
                    <div class="d-flex align-items-baseline flex-wrap mr-5">
                        <!--begin::Page Title-->

                        <!--end::Page Title-->
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                            {{--                            <li class="breadcrumb-item">--}}
                            {{--                                <a href="{{url('resources')}}" class="text-muted">{{trans('lang.HR')}}</a>--}}
                            {{--                            </li>--}}
                            {{--                            <li class="breadcrumb-item">--}}
                            {{--                                <a href="" class="text-muted">Profile</a>--}}
                            {{--                            </li>--}}

                            <li class="breadcrumb-item">
                                <h5 class="text-dark font-weight-bold my-1 mr-5 ">{{trans('lang.orders')}}</h5>
                            </li>
                        </ul>

                        <!--end::Breadcrumb-->
                    </div>
                    <!--end::Page Heading-->
                </div>
            </div>
        </div>

        <div class="container">
            <!--begin::Card--><br><br><br>            <!--begin::Card-->
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">{{__('lang.orders')}}
                    </div>
                    <div class="card-toolbar">
                        <button style="margin: 6px" type="button" data-toggle="modal" data-toggle="modal"
                                data-target="#kt_modal_5" class="btn btn-success font-weight-bolder">
                            &nbsp;&nbsp;<i class="flaticon2-magnifier-tool"></i>

                            {{__('lang.search')}}</button>
                        <!--begin::Button-->

                        @if(Auth::guard('suppliers')->check())
                            @if(Auth::guard('suppliers')->user()->type != 'Manager')
                                <a href="{{url('pending-orders')}}" class="btn btn-primary font-weight-bolder">
            <span class="svg-icon svg-icon-md">
              <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                   height="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                  <rect x="0" y="0" width="24" height="24"/>
                  <circle fill="#000000" cx="9" cy="15" r="6"/>
                  <path
                      d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z"
                      fill="#000000" opacity="0.3"/>
                </g>
              </svg>
                <!--end::Svg Icon-->
            </span> {{__('lang.pending_orders')}}</a>
                        @endif
                    @endif




                    <!--end::Button-->
                    </div>
                </div>
                <div class="card-body">

                    <!--begin: Datatable-->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-checkable mt-10" id="kt_tdata">
                            <thead>
                            <tr style="  font-weight: bold!important;">
                                <th class="headerr">#</th>

                                <th class="headerr">{{__('lang.supplier')}} </th>
                                <th class="headerr">{{__('lang.date')}} </th>
                                <th class="headerr">{{__('lang.order_id')}} </th>
                                <th class="headerr">{{__('lang.UserName')}} </th>
                                <th class="headerr">{{__('lang.main_category')}} </th>
                                <th class="headerr">{{__('lang.total_price')}} </th>
                                <th class="headerr">{{__('lang.type_order')}} </th>
                                @if(Auth::guard('suppliers')->check())
                                    @if(Auth::guard('suppliers')->user()->type != 'Manager')
                                        <th style="width: 325.188px!important;">{{__('lang.Project_Responsible')}} </th>
                                        <th>{{__('lang.DeliverOrder')}} </th>
                                    @endif
                                @endif
                                <th class="headerr"> {{__('lang.view')}} </th>

                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>

                    <!--end: Datatable-->
                </div>

            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>

    <div class="modal fade" id="kt_modal_5" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        {{__('lang.search')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form method="get" action="{{url('/OrderSearch')}}">
                        <div class="col-xl-12">
                            <div class="kt-section__body">
                                <div class="form-group">
                                    <label>{{__('lang.supplier')}} </label>
                                    @inject('Suppliers','App\Models\Supplier')
                                    <select style="width: 100%" class="select2" name="supplier_id">
                                        <option value="0">{{__('lang.all')}}</option>
                                        @foreach($Suppliers->all() as $Supplier)
                                            <option value="{{$Supplier->id}}"> {{$Supplier->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>{{__('lang.MainCategory')}} </label>
                                    @inject('MainCategory','App\Models\MainCategory')
                                    <select style="width: 100%" class="select2" name="main_category_id">
                                        <option value="0">{{__('lang.all')}}</option>
                                        @foreach($MainCategory->all() as $data)
                                            <option value="{{$data->id}}"> {{$data->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>{{__('lang.from')}} </label>
                                    <input type="date" class="form-control form-control-solid" name="from"
                                           placeholder="{{__('lang.from')}}">
                                </div>
                                <div class="form-group">
                                    <label>{{__('lang.to')}} </label>
                                    <input type="date" class="form-control form-control-solid" name="to"
                                           placeholder="{{__('lang.to')}}">
                                </div>

                                <div class="form-group">
                                    <label>{{__('lang.type_order')}}</label>
                                    <select style="width: 100%" class="select2" name="type">
                                        <option value="0">{{__('lang.all')}}</option>
                                        <option value="Pending"> {{__('lang.Pending')}}</option>
                                        <option value="ReOrder"> {{__('lang.ReOrder')}}</option>
                                        <option value="Accepted"> {{__('lang.Accepted')}}</option>
                                        <option value="Delivered"> {{__('lang.Delivered')}}</option>
                                        <option value="Cancelled"> {{__('lang.Cancelled')}}</option>
                                    </select>
                                </div>


                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">{{__('lang.close')}}</button>
                            <button type="submit" class="btn btn-primary">{{__('lang.search')}}</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade bs-edit-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
         aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content card card-outline-info">
                <div class="modal-header card-header">
                    <h3 class="modal-title" id="myLargeModalLabel">{{__('lang.order_details')}}</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


    <div class="modal fade add_deligate" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
         aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content card card-outline-info">
                <div class="modal-header card-header">
                    <h3 class="modal-title" id="myLargeModalLabel">{{__('lang.Deligate_data')}}</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="px-10" novalidate="novalidate" id="deligate">

                        <div class="form-group">
                            <input type="hidden" id="order_id" name="order_id" required/>
                            <input type="text" class="form-control form-control-solid" id="deligate_name"
                                   readonly
                                   placeholder="{{__('lang.deligate_name')}}">

                            <input type="text" class="form-control form-control-solid" id="deligate_phone"
                                   readonly
                                   placeholder="{{__('lang.deligate_phone')}}">
                            <label>{{__('lang.deligate')}} </label>

                            <select class="form-control" name="deligate_id" required>
                                <option value="">اختر مندوب</option>
                                @inject('Deligates','App\Models\Deligate')
                                @foreach($Deligates->where('supplier_id',supplier_parent())->get() as $data)
                                    <option value="{{$data->id}}">{{$data->name}}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">{{__('lang.close')}}</button>
                            <button type="submit" id="submitForm" class="btn btn-primary">{{__('lang.save')}}</button>
                        </div>

                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <div class="modal fade add_deligate_code" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
         aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content card card-outline-info">
                <div class="modal-header card-header">
                    <h3 class="modal-title" id="myLargeModalLabel">{{__('lang.Deligate_Code')}}</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="px-10" novalidate="novalidate" id="deligate_code">
                        <div class="form-group">
                            <input type="hidden" id="order_id_code" name="order_id" required/>
                            <input type="code" class="form-control form-control-solid" name="code" required
                                   placeholder="{{__('lang.code')}}">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">{{__('lang.close')}}</button>
                            <button type="submit" id="submitCodeForm"
                                    class="btn btn-primary">{{__('lang.save')}}</button>
                        </div>

                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{url('/DeliveryOrder')}}" method="post">

                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <input type="hidden" name="order_id" class="form-control" id="order_id">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">{{__('lang.code')}}:</label>
                            <input type="number" name="delivery_code" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{__('lang.close')}}</button>
                        <button type="submit" id="submitCodeForm"
                                class="btn btn-primary">{{__('lang.save')}}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@section('js')
    <script src="{{asset('dashboard/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/pages/crud/datatables/basic/basic.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/pages/crud/file-upload/image-input.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/pages/features/miscellaneous/sweetalert2.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/pages/features/miscellaneous/dropify.min.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/pages/crud/forms/widgets/select2.js')}}"></script>


    <script type="text/javascript">
        $(function () {
            var table = $('#kt_tdata').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                responsive: true,
                aaSorting: [],
                "dom": "<'card-header border-0 p-0 pt-6'<'card-title' <'d-flex align-items-center position-relative my-1'f> r> <'card-toolbar' <'d-flex justify-content-end add_button'B> r>>  <'row'l r> <''t><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable
                lengthMenu: [[10, 25, 50, 100, 250, -1], [10, 25, 50, 100, 250, "الكل"]],
                "language": {
                    search: '<i class="fa fa-eye" aria-hidden="true"></i>',
                    searchPlaceholder: 'بحث سريع',
                    "url": "{{ url('admin/assets/ar.json') }}"
                },
                buttons: [
                    {extend: 'print', className: 'btn btn-light-primary me-3', text: '<i class="bi bi-printer-fill fs-2x"></i>'},
                    // {extend: 'pdf', className: 'btn btn-raised btn-danger', text: 'PDF'},
                    {extend: 'excel', className: 'btn btn-light-primary me-3', text: '<i class="bi bi-file-earmark-spreadsheet-fill fs-2x"></i>'},
                    // {extend: 'colvis', className: 'btn secondary', text: 'إظهار / إخفاء الأعمدة '}
                ],
                ajax: {
                    url: '{{ route('orders.datatable.data') }}',
                    data: {
                    }
                },
                columns: [
                    {data: 'checkbox', name: 'checkbox', "searchable": false, "orderable": false},
                    {data: 'supplier_id', name: 'name', "searchable": true, "orderable": true},
                    {data: 'created_at', name: 'created_at', "searchable": true, "orderable": true},
                    {data: 'id', name: 'id', "searchable": true, "orderable": true},
                    {data: 'user_id', name: 'user_id', "searchable": true, "orderable": true},
                    {data: 'main_category_id', name: 'main_category_id', "searchable": true, "orderable": true},
                    {data: 'total_price', name: 'total_price', "searchable": true, "orderable": true},
                    {data: 'type', name: 'type', "searchable": true, "orderable": true},
                    @if(Auth::guard('suppliers')->check() && Auth::guard('suppliers')->user()->type != 'Manager')
                    {data: 'supplier_buttons', name: 'supplier_buttons', "searchable": true, "orderable": true},
                    {data: 'supplier_buttons2', name: 'supplier_buttons2', "searchable": true, "orderable": true},
                    @endif
                    {data: 'actions', name: 'actions', "searchable": false, "orderable": false},

                ]
            });
            {{--$.ajax({--}}
            {{--    url: "{{ URL::to('/add-button-Coupons')}}",--}}
            {{--    success: function (data) { $('.add_button').append(data); },--}}
            {{--    dataType: 'html'--}}
            {{--});--}}
        });
    </script>


    <script>
        $(".DeliveryOrder").click(function () {
            var id = $(this).data('id')
            $.ajax({
                type: "GET",
                url: "{{url('order-details')}}",
                data: {"id": id},
                success: function (data) {
                    $(".bs-edit-modal-lg .modal-body").html(data)
                    $(".bs-edit-modal-lg").modal('show')
                    $(".bs-edit-modal-lg").on('hidden.bs.modal', function (e) {
                        //   $('.bs-edit-modal-lg').empty();
                        $('.bs-edit-modal-lg').hide();
                    })
                }
            })
        })
        $('#exampleModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('whatever') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('.modal-title').text('{{__('lang.DeliverOrder')}} : ' + recipient)
            modal.find('.modal-body #order_id').val(recipient)
        })

        //DataTable
        {{--var table = $('#kt_tdata').DataTable({--}}

        {{--    dom: 'Bfrtip',--}}
        {{--    "ordering": false,--}}
        {{--    buttons: [--}}
        {{--        'copy', 'excel', 'print'--}}
        {{--    ],--}}
        {{--    @if(session('lang') != 'en')--}}

        {{--    "language": {--}}
        {{--        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Arabic.json"--}}
        {{--    }--}}
        {{--    @endif--}}
        {{--});--}}

        $(document).ready(function () {

            $(".headerr").attr("style", 'font-weight: bold!important;');

        });
    </script>
    <!--begin::Page scripts(used by this page) -->

    <!--begin::Page scripts(used by this page) -->
    <script>
        $('#kt_select2_101').select2({
            placeholder: ""
        });
        $('.select2').select2({
            placeholder: ""
        });
        //Delete Row
        $("body").on("click", "#delete", function () {
            var dataList = [];
            dataList = $("#kt_tdata .selected").map(function () {
                return $(this).val();
            }).get();

                if (dataList.length > 0) {
                    Swal.fire({
                        title: "{{__('lang.warrning')}}",
                        text: "",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#f64e60",
                        confirmButtonText: "{{__('lang.btn_yes')}}",
                        cancelButtonText: "{{__('lang.btn_no')}}",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    }).then(function (result) {
                        if (result.value) {
                            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                            $.ajax({
                                url: '{{url("Delete_User")}}',
                                type: "get",
                                data: {'id': dataList, _token: CSRF_TOKEN},
                                dataType: "JSON",
                                success: function (data) {
                                    if (data.message == "Success") {
                                        $("#kt_datatable .selected").hide();
                                        @if( Request::segment(1) == "ar")
                                        $('#delete').text('حذف 0 سجل');
                                        @else
                                        $('#delete').text('Delete 0 row');
                                        @endif
                                        Swal.fire("{{__('lang.Success')}}", "{{__('lang.Success_text')}}", "success");
                                        location.reload();
                                    } else {
                                        Swal.fire("{{__('lang.Sorry')}}", "{{__('lang.Message_Fail_Delete')}}", "error");
                                    }
                                },
                                fail: function (xhrerrorThrown) {
                                    Swal.fire("{{__('lang.Sorry')}}", "{{__('lang.Message_Fail_Delete')}}", "error");
                                }
                            });
                            // result.dismiss can be 'cancel', 'overlay',
                            // 'close', and 'timer'
                        } else if (result.dismiss === 'cancel') {
                            Swal.fire("{{__('lang.Cancelled')}}", "{{__('lang.Message_Cancelled_Delete')}}", "error");
                        }
                    });
                }
        });

        $(document).ready(function () {
            // Basic
            $('.dropify').dropify();

            // Used events
            var drEvent = $('#input-file-events').dropify();

            drEvent.on('dropify.beforeClear', function (event, element) {
                return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
            });

            drEvent.on('dropify.afterClear', function (event, element) {
                alert('File deleted');
            });

            drEvent.on('dropify.errors', function (event, element) {
                console.log('Has Errors');
            });

            var drDestroy = $('#input-file-to-destroy').dropify();
            drDestroy = drDestroy.data('dropify')
            $('#toggleDropify').on('click', function (e) {
                e.preventDefault();
                if (drDestroy.isDropified()) {
                    drDestroy.destroy();
                } else {
                    drDestroy.init();
                }
            })
        });


        $(".edit-inboxGroup").click(function () {
            var id = $(this).data('id')
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: "GET",
                url: "{{url('Edit_UserinboxGroup')}}",
                data: {"id": id},
                success: function (data) {
                    $(".bs-edit-modal-lg .modal-body").html(data)
                    $(".bs-edit-modal-lg").modal('show')
                    $(".bs-edit-modal-lg").on('hidden.bs.modal', function (e) {
                        //   $('.bs-edit-modal-lg').empty();
                        $('.bs-edit-modal-lg').hide();
                    })
                }
            })
        })

        //End Delete Row


        $(".edit-Advert").click(function () {
            var id = $(this).data('id')
            $.ajax({
                type: "GET",
                url: "{{url('order-details')}}",
                data: {"id": id},
                success: function (data) {
                    $(".bs-edit-modal-lg .modal-body").html(data)
                    $(".bs-edit-modal-lg").modal('show')
                    $(".bs-edit-modal-lg").on('hidden.bs.modal', function (e) {
                        //   $('.bs-edit-modal-lg').empty();
                        $('.bs-edit-modal-lg').hide();
                    })
                }
            })
        })


        $(".edit-Adverts").click(function () {
            var id = $(this).data('id');
            var project_id = $(this).data('project-id');
            $.ajax({
                type: "GET",
                url: "{{url('Edit_User_notation')}}",
                data: {"id": id, "project_id": project_id},
                success: function (data) {
                    $(".bs-edit-modal-lg .modal-body").html(data)
                    $(".bs-edit-modal-lg").modal('show')
                    $(".bs-edit-modal-lg").on('hidden.bs.modal', function (e) {
                        //   $('.bs-edit-modal-lg').empty();
                        $('.bs-edit-modal-lg').hide();
                    })
                }
            })
        })

        $(".switchery-demo").click(function () {
            var id = $(this).data('id')
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: "get",
                url: "{{url('UpdateStatusUser')}}",
                data: {"id": id, _token: CSRF_TOKEN},
                success: function (data) {
                    Swal.fire("@if(Request::segment(1) == 'ar' ) تم  @else Success @endif ", "@if(Request::segment(1) == 'ar' ) تم التعديل بنجاح   @else Successfully changed @endif", "success");

                }
            })
        })


        $('#deligate').submit(function (event) {

            var formdata = $('#deligate').serialize();
            console.log(jQuery('#order_id').val());
            $.ajax({
                url: "/addDeligate",
                type: "POST",
                data: formdata,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    console.log(formdata);
                    console.log(response);
                    if (response.errors) {
                        $.each(response.errors, function (k, v) {
                            $('#deligate').prepend("<p style='color: red'>" + v + "</p>");
                        })
                    } else {
                        $(".add_deligate").modal('hide');
                        $('#order_id_code').val(jQuery('#order_id').val());
                        Swal.fire({
                            icon: 'success',
                            title: "{{__('lang.Success')}}",
                            text: "{{__('lang.Success_text')}}",
                            type: "success",
                            timer: 3000,
                            showConfirmButton: false
                        });
                    }
                },

            });
        });

        $('#deligate_code').submit(function (event) {
            event.preventDefault();
            var formdata = $('#deligate_code').serialize();
            console.log(formdata);
            $.ajax({
                url: "/deligate-code",
                type: "POST",
                data: formdata,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    console.log(formdata);
                    console.log(response);
                    if (response.errors) {
                        $.each(response.errors, function (k, v) {
                            $('#deligate_code').prepend("<p style='color: red'>" + v + "</p>");
                        })
                    } else {
                        var delay = 2000;
                        var url = '{{url('/orders')}}'
                        setTimeout(function () {
                            window.location = url;
                        }, delay);
                    }
                },

            });
        });

        $(".add-deligate").click(function () {
            var order_id = $(this).data('id');
            console.log(order_id);
            $('#deligate_name').val('');
            $('#deligate_phone').val('');
            $.ajax({
                url: "/orders_ajax/" + order_id,
                dataType: "json",
                success: function (html) {
                    if (html.order.has_deligate == 1) {
                        $('#deligate_name').val(html.order.deligate_name);
                        $('#deligate_phone').val(html.order.deligate_phone);
                    }
                }
            })
            $('#order_id').val(order_id);
            $(".add_deligate").modal('show');

        });

    </script>

    <?php
    $message = session()->get("message");
    ?>

    @if( session()->has("message"))
        @if( $message == "Success")
            <script>
                Swal.fire({
                    icon: 'success',
                    title: "{{__('lang.Success')}}",
                    text: "{{__('lang.Success_text')}}",
                    type: "success",
                    timer: 3000,
                    showConfirmButton: false
                });

            </script>
        @elseif ( $message == "Failed")
            <script>
                Swal.fire({
                    icon: 'warning',
                    title: "{{__('lang.Sorry')}}",
                    text: "{{__('lang.operation_failed')}}",
                    type: "error",
                    timer: 2000,
                    showConfirmButton: false
                });
            </script>
        @endif

        @if( $message == "FailedCode1")
            <script>
                Swal.fire({
                    icon: 'warning',
                    title: "{{__('lang.Sorry')}}",
                    text: "عفوا كود التاكيد غير صحيح",
                    type: "error",
                    timer: 4000,
                    showConfirmButton: false
                });
            </script>
        @endif
        @if( $message == "email")
            <script>
                Swal.fire({
                    icon: 'warning',
                    title: "{{__('lang.Sorry')}}",
                    text: "عفوا البريد الالكتروني موجود بالفعل",
                    type: "error",
                    timer: 2000,
                    showConfirmButton: false
                });
            </script>
        @endif
        @if( $message == "job_num")
            <script>
                Swal.fire({
                    icon: 'warning',
                    title: "{{__('lang.Sorry')}}",
                    text: "عفوا رقم الوظيفة موجود بالفعل",
                    type: "error",
                    timer: 2000,
                    showConfirmButton: false
                });
            </script>
        @endif
        @if( $message == "contract_num")
            <script>
                Swal.fire({
                    icon: 'warning',
                    title: "{{__('lang.Sorry')}}",
                    text: "عفوا رقم العقد موجود بالفعل",
                    type: "error",
                    timer: 2000,
                    showConfirmButton: false
                });
            </script>
        @endif
    @endif

@endsection

@endsection

