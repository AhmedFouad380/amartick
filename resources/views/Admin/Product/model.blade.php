<link rel="stylesheet" href="{{asset('dashboard/dropify/dist/css/dropify.min.css')}}">


<form class="px-10" novalidate="novalidate" id="kt_form2" method="post" action="{{url('Update_Products')}}"
      enctype="multipart/form-data">
    <!--begin: Wizard Step 1-->
    @csrf
    <div class="form-group">
        <label>{{__('lang.name_ar')}} </label>
        <input type="text" class="form-control form-control-solid" value="{{$User->name_ar}}" name="name_ar" required
               placeholder="{{__('lang.name_ar')}}">
        <input type="hidden" class="form-control form-control-solid" value="{{$User->id}}" name="id" required
               placeholder="{{__('lang.name_ar')}}">
    </div>
    <div class="form-group">
        <label>{{__('lang.name_en')}} </label>
        <input type="text" class="form-control form-control-solid" name="name_en" value="{{$User->name_en}}" required
               placeholder="{{__('lang.name_en')}}">
    </div>
    <div class="form-group">
        <label>{{__('lang.MainCategory')}} </label>
        @inject('mainCategory','App\Models\MainCategory')
        <select id="MainCategory2" name="main_category_id" class="form-control">
            @foreach($mainCategory->all() as $b)
                @if($User->main_category_id == $b->id)
                    <option selected
                            value="{{$b->id}}">@if(session('lang') == 'en'){{$b->name_en}} @else {{$b->name_ar}} @endif</option>

                @else
                    <option
                        value="{{$b->id}}">@if(session('lang') == 'en'){{$b->name_en}} @else {{$b->name_ar}} @endif</option>

                @endif

            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label>{{__('lang.SubCategory')}} </label>
        @inject('SubCategory','App\Models\SubCategory')
        <select id="SubCategory2" name="sub_category_id" class="form-control">
            @foreach($SubCategory->where('main_category_id',$User->main_category_id)->get() as $b)
                @if($User->sub_category_id == $b->id)
                    <option selected
                            value="{{$b->id}}" >@if(session('lang') == 'en'){{$b->name_en}} @else {{$b->name_ar}} @endif</option>
                @else
                    <option
                        value="{{$b->id}}">@if(session('lang') == 'en'){{$b->name_en}} @else {{$b->name_ar}} @endif</option>
                @endif
            @endforeach
        </select>
    </div>
    '
    <div class="form-group">
        <label>{{__('lang.Company')}} </label>
        @inject('SubCategory','App\Models\Company')
        <select name="company_id" class="form-control">
            @foreach($SubCategory->all() as $b)
                @if($User->company_id == $b->id)
                    <option selected
                            value="{{$b->id}}">@if(session('lang') == 'en'){{$b->name_en}} @else {{$b->name_ar}} @endif</option>
                @else
                    <option
                        value="{{$b->id}}">@if(session('lang') == 'en'){{$b->name_en}} @else {{$b->name_ar}} @endif</option>
                @endif
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label>{{__('lang.price')}} </label>
        <input type="number" min="0" step="1" class="form-control form-control-solid" value="{{$User->price}}" name="price" required
               placeholder="{{__('lang.price')}}">
    </div>
{{--    <div class="form-group">--}}
{{--        <label>{{__('lang.delivery_time')}} </label>--}}
{{--        <input type="text" class="form-control form-control-solid" value="{{$User->delivery_time}}" name="delivery_time"--}}
{{--               required placeholder="{{__('lang.delivery_time')}}">--}}
{{--    </div>--}}

    <div class="form-group">
        <label>{{__('lang.active')}} </label>
        <select name="is_active" class="form-control">

            <option @if($User->is_active == 1) selected @endif value="1">{{trans('lang.active')}}</option>
            <option @if($User->is_active == 0) selected @endif value="0">{{trans('lang.inActive')}}</option>

        </select>
    </div>

    <div class="form-group">
        <label>{{__('lang.unit_ar')}} </label>
        <input type="text" class="form-control form-control-solid" value="{{$User->unit_ar}}" name="unit_ar" required
               placeholder="{{__('lang.unit_ar')}}">
    </div>
    <div class="form-group">
        <label>{{__('lang.unit_en')}} </label>
        <input type="text" class="form-control form-control-solid" value="{{$User->unit_en}}" name="unit_en" required
               placeholder="{{__('lang.unit_en')}}">
    </div>
    <div class="form-group">
        <label>{{__('lang.description_ar')}} </label>
        <textarea rows="5" class="form-control" value="" name="description_ar">{{$User->description_ar}}</textarea>
    </div>

    <div class="form-group">
        <label>{{__('lang.description_en')}} </label>
        <textarea rows="5" class="form-control" value="" name="description_en"> {{$User->description_en}} </textarea>
    </div>


    <div class="form-group row">
        <label class="col-xl-3 col-lg-3 col-form-label">@if(session('lang') == 'en')   image @else
                الصورة @endif</label>
        <div class="col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-block">
                    <h4 class="card-title"></h4>
                    <div class="controls">
                        <input type="file" id="input-file-now" class="dropify" name="image"
                               data-default-file="{{$User->image}}" required
                               data-validation-required-message="{{trans('word.This field is required')}}"/>
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
    $("#MainCategory2").click(function () {
        var wahda = $(this).val();

        if (wahda != '') {

            $.get("{{ URL::to('/GetSubCategory')}}" + '/' + wahda, function ($data) {
                console.log($data)

                var outs = "";
                $.each($data, function (name, id) {

                    outs += '<option value="' + id + '">' + name + '</option>'

                });
                $('#SubCategory2').html(outs);


            });
        }
    });

</script>
