<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <!-- <link rel="stylesheet" href="OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css">
        <link rel="stylesheet" href="fancy-box/jquery.fancybox.min.css"> -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.css" integrity="sha512-nNlU0WK2QfKsuEmdcTwkeh+lhGs6uyOxuUs+n+0oXSYDok5qy0EI0lt01ZynHq6+p/tbgpZ7P+yUb+r71wqdXg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}">

        <title>@if(!empty($page->title)) {!! $page->title !!} @else Home @endif</title>

        @if(!empty($page->meta_title))
            <meta name="title" content="{{$page->meta_title}}">
        @endif

        @if(!empty($page->meta_keyword))
            <meta name="keywords" content="{{$page->meta_keyword}}">
        @endif

        @if(!empty($page->meta_description))
            <meta name="description" content="{{$page->meta_description}}">
        @endif

        @stack('customStyles')
        @routes                    
    </head>
<body>
    @include('frontend.layouts.header')

    @yield('container')

    @include('frontend.layouts.footer')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js " integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin=" anonymous "></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js " integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM " crossorigin="anonymous "></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js" integrity="sha512-uURl+ZXMBrF4AwGaWmEetzrd+J5/8NRkWAvJx5sbPSSuOb0bZLqf+tOzniObO00BjHa/dD7gub9oCGMLPQHtQA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- <script src="OwlCarousel2-2.3.4/dist/owl.carousel.min.js "></script>
    <script src="fancy-box/jquery.fancybox.min.js"></script> -->
    <!-- <script>
        $(document).ready(function() {
            $('.services-select').on('change', function(e) {
                $('.services-tabs  .services-pricing-tabs .nav-link').eq($(this).val()).tab('show');
            });
        });
    </script> -->

    <script type="text/javascript">
        $('.header-button').on('click', function() {

            $('.custom-collapse').fadeToggle();

        });
    </script>
    <!-- <script>
        $(".custom-collapse a").on("click", function() {
            $("a").removeClass("active");
            $(this).addClass("active");
        });
    </script> -->
    <script>
        $(window).scroll(function() {
            var sticky = $('.mob-header'),
                scroll = $(window).scrollTop(),
                stickyHeight = sticky.innerHeight();

            $('.mob-header-area').css('height', stickyHeight);

            if (scroll >= 100) sticky.addClass('fixed animated slideInDown');
            else sticky.removeClass('fixed animated slideInDown');
        });
    </script>
    <script>
        $('.footer-arrow').on("click", function() {
            $(window).scrollTop(0);
        });

        $('[data-fancybox="gallery"]').fancybox({
            buttons: [
                'slideShow', 'share', 'zoom', 'fullScreen', 'thumbs', 'close'
            ]
        });
    </script>
    <script>
        $('.banner-carousel').owlCarousel({
            loop: true,
            margin: 10,
            navigation: false,
            dots: false,
            autoplay: true,
            responsive: {
                0: { items: 2 },
                600: { items: 3 },
                900: { items: 6 }
            }
        })

        $('.portfolio-carousel-lower').owlCarousel({
            loop: true,
            rtl: true,
            margin: 0,
            nav: false,
            dots: false,
            autoplay: true,
            autoplayTimeout: 3000,
            autoplayHoverPause: true,
            responsive: {
                0: { items: 2 },
                576: { items: 2 },
                768: { items: 3 },
                992: { items: 5 }
            }
        })
        $('.portfolio-carousel-upper').owlCarousel({
            loop: true,
            margin: 0,
            nav: false,
            dots: false,
            autoplay: true,
            autoplayTimeout: 3000,
            autoplayHoverPause: true,
            responsive: {
                0: { items: 2 },
                576: { items: 2 },
                768: { items: 3 },
                992: { items: 5 }
            }
        })
        $('.testimonial-carousel').owlCarousel({
            loop: true,
            items: 1,
            margin: 10,
            nav: true,
            autoplay: true,
            autoplayTimeout: 3000,
            autoplayHoverPause: true
        })
    </script>
    @stack('customScripts')
</body>

</html>
