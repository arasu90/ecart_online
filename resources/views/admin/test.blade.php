<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Kaiadmin - Bootstrap 5 Admin Dashboard</title>
  <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
  <link rel="icon" href="{{ asset('admin/assets/img/kaiadmin/favicon.ico')}}" type="image/x-icon" />

  <!-- Fonts and icons -->
  <script src="{{ asset('admin/assets/js/plugin/webfont/webfont.min.js')}}"></script>
  <script>
    WebFont.load({
      google: { families: ["Public Sans:300,400,500,600,700"] },
      custom: {
        families: [
          "Font Awesome 5 Solid",
          "Font Awesome 5 Regular",
          "Font Awesome 5 Brands",
          "simple-line-icons",
        ],
        urls: ["{{ asset('admin/assets/css/fonts.min.css') }}"],
      },
      active: function () {
        sessionStorage.fonts = true;
      },
    });
    </script>

<!-- CSS Files -->
<link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.min.css')}}" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
  <link rel="stylesheet" href="{{ asset('admin/assets/css/plugins.min.css')}}" />
  <link rel="stylesheet" href="{{ asset('admin/assets/css/kaiadmin.min.css')}}" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />


  <!-- CSS Just for demo purpose, don't include it in your project -->
  <!-- <link rel="stylesheet" href="{{ asset('admin/assets/css/demo.css')}}" /> -->
</head>

<body>
  <div class="wrapper">
    
<!-- Sidebar -->
@include('admin.include.sidebar')
    <div class="main-panel">
      <!-- header -->
      @include('admin.include.header')
      <div class="container">
        <div class="page-inner">
            @isset($header)
            <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset
            <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span class="card-title">Products</span>
                    <span> @if(Session::has('error'))
                        <span class="text-danger" role="alert">
                            <strong>{{ Session::get('error') }} </strong>
                        </span>
                        @endif
                        @if(Session::has('success'))
                        <span class="text-success" role="alert">
                            <strong>{{ Session::get('success') }}</strong>
                        </span>
                        @endif</span>
                    <a href="{{route('newproduct')}}" class="btn btn-warning btn-sm pull-right">Add New</a>
                </div>
                <div class="card-body">
                <div class="col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="product_title">Product Data Title<span class="text-danger" style="font-size: x-large;">*</span></label>
                                    <select class="form-control select2">
        <option>Select</option>
        <option>Car</option>
        <option>Bike</option>
        <option>Scooter</option>
        <option>Cycle</option>
        <option>Horse</option>
      </select>

                                </div>
                            </div>
                </div>
            </div>
        </div>
    </div>
        </div>
      </div>

      <!-- footer -->
       @include('admin.include.footer')

      </div>
      
      <!--   Core JS Files   -->
      <script src="{{ asset('admin/assets/js/core/jquery-3.7.1.min.js')}}"></script>
      <script src="{{ asset('admin/assets/js/core/popper.min.js')}}"></script>
      <script src="{{ asset('admin/assets/js/core/bootstrap.min.js')}}"></script>
      
      <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>


      <!-- jQuery Scrollbar -->
      <script src="{{ asset('admin/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>
      
      <!-- Chart JS -->
      <script src="{{ asset('admin/assets/js/plugin/chart.js/chart.min.js')}}"></script>
      
      <!-- jQuery Sparkline -->
      <script src="{{ asset('admin/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js')}}"></script>

  <!-- Chart Circle -->
  <script src="{{ asset('admin/assets/js/plugin/chart-circle/circles.min.js')}}"></script>
  
  <!-- Datatables -->
  <script src="{{ asset('admin/assets/js/plugin/datatables/datatables.min.js')}}"></script>
  
  <!-- Bootstrap Notify -->
  <script src="{{ asset('admin/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js')}}"></script>
  
  <!-- jQuery Vector Maps -->
  <script src="{{ asset('admin/assets/js/plugin/jsvectormap/jsvectormap.min.js')}}"></script>
  <script src="{{ asset('admin/assets/js/plugin/jsvectormap/world.js')}}"></script>
  
  <!-- Sweet Alert -->
  <script src="{{ asset('admin/assets/js/plugin/sweetalert/sweetalert.min.js')}}"></script>
  
  <!-- Kaiadmin JS -->
  <script src="{{ asset('admin/assets/js/kaiadmin.min.js')}}"></script>
  

  <!-- Kaiadmin DEMO methods, don't include it in your project! -->
  <!-- <script src="{{ asset('admin/assets/js/setting-demo.js')}}"></script> -->
  <!-- <script src="{{ asset('admin/assets/js/demo.js')}}"></script> -->
  @stack('scripts')
  <script>
    $("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
      type: "line",
      height: "70",
      width: "100%",
      lineWidth: "2",
      lineColor: "#177dff",
      fillColor: "rgba(23, 125, 255, 0.14)",
    });

    $("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
      type: "line",
      height: "70",
      width: "100%",
      lineWidth: "2",
      lineColor: "#f3545d",
      fillColor: "rgba(243, 84, 93, .14)",
    });

    $("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
      type: "line",
      height: "70",
      width: "100%",
      lineWidth: "2",
      lineColor: "#ffa534",
      fillColor: "rgba(255, 165, 52, .14)",
    });

    $(function() {
      $('.select2').select2();
            });
  </script>
</body>

</html>