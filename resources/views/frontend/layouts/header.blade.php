<header class="mob-header-area">
    <div class="mob-header">
        <div class="container">
            <div class="row">
                <div class="col-md-2 d-flex align-items-center">
                    <a href="{{ route('front.home') }}" class="logo"><img src="{{ asset($brand_settings['logo']->key_value) }}"></a>
                </div>
                <button class="header-button"><i class="fas fa-bars"></i></button>
                <div class="col-md-8">
                    <div class="custom-collapse">
                        <ul>
                            <li> <a href="{{ route('front.home') }}" class="active">Home</a> </li>
                            <li><a href="{{ route('front.about.us') }}">About Us</a></li>
                            <li><a href="{{ route('front.logo.and.branding') }}">Logo & Branding</a> </li>
                            <!--  <li class="dropdown"><a href="#">Services <i class="fas fa-angle-down carret"></i></a>
                                <ul>
                                        <li><a href="#">Logo Services</a></li>
                                        <li><a href="#">Website Services</a></li>
                                        <li><a href="#">Video Animation</a></li>
                                </ul>
                            </li> -->
                            <li><a href="{{ route('front.website.design') }}">Website</a></li>
                            <li><a href="{{ route('front.pricing') }}">Pricing</a></li>
                            <li><a href="{{ route('front.portfolio') }}">Portfolio</a></li>
                            <li><a href="{{ route('front.contact.us') }}">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
                @if(!empty($brand_settings["company_number"]->key_value))
                    <div class="col-md-2 d-flex align-items-center">
                        <a href="tel:{{ $brand_settings['company_number']->key_value }}" class="phone-1"><i class="fas fa-phone phone"></i>{{ $brand_settings["company_number"]->key_value }}</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</header>

<header class="mob-menu">
    <div class="container">
        <div class="row">
            <div class="col-6">
                <a href="{{ route('front.home') }}" class="logo"><img src="{{ asset('frontend/assets/images/logo-2.png') }}" class="img-fluid"></a>
            </div>
            <div class="col-6 d-flex align-items-center justify-content-end">
                <button class="header-button"><i class="fa-solid fa-bars"></i></button>
            </div>
            <div class="col-12 d-flex justify-content-start">
                <div class="custom-collapse">
                    <ul>
                        <li> <a href="{{ route('front.home') }}">Home</a> </li>
                        <li><a href="{{ route('front.home') }}">Logo & Branding</a> </li>
                        <li><a href="{{ route('front.home') }}">About Us</a></li>
                        <!--  <li class="dropdown"><a href="#">Services <i class="fas fa-angle-down carret"></i></a>
                            <ul>
                                    <li><a href="#">Logo Services</a></li>
                                    <li><a href="#">Website Services</a></li>
                                    <li><a href="#">Video Animation</a></li>
                            </ul>
                    </li> -->
                        <li><a href="{{ route('front.home') }}">Website</a></li>
                        <li><a href="{{ route('front.home') }}">Portfolio</a></li>
                        <li><a href="{{ route('front.home') }}">Pricing</a></li>
                        @if(!empty($brand_settings["company_number"]->key_value))
                            <li><a href="tel:{{ $brand_settings['company_number']->key_value }}" class="phone-1"><i class="fas fa-phone phone"></i>{{ $brand_settings['company_number']->key_value }}</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
