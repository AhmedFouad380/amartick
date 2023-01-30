@extends('layout.layout')

@section('title')
    {{__('lang.Home')}}
@endsection
@section('css')
    <link href="{{asset('dashboard//plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet"
          type="text/css"/>
    <style>
        .bootstrap-datetimepicker-widget {
            display: contents !important;
        }


    </style>
@endsection


@section('content')

    <style>
        .text-muted {
            color: #000000 !important;
        }
    </style>
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Dashboard-->
            <!--begin::Row-->
            @if(Auth::guard('admins')->check())

                <div class="row">
                    <div class="col-xl-3">
                        <!--begin::Stats Widget 29-->
                        <div style="background-color:#FFF!important; border-radius: 35px; "
                             class="card card-custom bgi-no-repeat card-stretch gutter-b"
                             style="background-position: right top; background-size: 30% auto; background-image: url(assets/media/svg/shapes/abstract-1.svg)">
                            <!--begin::Body-->
                            <div class="card-body">
												<span class="svg-icon svg-icon-2x svg-icon-info">
													<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Mail-opened.svg-->
														<svg xmlns="http://www.w3.org/2000/svg"
                                                             xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                             height="24px" viewBox="0 0 24 24" version="1.1">
														<g stroke="none" stroke-width="1" fill="none"
                                                           fill-rule="evenodd">
															<polygon points="0 0 24 0 24 24 0 24"/>
															<path
                                                                d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z"
                                                                fill="#000000" fill-rule="nonzero" opacity="0.3"/>
															<path
                                                                d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z"
                                                                fill="#000000" fill-rule="nonzero"/>
														</g>
													</svg>
                                                    <!--end::Svg Icon-->
												</span>
                                @inject('Admins','App\Models\Admin')
                                <span
                                    class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block">{{$Admins->count()}}</span>
                                <span class="font-weight-bold text-muted font-size-sm">{{__('lang.admins')}}</span>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Stats Widget 29-->
                    </div>
                    <div class="col-xl-3">
                        <!--begin::Stats Widget 30-->
                        <div style="background-color:#FFF!important; border-radius: 35px; "
                             class="card card-custom bg-info card-stretch gutter-b">
                            <!--begin::Body-->
                            <div class="card-body">
												<span class="svg-icon svg-icon-2x svg-icon-info">
													<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Mail-opened.svg-->
														<svg xmlns="http://www.w3.org/2000/svg"
                                                             xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                             height="24px" viewBox="0 0 24 24" version="1.1">
														<g stroke="none" stroke-width="1" fill="none"
                                                           fill-rule="evenodd">
															<polygon points="0 0 24 0 24 24 0 24"/>
															<path
                                                                d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z"
                                                                fill="#000000" fill-rule="nonzero" opacity="0.3"/>
															<path
                                                                d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z"
                                                                fill="#000000" fill-rule="nonzero"/>
														</g>
													</svg>
                                                    <!--end::Svg Icon-->
												</span>
                                @inject('Supplier','App\Models\Supplier')
                                <span
                                    class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block">{{$Supplier->count()}}</span>
                                <span class="font-weight-bold text-muted font-size-sm">{{__('lang.Suppliers')}}</span>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Stats Widget 30-->
                    </div>
                    <div class="col-xl-3">
                        <!--begin::Stats Widget 31-->
                        <div style="background-color:#FFF!important; border-radius: 35px; "
                             class="card card-custom bg-danger card-stretch gutter-b">
                            <!--begin::Body-->
                            <div class="card-body">
												<span class="svg-icon svg-icon-2x svg-icon-info">
													<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Mail-opened.svg-->
														<svg xmlns="http://www.w3.org/2000/svg"
                                                             xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                             height="24px" viewBox="0 0 24 24" version="1.1">
														<g stroke="none" stroke-width="1" fill="none"
                                                           fill-rule="evenodd">
															<polygon points="0 0 24 0 24 24 0 24"/>
															<path
                                                                d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z"
                                                                fill="#000000" fill-rule="nonzero" opacity="0.3"/>
															<path
                                                                d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z"
                                                                fill="#000000" fill-rule="nonzero"/>
														</g>
													</svg>
                                                    <!--end::Svg Icon-->
												</span>
                                @inject('User','App\Models\User')
                                <span
                                    class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block">{{$User->count()}}</span>
                                <span class="font-weight-bold text-muted font-size-sm">{{__('lang.Clients')}}</span>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Stats Widget 31-->
                    </div>
                    <div class="col-xl-3">
                        <!--begin::Stats Widget 32-->
                        <div style="background-color:#FFF!important; border-radius: 35px; "
                             class="card card-custom bg-dark card-stretch gutter-b">
                            <!--begin::Body-->
                            <div class="card-body">
												<span class="svg-icon svg-icon-2x svg-icon-danger">
													<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Group.svg-->
														<svg xmlns="http://www.w3.org/2000/svg"
                                                             xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                             height="24px" viewBox="0 0 24 24" version="1.1">
														<g stroke="none" stroke-width="1" fill="none"
                                                           fill-rule="evenodd">
															<rect x="0" y="0" width="24" height="24"/>
															<rect fill="#000000" opacity="0.3" x="13" y="4" width="3"
                                                                  height="16" rx="1.5"/>
															<rect fill="#000000" x="8" y="9" width="3" height="11"
                                                                  rx="1.5"/>
															<rect fill="#000000" x="18" y="11" width="3" height="9"
                                                                  rx="1.5"/>
															<rect fill="#000000" x="3" y="13" width="3" height="7"
                                                                  rx="1.5"/>
														</g>
													</svg>
                                                    <!--end::Svg Icon-->
												</span>
                                @inject('Product','App\Models\Project')
                                <span
                                    class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block">{{$Product->count()}}</span>
                                <span class="font-weight-bold text-muted font-size-sm">{{__('lang.Projects')}}</span>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Stats Widget 32-->
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-3">
                        <!--begin::Stats Widget 25-->
                        <div style="background-color:#FFF!important; border-radius: 35px; "
                             class="card card-custom bg-light-success card-stretch gutter-b">
                            <!--begin::Body-->
                            <div class="card-body">
												<span class="svg-icon svg-icon-2x svg-icon-success">
													<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Mail-opened.svg-->
														<svg xmlns="http://www.w3.org/2000/svg"
                                                             xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                             height="24px" viewBox="0 0 24 24" version="1.1">
														<g stroke="none" stroke-width="1" fill="none"
                                                           fill-rule="evenodd">
															<rect x="0" y="0" width="24" height="24"/>
															<rect fill="#000000" opacity="0.3" x="13" y="4" width="3"
                                                                  height="16" rx="1.5"/>
															<rect fill="#000000" x="8" y="9" width="3" height="11"
                                                                  rx="1.5"/>
															<rect fill="#000000" x="18" y="11" width="3" height="9"
                                                                  rx="1.5"/>
															<rect fill="#000000" x="3" y="13" width="3" height="7"
                                                                  rx="1.5"/>
														</g>
													</svg>
                                                    <!--end::Svg Icon-->
												</span>
                                @inject('MainCategory','App\Models\MainCategory')
                                <span
                                    class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block">{{$MainCategory->count()}}</span>
                                <span
                                    class="font-weight-bold text-muted font-size-sm">{{__('lang.MainCategory')}}</span>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Stats Widget 25-->
                    </div>
                    <div class="col-xl-3">
                        <!--begin::Stats Widget 26-->
                        <div style="background-color:#FFF!important; border-radius: 35px; "
                             class="card card-custom bg-light-danger card-stretch gutter-b">
                            <!--begin::ody-->
                            <div class="card-body">
												<span class="svg-icon svg-icon-2x svg-icon-danger">
													<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Group.svg-->
														<svg xmlns="http://www.w3.org/2000/svg"
                                                             xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                             height="24px" viewBox="0 0 24 24" version="1.1">
														<g stroke="none" stroke-width="1" fill="none"
                                                           fill-rule="evenodd">
															<rect x="0" y="0" width="24" height="24"/>
															<rect fill="#000000" opacity="0.3" x="13" y="4" width="3"
                                                                  height="16" rx="1.5"/>
															<rect fill="#000000" x="8" y="9" width="3" height="11"
                                                                  rx="1.5"/>
															<rect fill="#000000" x="18" y="11" width="3" height="9"
                                                                  rx="1.5"/>
															<rect fill="#000000" x="3" y="13" width="3" height="7"
                                                                  rx="1.5"/>
														</g>
													</svg>
                                                    <!--end::Svg Icon-->
												</span>
                                @inject('SubCategory','App\Models\SubCategory')
                                <span
                                    class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block">{{$SubCategory->count()}}</span>
                                <span class="font-weight-bold text-muted font-size-sm">{{__('lang.SubCategory')}}</span>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Stats Widget 26-->
                    </div>
                    <div class="col-xl-3">
                        <!--begin::Stats Widget 27-->
                        <div style="background-color:#FFF!important; border-radius: 35px; "
                             class="card card-custom bg-light-info card-stretch gutter-b">
                            <!--begin::Body-->
                            <div class="card-body">
														<span class="svg-icon svg-icon-2x svg-icon-success">
													<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Mail-opened.svg-->
														<svg xmlns="http://www.w3.org/2000/svg"
                                                             xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                             height="24px" viewBox="0 0 24 24" version="1.1">
														<g stroke="none" stroke-width="1" fill="none"
                                                           fill-rule="evenodd">
															<rect x="0" y="0" width="24" height="24"/>
															<rect fill="#000000" opacity="0.3" x="13" y="4" width="3"
                                                                  height="16" rx="1.5"/>
															<rect fill="#000000" x="8" y="9" width="3" height="11"
                                                                  rx="1.5"/>
															<rect fill="#000000" x="18" y="11" width="3" height="9"
                                                                  rx="1.5"/>
															<rect fill="#000000" x="3" y="13" width="3" height="7"
                                                                  rx="1.5"/>
														</g>
													</svg>
                                                            <!--end::Svg Icon-->
												</span>
                                @inject('Product','App\Models\Product')
                                <span
                                    class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block">{{$Product->count()}}</span>
                                <span class="font-weight-bold text-muted font-size-sm">{{__('lang.Products')}}</span>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Stats Widget 27-->
                    </div>
                    <div class="col-xl-3">
                        <!--begin::Stats Widget 28-->
                        <div style="background-color:#FFF!important; border-radius: 35px; "
                             class="card card-custom bg-light-warning card-stretch gutter-b">
                            <!--begin::Body-->
                            <div class="card-body">
												<span class="svg-icon svg-icon-2x svg-icon-warning">
													<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Group-chat.svg-->
													<svg xmlns="http://www.w3.org/2000/svg"
                                                         xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                         height="24px" viewBox="0 0 24 24" version="1.1">
														<g stroke="none" stroke-width="1" fill="none"
                                                           fill-rule="evenodd">
															<rect x="0" y="0" width="24" height="24"/>
															<path
                                                                d="M16,15.6315789 L16,12 C16,10.3431458 14.6568542,9 13,9 L6.16183229,9 L6.16183229,5.52631579 C6.16183229,4.13107011 7.29290239,3 8.68814808,3 L20.4776218,3 C21.8728674,3 23.0039375,4.13107011 23.0039375,5.52631579 L23.0039375,13.1052632 L23.0206157,17.786793 C23.0215995,18.0629336 22.7985408,18.2875874 22.5224001,18.2885711 C22.3891754,18.2890457 22.2612702,18.2363324 22.1670655,18.1421277 L19.6565168,15.6315789 L16,15.6315789 Z"
                                                                fill="#000000"/>
															<path
                                                                d="M1.98505595,18 L1.98505595,13 C1.98505595,11.8954305 2.88048645,11 3.98505595,11 L11.9850559,11 C13.0896254,11 13.9850559,11.8954305 13.9850559,13 L13.9850559,18 C13.9850559,19.1045695 13.0896254,20 11.9850559,20 L4.10078614,20 L2.85693427,21.1905292 C2.65744295,21.3814685 2.34093638,21.3745358 2.14999706,21.1750444 C2.06092565,21.0819836 2.01120804,20.958136 2.01120804,20.8293182 L2.01120804,18.32426 C1.99400175,18.2187196 1.98505595,18.1104045 1.98505595,18 Z M6.5,14 C6.22385763,14 6,14.2238576 6,14.5 C6,14.7761424 6.22385763,15 6.5,15 L11.5,15 C11.7761424,15 12,14.7761424 12,14.5 C12,14.2238576 11.7761424,14 11.5,14 L6.5,14 Z M9.5,16 C9.22385763,16 9,16.2238576 9,16.5 C9,16.7761424 9.22385763,17 9.5,17 L11.5,17 C11.7761424,17 12,16.7761424 12,16.5 C12,16.2238576 11.7761424,16 11.5,16 L9.5,16 Z"
                                                                fill="#000000" opacity="0.3"/>
														</g>
													</svg>
                                                    <!--end::Svg Icon-->
												</span>
                                @inject('Mail','App\Models\Inbox')
                                <span
                                    class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block">{{$Mail->where('receiver_id',auth_login()->user()->id)->count()}}</span>
                                <span class="font-weight-bold text-muted font-size-sm">{{__('lang.inbox')}}</span>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Stat: Widget 28-->
                    </div>
                </div>
            @endif

            <div class="row">
                @inject('Orders','App\Models\Order')

                <h3 class="card-title align-items-start flex-column">
                    <span class="font-weight-bolder text-dark">{{__('lang.orders')}}</span>
                    <span
                        class="text-muted mt-3 font-weight-bold font-size-sm">
                            الاجمالي :
                                @if(Auth::guard('admins')->check())
                            {{$Orders->count()}}
                        @else
                            {{$Orders->where('supplier_id',supplier_parent())->count()}}
                        @endif
                        </span>
                </h3>

                <div class="col-lg-12 col-xxl-12">

                    <div class="card card-custom card-stretch gutter-b">
                        <div id="chart_2" style="width:100%"></div>
                    </div>
                    <br><br>
                </div>

            </div>
            @if(Auth::guard('admins')->check())
                <div class="row">

                    <div class="col-lg-6 col-xxl-4">
                        <!--begin::Mixed Widget 1-->
                        <div class="card card-custom bg-gray-100 card-stretch gutter-b">
                            <!--begin::Header-->

                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body p-0 position-relative overflow-hidden">
                                <!--begin::Chart-->
                                <div id="" class="card-rounded-bottom" style="height: 200px"></div>
                                <!--end::Chart-->
                                <!--begin::Stats-->
                                <div class="card-spacer mt-n25">
                                    <!--begin::Row-->
                                    <div class="row m-0">
                                        <div class="col bg-light-warning px-6 py-8 rounded-xl mr-7 mb-7">
															<span
                                                                class="svg-icon svg-icon-3x svg-icon-primary d-block my-2">
																<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Add-user.svg-->
																<svg xmlns="http://www.w3.org/2000/svg"
                                                                     xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                     width="24px" height="24px" viewBox="0 0 24 24"
                                                                     version="1.1">
																	<g stroke="none" stroke-width="1" fill="none"
                                                                       fill-rule="evenodd">
																		<polygon points="0 0 24 0 24 24 0 24"/>
																		<path
                                                                            d="M18,8 L16,8 C15.4477153,8 15,7.55228475 15,7 C15,6.44771525 15.4477153,6 16,6 L18,6 L18,4 C18,3.44771525 18.4477153,3 19,3 C19.5522847,3 20,3.44771525 20,4 L20,6 L22,6 C22.5522847,6 23,6.44771525 23,7 C23,7.55228475 22.5522847,8 22,8 L20,8 L20,10 C20,10.5522847 19.5522847,11 19,11 C18.4477153,11 18,10.5522847 18,10 L18,8 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z"
                                                                            fill="#000000" fill-rule="nonzero"
                                                                            opacity="0.3"/>
																		<path
                                                                            d="M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z"
                                                                            fill="#000000" fill-rule="nonzero"/>
																	</g>
																</svg>
                                                                <!--end::Svg Icon-->
															</span>
                                            <a href="#"
                                               class="text-warning font-weight-bold font-size-h6">{{__('lang.Users')}} {{$users}}</a>
                                        </div>
                                        <div class="col bg-light-primary px-6 py-8 rounded-xl mb-7">
															<span
                                                                class="svg-icon svg-icon-3x svg-icon-primary d-block my-2">
																<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Add-user.svg-->
																<svg xmlns="http://www.w3.org/2000/svg"
                                                                     xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                     width="24px" height="24px" viewBox="0 0 24 24"
                                                                     version="1.1">
																	<g stroke="none" stroke-width="1" fill="none"
                                                                       fill-rule="evenodd">
																		<polygon points="0 0 24 0 24 24 0 24"/>
																		<path
                                                                            d="M18,8 L16,8 C15.4477153,8 15,7.55228475 15,7 C15,6.44771525 15.4477153,6 16,6 L18,6 L18,4 C18,3.44771525 18.4477153,3 19,3 C19.5522847,3 20,3.44771525 20,4 L20,6 L22,6 C22.5522847,6 23,6.44771525 23,7 C23,7.55228475 22.5522847,8 22,8 L20,8 L20,10 C20,10.5522847 19.5522847,11 19,11 C18.4477153,11 18,10.5522847 18,10 L18,8 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z"
                                                                            fill="#000000" fill-rule="nonzero"
                                                                            opacity="0.3"/>
																		<path
                                                                            d="M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z"
                                                                            fill="#000000" fill-rule="nonzero"/>
																	</g>
																</svg>
                                                                <!--end::Svg Icon-->
															</span>
                                            <a href="#"
                                               class="text-primary font-weight-bold font-size-h6 mt-2">{{__('lang.suppliers')}} {{$supplier}}</a>
                                        </div>
                                    </div>
                                    <!--end::Row-->
                                    <!--begin::Row-->
                                    <div class="row m-0">
                                        <div class="col bg-light-danger px-6 py-8 rounded-xl mr-7">
															<span
                                                                class="svg-icon svg-icon-3x svg-icon-danger d-block my-2">
																<!--begin::Svg Icon | path:assets/media/svg/icons/Design/Layers.svg-->
																<svg xmlns="http://www.w3.org/2000/svg"
                                                                     xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                     width="24px" height="24px" viewBox="0 0 24 24"
                                                                     version="1.1">
																	<g stroke="none" stroke-width="1" fill="none"
                                                                       fill-rule="evenodd">
																		<polygon points="0 0 24 0 24 24 0 24"/>
																		<path
                                                                            d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z"
                                                                            fill="#000000" fill-rule="nonzero"/>
																		<path
                                                                            d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z"
                                                                            fill="#000000" opacity="0.3"/>
																	</g>
																</svg>
                                                                <!--end::Svg Icon-->
															</span>
                                            <a href="#"
                                               class="text-danger font-weight-bold font-size-h6 mt-2">{{__('lang.Mothly_Orders')}}  {{$monthly_orders->count()}}</a>
                                        </div>
                                        <div class="col bg-light-success px-6 py-8 rounded-xl">
															<span
                                                                class="svg-icon svg-icon-3x svg-icon-success d-block my-2">
																<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Urgent-mail.svg-->
																<svg xmlns="http://www.w3.org/2000/svg"
                                                                     xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                     width="24px" height="24px" viewBox="0 0 24 24"
                                                                     version="1.1">
																	<g stroke="none" stroke-width="1" fill="none"
                                                                       fill-rule="evenodd">
																		<rect x="0" y="0" width="24" height="24"/>
																		<path
                                                                            d="M12.7037037,14 L15.6666667,10 L13.4444444,10 L13.4444444,6 L9,12 L11.2222222,12 L11.2222222,14 L6,14 C5.44771525,14 5,13.5522847 5,13 L5,3 C5,2.44771525 5.44771525,2 6,2 L18,2 C18.5522847,2 19,2.44771525 19,3 L19,13 C19,13.5522847 18.5522847,14 18,14 L12.7037037,14 Z"
                                                                            fill="#000000" opacity="0.3"/>
																		<path
                                                                            d="M9.80428954,10.9142091 L9,12 L11.2222222,12 L11.2222222,16 L15.6666667,10 L15.4615385,10 L20.2072547,6.57253826 C20.4311176,6.4108595 20.7436609,6.46126971 20.9053396,6.68513259 C20.9668779,6.77033951 21,6.87277228 21,6.97787787 L21,17 C21,18.1045695 20.1045695,19 19,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,6.97787787 C3,6.70173549 3.22385763,6.47787787 3.5,6.47787787 C3.60510559,6.47787787 3.70753836,6.51099993 3.79274528,6.57253826 L9.80428954,10.9142091 Z"
                                                                            fill="#000000"/>
																	</g>
																</svg>
                                                                <!--end::Svg Icon-->
															</span>
                                            <a href="#"
                                               class="text-success font-weight-bold font-size-h6 mt-2">{{__('lang.Mothly_Projects')}}  {{$monthly_projects}}</a>
                                        </div>
                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Stats-->
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Mixed Widget 1-->
                    </div>
                    <div class="col-lg-6 col-xxl-4">
                        <!--begin::List Widget 9-->
                        <div class="card card-custom card-stretch gutter-b">
                            <!--begin::Header-->
                            <div class="card-header align-items-center border-0 mt-4">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="font-weight-bolder text-dark">{{__('lang.Mothly_Orders')}}</span>
                                    <span
                                        class="text-muted mt-3 font-weight-bold font-size-sm">{{$monthly_orders->count()}}</span>
                                </h3>

                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body pt-4">
                                <!--begin::Timeline-->
                                <div class="timeline timeline-6 mt-3">
                                @foreach($monthly_orders as  $key => $monthly_order)
                                    @if($key <5)
                                        <!--begin::Item-->
                                            <div class="timeline-item align-items-start">
                                                <!--begin::Label-->
                                                <div
                                                    class="timeline-label font-weight-bolder text-dark-75 font-size-lg">{{Carbon\Carbon::parse($monthly_order->created_at)->format('m-d H:i')}}
                                                </div>
                                                <!--end::Label-->
                                                <!--begin::Badge-->
                                                <div class="timeline-badge">
                                                    <i class="fa fa-genderless text-warning icon-xl"></i>
                                                </div>
                                                <!--end::Badge-->
                                                <!--begin::Text-->
                                                <div
                                                    class="font-weight-mormal font-size-lg timeline-content text-muted pl-3">
                                                    @if($monthly_order->Supplier)
                                                        {{__('lang.supplier')}} :
                                                        <b> {{$monthly_order->Supplier->name}}</b>
                                                    @endif
                                                    {{__('lang.User')}} : <b>@if($monthly_order->User){{$monthly_order->User->name}}@else ---@endif</b> <br>
                                                    {{__('lang.total_price')}} :<b> {{$monthly_order->total_price}}</b>
                                                </div>
                                                <!--end::Text-->
                                            </div>
                                            <!--end::Item-->
                                        @endif
                                    @endforeach

                                </div>
                                <!--end::Timeline-->
                            </div>
                            <!--end: Card Body-->
                        </div>
                        <!--end: List Widget 9-->
                    </div>

                </div>
        @endif
        <!--end::Row-->
            <!--begin::Row-->
            <!--end::Row-->
            <!--end::Dashboard-->
        </div>
        <!--end::Container-->
    </div>



