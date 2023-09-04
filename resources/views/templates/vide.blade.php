<!doctype html>
<html lang="ar" dir="rtl" >

<head>
  <meta charset="utf-8" >
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>  - التدبير اليومي - للحراسة العامة</title>
  <link rel="shortcut icon" type="image/png" href="{{asset('assets/images/logos/favicon.png')}}" />
  <link rel="stylesheet" href="{{asset('assets/css/styles.min.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/css/styles.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/libs/apexcharts/dist/apexcharts.css')}}" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@500&display=swap" rel="stylesheet">


</head>

<body>



 <!--  Header End -->
    <div class=" col-10 mx-auto bg-white card py-2" style="padding-left: 2%">

        @yield('content')

    </div>
<!-- footer -->
@include('includes.footer')

  <script src="{{asset('assets/libs/jquery/dist/jquery.min.js')}}"></script>
  <script src="{{asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('assets/js/sidebarmenu.js')}}"></script>
  <script src="{{asset('assets/js/app.min.js')}}"></script>*
  <script src="{{asset('assets/libs/simplebar/dist/simplebar.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
  <script src="{{asset('assets/js/ajax.js')}}"></script>
  <script src="{{asset('assets/js/script.js')}}"></script>


<script>
    $(document).ready(function() {
   @yield('script')
});

</script>

</body>

</html>
