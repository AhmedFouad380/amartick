<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<head>
    <base href="../../../../">
    <meta charset="utf-8"/>
    @inject('Setting','App\Models\Setting')
    <title> {{$Setting->find(1)->name}} || تسجيل حساب مورد </title>
    <meta name="description" content="Singin page example"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <link rel="canonical" href="https://keenthemes.com/metronic"/>
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"/>
    <!--end::Fonts-->
    <!--begin::Page Custom Styles(used by this page)-->
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
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body"
      class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
<!--begin::Main-->
<div class="d-flex flex-column flex-root">
    <!--begin::Login-->
    <div class="login login-3 wizard d-flex flex-column flex-lg-row flex-column-fluid wizard" id="kt_login">
        <!--begin::Aside-->

        <!--begin::Aside-->
        <!--begin::Content-->
        <div class="login-content flex-column-fluid d-flex flex-column p-10">

            <!--end::Top-->
            <!--begin::Wrapper-->
            <div class="d-flex flex-row-fluid flex-center">
                <!--begin::Signin-->
                <div class="login-form login-form-signup">
                    <!--begin::Form-->
                    <form class="form" action="/signup" novalidate="novalidate" id="kt_login_signup_form" method="post"
                          enctype="multipart/form-data">
                    @csrf
                    <!--begin: Wizard Step 1-->
                        <div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
                            <!--begin::Title-->
                            <div class="pb-10 pb-lg-15">
                                <h3 class="font-weight-bolder text-dark display5">اضافة شركة توريد</h3>
                                <div class="text-muted font-weight-bold font-size-h4">تمتلك حساب ؟
                                    <a href="{{url('login')}}" class="text-primary font-weight-bolder">تسجيل دخول</a>
                                </div>
                            </div>
                            <!--begin::Title-->

                            <!--begin::Form Group-->
                            <div class="form-group">
                                <label class="font-size-h6 font-weight-bolder text-dark">اسم الشركة</label>
                                <input type="text"
                                       class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6"
                                       name="name" required value="{{old('name')}}"/>
                                @if($errors->has('name'))
                                    <div class="error" style="color: red">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                            <!--end::Form Group-->
                            <!--begin::Form Group-->
                            <div class="form-group">
                                <label class="font-size-h6 font-weight-bolder text-dark">البريد الالكترونى</label>
                                <input type="text"
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
                                <input type="number"
                                       class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6"
                                       name="phone" required placeholder="966XXXXXXXXX" value="{{old('phone')}}"/>
                                @if($errors->has('phone'))
                                    <div class="error" style="color: red">{{ $errors->first('phone') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="font-size-h6 font-weight-bolder text-dark">الرقم السري</label>
                                <input  type="text"   style="-webkit-text-security: square;"
                                       class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6"
                                       name="password" required value="{{old('password')}}"/>
                                @if($errors->has('password'))
                                    <div class="error" style="color: red">{{ $errors->first('password') }}</div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label class="font-size-h6 font-weight-bolder text-dark">العنوان</label>
                                <input type="text"
                                       class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6"
                                       name="address" required value="{{old('address')}}"/>
                                @if($errors->has('address'))
                                    <div class="error" style="color: red">{{ $errors->first('address') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="font-size-h6 font-weight-bolder text-dark">المرفقات</label><br>
                                <label class="text-hover-info"> ..... سجل تجاري - بطاقة ضريبيه </label>
                                <input type="file"
                                       class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6"
                                       name="attachments[]" required multiple/>
                                @if($errors->has('attachments'))
                                    <div class="error" style="color: red">{{ $errors->first('attachments') }}</div>
                                @endif
                            </div>


                            <!--end::Form Group-->
                        </div>
                        <!--end: Wizard Step 1-->
                        <!--begin: Wizard Step 2-->
                        <div class="pb-5" data-wizard-type="step-content">
                            <!--begin::Title-->
                            <div class="pt-lg-0 pt-5 pb-15">
                                <h3 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">بيانات الفرع
                                    الرئيسي</h3>

                            </div>
                            <!--begin::Title-->
                            <!--begin::Row-->
                            <!--begin::Title-->

                            <!--begin::Title-->
                            <!--begin::Form Group-->
                            <div class="form-group">
                                <label class="font-size-h6 font-weight-bolder text-dark">اسم الفرع</label>
                                <input type="text"
                                       class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6"
                                       name="branch_name" required value="{{old('branch_name')}}"/>
                                @if($errors->has('branch_name'))
                                    <div class="error" style="color: red">{{ $errors->first('branch_name') }}</div>
                                @endif
                            </div>
                            <!--end::Form Group-->
                            <!--begin::Form Group-->
                            <div class="form-group">
                                <label class="font-size-h6 font-weight-bolder text-dark">البريد الالكترونى</label>
                                <input type="text"
                                       class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6"
                                       name="branch_email" required value="{{old('branch_email')}}"/>
                                @if($errors->has('branch_email'))
                                    <div class="error" style="color: red">{{ $errors->first('branch_email') }}</div>
                                @endif
                            </div>
                            <!--end::Form Group-->
                            <!--begin::Form Group-->
                            <div class="form-group">
                                <label class="font-size-h6 font-weight-bolder text-dark">رقم الجوال</label>
                                <input type="number"
                                       class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6"
                                       name="branch_phone" required placeholder="966XXXXXXXXX"
                                       value="{{old('branch_phone')}}"/>
                                @if($errors->has('branch_phone'))
                                    <div class="error" style="color: red">{{ $errors->first('branch_phone') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="font-size-h6 font-weight-bolder text-dark">الرقم السري</label>
                                <input  type="text"   style="-webkit-text-security: square;"
                                       class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6"
                                       name="branch_password" required/>
                                @if($errors->has('branch_password'))
                                    <div class="error" style="color: red">{{ $errors->first('branch_password') }}</div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label class="font-size-h6 font-weight-bolder text-dark">العنوان</label>
                                <input type="text"
                                       class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6"
                                       name="branch_address" required value="{{old('branch_address')}}"/>
                                @if($errors->has('branch_address'))
                                    <div class="error" style="color: red">{{ $errors->first('branch_address') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="font-size-h6 font-weight-bolder text-dark">الفئة الرئيسيه</label>

                                <select name="category[]"
                                        class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6 selectpicker"
                                        multiple="multiple">
                                    @foreach(\App\Models\MainCategory::all() as $cat)
                                        <option value="{{$cat->id}}">{{$cat->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="font-size-h6 font-weight-bolder text-dark">وصف للفرع</label>
                                <input type="text"
                                       class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6"
                                       name="desc" required value="{{old('desc')}}"/>


                            </div>

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

                        $lat = !empty(old('lat')) ? old('lat') : '24.69670448385797';
                        $lng = !empty(old('lng')) ? old('lng') : '46.690517596875';

                        ?>
                        <!--begin::Form Group-->

                            <input type="hidden" value="{{$lat}}" id="lat" name="lat">
                            <input type="hidden" value="{{$lng}}" id="lng" name="lng">
                            <input type="text" id="search_input" placeholder=" أبحث  بالمكان او اضغط على الخريطه" />
                             <input type="hidden" id="information"  />
                            <div id="us1" style="width: 100%; height: 400px;"></div>

                            <!--end::Form Group-->
                        </div>
                        <!--end: Wizard Step 3-->
                        <!--begin: Wizard Step 4-->
                        <div class="pb-5" data-wizard-type="step-content">
                            <!--begin::Title-->
                            <div class="pt-lg-0 pt-5 pb-15">
                                <h3 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">اكتمل التسجيل</h3>
                                <div class="text-muted font-weight-bold font-size-h4">
                                    شكرآ للتسجيل مع عمار تك
                                </div>
                                <div class="text-left">
                                    <h4 class="font-weight-bolder mb-3">: بيانات الشركة </h4>
                                    <div class="text-dark-50 font-weight-bold line-height-lg mb-8">
                                        <div id="comp_name"></div>
                                        <div id="comp_phone"></div>
                                        <div id="comp_email"></div>
                                        <div id="comp_address"></div>
                                    </div>

                                    <h4 class="font-weight-bolder mb-3">: بيانات الفرع </h4>
                                    <div class="text-dark-50 font-weight-bold line-height-lg mb-8">
                                        <div id="branch_name"></div>
                                        <div id="branch_phone"></div>
                                        <div id="branch_email"></div>
                                        <div id="branch_location"></div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Title-->

                            <!--end::Section-->
                        </div>
                        <!--end: Wizard Step 4-->
                        <!--begin: Wizard Actions-->
                        <div class="d-flex justify-content-between pt-3">

                            <div>
                                <button class="btn btn-primary font-weight-bolder font-size-h6 pl-5 pr-8 py-4 my-3"
                                        data-wizard-type="action-submit" type="submit"
                                        id="kt_login_signup_form_submit_button">
                                        <span class="svg-icon svg-icon-md mr-1">
											<!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Left-2.svg-->
											<svg xmlns="http://www.w3.org/2000/svg"
                                                 xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
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
										</span>ارسال الطلب
                                </button>
                                <button type="button" onclick="showInput();"
                                        class="btn btn-primary font-weight-bolder font-size-h6 pl-8 pr-4 py-4 my-3"
                                        data-wizard-type="action-next">
                                    <span class="svg-icon svg-icon-md mr-1">
											<!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Left-2.svg-->
											<svg xmlns="http://www.w3.org/2000/svg"
                                                 xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
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
                            <div class="mr-2">
                                <button type="button"
                                        class="btn btn-light-primary font-weight-bolder font-size-h6 pl-6 pr-8 py-4 my-3 mr-3"
                                        data-wizard-type="action-prev">


                                    السابق
                                    <span class="svg-icon svg-icon-md ml-1">
											<!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Right-2.svg-->
											<svg xmlns="http://www.w3.org/2000/svg"
                                                 xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
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
        <div class="login-aside d-flex flex-column flex-row-auto">
            <!--begin::Aside Top-->
            <div class="d-flex flex-column-auto flex-column pt-15 px-30">
                <!--begin::Aside header-->
                <a href="#" class="login-logo py-6">
                    @inject('Setting','App\Models\Setting')
                    <img src="{{asset($Setting->find(1)->logo)}}" class="max-h-200px max-w-250px"  alt=""/>
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

                                <div class="wizard-label">
                                    <h3 class="wizard-title">بيانات الشركة</h3>
                                    <div class="wizard-desc">البيانات الاساسية للشركة</div>
                                </div>
                                <div class="wizard-icon">
                                    <i class="wizard-check ki ki-check"></i>
                                    <span class="wizard-number">1</span>
                                </div>

                            </div>
                        </div>
                        <!--end::Wizard Step 1 Nav-->
                        <!--begin::Wizard Step 2 Nav-->
                        <div class="wizard-step" style="text-align: right" data-wizard-type="step">
                            <div class="wizard-wrapper" style=" position: relative;
            float: right;!important;">

                                <div class="wizard-label">
                                    <h3 class="wizard-title">بيانات الفرع
                                    </h3>
                                    <div class="wizard-desc">ادخال بيانات الفرع الاساسي
                                    </div>
                                </div>
                                <div class="wizard-icon">
                                    <i class="wizard-check ki ki-check"></i>
                                    <span class="wizard-number">2</span>
                                </div>

                            </div>
                        </div>
                        <!--end::Wizard Step 2 Nav-->
                        <!--begin::Wizard Step 3 Nav-->
                        <div class="wizard-step" style="text-align: right" data-wizard-type="step">
                            <div class="wizard-wrapper" style=" position: relative;
            float: right;!important;">

                                <div class="wizard-label">
                                    <h3 class="wizard-title">تحديد الموقع
                                    </h3>
                                    <div class="wizard-desc">موقع الفرع على الخريطة
                                    </div>
                                </div>
                                <div class="wizard-icon">
                                    <i class="wizard-check ki ki-check"></i>
                                    <span class="wizard-number">3</span>
                                </div>

                            </div>
                        </div>
                        <!--end::Wizard Step 3 Nav-->
                        <!--begin::Wizard Step 4 Nav-->
                        <div class="wizard-step" style="text-align: right" data-wizard-type="step">
                            <div class="wizard-wrapper" style=" position: relative;
            float: right;!important;">

                                <div class="wizard-label">
                                    <h3 class="wizard-title">انتهاء وحفظ!</h3>
                                    <div class="wizard-desc">حفظ بياناتك</div>
                                </div>
                                <div class="wizard-icon">
                                    <i class="wizard-check ki ki-check"></i>
                                    <span class="wizard-number">4</span>
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
    <!--end::Login-->
</div>
<!--end::Main-->
<script>var HOST_URL = "https://preview.keenthemes.com/metronic/theme/html/tools/preview";</script>
<!--begin::Global Config(global config for global JS scripts)-->
<script>var KTAppSettings = {
        "breakpoints": {"sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400},
        "colors": {
            "theme": {
                "base": {
                    "white": "#ffffff",
                    "primary": "#3699FF",
                    "secondary": "#E5EAEE",
                    "success": "#1BC5BD",
                    "info": "#8950FC",
                    "warning": "#FFA800",
                    "danger": "#F64E60",
                    "light": "#E4E6EF",
                    "dark": "#181C32"
                },
                "light": {
                    "white": "#ffffff",
                    "primary": "#E1F0FF",
                    "secondary": "#EBEDF3",
                    "success": "#C9F7F5",
                    "info": "#EEE5FF",
                    "warning": "#FFF4DE",
                    "danger": "#FFE2E5",
                    "light": "#F3F6F9",
                    "dark": "#D6D6E0"
                },
                "inverse": {
                    "white": "#ffffff",
                    "primary": "#ffffff",
                    "secondary": "#3F4254",
                    "success": "#ffffff",
                    "info": "#ffffff",
                    "warning": "#ffffff",
                    "danger": "#ffffff",
                    "light": "#464E5F",
                    "dark": "#ffffff"
                }
            },
            "gray": {
                "gray-100": "#F3F6F9",
                "gray-200": "#EBEDF3",
                "gray-300": "#E4E6EF",
                "gray-400": "#D1D3E0",
                "gray-500": "#B5B5C3",
                "gray-600": "#7E8299",
                "gray-700": "#5E6278",
                "gray-800": "#3F4254",
                "gray-900": "#181C32"
            }
        },
        "font-family": "Poppins"
    };</script>
<!--end::Global Config-->
<!--begin::Global Theme Bundle(used by all pages)-->
<script src="{{asset('dashboard/assets/plugins/global/plugins.bundle.js')}}"></script>
<script src="{{asset('dashboard/assets/plugins/custom/prismjs/prismjs.bundle.js')}}"></script>
<script src="{{asset('dashboard/assets/js/scripts.bundle.js')}}"></script>
<!--end::Global Theme Bundle-->
<!--begin::Page Scripts(used by this page)-->
<script src="{{asset('dashboard/assets/js/pages/custom/login/login-3.js')}}"></script>

<script type="text/javascript"
        src='https://maps.google.com/maps/api/js?sensor=false&libraries=places&key=AIzaSyAIcQUxj9rT_a3_5GhMp-i6xVqMrtasqws&language=ar'></script>
<script src="{{asset('dashboard/locationpicker.jquery.js')}}"></script>
<script src="{{asset('dashboard/assets/js/pages/crud/forms/widgets/bootstrap-select.js')}}"></script>


<script>
    $('#us1').locationpicker({
        location: {
            latitude: {{$lat}},
            longitude: {{$lng}}
        },
        radius: 300,
        markerIcon: "{{asset('dashboard/map-marker-2-xl.png')}}",
        inputBinding: {
            latitudeInput: $('#lat'),
            longitudeInput: $('#lng'),
            // radiusInput: $('#us2-radius'),
            // locationNameInput: $('#address'),
        }

    });


    if (document.getElementById('us1')) {
        var content;
        var latitude = 24.69670448385797;
        var longitude = 46.690517596875;
        var map;
        var marker;
        navigator.geolocation.getCurrentPosition(loadMap);

        function loadMap(location) {
            if (location.coords) {
                latitude = location.coords.latitude;
                longitude = location.coords.longitude;
            }
            var myLatlng = new google.maps.LatLng(latitude, longitude);
            var mapOptions = {
                zoom: 8,
                center: myLatlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP,

            };
            map = new google.maps.Map(document.getElementById("us1"), mapOptions);

            content = document.getElementById('information');
            google.maps.event.addListener(map, 'click', function(e) {
                placeMarker(e.latLng);
            });

            var input = document.getElementById('search_input');
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

            var searchBox = new google.maps.places.SearchBox(input);

            google.maps.event.addListener(searchBox, 'places_changed', function() {
                var places = searchBox.getPlaces();
                placeMarker(places[0].geometry.location);
            });

            marker = new google.maps.Marker({
                map: map
            });
        }
    }

    function placeMarker(location) {
        marker.setPosition(location);
        map.panTo(location);
        //map.setCenter(location)
        content.innerHTML = "Lat: " + location.lat() + " / Long: " + location.lng();
        $("#lat").val(location.lat());
        $("#lng").val(location.lng());
        google.maps.event.addListener(marker, 'click', function(e) {
            new google.maps.InfoWindow({
                content: "Lat: " + location.lat() + " / Long: " + location.lng()
            }).open(map,marker);

        });
    }



    function showInput() {
        document.getElementById('comp_name').innerHTML =
            document.getElementsByName("name")[0].value;
        document.getElementById('comp_email').innerHTML =
            document.getElementsByName("email")[0].value;
        document.getElementById('comp_phone').innerHTML =
            document.getElementsByName("phone")[0].value;
        document.getElementById('comp_address').innerHTML =
            document.getElementsByName("address")[0].value;
        document.getElementById('branch_name').innerHTML =
            document.getElementsByName("branch_name")[0].value;
        document.getElementById('branch_email').innerHTML =
            document.getElementsByName("branch_email")[0].value;
        document.getElementById('branch_phone').innerHTML =
            document.getElementsByName("branch_phone")[0].value;
        var lat = document.getElementsByName("lat")[0].value;
        var lng = document.getElementsByName("lng")[0].value;


        var latlng = new google.maps.LatLng(lat, lng);
        var geocoder = geocoder = new google.maps.Geocoder();
        geocoder.geocode({'latLng': latlng}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[1]) {
                    document.getElementById('branch_location').innerHTML = results[1].formatted_address;
                }
            }
        });
    }
</script>

@if( Session::has('errors'))

    <script>
        Swal.fire({
            icon: 'warning',
            title: "عفوا",
            text: "برجاء التأكد من البيانات  ",
            type: "error",
            timer: 2000,
            showConfirmButton: false
        });
    </script>

@endif

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

    @endif
@endif
<!--end::Page Scripts-->
</body>
<!--end:
