<link rel="stylesheet" href="{{asset('dashboard/dropify/dist/css/dropify.min.css')}}">



<form class="px-10" novalidate="novalidate" id="kt_form2"  method="post" action='{{url('Update_Catgories')}}' enctype="multipart/form-data">
    <!--begin: Wizard Step 1-->
    @csrf
    <div class="form-group">
        <label>{{__('lang.name_ar')}} </label>
        <input type="text" class="form-control form-control-solid"  value="{{$User->name_ar}}" name="name_ar" required placeholder="{{__('lang.name_ar')}}" >
        <input type="hidden" class="form-control form-control-solid"  value="{{$User->id}}" name="id" required placeholder="{{__('lang.name_ar')}}" >
    </div>
    <div class="form-group">
        <label>{{__('lang.name_en')}} </label>
        <input type="text" class="form-control form-control-solid" value="{{$User->name_en}}"  name="name_en" required placeholder="{{__('lang.name_en')}}" >
    </div>
{{--    <div class="form-group">--}}
{{--        <label>{{__('lang.deliver_from')}} </label>--}}
{{--        <input type="time" class="form-control form-control-solid" value="{{$User->deliver_from}}"  name="deliver_from" required placeholder="{{__('lang.deliver_from')}}" >--}}
{{--    </div>--}}

{{--    <div class="form-group">--}}
{{--        <label>{{__('lang.deliver_to')}} </label>--}}
{{--        <input type="time" class="form-control form-control-solid" value="{{$User->deliver_to}}"  name="deliver_to" required placeholder="{{__('lang.deliver_to')}}" >--}}
{{--    </div>--}}

    <div class="form-group">
        <label>{{__('lang.estimate_time')}} </label>
        <input type="text" class="form-control form-control-solid" value="{{$User->estimate_time}}"  name="estimate_time" required placeholder="{{__('lang.estimate_time')}}" >
    </div>

    <div class="form-group">
        <label>{{__('lang.supplier_count')}} </label>
        <input type="number" class="form-control form-control-solid" value="{{$User->supplier_count}}" name="supplier_count" required placeholder="{{__('lang.estimate_time')}}" >
    </div>
    <div class="form-group">
        <label>{{__('lang.max_request')}} </label>
        <input type="number" class="form-control form-control-solid" value="{{$User->max_request}}"name="max_request" required placeholder="{{__('lang.max_request')}}" >
    </div>
    <div class="form-group">
        <label>{{__('lang.max_distance')}} </label>
        <input type="number" class="form-control form-control-solid" value="{{$User->max_distance}}" name="max_distance" required placeholder="{{__('lang.max_distance')}}" >
    </div>
    <div class="form-group">
        <label>{{__('lang.max_time_reorder')}} </label>
        <input type="number" class="form-control form-control-solid"value="{{$User->max_time_reorder}}"  name="max_time_reorder" required placeholder="{{__('lang.max_time_reorder')}}" >
    </div>


    <div class="form-group row">
        <label class="col-xl-3 col-lg-3 col-form-label">{{__('lang.image')}}</label>
        <div class="col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-block">
                    <h4 class="card-title"></h4>
                    <div class="controls">
                        <input type="file" id="input-file-now" class="dropify"  data-default-file="{{$User->image}}" name="image" required data-validation-required-message="{{trans('word.This field is required')}}"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <label  class="col-md-12 col-md-12">                {{__('lang.icon')}}
        </label>
        @for($x = 1; $x < 16 ; $x++)
            <div class="col-md-3">
                <input type="radio" name="icon" value="{{$x.'.png'}}" @if(asset('uploads/MainCategory/Icon/'.$x.'.png') == $User->icon ) checked="checked" @endif >
                <img src="{{asset('uploads/MainCategory/Icon/'.$x.'.png')}}" style="width:40px; height: 40px;">
            </div>
        @endfor
    </div>
    <!--end: Wizard Actions-->
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('lang.Jobs_Close')}}</button>
        <button type="submit" class="btn btn-primary">{{__('lang.save')}}</button>
    </div>
</form>


<script src="{{asset('dashboard/assets/js/pages/crud/forms/widgets/select2.js')}}"></script>
<script src="{{asset('dashboard/assets/js/pages/features/miscellaneous/dropify.min.js')}}"></script>

<!--begin::Page scripts(used by this page) -->
<script>
    $('.iconSelected2').on('click , change',function () {
        var value = $(this).val();

        $('#Icon2').val(value);
    })
    $('#kt_select4').select2({
        placeholder: ""
    });
    $('#kt_select5').select2({
        placeholder: ""
    });
</script>
<!--begin::Page scripts(used by this page) -->
<script type="text/javascript">
    $(document).ready(function() {
        // Basic
        $('.dropify').dropify();

        // Used events
        var drEvent = $('#input-file-events').dropify();

        drEvent.on('dropify.beforeClear', function(event, element) {
            return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
        });

        drEvent.on('dropify.afterClear', function(event, element) {
            alert('File deleted');
        });

        drEvent.on('dropify.errors', function(event, element) {
            console.log('Has Errors');
        });

        var drDestroy = $('#input-file-to-destroy').dropify();
        drDestroy = drDestroy.data('dropify')
        $('#toggleDropify').on('click', function(e) {
            e.preventDefault();
            if (drDestroy.isDropified()) {
                drDestroy.destroy();
            } else {
                drDestroy.init();
            }
        })
    });


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
