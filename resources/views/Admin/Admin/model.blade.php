

<link rel="stylesheet" href="{{asset('dashboard/dropify/dist/css/dropify.min.css')}}">



<form class="px-10" novalidate="novalidate" id="kt_form2"  method="post" action='{{url('Update_Admins')}}' enctype="multipart/form-data">
    <!--begin: Wizard Step 1-->
    @csrf
    <div class="form-group">
        <label>{{__('lang.name')}} </label>
        <input type="text" class="form-control form-control-solid" value="{{$User->name}}" name="name" required placeholder="{{__('lang.name')}}" >
        <input type="hidden" class="form-control form-control-solid" value="{{$User->id}}" name="id" required placeholder="{{__('lang.name')}}" >
    </div>

    <div class="form-group">
        <label>{{__('lang.phone')}} </label>
        <input type="text" class="form-control form-control-solid" value="{{$User->phone}}" name="phone" required placeholder="{{__('lang.phone')}}" >
    </div>
    <div class="form-group">
        <label>{{__('lang.email')}} </label>
        <input type="email" class="form-control hijri-date-input" name="email" value="{{$User->email}}" required value="">
    </div>

    <div class="form-group">
        <label>{{__('lang.address')}}  </label>
        <input type="text" class="form-control form-control-solid" name="address" value="{{$User->address}}"  required placeholder="{{__('lang.address')}}" >
    </div>
    <div class="form-group">
        <label>{{__('lang.password')}}  </label>
        <input  type="text"   style="-webkit-text-security: square;"    class="form-control form-control-solid" name="password"   required placeholder="{{__('lang.password')}}" >
    </div>
    <div class="form-group">
        <label >{{trans('lang.roles')}}</label>
        <div class="col-sm-12">
            <select name="role" class="form-control">
                <option value="">{{trans('lang.choose_role')}}</option>
                @foreach(\Spatie\Permission\Models\Role::all() as $role)
                    <option @if($User->roles->first()) @if($User->roles->first()->id == $role->id) selected @endif @endif value="{{$role->id}}">{{$role->name}}</option>
                @endforeach
            </select>
        </div>
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


<script src="{{asset('dashboard/assets/js/pages/crud/forms/widgets/select2.js')}}"></script>
<script src="{{asset('dashboard/assets/js/pages/features/miscellaneous/dropify.min.js')}}"></script>

<!--begin::Page scripts(used by this page) -->
<script>
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
