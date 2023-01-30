@if(Request::segment(1) == 'ar' )
    <link href="{{asset('dashboard/assets/css/pages/wizard/wizard-6.rtl.css')}}" rel="stylesheet" type="text/css" />
@else
    <link href="{{asset('dashboard/assets/css/pages/wizard/wizard-6.css')}}" rel="stylesheet" type="text/css" />
@endif


            <form class="px-10" novalidate="novalidate" id="kt_form2"  method="post" action="{{url('Update_Products')}}" enctype="multipart/form-data">
                <!--begin: Wizard Step 1-->
                @csrf
                <div class="form-group">
                    <label>{{__('lang.name_ar')}} </label>
                    <input type="text" class="form-control form-control-solid" value="{{$User->name_ar}}" name="name_ar" required placeholder="{{__('lang.name_ar')}}" >
                </div>
                <div class="form-group">
                    <label>{{__('lang.name_en')}} </label>
                    <input type="text" class="form-control form-control-solid" name="name_en" value="{{$User->name_en}}"  required placeholder="{{__('lang.name_en')}}" >
                </div>
                <div class="form-group">
                    <label>{{__('lang.mainCategory')}} </label>
                    @inject('mainCategory','App\Models\MainCategory')
                    <select name="main_category_id" class="form-control">
                        @foreach($mainCategory->all() as $b)
                            @if($User->main_category_id == $b->id)
                                <option selected value="{{$b->id}}">@if(Request::segment(1) == 'ar'){{$b->name_ar}} @else {{$b->name_en}} @endif</option>

                            @else
                                <option value="{{$b->id}}">@if(Request::segment(1) == 'ar'){{$b->name_ar}} @else {{$b->name_en}} @endif</option>

                            @endif

                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>{{__('lang.SubCategory')}} </label>
                    @inject('SubCategory','App\Models\SubCategory')
                    <select name="sub_category_id" class="form-control">
                        @foreach($SubCategory->all() as $b)
                            @if($User->main_category_id == $b->id)
                                <option selected value="{{$b->id}}">@if(Request::segment(1) == 'ar'){{$b->name_ar}} @else {{$b->name_en}} @endif</option>
                            @else
                                <option value="{{$b->id}}">@if(Request::segment(1) == 'ar'){{$b->name_ar}} @else {{$b->name_en}} @endif</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>{{__('lang.price')}} </label>
                    <input type="text" class="form-control form-control-solid" value="{{$User->price}}" name="price" required placeholder="{{__('lang.price')}}" >
                </div>
                <div class="form-group">
                    <label>{{__('lang.delivery_time')}} </label>
                    <input type="text" class="form-control form-control-solid" value="{{$User->delivery_time}}"  name="delivery_time" required placeholder="{{__('lang.delivery_time')}}" >
                </div>

                <div class="form-group">
                    <label>{{__('lang.active')}} </label>
                    <select name="is_active" class="form-control">
                        @if($User->is_active == 1)
                        <option value="1">active</option>
                        <option value="0">inActive</option>
                        @else
                            <option value="1">active</option>
                            <option selected value="0">inActive</option>
                        @endif
                    </select>
                </div>
                <div class="form-group">
                    <label>{{__('lang.description_ar')}} </label>
                    <textarea rows="5" class="form-control" value="{{$User->description_ar}}" name="description_ar"></textarea>
                </div>

                <div class="form-group">
                    <label>{{__('lang.description_en')}} </label>
                    <textarea rows="5" class="form-control"value="{{$User->description_en}}"   name="description_en"></textarea>
                </div>


                <div class="form-group row">
                    <label class="col-xl-3 col-lg-3 col-form-label">@if(Request::segment(1) == 'ar') الصورة   @else  image @endif</label>
                    <div class="col-lg-12 col-xl-12">
                        <div class="card">
                            <div class="card-block">
                                <h4 class="card-title"></h4>
                                <div class="controls">
                                    <input type="file" id="input-file-now" class="dropify"  name="image" required data-validation-required-message="{{trans('word.This field is required')}}"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--end: Wizard Actions-->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('lang.Jobs_Close')}}</button>
                    <button type="submit" class="btn btn-primary">{{__('lang.save')}}</button>
                </div>
            </form>

    <script src="{{asset('dashboard/assets/js/pages/custom/wizard/wizard-6-2.js')}}"></script>

		<script src="{{asset('dashboard/assets/js/pages/crud/forms/widgets/select2.js')}}"></script>

    <!--begin::Page scripts(used by this page) -->
    <script>
  $('#kt_select4').select2({
         placeholder: ""
        });
        $('#kt_select5').select2({
         placeholder: ""
        });
        </script>
    <script src="{{asset('hijri/js/momentjs.js')}}"></script>
    <script src="{{asset('hijri/js/moment-with-locales.js')}}"></script>
    <script src="{{asset('hijri/js/moment-hijri.js')}}"></script>
    <script src="{{asset('hijri/js/bootstrap-hijri-datetimepicker.js')}}"></script>

    <!--begin::Page scripts(used by this page) -->
    <script type="text/javascript">


        $(function () {

            initHijrDatePicker();

            //initHijrDatePickerDefault();

            $('.disable-date').hijriDatePicker({

                minDate:"2020-01-01",
                maxDate:"2021-01-01",
                viewMode:"years",
                hijri:true,
                debug:true
            });

        });

        function initHijrDatePicker() {

            $(".hijri-date-input").hijriDatePicker({
                locale: "ar-sa",
                format: "DD-MM-YYYY",
                hijriFormat:"iYYYY-iMM-iDD",
                dayViewHeaderFormat: "MMMM YYYY",
                hijriDayViewHeaderFormat: "iMMMM iYYYY",
                showSwitcher: true,
                allowInputToggle: true,
                showTodayButton: false,
                useCurrent: true,
                isRTL: false,
                viewMode:'months',
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
