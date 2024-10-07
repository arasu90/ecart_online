<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="{{ asset('img/favicon.ico') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <!-- <link href="{{ asset('css/custom.css') }}" rel="stylesheet"> -->
     <style>
        .logo {
    width: 150px; /* Adjust as needed */
    height: auto; /* Maintain aspect ratio */
}

        .product-img{
            width : 100% !important;
            height: 250px !important;
        }

        .product-img-286{
            width : 286px !important;
            height: 286px !important;
        }

        .product_details{
            width : 675px !important;
            height: 675px !important;
        }
     </style>
</head>

<body>
    @include('layouts.topbar')
    @include('layouts.navbar')
    <main>
        {{ $slot }}
    </main>
    
    @include('layouts.footer')
   

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>

    <!-- Contact Javascript File -->
    <script src="{{ asset('mail/jqBootstrapValidation.min.js') }}"></script>
    <script src="{{ asset('mail/contact.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('js/main.js') }}"></script>
    @stack('scripts')
    <script type="text/javascript">

        $(".shoppingcart").on('click', function(e){
            var prod_id = $(this).data('prod_id');
            var cart_type = $(this).data('cart_type');
            if(cart_type == 'add'){
                addtocart(prod_id);
                // $(this).html('<i class="fas fa-shopping-cart text-primary mr-1"></i><span class="text-primary">Remove to Cart</span>');
                $(this).data('cart_type','remove');
                var text_color = 'text-primary';
                if($(this).hasClass('btn-primary')){
                    console.log('product page');
                    text_color = 'text-white';
                }
                $('.shoppingcartbtn_'+prod_id).html('<i class="fas fa-shopping-cart '+text_color+' mr-1"></i><span class="'+text_color+'">Remove Cart</span>');
            }else if(cart_type == 'remove'){
                removetocart(prod_id);
                // $(this).html('<i class="fas fa-shopping-cart text-primary mr-1"></i><span class="">Add to Cart</span>');
                $(this).data('cart_type','add');
                var text_color = 'text-primary';
                if($(this).hasClass('btn-primary')){
                    console.log('product page');
                    text_color = '';
                }
                $('.shoppingcartbtn_'+prod_id).html('<i class="fas fa-shopping-cart '+text_color+'  mr-1"></i><span class="">Add to Cart</span>');
            }else{
                console.log('error on cart add product');
            }
        });
        function removetocart(product_id){
            $.ajax({
                    url: '{{route("removetocart")}}',
                    method: 'POST',
                    data: {
                        'product_id': product_id,
                    },
                    dataType: 'JSON',
                    "headers": {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        var cart_count = response.cartcount;
                        $('#shoppingcart_count').text(cart_count);
                    },
                    error: function(response) {
                        console.log(response);
                    }
                });
        }
        function addtocart(product_id){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            
            $.ajax({
                url: '{{route("addtocart")}}',
                method: "POST",
                data: {
                    'product_id': product_id,
                },
                success: function (response) {
                    var cart_count = response.cartcount;
                    $('#shoppingcart_count').text(cart_count);
                },
            });
        }

       // script.js
document.addEventListener('DOMContentLoaded', () => {
    const stars = document.querySelectorAll('.star');
    let selectedRating = 0;

    stars.forEach(star => {
        star.addEventListener('mouseover', () => {
            const value = star.getAttribute('data-value');
            // console.log(value);
            updateStars(value);
        });

        star.addEventListener('mouseout', () => {
            updateStars(selectedRating);
        });

        star.addEventListener('click', () => {
            selectedRating = star.getAttribute('data-value');
            $("#rating_val").val(selectedRating);
            updateStars(selectedRating);
        });
    });

    function updateStars(rating) {
        // console.log('rating var '+rating);
        stars.forEach(star => {
            var value = star.getAttribute('data-value');
            // console.log('rating var '+rating +' valeu '+value);
            if (value <= rating) {
                // console.log('class added');
                // $(star).addClass('far fa-star');
                // $(star).removeClass('fas fa-star');
                star.classList.add('fas');
                star.classList.remove('far');
            } else {
                // console.log('class removed');
                // $(star).classList('fas fa-star');
                // $(star).removeClass('far fa-star');
                star.classList.remove('fas');
                star.classList.add('far');
            }
        });
    }
});


    </script>

</body>

</html>