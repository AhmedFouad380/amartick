@extends('layout.layout')

@section('title')
    @if(Auth::guard('admins')->check())
        {{__('lang.suppliers')}}
    @else
        {{__('lang.Branches')}}
    @endif
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
    <link href="{{asset('dashboard/assets/css/pages/login/login-3.rtl.css')}}" rel="stylesheet" type="text/css"/>
    <!--end::Page Custom Styles-->
    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="{{asset('dashboard/assets/plugins/global/plugins.bundle.rtl.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('dashboard/assets/plugins/custom/prismjs/prismjs.bundle.rtl.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('dashboard/assets/css/style.bundle.rtl.css')}}" rel="stylesheet" type="text/css"/>
    <!--end::Global Theme Styles-->
    <!--begin::Layout Themes(used by all pages)-->
    <link href="{{asset('dashboard/assets/css/themes/layout/header/base/light.rtl.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('dashboard/assets/css/themes/layout/header/menu/light.rtl.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('dashboard/assets/css/themes/layout/brand/dark.rtl.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('dashboard/assets/css/themes/layout/aside/dark.rtl.css')}}" rel="stylesheet" type="text/css"/>
    <!--end::Layout Themes-->
    <link rel="shortcut icon" href="{{asset('dashboard/assets/media/logos/fav.png')}}"/>

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
                                <h5 class="text-dark font-weight-bold my-1 mr-5 ">  @if(Auth::guard('admins')->check())
                                        {{__('lang.suppliers')}}
                                    @else
                                        {{__('lang.Branches')}}
                                    @endif</h5>
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
            <div class="login login-3 wizard d-flex flex-column flex-lg-row flex-column-fluid wizard" id="kt_login">
                <!--begin::Aside-->

                <!--begin::Aside-->
                <!--begin::Content-->
                <div class="login-content flex-column-fluid d-flex flex-column p-10">

                    <!--end::Top-->
                    <!--begin::Wrapper-->
                    <div class="">
                        <!--begin::Signin-->

                        <div class="login-form login-form-signup">
                            <!--begin::Form-->
                            <form class="form" action="{{url('SupplierActive')}}" novalidate="novalidate"
                                  id="kt_login_signup_form" method="post"
                                  enctype="multipart/form-data">
                            @csrf
                            <!--begin: Wizard Step 1-->
                                <div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
                                    <!--begin::Title-->
                                    <div class="pt-lg-0 pt-5 pb-15">
                                        <h3 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">بيانات
                                            الشركة</h3>

                                    </div>
                                    <!--begin::Title-->
                                    <!--begin::Row-->
                                    <!--begin::Title-->

                                    <!--begin::Form Group-->
                                    <div class="form-group">
                                        <label class="font-size-h6 font-weight-bolder text-dark">اسم الشركة</label>
                                        <input type="text"
                                               class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6"
                                               name="name" value="{{$Supplier->name}}" disabled required
                                               value="{{old('name')}}"/>
                                        @if($errors->has('name'))
                                            <div class="error" style="color: red">{{ $errors->first('name') }}</div>
                                        @endif
                                    </div>
                                    <!--end::Form Group-->
                                    <!--begin::Form Group-->
                                    <div class="form-group">
                                        <label class="font-size-h6 font-weight-bolder text-dark">البريد
                                            الاليكترونى</label>
                                        <input type="text" value="{{$Supplier->email}}" disabled
                                               class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6"
                                               name="email" required value="{{old('email')}}"/>
                                        @if($errors->has('email'))
                                            <div class="error" style="color: red">{{ $errors->first('email') }}</div>
                                        @endif
                                    </div>
                                    <!--end::Form Group-->
                                    <!--begin::Form Group-->
                                    <div class="form-group">
                                        <label class="font-size-h6 font-weight-bolder text-dark">رقم الجوال</label>
                                        <input type="number" value="{{$Supplier->phone}}" disabled
                                               class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6"
                                               name="phone" required placeholder="966XXXXXXXXX"
                                               value="{{old('phone')}}"/>
                                        @if($errors->has('phone'))
                                            <div class="error" style="color: red">{{ $errors->first('phone') }}</div>
                                        @endif
                                    </div>


                                    <div class="form-group">
                                        <label class="font-size-h6 font-weight-bolder text-dark">العنوان</label>
                                        <input type="text" value="{{$Supplier->address}}" disabled
                                               class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6"
                                               name="address" required value="{{old('address')}}"/>
                                        @if($errors->has('address'))
                                            <div class="error" style="color: red">{{ $errors->first('address') }}</div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label class="font-size-h6 font-weight-bolder text-dark">المرفقات</label><br>
                                        @foreach($attachments as $attachment)

                                            <a href="{{$attachment->file}}" target="_blank">

                                                   <span class="svg-icon svg-icon-primary svg-icon-6x"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Files\DownloadedFile.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <polygon points="0 0 24 0 24 24 0 24"/>
                                                        <path d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                        <path d="M14.8875071,11.8306874 L12.9310336,11.8306874 L12.9310336,9.82301606 C12.9310336,9.54687369 12.707176,9.32301606 12.4310336,9.32301606 L11.4077349,9.32301606 C11.1315925,9.32301606 10.9077349,9.54687369 10.9077349,9.82301606 L10.9077349,11.8306874 L8.9512614,11.8306874 C8.67511903,11.8306874 8.4512614,12.054545 8.4512614,12.3306874 C8.4512614,12.448999 8.49321518,12.5634776 8.56966458,12.6537723 L11.5377874,16.1594334 C11.7162223,16.3701835 12.0317191,16.3963802 12.2424692,16.2179453 C12.2635563,16.2000915 12.2831273,16.1805206 12.3009811,16.1594334 L15.2691039,12.6537723 C15.4475388,12.4430222 15.4213421,12.1275254 15.210592,11.9490905 C15.1202973,11.8726411 15.0058187,11.8306874 14.8875071,11.8306874 Z" fill="#000000"/>
                                                    </g>
                                                </svg><!--end::Svg Icon--></span>

                                            </a>
                                        @endforeach
                                    </div>
                                    <!--end::Form Group-->
                                </div>
                                <!--end: Wizard Step 1-->
                                <!--begin: Wizard Step 2-->
                                <div class="pb-5" data-wizard-type="step-content">
                                    <!--begin::Title-->
                                    <div class="pt-lg-0 pt-5 pb-15">
                                        <h3 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">بيانات
                                            الفرع
                                            الرئيسي</h3>

                                    </div>
                                    <!--begin::Title-->
                                    <!--begin::Row-->
                                    <!--begin::Title-->

                                    <!--begin::Title-->
                                    <!--begin::Form Group-->
                                    <div class="form-group">
                                        <label class="font-size-h6 font-weight-bolder text-dark">اسم الفرع</label>
                                        <input type="text" value="{{$Branch->name}}" disabled
                                               class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6"
                                               name="branch_name" required value="{{old('branch_name')}}"/>
                                        @if($errors->has('branch_name'))
                                            <div class="error"
                                                 style="color: red">{{ $errors->first('branch_name') }}</div>
                                        @endif
                                    </div>
                                    <!--end::Form Group-->
                                    <!--begin::Form Group-->
                                    <div class="form-group">
                                        <label class="font-size-h6 font-weight-bolder text-dark">البريد
                                            الاليكترونى</label>
                                        <input type="text" value="{{$Branch->email}}" disabled
                                               class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6"
                                               name="branch_email" required value="{{old('branch_email')}}"/>
                                        @if($errors->has('branch_email'))
                                            <div class="error"
                                                 style="color: red">{{ $errors->first('branch_email') }}</div>
                                        @endif
                                    </div>
                                    <!--end::Form Group-->
                                    <!--begin::Form Group-->
                                    <div class="form-group">
                                        <label class="font-size-h6 font-weight-bolder text-dark">رقم الجوال</label>
                                        <input type="number" value="{{$Branch->phone}}" disabled
                                               class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6"
                                               name="branch_phone" required placeholder="966XXXXXXXXX"
                                               value="{{old('branch_phone')}}"/>
                                        @if($errors->has('branch_phone'))
                                            <div class="error"
                                                 style="color: red">{{ $errors->first('branch_phone') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label class="font-size-h6 font-weight-bolder text-dark">العنوان</label>
                                        <input type="text" value="{{$Branch->address}}" disabled
                                               class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6"
                                               name="branch_address" required/>
                                        @if($errors->has('branch_address'))
                                            <div class="error"
                                                 style="color: red">{{ $errors->first('branch_address') }}</div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label class="font-size-h6 font-weight-bolder text-dark">الفئة الرئيسيه</label>

                                        <?php $Categories = explode(' - ', $Supplier->categories); ?>
                                        <br>
                                        <label class="font-size-h6 font-weight-bolder text-muted">
                                            @foreach($Categories as $cate)
                                                {{$cate}} -
                                            @endforeach
                                        </label>


                                    </div>

                                {{--                                    <div class="form-group">--}}
                                {{--                                        <label class="font-size-h6 font-weight-bolder text-dark">وصف للفرع</label>--}}

                                {{--                                        @php--}}
                                {{--                                        $inbox = \App\Models\Inbox::where('supplier_id' ,$Branch->id )->first();--}}
                                {{--                                        @endphp--}}
                                {{--                                        <input type="text"--}}
                                {{--                                               class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6"--}}
                                {{--                                               name="desc" required value="@if($inbox){{$inbox->message}}@endif" disabled/>--}}


                                {{--                                    </div>--}}

                                <!--end::Row-->
                                </div>
                                <!--end: Wizard Step 2-->
                                <!--begin: Wizard Step 3-->
                                <div class="pb-5" data-wizard-type="step-content">
                                    <!--begin::Title-->


                                    <div class="pt-lg-0 pt-5 pb-15">
                                        <h3 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">
                                            موقع الفرع على الخريطة</h3>
                                        <div class="text-muted font-weight-bold font-size-h4">اختيار موقع الفرع
                                        </div>
                                    </div>
                                    <!--end::Title-->
                                <?php

                                $lat = $Branch->lat;
                                $lng = $Branch->lng;

                                ?>
                                <!--begin::Form Group-->

                                    <input type="hidden" value="{{$lat}}" id="lat" name="lat">
                                    <input type="hidden" value="{{$lng}}" id="lng" name="lng">
                                    <div id="us1" style="width: 100%; height: 400px;"></div>

                                    <!--end::Form Group-->
                                </div>
                                <!--end: Wizard Step 3-->
                                <!--begin: Wizard Step 4-->
                                <div class="pb-5" data-wizard-type="step-content">
                                    <!--begin::Title-->
                                    <div class="pt-lg-0 pt-5 pb-15">
                                        <h3 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">اكتمل
                                            التسجيل</h3>
                                        <div class="text-muted font-weight-bold font-size-h4">
                                            قبول او رفض المورد
                                        </div>

                                        <input type="hidden" value="{{$Supplier->id}}" name="id">
                                        <div class="form-group">
                                            <label>{{__('lang.status')}} </label>
                                            <select name="is_active" class="form-control">
                                                <option value="1">{{__('lang.accept')}}</option>
                                                <option value="0">{{__('lang.reject')}}</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                                <!--end::Title-->

                                <!--end::Section-->

                                <!--end: Wizard Step 4-->
                                <!--begin: Wizard Actions-->
                                <div class="d-flex justify-content-between pt-3">


                                    <div class="mr-2">
                                        <button type="button"
                                                class="btn btn-light-primary font-weight-bolder font-size-h6 pl-6 pr-8 py-4 my-3 mr-3"
                                                data-wizard-type="action-prev">


                                            السابق
                                            <span class="svg-icon svg-icon-md ml-1">
                                                <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Right-2.svg-->
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                     height="24px"
                                                     viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <polygon points="0 0 24 0 24 24 0 24"/>
                                                        <rect fill="#000000" opacity="0.3"
                                                              transform="translate(8.500000, 12.000000) rotate(-90.000000) translate(-8.500000, -12.000000)"
                                                              x="7.5" y="7.5" width="2" height="9" rx="1"/>
                                                        <path
                                                            d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z"
                                                            fill="#000000" fill-rule="nonzero"
                                                            transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)"/>
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </button>
                                    </div>

                                    <div>
                                        <button
                                            class="btn btn-primary font-weight-bolder font-size-h6 pl-5 pr-8 py-4 my-3"
                                            data-wizard-type="action-submit" type="submit"
                                            id="kt_login_signup_form_submit_button">
                                            <span class="svg-icon svg-icon-md mr-1">
                                                <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Left-2.svg-->
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                     height="24px"
                                                     viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <polygon points="0 0 24 0 24 24 0 24"/>
                                                        <rect fill="#000000" opacity="0.3"
                                                              transform="translate(15.000000, 12.000000) scale(-1, 1) rotate(-90.000000) translate(-15.000000, -12.000000)"
                                                              x="14" y="7" width="2" height="10" rx="1"/>
                                                        <path
                                                            d="M3.7071045,15.7071045 C3.3165802,16.0976288 2.68341522,16.0976288 2.29289093,15.7071045 C1.90236664,15.3165802 1.90236664,14.6834152 2.29289093,14.2928909 L8.29289093,8.29289093 C8.67146987,7.914312 9.28105631,7.90106637 9.67572234,8.26284357 L15.6757223,13.7628436 C16.0828413,14.136036 16.1103443,14.7686034 15.7371519,15.1757223 C15.3639594,15.5828413 14.7313921,15.6103443 14.3242731,15.2371519 L9.03007346,10.3841355 L3.7071045,15.7071045 Z"
                                                            fill="#000000" fill-rule="nonzero"
                                                            transform="translate(9.000001, 11.999997) scale(-1, -1) rotate(90.000000) translate(-9.000001, -11.999997)"/>
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span> حفظ
                                        </button>
                                        <button type="button" onclick="showInput();"
                                                class="btn btn-primary font-weight-bolder font-size-h6 pl-8 pr-4 py-4 my-3"
                                                data-wizard-type="action-next">
                                        <span class="svg-icon svg-icon-md mr-1">
                                                <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Left-2.svg-->
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                     height="24px"
                                                     viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <polygon points="0 0 24 0 24 24 0 24"/>
                                                        <rect fill="#000000" opacity="0.3"
                                                              transform="translate(15.000000, 12.000000) scale(-1, 1) rotate(-90.000000) translate(-15.000000, -12.000000)"
                                                              x="14" y="7" width="2" height="10" rx="1"/>
                                                        <path
                                                            d="M3.7071045,15.7071045 C3.3165802,16.0976288 2.68341522,16.0976288 2.29289093,15.7071045 C1.90236664,15.3165802 1.90236664,14.6834152 2.29289093,14.2928909 L8.29289093,8.29289093 C8.67146987,7.914312 9.28105631,7.90106637 9.67572234,8.26284357 L15.6757223,13.7628436 C16.0828413,14.136036 16.1103443,14.7686034 15.7371519,15.1757223 C15.3639594,15.5828413 14.7313921,15.6103443 14.3242731,15.2371519 L9.03007346,10.3841355 L3.7071045,15.7071045 Z"
                                                            fill="#000000" fill-rule="nonzero"
                                                            transform="translate(9.000001, 11.999997) scale(-1, -1) rotate(90.000000) translate(-9.000001, -11.999997)"/>
                                                    </g>
                                                </svg>
                                            <!--end::Svg Icon-->
                                            </span>التالي
                                        </button>
                                    </div>
                                </div>
                                <!--end: Wizard Actions-->
                            </form>
                            <!--end::Form-->
                        </div>
                        <!--end::Signin-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Content-->
                <div class="login-aside d-flex flex-column flex-row-auto" style="max-width:450px;!important;">
                    <!--begin::Aside Top-->
                    <div class="d-flex flex-column-auto flex-column pt-15 px-30">
                        <!--begin::Aside header-->
                        <a href="#" class="login-logo py-6">
{{--                            @inject('Setting','App\Models\Setting')--}}
{{--                            <img src="{{asset($Setting->find(1)->logo)}}" class="max-h-200px max-w-250px" alt=""/>--}}
                        </a>
                        <!--end::Aside header-->
                        <!--begin: Wizard Nav-->
                        <div class="wizard-nav ">
                            <!--begin::Wizard Steps-->
                            <div class="wizard-steps">
                                <!--begin::Wizard Step 1 Nav-->
                                <div class="wizard-step" style="text-align: right" data-wizard-type="step"
                                     data-wizard-state="current">
                                    <div class="wizard-wrapper" style=" position: relative;
                float: right;!important;">
                                        <div class="wizard-icon">
                                            <i class="wizard-check ki ki-check"></i>
                                            <span class="wizard-number">1</span>
                                        </div>
                                        <div class="wizard-label">
                                            <h3 class="wizard-title">بيانات الشركة</h3>
                                            <div class="wizard-desc">البيانات الاساسية للشركة</div>
                                        </div>


                                    </div>
                                </div>
                                <!--end::Wizard Step 1 Nav-->
                                <!--begin::Wizard Step 2 Nav-->
                                <div class="wizard-step" style="text-align: right" data-wizard-type="step">
                                    <div class="wizard-wrapper" style=" position: relative;
                float: right;!important;">
                                        <div class="wizard-icon">
                                            <i class="wizard-check ki ki-check"></i>
                                            <span class="wizard-number">2</span>
                                        </div>
                                        <div class="wizard-label">
                                            <h3 class="wizard-title">بيانات الفرع
                                            </h3>
                                            <div class="wizard-desc">ادخال بيانات الفرع الاساسي
                                            </div>
                                        </div>


                                    </div>
                                </div>
                                <!--end::Wizard Step 2 Nav-->
                                <!--begin::Wizard Step 3 Nav-->
                                <div class="wizard-step" style="text-align: right" data-wizard-type="step">
                                    <div class="wizard-wrapper" style=" position: relative;
                float: right;!important;">
                                        <div class="wizard-icon">
                                            <i class="wizard-check ki ki-check"></i>
                                            <span class="wizard-number">3</span>
                                        </div>
                                        <div class="wizard-label">
                                            <h3 class="wizard-title">تحديد الموقع
                                            </h3>

                                            <div class="wizard-desc">موقع الفرع على الخريطة
                                            </div>
                                        </div>


                                    </div>
                                </div>
                                <!--end::Wizard Step 3 Nav-->
                                <!--begin::Wizard Step 4 Nav-->
                                <div class="wizard-step" style="text-align: right" data-wizard-type="step">
                                    <div class="wizard-wrapper" style=" position: relative;
                float: right;!important;">
                                        <div class="wizard-icon">
                                            <i class="wizard-check ki ki-check"></i>
                                            <span class="wizard-number">4</span>
                                        </div>
                                        <div class="wizard-label">
                                            <h3 class="wizard-title">قبول او رفض المورد !</h3>
                                            {{--                                            <div class="wizard-desc">حفظ بياناتك</div>--}}
                                        </div>


                                    </div>
                                </div>
                                <!--end::Wizard Step 4 Nav-->
                            </div>
                            <!--end::Wizard Steps-->
                        </div>
                        <!--end: Wizard Nav-->
                    </div>
                    <!--end::Aside Top-->

                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>



    <!-- /.modal -->

    <!-- /.modal -->

@section('js')
    <script src="{{asset('dashboard/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/pages/crud/datatables/basic/basic.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/pages/crud/file-upload/image-input.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/pages/features/miscellaneous/sweetalert2.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/pages/features/miscellaneous/dropify.min.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/pages/crud/forms/widgets/select2.js')}}"></script>


    <script type="text/javascript"
            src='https://maps.google.com/maps/api/js?sensor=false&libraries=places&key=AIzaSyAIcQUxj9rT_a3_5GhMp-i6xVqMrtasqws'></script>

    <script src="{{asset('dashboard/locationpicker.jquery.js')}}"></script>

    <script src="{{asset('dashboard/assets/js/pages/custom/login/login-3.js')}}"></script>

    <script>
        $('#us1').locationpicker({
            location: {
                latitude: {{$lat}},
                longitude: {{$lng}}
            },
            radius: 300,
            inputBinding: {
                latitudeInput: $('#lat'),
                longitudeInput: $('#lng'),
                // radiusInput: $('#us2-radius'),
                // locationNameInput: $('#address'),
            },


        });


    </script>

    <script>
        //DataTable
        var table = $('#kt_tdata').DataTable({
            dom: 'Bfrtip',
            "ordering": false,
            "paging": false,
            buttons: [
                'copy', 'excel', 'print'
            ],
            @if( Request::segment(1) == "ar")
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Arabic.json"
            }
            @endif
        });
    </script>
    <script>

        $('#kt_tdata tbody').on('click', 'tr', function () {
            if (event.ctrlKey) {
                $(this).toggleClass('selected');
                @if(session('lang') == 'en')
                $('#delete').text('Delete ' + table.rows('.selected').data().length + ' row');
                @else
                $('#delete').text('حذف ' + table.rows('.selected').data().length + ' سجل');
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
                @if(session('lang') == 'en')
                $('#delete').text('Delete ' + table.rows('.selected').data().length + ' row');
                @else
                $('#delete').text('حذف ' + table.rows('.selected').data().length + ' سجل');
                @endif            }
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
                            url: '{{url("suppliers_delete")}}',
                            type: "get",
                            data: {'id': dataList},
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


    </script>

    <!--begin::Page scripts(used by this page) -->
    <script type="text/javascript">


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

        $(".edit-notation").click(function () {
            var id = $(this).data('id')
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: "GET",
                url: "{{url('Edit_User_notation')}}",
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
        $(".edit-Shift").click(function () {
            var id = $(this).data('id')
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: "GET",
                url: "{{url('User_shifts')}}",
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

        $(".edit-Advert").click(function () {
            var id = $(this).data('id')
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: "GET",
                url: "{{url('Edit_User')}}",
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
                url: "{{url('UpdateStatusSupplier')}}",
                data: {"id": id, _token: CSRF_TOKEN},
                success: function (data) {
                    Swal.fire("{{__('lang.Success')}}", "{{__('lang.Success_text')}}", "success");

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

@endsection