@endsection
@section('js')
    <script src="{{asset('dashboard/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>

    <script>
        $('#exampleModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('whatever') // Extract info from data-* attributes
            var contract_num = button.data('b') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('.modal-body #id').val(recipient);
            modal.find('.modal-body #contract_num').val(contract_num)


        })
        $('#exampleModal1').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('whatever') // Extract info from data-* attributes
            var contract_num = button.data('b') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)

            modal.find('.modal-body #contract_num').val(contract_num);
            modal.find('.modal-body #id').val(recipient)
        })

        $('#datatable').dataTable({
            "searching": true,

        });
    </script>


    <script src="{{asset('hijri/js/momentjs.js')}}"></script>
    <script src="{{asset('hijri/js/moment-with-locales.js')}}"></script>
    <script src="{{asset('hijri/js/moment-hijri.js')}}"></script>
    <script src="{{asset('hijri/js/bootstrap-hijri-datetimepicker.js')}}"></script>

    <!--<script src="{{asset('dashboard/assets/js/pages/features/charts/apexcharts.js')}}"></script>-->

    <script>
        "use strict";

        // Shared Colors Definition
        const primary = '#6993FF';
        const success = '#1BC5BD';
        const info = '#8950FC';
        const warning = '#FFA800';
        const danger = '#F64E60';

        // Class definition
        function generateBubbleData(baseval, count, yrange) {
            var i = 0;
            var series = [];
            while (i < count) {
                var x = Math.floor(Math.random() * (750 - 1 + 1)) + 1;
                ;
                var y = Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min;
                var z = Math.floor(Math.random() * (75 - 15 + 1)) + 15;

                series.push([x, y, z]);
                baseval += 86400000;
                i++;
            }
            return series;
        }

        function generateData(count, yrange) {
            var i = 0;
            var series = [];
            while (i < count) {
                var x = 'w' + (i + 1).toString();
                var y = Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min;

                series.push({
                    x: x,
                    y: y
                });
                i++;
            }
            return series;
        }

        var KTApexChartsDemo = function () {
            // Private functions

            var _demo3 = function () {
                const apexChart = "#chart_3";
                var options = {
                    series: [{
                        name: 'الموظفيين',
                        data: []
                    },],
                    chart: {
                        type: 'bar',
                        height: 350
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '55%',
                            endingShape: 'rounded'
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ['transparent']
                    },
                    xaxis: {
                        categories: [
                            @for($x=2010; $x<=date('Y'); $x++)
                            {{$x}},
                            @endfor

                        ],
                    },
                    yaxis: {
                        title: {}
                    },
                    fill: {
                        opacity: 1
                    },
                    tooltip: {
                        y: {
                            formatter: function (val) {
                                return val
                            }
                        }
                    },
                    colors: [primary, success, warning]
                };

                var chart = new ApexCharts(document.querySelector(apexChart), options);
                chart.render();
            }


            return {
                // public functions
                init: function () {
                    _demo3();
                }
            };
        }();

        jQuery(document).ready(function () {
            KTApexChartsDemo.init();
        });
        var KTApexChartsDemo = function () {
            // Private functions

            var _demo3 = function () {
                const apexChart = "#chart_3";
                var options = {
                    series: [{
                        name: 'الطلبات',
                        data: [
                            @inject('uses','App\Models\Order')
                                @for($x=1; $x<=12; $x++)
                                @if(Auth::guard('admins')->check())
                                "{{$uses->whereYear('created_at',date('Y'))->whereMonth('created_at','=',$x)->count()}}",
                            @else
                                "{{$uses->where('supplier_id',supplier_parent())->whereYear('created_at',date('Y'))->whereMonth('created_at','=',$x)->count()}}",

                            @endif
                            @endfor
                        ]
                    },],
                    chart: {
                        type: 'bar',
                        height: 350
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '55%',
                            endingShape: 'rounded'
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ['transparent']
                    },
                    xaxis: {
                        categories: [
                            @for($x=1; $x<=12; $x++)
                            {{$x}},
                            @endfor

                        ],
                    },
                    yaxis: {
                        title: {}
                    },
                    fill: {
                        opacity: 1
                    },
                    tooltip: {
                        y: {
                            formatter: function (val) {
                                return val
                            }
                        }
                    },
                    colors: [primary, success, warning]
                };

                var chart = new ApexCharts(document.querySelector(apexChart), options);
                chart.render();
            }

            var _demo2 = function () {
                const apexChart = "#chart_2";
                var options = {
                    series: [{
                        name: 'الطلبات المكتملة',
                        data: [
                            @inject('uses','App\Models\Order')
                                @for($x=1; $x<=12; $x++)
                                @if(Auth::guard('admins')->check())
                                "{{$uses->whereYear('created_at',date('Y'))->where('type','Delivered')->whereMonth('created_at','=',$x)->count()}}",
                            @else
                                "{{$uses->where('supplier_id',supplier_parent())->where('type','Delivered')->whereYear('created_at',date('Y'))->whereMonth('created_at','=',$x)->count()}}",
                            @endif
                            @endfor
                        ]
                    },
                        {
                            name: 'الطلابات الغير مكتملة ',
                            data: [
                                @inject('uses','App\Models\Order')
                                    @for($x=1; $x<=12; $x++)
                                    @if(Auth::guard('admins')->check())
                                    "{{$uses->whereYear('created_at',date('Y'))->where('type','!=','Delivered')->whereMonth('created_at','=',$x)->count()}}",
                                @else
                                    "{{$uses->where('supplier_id',supplier_parent())->where('type','!=','Delivered')->whereYear('created_at',date('Y'))->whereMonth('created_at','=',$x)->count()}}",
                                @endif
                                @endfor
                            ]
                        }
                    ],
                    chart: {
                        height: 350,
                        type: 'area'
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'smooth'
                    },
                    xaxis: {
                        type: 'datetime',

                        categories: [
                            @for($x=1; $x<=12; $x++)
                                "{{date('Y')}}-{{$x}}-1",
                            @endfor
                        ]
                    },
                    tooltip: {

                    },
                    colors: [success,danger ]
                };

                var chart = new ApexCharts(document.querySelector(apexChart), options);
                chart.render();
            }

            return {
                // public functions
                init: function () {
                    _demo3();
                    _demo2();
                }
            };
        }();


    </script>

    <script>
        //DataTable
        var table = $('#kt_tdata').DataTable({
            dom: 'Bfrtip',
            "ordering":false,
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
@endsection
