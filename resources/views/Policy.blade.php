<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!--favicon icon-->
    <link rel="icon" href="{{asset('assets/img/favicon.png')}}" type="image/png" sizes="16x16">

    <!--title-->
    <title> Amar-tech</title>

    <!--build:css-->
    <link rel="stylesheet" href="{{asset('assets/css/main-rtl.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/animate.min.css')}}">
    <!-- endbuild -->
</head>

<body>

<!--preloader start-->
<div id="preloader">
    <div class="preloader-wrap">
        <img src="{{asset('assets/img/logo-color.png')}}" alt="logo" class="img-fluid" />
        <div class="thecube">
            <div class="cube c1"></div>
            <div class="cube c2"></div>
            <div class="cube c4"></div>
            <div class="cube c3"></div>
        </div>
    </div>
</div>
<!--preloader end-->
<!--header section start-->
<header class="header">
    <!--start navbar-->
    <nav class="navbar navbar-expand-lg fixed-top bg-transparent">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{asset('assets/img/logo-white.png')}}" alt="logo" class="img-fluid " />
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="ti-menu"></span>
            </button>

            <div class="collapse navbar-collapse h-auto" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto menu">
                    <li><a href="#"> الرئيسية</a>

                    </li>
                    <li><a href="#about" class="page-scroll">عن التطبيق</a></li>
                    <li><a href="#screenshots" class="page-scroll">صور التطبيق</a></li>
                    <li><a href="#process" class="page-scroll">خطوات التطبيق</a></li>
                    <li><a href="#contact" class="page-scroll">اتصل بنا</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<!--header section end-->

<div class="main">

  x
    <!--screenshots section end-->

    <!--work process start-->
    <section id="process" class="work-process-section position-relative  ptb-100 gray-light-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-9 col-lg-8">
                    <div class="section-heading text-center mb-5">
                        <h2>سياسة الخصوصية </h2>

                    </div>
                    <p>
                        @inject('Setting','App\Models\Setting')
                        {{$Setting->find(1)->terms_policy}}
                    </p>
                </div>
            </div>
        </div>
    </section>


    <!--work process end-->


</div>

<!--footer section start-->
<!--when you want to remove subscribe newsletter container then you should remove .footer-with-newsletter class-->
<footer class="footer-1 gradient-bg ptb-60 footer-with-newsletter">


    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-12 ">
                <a href="#" class="navbar-brand mb-2 center">
                    <img src="{{asset('assets/img/logo-white.png')}}" alt="logo" class="img-fluid wow shake">
                </a>
                <br>

                <div class="list-inline social-list-default background-color social-hover-2  center">
                    <li class="list-inline-item"><a class="twitter" href="#"><i class="fab fa-twitter"></i></a></li>
                    <li class="list-inline-item"><a class="youtube" href="#"><i class="fab fa-youtube"></i></a></li>
                    <li class="list-inline-item"><a class="linkedin" href="#"><i class="fab fa-linkedin-in"></i></a></li>
                    <li class="list-inline-item"><a class="dribbble" href="#"><i class="fab fa-dribbble"></i></a></li>
                </div>
            </div>
            <p class="center m-t-10">

                Designed and developed by <a class="grand" href="#">Uram-IT</a>


            </p>
        </div>
    </div>
    <!--end of container-->
</footer>
<!--footer bottom copyright start-->

<!--footer bottom copyright end-->
<!--footer section end-->
<!--scroll bottom to top button start-->
<div class="scroll-top scroll-to-target primary-bg text-white" data-target="html">
    <span class="fas fa-hand-point-up"></span>
</div>
<!--scroll bottom to top button end-->
<!--build:js-->
<script src="{{asset('assets/js/vendors/jquery-3.5.1.min.js')}}"></script>
<script src="{{asset('assets/js/vendors/popper.min.js')}}"></script>
<script src="{{asset('assets/js/vendors/bootstrap.min-rtl.js')}}"></script>
<script src="{{asset('assets/js/vendors/jquery.easing.min.js')}}"></script>
<script src="{{asset('assets/js/vendors/owl.carousel.min.js')}}"></script>
<script src="{{asset('assets/js/vendors/countdown.min.js')}}"></script>
<script src="{{asset('assets/js/vendors/jquery.waypoints.min.js')}}"></script>
<script src="{{asset('assets/js/vendors/jquery.rcounterup.js')}}"></script>
<script src="{{asset('assets/js/vendors/magnific-popup.min.js')}}"></script>
<script src="{{asset('assets/js/vendors/validator.min.js')}}"></script>
<script src="{{asset('assets/js/app.js')}}"></script>
<script src="{{asset('assets/js/wow.min.js')}}"></script>

<!-- inject js end -->
<script>
    $(".clickable").on('click', function(){
        $(".clickable").removeClass('current');
        $(this).addClass('current');
    });


    new WOW().init();

</script>
<!--endbuild-->
</body>

</html>
