<!DOCTYPE html>
<html lang="en">
<head>

    {{--    <meta charset="utf-8">--}}
    {{--    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>--}}

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>المشروع: {{$project->name}}</title>

    <link rel="shortcut icon" type="image/png" href="{{url('public/app-assets/images/ico/ico.jpg')}}">
    {{--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"--}}
    {{--          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">--}}
    <link rel="stylesheet" href="{{url('public/app-assets/css/bootstrap.css')}}"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="{{url('public/app-assets/css/bootstrap.css')}}">
    <!-- font icons-->
    <link rel="stylesheet" type="text/css">
    <!-- END VENDOR CSS-->
    <!-- BEGIN ROBUST CSS-->
    <link rel="stylesheet" type="text/css" href="{{url('public/app-assets/css/bootstrap-extended.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('public/app-assets/css/app.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('public/app-assets/css/colors.css')}}">
    <!-- END ROBUST CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css"
          href="{{url('public/app-assets/css/core/menu/menu-types/vertical-menu.css')}}">
    <link rel="stylesheet" type="text/css"
          href="{{url('public/app-assets/css/core/menu/menu-types/vertical-overlay-menu.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('public/app-assets/css/core/colors/palette-gradient.css')}}">
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{url('public/assets/css/style.css')}}">

    <style>
        table, th, td {
            border: 1px solid black;
        }

    </style>
</head>

<body>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div>
                <h5 style="font-family: DejaVu Sans, sans-serif ;font-size: 20px;text-align: center;">
                    المشروع: {{$project->name}}</h5>

            </div>
        </div>
    </div>

    @foreach($categoryItem as $item)
        <br>
        <br>
        <br>
        <div style="font-family: DejaVu Sans, sans-serif ;font-size: 18px;text-align: center;" class="card-header">اسم
            الفئة: {{$item->name}}</div>
        <div style="font-family: DejaVu Sans, sans-serif ;font-size: 18px;text-align: center;" class="card-header">
            اجمالى الفئة: @if($item->orders_delivered_sum_total_price == null)
                0 @else {{$item->orders_delivered_sum_total_price}}  @endif</div>
        <div class="card-body">
            <div>
                <table
                    style="font-family: DejaVu Sans, sans-serif ;font-size: 13px;width:100%">
                    <thead>
                    <tr>
                        <th>{{__('lang.price')}} </th>
                        <th>{{__('lang.ProductCount')}} </th>
                        <th>{{__('lang.Product')}} </th>
                        <th>#</th>

                    </tr>
                    </thead>
                    <tbody>

                    @foreach($item->OrdersDetails as $key =>$User)
                        <tr style="font-family: DejaVu Sans, sans-serif ;font-size: 13px;text-align: center;">
                            <td>{{$User->price}}</td>
                            <td>{{$User->count}}</td>
                            <td>{{$User->name}}</td>
                            <td>
                                {{$key + 1}}
                            </td>

                        </tr>


                    @endforeach

                    </tbody>

                </table>

            </div>

        </div>
    @endforeach

    <div style="padding-top: 25px">
        <div class="card-body">
            <div class="row">
                <div>

                    <h5 style="font-family: DejaVu Sans, sans-serif ;font-size: 20px;text-align: center;">
                        اجمالى المشروع: {{$total_price}}</h5>

                </div>
            </div>
        </div>
    </div>


</div>


<style>
    #footer {
        position: absolute;
        bottom: 0;
        height: 2.5rem; /* Footer height */
    }
</style>

<footer id="footer" class=" "
        style="font-family:DejaVu Sans, sans-serif ;font-size: 13px;text-align: center;padding-left: 175px">
    <br>
    <p class="clearfix text-muted text-sm-center mb-0 px-2"><span class="float-md-left d-xs-block d-md-inline-block">Copyright   2021 <a
                href="#" target="_blank"
                class="text-bold-800 grey darken-2">Uram IT </a>, All rights reserved. </span><span
            class="float-md-right d-xs-block d-md-inline-block"> </span></p>
</footer>
</body>
</html>

