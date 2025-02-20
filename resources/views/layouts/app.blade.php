@inject('CommonClass', 'App\CommonClass')
@php
$website_data_value = $CommonClass->getWebsiteData();
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>E-Cart App</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="{{ asset('assets/img/new-design.png') }}" rel="icon">
    <link rel="bookmark" href="{{ asset('assets/img/logo.png') }}" />
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('assets/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <style>
        .pageLoader {
            background: url("{{ asset('assets/img/load-33_256.gif') }}") no-repeat center center;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            z-index: 9999999;
            background-color: rgba(195, 101, 101, 0.55);

        }

        .dropdown-item {
            padding: 0.5rem 0.5rem !important;
        }

        .dropdown-menu {
            min-width: 15rem !important;
        }

        .text-black {
            color: black !important;
        }

        .toast-custom-box {
            position: absolute;
            top: 5%;
            right: 5%;
            min-width: 20rem;
        }

        @media (max-width:480px) {
            .toast-custom-box {
                position: absolute;
                top: 10%;
            }
        }

        .carousel {
            display: flex;
            overflow: hidden;
            /* Hide overflow for a clean carousel look */
        }

        .carousel-item {
            flex: 0 0 100%;
            /* Ensure each item takes full width of the carousel */
            position: relative;
        }

        .carousel-item img {
            width: 100%;
            /* Ensure image takes up full width of the carousel item */
            height: 30rem;
            /* Ensure image takes full height of the carousel item */
            object-fit: fill;
            /* Maintain the aspect ratio and cover the entire area */
            object-position: center;
            /* Keeps the image centered */
            transition: all 0.3s ease;
            /* Optional: Add smooth transition effect */
        }

        .product-card-img {
            height: 20rem;
        }
    </style>
</head>

<body>
    <div class="pageLoader" id="pageLoader"></div>
    @include('include.topbar')

    @include('include.navbar')

    <main>
        @include('include.alertbox')

        {{ $slot }}
    </main>

    @include('include.footer')

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('assets/lib/owlcarousel/owl.carousel.min.js') }}"></script>

    <!-- Contact Javascript File -->
    <script src="{{ asset('assets/mail/jqBootstrapValidation.min.js') }}"></script>
    <script src="{{ asset('assets/mail/contact.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script>
        $(window).on('beforeunload', function() {
            $('#pageLoader').show();
        });
        $(window).on('unload', function() {
            $('#pageLoader').hide(); // Ensure the loader is hidden when the page unloads
        });
        $(function() {
            $('#pageLoader').hide();

            $(".toast").fadeTo(2000, 500).slideUp(500, function() {
                $(".toast").slideUp(500);
            });
        })
    </script>
    @stack('scripts')
</body>

</html>