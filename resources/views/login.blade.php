<!DOCTYPE html>
<html direction="rtl" dir="rtl" style="direction: rtl" >

	<!--begin::Head-->
	<head><base href="../../../../">
		<meta charset="utf-8" />
		@inject('Setting','App\Models\Setting')
		<title> {{$Setting->find(1)->name}} || تسجيل الدخول  </title>
		<meta name="description" content="UramSYS" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<link rel="canonical" href="http://uramit.com/" />
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Page Custom Styles(used by this page)-->

		<!--end::Page Custom Styles-->
		<link href="{{asset('dashboard/assets/css/pages/login/login-4.rtl.css')}}" rel="stylesheet" type="text/css" />

        <link href="{{asset('dashboard/assets/plugins/global/plugins.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('dashboard/assets/plugins/custom/prismjs/prismjs.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('dashboard/assets/css/style.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />

        <link href="{{asset('dashboard/assets/css/themes/layout/header/base/light.rtl.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('dashboard/assets/css/themes/layout/header/menu/light.rtl.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('dashboard/assets/css/themes/layout/brand/dark.rtl.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('dashboard/assets/css/themes/layout/aside/dark.rtl.css')}}" rel="stylesheet" type="text/css" />
		<!--end::Layout Themes-->
		<link rel="shortcut icon" href="{{asset('dashboard/assets/media/logos/fav.png')}}" />
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
		<!--begin::Main-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Login-->
			<div class="login login-4 wizard d-flex flex-column flex-lg-row flex-column-fluid">
				<!--begin::Content-->
				<div class="login-container order-2 order-lg-1 d-flex flex-center flex-row-fluid px-7 pt-lg-0 pb-lg-0 pt-4 pb-6 bg-white" style="background-image: url({{asset('/dashboard/assets/media/bg/bg2.jpg')}});">
					<!--begin::Wrapper-->
					<div class="login-content d-flex flex-column pt-lg-0 pt-12">
						<!--begin::Logo-->
						<a href="#" class="login-logo pb-xl-20 pb-15">
						    @inject('Setting','App\Models\Setting')
							<img src="{{asset($Setting->find(1)->logo)}}" style="height: 160px !important;
    width: 180px;" alt="" />
						</a>
						<!--end::Logo-->
						<!--begin::Signin-->
						<div class="login-form">
							<!--begin::Form-->
                            <form class="form" action="/UserLogin" method="POST">
                                @csrf
								<!--begin::Title-->
								<div class="pb-5 pb-lg-15">
									<h3 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">تسجيل الدخول</h3>
								</div>
								<!--begin::Title-->
								<!--begin::Form group-->
								<div class="form-group">
									<label class="font-size-h6 font-weight-bolder text-dark">{{__('lang.phone')}}</label>
									<input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg border-0
                                    @error('phone') is-invalid @enderror" id="phone" type="number" name="phone"
                                           placeholder="966XXXXXXXXX" value="{{ old('phone') }}"
                                           required autocomplete="phone" autofocus max-length="12"/>
                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
								<!--end::Form group-->
								<!--begin::Form group-->
								<div class="form-group">
									<div class="d-flex justify-content-between mt-n5">
										<label class="font-size-h6 font-weight-bolder text-dark pt-5"> {{__('lang.password')}} </label>
										<a href="#" class="text-primary font-size-h6 font-weight-bolder text-hover-primary pt-5">هل نسيت كلمة المرور ؟</a>
									</div>
									<input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg border-0 @error('password') is-invalid @enderror" id="password" type="text"   style="-webkit-text-security: square;"  name="password" placeholder=" {{__('lang.password')}} " required autocomplete="current-password" />
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <!--end::Form group-->
                                <div class="kt-login__extra">
                                    <label class="kt-checkbox">
                                        <input type="checkbox" name="remember"> تذكرني
                                        <span></span>
                                    </label>
                                </div>
								<!--begin::Action-->
								<div class="pb-lg-0 pb-5">
									<button type="submit" id="kt_login_singin_form_submit_button" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">تسجيل</button>
                                </div>
								<!--end::Action-->
                            </form>
                            <!--end::Form-->
						</div>
						<!--end::Signin-->
					</div>
					<!--end::Wrapper-->
				</div>
				<!--begin::Content-->
				<!--begin::Aside-->
				<div class="login-aside order-1 order-lg-2 bgi-no-repeat bgi-position-x-right" style="background-size:cover; background-image: url({{asset('/dashboard/2.png')}});">
					<div class="login-conteiner bgi-no-repeat bgi-position-x-right bgi-position-y-bottom" >
						<!--begin::Aside title-->
						<!--end::Aside title-->
					</div>
				</div>
				<!--end::Aside-->
			</div>
			<!--end::Login-->
		</div>
		<!--end::Main-->

		<!--begin::Global Config(global config for global JS scripts)-->
		<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#E4E6EF", "dark": "#181C32" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#EBEDF3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#3F4254", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#EBEDF3", "gray-300": "#E4E6EF", "gray-400": "#D1D3E0", "gray-500": "#B5B5C3", "gray-600": "#7E8299", "gray-700": "#5E6278", "gray-800": "#3F4254", "gray-900": "#181C32" } }, "font-family": "Poppins" };</script>
		<!--end::Global Config-->
		<!--begin::Global Theme Bundle(used by all pages)-->
		<script src="{{asset('dashboard/assets/plugins/global/plugins.bundle.js')}}"></script>
		<script src="{{asset('dashboard/assets/plugins/custom/prismjs/prismjs.bundle.js')}}"></script>
		<script src="{{asset('dashboard/assets/js/scripts.bundle.js')}}"></script>
		<!--end::Global Theme Bundle-->
		<!--begin::Page Scripts(used by this page)-->
		<script src="{{asset('dashboard/assets/js/pages/custom/login/login-4.js')}}"></script>
		  <?php
    $message=session()->get("message");
    ?>

    @if( session()->has("message"))
        @if( $message == "Success")
            <script>
                Swal.fire({
                    icon: 'success',
                    title: "{{__('lang.Success')}}",
                    text: "{{__('lang.Success_text')}}",
                    type:"success" ,
                    timer: 1000,
                    showConfirmButton: false
                });

            </script>
        @elseif ( $message == "Failed")
            <script>
                Swal.fire({
                    icon: 'warning',
                    title: "عفوا",
                    text: "عفوا كلمة المرور غير صحيحة ",
                    type:"error" ,
                    timer: 2000,
                    showConfirmButton: false
                });
            </script>
        @endif
    @endif
		<!--end::Page Scripts-->
	</body>
	<!--end::Body-->
</html>
