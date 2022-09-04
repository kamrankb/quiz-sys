<section class="footer">
    <img src="{{ asset('frontend/assets/images/footer-arrow.svg') }}" class="footer-arrow">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-2 col-12 d-flex justify-content-center">
                <img src="{{ asset($brand_settings['logo_white']->key_value) }}" class="img-fluid">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center mt-4">
                <div class="footer-icon">

                    <a href="#"><i class="fa-brands fa-facebook-f fb"></i></a>
                    <a href="#"><i class="fa-brands fa-twitter fb"></i></a>
                    <a href="#"><i class="fa-brands fa-google-plus-g fb"></i></a>
                    <a href="#"><i class="fa-brands fa-linkedin-in fb"></i></a>
                    <a href="#"><i class="fa-brands fa-youtube fb"></i></a>
                    <a href="#"><i class="fa-brands fa-instagram-square fb"></i></a>
                    <a href="#"><i class="fa-brands fa-behance fb"></i></a>
                    <a href="#"><i class="fa-brands fa-dribbble fb"></i></a>
                </div>
                <div class="footer-links">
                    <p>Copyright &copy; 2022 {{ $brand_settings['company_name']->key_value }}. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </div>
</section>