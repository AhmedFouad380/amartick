@extends('layout.layout')

@section('title')
    {{__('lang.AccouontRequests')}}
@endsection
@section('css')
    <link href="{{asset('dashboard/assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet"
          type="text/css"/>
    <link rel="stylesheet" href="{{asset('dashboard/dropify/dist/css/dropify.min.css')}}">

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
                                <h5 class="text-dark font-weight-bold my-1 mr-5 ">{{trans('lang.AccouontRequests')}}</h5>
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
                        <h3 class="card-label">{{__('lang.AccouontRequests')}}

                    </div>

                    <div class="card-toolbar">
                        <!--begin::Button-->
                        <button  style="margin: 6px"  type="button" data-toggle="modal" data-toggle="modal"
                                 data-target="#kt_modal_5" class="btn btn-success font-weight-bolder">
                            &nbsp;&nbsp;<i class="flaticon2-magnifier-tool"></i>

                            {{__('lang.search')}}</button>
                        @if (Auth::guard('admins')->user()->can('AddEditDelete'))
                        <button type="button" data-toggle="modal" data-toggle="modal" data-target="#kt_modal_4"
                                class="btn btn-primary font-weight-bolder">
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
            </span> {{__('lang.WalletCreate')}}</button>
                        @endif
                    </div>

                </div>
                <div class="card-body">

                    <!--begin: Datatable-->
                    <table class="table table-bordered table-hover table-checkable mt-10" id="kt_tdata">
                        <thead>
                        <tr>
                            <th style="display: none">#</th>
                            <th>#</th>
                            <th class="headerr">{{__('lang.supplier')}} </th>
                            <th class="headerr">{{__('lang.price')}} </th>
                            <th class="headerr">{{__('lang.date')}} </th>
                            <th class="headerr">{{__('lang.description')}} </th>
                            <th class="headerr">{{__('lang.file')}} </th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($Users as $key => $User)
                            <tr>

                                <td style="display: none">{{$User->id}}</td>
                                <td>{{$key +1 }}</td>
                                <td>{{$User->Supplier->name}}</td>
                                <td>{{$User->price}}</td>
                                <td>{{Carbon\Carbon::parse($User->created_at)->translatedFormat('d M Y')}}</td>
                                <td>{{$User->description}}</td>
                                <td> @if($User->file ) <a href="{{$User->file}}" download > <i class="fa fa-download"></i></a> @endif  </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <!--end: Datatable-->
                    <div class="row justify-content-center mt-5">
                        <nav aria-label="Page navigation example">
                            @php
                                $paginator =$Users->appends(request()->input())->links()->paginator;
                                    if ($paginator->currentPage() < 2 ){
                                        $link = $paginator->currentPage();
                                    }else{
                                         $link = $paginator->currentPage() -1;
                                    }
                                    if($paginator->currentPage() == $paginator->lastPage()){
                                               $last_links = $paginator->currentPage();
                                    }else{
                                               $last_links = $paginator->currentPage() +1;

                                    }
                            @endphp
                            @if ($paginator->lastPage() > 1)
                                <ul class="pagination">
                                    <li class="{{ ($paginator->currentPage() == 1) ? ' disabled' : '' }} page-item">
                                        <a class="page-link" href="{{ $paginator->url(1) }}">?????????? </a>
                                    </li>
                                    @for ($i = $link; $i <= $last_links; $i++)
                                        <li class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }} page-item">
                                            <a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a>
                                        </li>
                                    @endfor
                                    <li class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }} page-item">
                                        <a class="page-link"
                                           href="{{ $paginator->url($paginator->lastPage()) }}">????????????</a>
                                    </li>
                                </ul>
                            @endif

                        </nav>
                    </div>

                </div>

            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <div class="modal fade" id="kt_modal_5" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        {{__('lang.search')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form method="get" action="{{url('/AccouontRequestSearch')}}" enctype="multipart/form-data">
                        <div class="col-xl-12">
                            <div class="kt-section__body">

                                <div class="form-group">
                                    <label>{{__('lang.supplier')}}</label>
                                    <select name="supplier_id" class="form-control">
                                        <option value="0">????????</option>
                                        @inject('suppliers','App\Models\Supplier')
                                        @foreach($suppliers->all() as $data)
                                            <option value="{{$data->id}}">{{$data->name}}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label"> {{__('lang.from')}}  </label>
                                    <div class="col-lg-9 col-xl-9">
                                        <input class="form-control form-control-solid" type="date"  name="from" value="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label"> {{__('lang.to')}}  </label>
                                    <div class="col-lg-9 col-xl-9">
                                        <input class="form-control form-control-solid" type="date"  name="to" value="">
                                    </div>
                                </div>



                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('lang.close')}}</button>
                            <button type="submit" class="btn btn-primary">{{__('lang.search')}}</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>


    <div class="modal fade" id="kt_modal_4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        {{__('lang.WalletCreate')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form class="px-10" novalidate="novalidate" id="kt_form" method="post" enctype="multipart/form-data"
                          action="{{url('create-AccouontRequests')}}" >
                        @csrf
                        <div class="form-group">
                            <label>{{__('lang.amount')}} </label>
                            <input type="number" class="form-control form-control-solid" name="price" required placeholder="{{__('lang.amount')}}" >
                        </div>
                        @if(Auth::guard('admins')->check())
                            <div class="form-group">
                                <label>{{__('lang.supplier')}}</label>
                                <select name="supplier_id" class="form-control">
                                    @inject('suppliers','App\Models\Supplier')
                                    @foreach($suppliers->all() as $data)
                                        <option value="{{$data->id}}">{{$data->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                                <input type="hidden" name="supplier_id" value="{{Auth::guard('suppliers')->user()->id}}">
                            @endif
                        <div class="form-group">
                            <label>{{__('lang.description')}} </label>
                            <textarea type="text" rows="5" class="form-control form-control-solid" name="description" required placeholder=""  >{{__('lang.description')}}</textarea>
                        </div>
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label">{{__('lang.file')}}</label>
                            <div class="col-lg-12 col-xl-12">
                                <div class="card">
                                    <div class="card-block">
                                        <h4 class="card-title"></h4>
                                        <div class="controls">
                                            <input type="file" id="input-file-now" class="dropify" name="file"
                                                   />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">{{__('lang.Close')}}</button>
                            <button type="submit" class="btn btn-primary">{{__('lang.save')}}</button>
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
                    <h3 class="modal-title" id="myLargeModalLabel">{{__('lang.Users_Edit')}}</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">??</button>
                </div>
                <div class="modal-body">

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- /.modal -->

@section('js')
    <script src="{{asset('dashboard/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/pages/crud/datatables/basic/basic.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/pages/crud/file-upload/image-input.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/pages/features/miscellaneous/sweetalert2.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/pages/features/miscellaneous/dropify.min.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/pages/custom/wizard/wizard-6.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/pages/crud/forms/widgets/select2.js')}}"></script>

    <script>
        //DataTable
      	var table = $('#kt_tdata').DataTable({
 			dom: 'Bfrtip',
 			"ordering":false,
 			  buttons: [
         'copy', 'excel', 'print'
     ],
 			@if(session('lang') != 'en')

 					"language": {
 							"url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Arabic.json"
 					}
 			@endif
 	});

 		$( document ).ready(function() {

          $(".headerr").attr("style",'font-weight: bold!important;');

});
    </script>

    <script>

        $('#kt_tdata tbody').on('click', 'tr', function () {
            if (event.ctrlKey) {
                $(this).toggleClass('selected');
                @if( Request::segment(1) == "ar")
                $('#delete').text('?????? ' + table.rows('.selected').data().length + ' ??????');
                @else
                $('#delete').text('Delete ' + table.rows('.selected').data().length + ' row');
                @endif
            } else {
                var isselected = false
                var numSelected = table.rows('.selected').data().length
                if ($(this).hasClass('selected') && numSelected == 1) {
                    isselected = true
                }
                $('#myTable tbody tr').removeClass('selected');
                if (!isselected) {
                    $(this).toggleClass('selected');
                }
                @if( Request::segment(1) == "ar")
                $('#delete').text('?????? ' + table.rows('.selected').data().length + ' ??????');
                @else
                $('#delete').text('Delete ' + table.rows('.selected').data().length + ' row');
                @endif
            }
        });
        $("body").on("click", "#delete", function () {
            var dataList = [];
            $("#kt_tdata .selected").each(function (index) {
                dataList.push($(this).find('td:first').text())
            })
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
                            url: '{{url("delete-AccouontRequests")}}',
                            type: "get",
                            data: {'id': dataList},
                            dataType: "JSON",
                            success: function (data) {
                                if (data.message == "Success") {
                                    $("#kt_datatable .selected").hide();
                                    @if(session('lang') == 'ar')

                                    $('#delete').text('?????? 0 ??????');
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


    </script>

    <!--begin::Page scripts(used by this page) -->
    <script type="text/javascript">


        $(function () {

            initHijrDatePicker();

            //initHijrDatePickerDefault();

            $('.disable-date').hijriDatePicker({

                minDate: "2020-01-01",
                maxDate: "2021-01-01",
                viewMode: "years",
                hijri: true,
                debug: true
            });

        });

        function initHijrDatePicker() {

            $(".hijri-date-input").hijriDatePicker({
                locale: "ar-sa",
                format: "DD-MM-YYYY",
                hijriFormat: "iYYYY-iMM-iDD",
                dayViewHeaderFormat: "MMMM YYYY",
                hijriDayViewHeaderFormat: "iMMMM iYYYY",
                showSwitcher: true,
                allowInputToggle: true,
                showTodayButton: false,
                useCurrent: true,
                isRTL: false,
                viewMode: 'months',
                keepOpen: false,
                hijri: false,
                debug: true,
                showClear: true,
                showTodayButton: true,
                showClose: true
            });
        }

        function initHijrDatePickerDefault() {

            $(".hijri-date-input").hijriDatePicker();
        }


    </script>
    <!--begin::Page scripts(used by this page) -->
    <script>
        $('#kt_select2_101').select2({
            placeholder: ""
        });
        $('#kt_select2_11').select2({
            placeholder: ""
        });
        //Delete Row

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


        $(".edit-Advert").click(function () {
            var id = $(this).data('id')
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: "GET",
                url: "{{url('Edit_ProductsImages')}}",
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

        $(".switchery-demo").click(function () {
            var id = $(this).data('id')
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: "get",
                url: "{{url('UpdateStatusUser')}}",
                data: {"id": id, _token: CSRF_TOKEN},
                success: function (data) {
                    Swal.fire("@if(Request::segment(1) == 'ar' ) ????  @else Success @endif ", "@if(Request::segment(1) == 'ar' ) ???? ?????????????? ??????????   @else Successfully changed @endif", "success");

                }
            })
        })
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
                    timer: 1000,
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

        @if( $message == "phone")
            <script>
                Swal.fire({
                    icon: 'warning',
                    title: "{{__('lang.Sorry')}}",
                    text: "???????? ?????? ???????????? ?????????? ????????????",
                    type: "error",
                    timer: 2000,
                    showConfirmButton: false
                });
            </script>
        @endif
        @if( $message == "email")
            <script>
                Swal.fire({
                    icon: 'warning',
                    title: "{{__('lang.Sorry')}}",
                    text: "???????? ???????????? ???????????????????? ?????????? ????????????",
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
                    text: "???????? ?????? ?????????????? ?????????? ????????????",
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
                    text: "???????? ?????? ?????????? ?????????? ????????????",
                    type: "error",
                    timer: 2000,
                    showConfirmButton: false
                });
            </script>
        @endif
    @endif

@endsection

@endsection

