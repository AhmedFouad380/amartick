@extends('layout.layout')

@section('title')
    {{__('lang.Product')}}
@endsection
@section('css')
    <link href="{{asset('dashboard/assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="{{asset('dashboard/dropify/dist/css/dropify.min.css')}}">

@endsection

@section('content')

    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <!--begin::Container-->        <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <!--begin::Mobile Toggle-->
                    <button class="burger-icon burger-icon-left mr-4 d-inline-block d-lg-none" id="kt_subheader_mobile_toggle">
                        <span></span>
                    </button>
                    <!--end::Mobile Toggle-->
                    <!--begin::Page Heading-->
                    <div class="d-flex align-items-baseline flex-wrap mr-5">
                        <!--begin::Page Title-->

                        <!--end::Page Title-->
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                                                    @if(Auth::guard('admins')->check())
                                                        <li class="breadcrumb-item">
                                                            <a href="{{url('suppliers')}}" class="text-muted">{{trans('lang.Suppliers')}}</a>
                                                        </li>
                            @inject('Supplier','App\Models\Supplier')
                                                        <li class="breadcrumb-item">
                                                            <a href="" class="text-muted">{{$Supplier->find($id)->name}}</a>
                                                        </li>
                        @endif
                            <li class="breadcrumb-item">
                                <h5 class="text-dark font-weight-bold my-1 mr-5 ">{{trans('lang.Product')}}</h5>
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
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">{{__('lang.Product')}} : @inject('supplier','App\Models\Supplier') {{$supplier->find($id)->name}}
                    </div>
                    <div class="card-toolbar">
                        <!--begin::Button-->
                        <button  style="margin: 6px"  type="button" data-toggle="modal" data-toggle="modal" data-target="#kt_modal_5" class="btn btn-info font-weight-bolder">
                            &nbsp;&nbsp;<i class="flaticon2-magnifier-tool"></i>

                            {{__('lang.search')}}</button>

                        &nbsp;&nbsp




                        <!--end::Button-->
                    </div>
                </div>
                <div class="card-body">

                    <!--begin: Datatable-->
                    <table class="table table-bordered table-hover table-checkable mt-10" id="kt_tdata">
                        <thead>
                        <tr>
                            <th class="headerr">#</th>
                            <th class="headerr">{{__('lang.name_ar')}} </th>
                            <th class="headerr">{{__('lang.name_en')}} </th>
                            <th class="headerr">{{__('lang.main_category')}} </th>
                            <th class="headerr">{{__('lang.sub_category')}} </th>
                            <th class="headerr">{{__('lang.company')}} </th>
                            <th class="headerr">{{__('lang.price')}} </th>
                            <th class="headerr">{{__('lang.active')}} </th>
                            <th class="headerr">{{__('lang.Images')}} </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($Users as $Key => $User)
                            <tr>

                                <td>
                                    {{$Key + 1 }}
                                </td>
                                <td>{{$User->name_ar}}</td>
                                <td>{{$User->name_en}}</td>
                                <td>@if($User->MainCategory->name)
                                        {{$User->MainCategory->name}}
                                    @else
                                        N\A
                                    @endif
                                </td>
                                <td>@if($User->SubCategory->name)
                                        {{$User->SubCategory->name}}
                                    @else
                                        N\A
                                    @endif
                                </td>
                                <td>@if($User->Company->name)
                                        {{$User->Company->name}}
                                    @else
                                        N\A
                                    @endif
                                </td>
                                <td>{{$User->price}}</td>
                                <td>
                    <span class="switch switch-sm switchery-demo">
                        <label>
                             <input type="checkbox" class="switchery-demo" data-id="{{$User->id}}"

                                    @if(isset($SupplierProduct) && in_array($User->id , $SupplierProduct))
                                    checked="checked" @endif />
                         <span></span>
                        </label>
                       </span>
                                </td>
                                <td> <a class="btn btn-danger" href="{{url('ProductsImages/'.$User->id)}}" > {{__('lang.Images')}}</a> </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="row justify-content-center mt-5">
                        <nav aria-label="Page navigation example">

                            @php
                                $paginator =$Users->appends(request()->input())->links()->paginator;
                                    if ($paginator->currentPage() < 2 ){
                                        $link = $paginator->currentPage();
                                    }else{
                                         $link = $paginator->currentPage() -1;
                                    }
                                    if($paginator->currentPage() == $paginator->lastPage()){
                                               $last_links = $paginator->currentPage();
                                    }else{
                                               $last_links = $paginator->currentPage() +1;

                                    }
                            @endphp
                            @if ($paginator->lastPage() > 1)
                                <ul class="pagination">
                                    <li class="{{ ($paginator->currentPage() == 1) ? ' disabled' : '' }} page-item">
                                        <a class="page-link" href="{{ $paginator->url(1) }}">الاول </a>
                                    </li>
                                    @for ($i = $link; $i <= $last_links; $i++)
                                        <li class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }} page-item">
                                            <a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a>
                                        </li>
                                    @endfor
                                    <li class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }} page-item">
                                        <a class="page-link"
                                           href="{{ $paginator->url($paginator->lastPage()) }}">الاخير</a>
                                    </li>
                                </ul>
                            @endif

                        </nav>
                    </div>
                    <!--end: Datatable-->
                </div>
                {{--                <h3>اجمالي الموظفيين : @inject('AllUsers','App\Models\User') {{$AllUsers->count()}} </h3>--}}
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>

    <div class="modal fade" id="kt_modal_5" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        {{__('lang.search')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form method="get" action="{{url('/SupplierProducts/'.$id)}}">
                        <div class="col-xl-12">
                            <div class="kt-section__body">
                                <div class="form-group">
                                    <label>{{__('lang.name_ar')}} </label>
                                    <input type="text" class="form-control form-control-solid" name="name_ar"  placeholder="{{__('lang.name_ar')}}" >
                                </div>
                                <div class="form-group">
                                    <label>{{__('lang.name_en')}} </label>
                                    <input type="text" class="form-control form-control-solid" name="name_en"  placeholder="{{__('lang.name_en')}}" >
                                </div>
                                <div class="form-group">
                                    <label>{{__('lang.MainCategory')}} </label>
                                    @inject('mainCategory','App\Models\MainCategory')
                                    <select name="main_category_id" class="form-control">
                                        <option value="">-----</option>
                                        @foreach($mainCategory->all() as $b)
                                            <option value="{{$b->id}}">{{$b->name}}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <input type="hidden" name="id" value="{{$id}}">

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('lang.Jobs_Close')}}</button>
                            <button type="submit" class="btn btn-primary">{{__('lang.search')}}</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="kt_modal_4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        {{__('lang.Users_Create')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form class="px-10" novalidate="novalidate" id="kt_form"  method="post" action="{{url('Create_Products')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>{{__('lang.name_ar')}} </label>
                            <input type="text" class="form-control form-control-solid" name="name_ar" required placeholder="{{__('lang.name_ar')}}" >
                        </div>
                        <div class="form-group">
                            <label>{{__('lang.name_en')}} </label>
                            <input type="text" class="form-control form-control-solid" name="name_en" required placeholder="{{__('lang.name_en')}}" >
                        </div>
                        <div class="form-group">
                            <label>{{__('lang.mainCategory')}} </label>
                            @inject('mainCategory','App\Models\MainCategory')
                            <select name="main_category_id" class="form-control">
                                @foreach($mainCategory->all() as $b)
                                    <option value="{{$b->id}}">{{$b->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>{{__('lang.SubCategory')}} </label>
                            @inject('SubCategory','App\Models\SubCategory')
                            <select name="sub_category_id" class="form-control">
                                @foreach($SubCategory->all() as $b)
                                    <option value="{{$b->id}}">{{$b->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>{{__('lang.price')}} </label>
                            <input type="text" class="form-control form-control-solid" name="price" required placeholder="{{__('lang.price')}}" >
                        </div>
                        <div class="form-group">
                            <label>{{__('lang.delivery_time')}} </label>
                            <input type="text" class="form-control form-control-solid" name="delivery_time" required placeholder="{{__('lang.delivery_time')}}" >
                        </div>

                        <div class="form-group">
                            <label>{{__('lang.active')}} </label>
                            <select name="is_active" class="form-control">
                                <option value="1">active</option>
                                <option value="0">inActive</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>{{__('lang.description_ar')}} </label>
                            <textarea rows="5" class="form-control" name="description_ar"></textarea>
                        </div>

                        <div class="form-group">
                            <label>{{__('lang.description_en')}} </label>
                            <textarea rows="5" class="form-control" name="description_en"></textarea>
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
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label">@if(Request::segment(1) == 'ar')  الصور   @else  image @endif</label>
                            <div class="col-lg-12 col-xl-12">
                                <div class="card">
                                    <div class="card-block">
                                        <h4 class="card-title"></h4>
                                        <div class="controls">
                                            <input type="file" id="input-file-now" class="dropify"  name="images[]" multiple required data-validation-required-message="{{trans('word.This field is required')}}"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('lang.Close')}}</button>
                            <button type="submit" class="btn btn-primary">{{__('lang.save')}}</button>
                        </div>
                        <!--begin: Wizard Step 1-->
                        <!--end: Wizard Step 1-->
                        <!--begin: Wizard Step 2-->
                        <!--end: Wizard Step 2-->
                        <!--begin: Wizard Step 3-->
                        <!--end: Wizard Step 3-->
                        <!--begin: Wizard Actions-->
                        <!--end: Wizard Actions-->
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bs-edit-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content card card-outline-info">
                <div class="modal-header card-header">
                    <h3 class="modal-title" id="myLargeModalLabel">{{__('lang.Users_Edit')}}</h3>
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

    <!-- /.modal -->

@section('js')
    <script src="{{asset('dashboard/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/pages/crud/datatables/basic/basic.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/pages/crud/file-upload/image-input.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/pages/features/miscellaneous/sweetalert2.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/pages/features/miscellaneous/dropify.min.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/pages/crud/forms/widgets/select2.js')}}"></script>

    <script>
        //DataTable
    var table = $('#kt_tdata').DataTable({
 			dom: 'Bfrtip',
 			"ordering":false,
 			  buttons: [
         'copy', 'excel', 'print'
     ],
 			@if(session('lang') != 'en')

 					"language": {
 							"url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Arabic.json"
 					}
 			@endif
 	});

 		$( document ).ready(function() {

          $(".headerr").attr("style",'font-weight: bold!important;');

});

    </script>
    <!--begin::Page scripts(used by this page) -->

    <!--begin::Page scripts(used by this page) -->
    <script>
        $('#kt_tdata tbody').on( 'click', 'tr', function () {
            if (event.ctrlKey) {
                $(this).toggleClass('selected');
                @if(session('lang') == 'en')
                $('#delete').text('Delete '+ table.rows('.selected').data().length +' row');
                @else
                $('#delete').text('حذف '+ table.rows('.selected').data().length +' سجل');
                @endif
            }else{
                var isselected = false
                var numSelected= table.rows('.selected').data().length
                if($(this).hasClass('selected') && numSelected==1){
                    isselected = true
                }
                $('#myTable tbody tr').removeClass('selected');
                if(!isselected){
                    $(this).toggleClass('selected');
                }
                @if(session('lang') == 'en')
                $('#delete').text('Delete '+ table.rows('.selected').data().length +' row');
                @else
                $('#delete').text('حذف '+ table.rows('.selected').data().length +' سجل');
                @endif            }
        });

        $('#kt_select2_101').select2({
            placeholder: ""
        });
        $('#kt_select2_11').select2({
            placeholder: ""
        });
        //Delete Row
        $("body").on("click", "#delete", function () {
            var dataList=[];
            $("#kt_tdata .selected").each(function(index) {
                dataList.push($(this).find('td:first').text())
            })

            if(dataList.length >0){
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
                            url:'{{url("Delete_Products")}}',
                            type:"get",
                            data:{'id':dataList,_token: CSRF_TOKEN},
                            dataType:"JSON",
                            success: function (data) {
                                if(data.message == "Success")
                                {
                                    $("#kt_datatable .selected").hide();
                                    @if(session('lang') == 'ar')

                                    $('#delete').text('حذف 0 سجل');
                                    @else
                                    $('#delete').text('Delete 0 row');
                                    @endif
                                    Swal.fire("{{__('lang.Success')}}", "{{__('lang.Success_text')}}", "success");
                                    location.reload();
                                }else{
                                    Swal.fire("{{__('lang.Sorry')}}", "{{__('lang.Message_Fail_Delete')}}", "error");
                                }
                            },
                            fail: function(xhrerrorThrown){
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



        $(".edit-Advert").click(function(){
            var id=$(this).data('id')
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: "GET",
                url: "{{url('Edit_Products')}}",
                data: {"id":id},
                success: function (data) {
                    $(".bs-edit-modal-lg .modal-body").html(data)
                    $(".bs-edit-modal-lg").modal('show')
                    $(".bs-edit-modal-lg").on('hidden.bs.modal',function (e){
                        //   $('.bs-edit-modal-lg').empty();
                        $('.bs-edit-modal-lg').hide();
                    })
                }
            })
        })
        @if(Request::segment(1) == 'SupplierProduct' || Request::segment(1) == 'ProductsSearch')
        $(".switchery-demo").click(function(){
            var id=$(this).data('id')
            $.ajax({
                type: "get",
                url: "{{url('ChangeStatus')}}",
                data: {"id":id},
                success: function (data) {
                    console.log(data)
                    Swal.fire("@if(Request::segment(1) == 'ar' ) تم  @else Success @endif ", "@if(Request::segment(1) == 'ar' ) تم التعديل بنجاح   @else Successfully changed @endif", "success");

                }
            })
        })
        @elseif(Request::segment(1) == 'SupplierProducts' )
        $(".switchery-demo").click(function(){
            var id=$(this).data('id')
            var supplier = {{Request::segment(2)}}
            $.ajax({
                type: "get",
                url: "{{url('ChangeStatus2')}}",
                data: {"id":id ,'supplier':supplier},
                success: function (data) {
                    console.log(data)
                    Swal.fire("@if(Request::segment(1) == 'ar' ) تم  @else  @endif ", "{{__('lang.Success')}}", "success");

                }
            })
        })
        @endif
    </script>

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
                    title: "{{__('lang.Sorry')}}",
                    text: "{{__('lang.operation_failed')}}",
                    type:"error" ,
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
                    type:"error" ,
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
                    type:"error" ,
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
                    type:"error" ,
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
                    type:"error" ,
                    timer: 2000,
                    showConfirmButton: false
                });
            </script>
        @endif
    @endif

@endsection

@endsection

