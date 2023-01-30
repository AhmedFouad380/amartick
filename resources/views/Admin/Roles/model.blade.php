<link rel="stylesheet" href="{{asset('dashboard/dropify/dist/css/dropify.min.css')}}">


<form class="px-10" novalidate="novalidate" id="kt_form2" method="post" action="{{url('roles/update_permission')}}"
      enctype="multipart/form-data">
    <!--begin: Wizard Step 1-->
    @csrf
    <div class="form-group">
        <label>{{__('lang.name')}} </label>
        <input type="text" class="form-control form-control-solid" name="name" value="{{$role->name}}" required
               placeholder="{{__('lang.name')}}">
        <input type="hidden" class="form-control form-control-solid" value="{{$role->id}}" name="id" required placeholder="{{__('lang.name_ar')}}" >

    </div>

    <div class="table-responsive">
        <table class="table table-borderless mb-0">
            <tbody>
            @foreach(Spatie\Permission\Models\Permission::all() as $key=> $single)
                @if($key==0)
                    <tr>
                        <th style="font-size:large;color: #0e6662 "
                            class=""> {{trans('lang.Settings')}}</th>
                    </tr>
                @endif
                @if($key==7)
                    <tr>
                        <th style="font-size:large;color: #0e6662 "
                            class=""> {{trans('lang.Other Setting')}}</th>
                    </tr>
                @endif
                @if($key==12)
                    <tr>
                        <th style="font-size:large;color: #0e6662 "
                            class=""> {{trans('lang.specific Setting')}}</th>
                    </tr>
                @endif

                <tr>
                    <th>{{trans('lang.'.$single->name)}}</th>
                    <td>
                        <input type="checkbox" value="{{$single->id}}" id="switch{{$key}}" switch="purple" name="permissions[]"
                               @if(in_array($single->id, $r_permissions))checked @endif/>
                        <label for="switch{{$key}}" data-on-label="نعم" data-off-label="لا" style="margin: 0px;"></label>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
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
