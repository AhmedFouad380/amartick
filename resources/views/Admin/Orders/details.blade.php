
        <div class="container">
            <div class="card card-custom gutter-b">

                <div class="card-body">

                    <!--begin: Datatable-->
                    <table class="table table-bordered table-hover table-checkable mt-10" id="kt_tdata2">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{__('lang.Product')}} </th>
                            <th>{{__('lang.ProductCount')}} </th>
                            <th>{{__('lang.price')}} </th>



                        </tr>
                        </thead>
                        <tbody>
                        @foreach($Users->OrderDetails as $Key => $User)
                            <tr>
                                <td>
                                    {{$Key + 1}}
                                </td>
                                <td>{{$User->name}}</td>
                                <td>{{$User->count}}</td>
                                <td>{{$User->price}}</td>


                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <!--end: Datatable-->
                </div>

            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->


    <script src="{{asset('dashboard/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/pages/crud/datatables/basic/basic.js')}}"></script>
    <script>
        //DataTable
        var table = $('#kt_tdata2').DataTable({
            dom: 'Bfrtip',
            "ordering": false,
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
    <!--begin::Page scripts(used by this page) -->



