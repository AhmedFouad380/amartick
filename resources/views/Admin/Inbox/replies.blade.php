@extends('layout.layout')

@section('title')
    {{__('lang.replies')}}
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
    <link rel="stylesheet" href="{{asset('dashboard/dropify/dist/css/dropify.min.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{asset('dashboard/assets/css/pages/login/login-3.rtl.css')}}" rel="stylesheet" type="text/css"/>

@endsection

@section('content')


    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
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
                        <h5 class="text-dark font-weight-bold my-1 mr-5">{{trans('lang.replies')}}</h5>
                        <!--end::Page Title-->
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">

                            <li class="breadcrumb-item">
                                <a href="{{url()->previous()}}" class="text-muted">{{trans('lang.inbox')}}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#" class="text-muted">{{trans('lang.replies')}}</a>
                            </li>
                        </ul>
                        <!--end::Breadcrumb-->
                    </div>
                    <!--end::Page Heading-->
                </div>
                <!--end::Info-->

                <!--begin::Toolbar-->

                <!--end::Toolbar-->
            </div>
        </div>
        <!--end::Subheader-->
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <br><br><br>
                <!--begin::Inbox-->
                <div class="d-flex flex-row">
                    <div class="flex-row-fluid ml-lg-8 d-block" id="kt_inbox_view">
                        <!--begin::Card-->
                        <div class="card card-custom card-stretch">

                            <!--begin::Body-->
                            <div class="card-body p-5">
                                <div class="px-4 mt-4 mb-10">
                                    <button type="button" data-toggle="modal" data-toggle="modal"
                                            data-target="#kt_modal_4"
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
            </span> {{__('lang.send_reply')}}</button>

                                </div>
                                <!--begin::Messages-->
                                <div class="mb-3">
                                    <div class="cursor-pointer shadow-xs toggle-on" data-inbox="message">
                                        <!--begin::Message Heading-->
                                        <div
                                            class="d-flex card-spacer-x py-6 flex-column flex-md-row flex-lg-column flex-xxl-row justify-content-between">
                                            <div class="d-flex align-items-center">
																<span class="symbol symbol-50 mr-4">
																	<span class="symbol-label"
                                                                          style="background-image: url('{{$Users->getSender->image}}')"></span>
																</span>
                                                <div class="d-flex flex-column flex-grow-1 flex-wrap mr-2">
                                                    <div class="d-flex">
                                                        <a href="#"
                                                           class="font-size-lg font-weight-bolder text-dark-75 text-hover-primary mr-2">{{$Users->getSender->name}}</a>
                                                        <div class="font-weight-bold text-muted">
                                                            <span
                                                                class="label label-success label-dot mr-2"></span> {{Carbon\Carbon::parse($Users->created_at)->diffForHumans()}}
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-column">
                                                        <div class="toggle-off-item">
																			<span
                                                                                class="font-weight-bold text-muted cursor-pointer"
                                                                                data-toggle="dropdown">to {{$Users->getReciever->name}}
																			<i class="flaticon2-down icon-xs ml-1 text-dark-50"></i></span>
                                                            <div
                                                                class="dropdown-menu dropdown-menu-lg dropdown-menu-left p-5">
                                                                <table>
                                                                    <tr>
                                                                        <td class="text-muted min-w-75px py-2">From</td>
                                                                        <td>{{$Users->getSender->name}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-muted py-2">Date:</td>
                                                                        <td>{{\Carbon\Carbon::parse($Users->created_at)->translatedFormat('M d Y h:i')}}</td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="text-muted font-weight-bold toggle-on-item"
                                                             data-inbox="toggle">
                                                            {{--                                                            {!! substr($Users->message , 0 , 50) !!}....--}}
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="d-flex my-2 my-xxl-0 align-items-md-center align-items-lg-start align-items-xxl-center flex-column flex-md-row flex-lg-column flex-xxl-row">
                                                <div
                                                    class="font-weight-bold text-muted mx-2">{{\Carbon\Carbon::parse($Users->created_at)->translatedFormat('M d Y h:i')}}</div>
                                            </div>
                                        </div>
                                        <!--end::Message Heading-->
                                        <div class="card-spacer-x py-3 toggle-off-item">
                                            {!! $Users->message  !!}
                                            <br>
                                            <br>
                                            <div class="card-spacer-x  toggle-off-item">
                                                <div class="row">
                                                    @if($Users->supplier_id != null)
                                                        <div class="col-lg-3">
                                                            <a href="{{url('supplier/'.$Users->supplier_id)}}"
                                                               class="btn btn-info"><i
                                                                    class="fa fa-mail-bulk"></i>{{trans('lang.supplier')}}
                                                            </a>
                                                        </div>
                                                    @endif
                                                    @if($Users->is_order == 1)
                                                        <div class="col-lg-3">
                                                            <a href="{{url('pending-orders',$Users->order->id)}}" class="btn btn-info"><i
                                                                    class="fa fa-mail-bulk"></i>{{trans('lang.order')}}
                                                            </a>
                                                        </div>

                                                    @endif
                                                    @if($Users->order)
                                                        @if($Users->order->payment_status == 1)
                                                            <div class="col-lg-3">
                                                                <a data-id="{{$Users->order->user_id}}"
                                                                   data-project-id="{{$Users->order->project_id}}"
                                                                   data-original-title="{{__('lang.Customer_data')}}"
                                                                   title="{{__('lang.Customer_data')}}"
                                                                   class="btn btn-secondary edit-Advert">
                                                                    <i class="fa fa-user"></i>{{trans('lang.Customer_data')}}
                                                                </a>
                                                            </div>

                                                            <div class="col-lg-3">
                                                                <a data-id="{{$Users->order->user_id}}"
                                                                   data-original-title="{{__('lang.Deligate_data')}}"
                                                                   title="{{__('lang.Deligate_data')}}"
                                                                   class="btn btn-primary add-deligate">
                                                                    <i class="fa fa-shipping-fast"></i>{{trans('lang.Deligate_data')}}
                                                                </a>
                                                            </div>


                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-spacer-x py-3 toggle-off-item">
                                            @foreach($Users->files as $file)
                                                <a href="{{url("$file->file")}}" target="_blank">  <span
                                                        class="svg-icon svg-icon-primary svg-icon-6x"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Files\DownloadedFile.svg--><svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <polygon points="0 0 24 0 24 24 0 24"/>
                                                        <path
                                                            d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z"
                                                            fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                        <path
                                                            d="M14.8875071,11.8306874 L12.9310336,11.8306874 L12.9310336,9.82301606 C12.9310336,9.54687369 12.707176,9.32301606 12.4310336,9.32301606 L11.4077349,9.32301606 C11.1315925,9.32301606 10.9077349,9.54687369 10.9077349,9.82301606 L10.9077349,11.8306874 L8.9512614,11.8306874 C8.67511903,11.8306874 8.4512614,12.054545 8.4512614,12.3306874 C8.4512614,12.448999 8.49321518,12.5634776 8.56966458,12.6537723 L11.5377874,16.1594334 C11.7162223,16.3701835 12.0317191,16.3963802 12.2424692,16.2179453 C12.2635563,16.2000915 12.2831273,16.1805206 12.3009811,16.1594334 L15.2691039,12.6537723 C15.4475388,12.4430222 15.4213421,12.1275254 15.210592,11.9490905 C15.1202973,11.8726411 15.0058187,11.8306874 14.8875071,11.8306874 Z"
                                                            fill="#000000"/>
                                                    </g>
                                                </svg><!--end::Svg Icon--></span>
                                                </a>
                                            @endforeach

                                        </div>

                                    </div>
                                    <div style="padding-right: 50px">
                                        @foreach($Users->childreninboxes as $user)
                                            <div class="cursor-pointer shadow-xs toggle-off" data-inbox="message">
                                                <!--begin::Message Heading-->
                                                <div
                                                    class="d-flex card-spacer-x py-6 flex-column flex-md-row flex-lg-column flex-xxl-row justify-content-between">
                                                    <div class="d-flex align-items-center">
																<span class="symbol symbol-50 mr-4">
																	<span class="symbol-label"
                                                                          style="background-image: url('{{$user->getSender->image}}')"></span>
																</span>
                                                        <div class="d-flex flex-column flex-grow-1 flex-wrap mr-2">
                                                            <div class="d-flex">
                                                                <a href="#"
                                                                   class="font-size-lg font-weight-bolder text-dark-75 text-hover-primary mr-2">{{$user->getSender->name}}</a>
                                                                <div class="font-weight-bold text-muted">
                                                            <span
                                                                class="label label-success label-dot mr-2"></span> {{Carbon\Carbon::parse($user->created_at)->diffForHumans()}}
                                                                </div>
                                                            </div>
                                                            <div class="d-flex flex-column">
                                                                <div class="toggle-off-item">
																			<span
                                                                                class="font-weight-bold text-muted cursor-pointer"
                                                                                data-toggle="dropdown">to {{$user->getReciever->name}}
																			<i class="flaticon2-down icon-xs ml-1 text-dark-50"></i></span>
                                                                    <div
                                                                        class="dropdown-menu dropdown-menu-lg dropdown-menu-left p-5">
                                                                        <table>
                                                                            <tr>
                                                                                <td class="text-muted min-w-75px py-2">
                                                                                    From
                                                                                </td>
                                                                                <td>{{$user->getSender->name}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-muted py-2">Date:</td>
                                                                                <td>{{\Carbon\Carbon::parse($user->created_at)->translatedFormat('M d Y h:i')}}</td>
                                                                            </tr>


                                                                        </table>
                                                                    </div>
                                                                </div>
                                                                <div class="text-muted font-weight-bold toggle-on-item"
                                                                     data-inbox="toggle">
                                                                    {{--                                                                    {{ substr( html_entity_decode($user->message) , 0 , 50) }}....--}}

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="d-flex my-2 my-xxl-0 align-items-md-center align-items-lg-start align-items-xxl-center flex-column flex-md-row flex-lg-column flex-xxl-row">
                                                        <div
                                                            class="font-weight-bold text-muted mx-2">{{\Carbon\Carbon::parse($user->created_at)->translatedFormat('M d Y h:i')}}</div>
                                                    </div>
                                                </div>
                                                <!--end::Message Heading-->

                                                <div class="card-spacer-x py-3 toggle-on-item">
                                                    {!! html_entity_decode($user->message)  !!}
                                                </div>

                                                <div class="card-spacer-x py-3 toggle-off-item">
                                                    @foreach($user->files as $file)
                                                        <a href="{{url("$file->file")}}" target="_blank"><i
                                                                class="fa fa-file"></i>
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                </div>
                                <!--end::Messages-->

                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Card-->
                    </div>
                </div>
                <!--end::Inbox-->

            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>


    <div class="modal fade" id="kt_modal_4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        {{__('lang.send_reply')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form class="px-10" novalidate="novalidate" id="kt_form" method="post"
                          action="{{url('sendReply')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>{{__('lang.message')}} </label>
                            <textarea name="message" id="kt-ckeditor-1">
												 {{__('lang.message')}}
												 	</textarea>

                            <input type="hidden" class="form-control form-control-solid" name="inbox_id" required
                                   value="{{$Users->id}}">

                        </div>
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label">{{__('lang.file')}}</label>
                            <div class="col-lg-12 col-xl-12">
                                <div class="card">
                                    <div class="card-block">
                                        <h4 class="card-title"></h4>
                                        <div class="controls">
                                            <input type="file" id="input-file-now" class="dropify" name="file[]"
                                                   multiple/>
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
                    <h3 class="modal-title" id="myLargeModalLabel">{{__('lang.Customer_data')}}</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


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
                                   name="deligate_name" required
                                   placeholder="{{__('lang.deligate_name')}}">
                        </div>
                        <div class="form-group">
                            <input type="number" class="form-control form-control-solid" id="deligate_phone"
                                   name="deligate_phone" required
                                   placeholder="{{__('lang.deligate_phone')}}">
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
@endsection
@section('js')
    <script src="{{asset('dashboard/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/pages/crud/datatables/basic/basic.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/pages/crud/file-upload/image-input.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/pages/features/miscellaneous/sweetalert2.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/pages/features/miscellaneous/dropify.min.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/pages/custom/wizard/wizard-6.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/pages/crud/forms/widgets/select2.js')}}"></script>
    <script src="{{asset('hijri/js/momentjs.js')}}"></script>
    <script src="{{asset('hijri/js/moment-with-locales.js')}}"></script>
    <script src="{{asset('hijri/js/moment-hijri.js')}}"></script>
    <script src="{{asset('hijri/js/bootstrap-hijri-datetimepicker.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/pages/custom/inbox/inbox.js')}}"></script>

    <script src="{{asset('dashboard/assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/pages/crud/forms/editors/ckeditor-classic.js')}}"></script>


    @if(session('lang') !='en')
        <script>
            $(document).ready(function () {
                $('.ck.ck-editor__editable_inline[dir=ltr]').css("text-align", "right");
            });
        </script>

    @endif

    <script>

        $('#deligate').submit(function (event) {
            event.preventDefault();
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
                        $(".add_deligate_code").modal('show');
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


        $(".edit-Advert").click(function () {
            var id = $(this).data('id');
            var project_id = $(this).data('project-id');
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
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
        });
        $("#receiver_type").change(function () {
            var type = document.getElementById("receiver_type").value;

            $.ajax({
                url: "/get-users/" + type,
                dataType: "json",
                success: function (html) {
                    $("#receiver_id").html('');

                    console.log(html);
                    $.each(html.users, function (i, value) {
                        $("#receiver_id").append('<option value=' + value.id + '>' + value.name + '</option>');

                    });
                }
            })


        });
    </script>
    <script>
        //DataTable
        var table = $('#kt_tdata').DataTable({
            dom: 'Bfrtip',
            "ordering": false,
            buttons: [
                'copy', 'excel', 'print'
            ],
            @if(session('lang') == 'ar')

            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Arabic.json"
            }
            @endif
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
        $("body").on("click", "#delete", function () {
            var dataList = [];
            dataList = $("#kt_datatable input:checkbox:checked").map(function () {
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
                            url: '{{url("Delete_Products")}}',
                            type: "get",
                            data: {'id': dataList, _token: CSRF_TOKEN},
                            dataType: "JSON",
                            success: function (data) {
                                if (data.message == "Success") {
                                    $("#kt_datatable .selected").hide();
                                    @if(session('lang') == 'ar')

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
                    text: "عفوا رقم الهاتف موجود بالفعل",
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



