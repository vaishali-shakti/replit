<!-- --------  header start ------ -->
<div class="wrapper">
    <header class="header_section">
        <div class="header nav-bar" id="header">
            <div class="container">
                <div class="row align-items-center justify-content-between">
                    <div class="col-6 col-lg-2 col-xl-auto">
                        <div class="header-logo">
                            <a href="{{ Route::currentRouteName() == 'home' ? '#' : route('home') }}">
                                <img src="{{ getSetting('logo') != null ? url('storage/setting', getSetting('logo')) : asset('assets/front/image/logo.png') }}" alt="" width="70">
                            </a>
                        </div>
                    </div>
                    <div class="col-3 col-lg-5 col-xl-6 d-none d-xl-block">
                        <div class="nav">
                            <nav>
                                <ul class="d-flex gap-3 gap-lg-3 gap-xl-1 justify-content-between nav-main">
                                    <li class="{{ Route::currentRouteName() == 'home' ? 'active' : '' }}">
                                        <a href="{{ route('home') }}" class="">Home</a>
                                    </li>
                                    <li class="{{ (Route::currentRouteName() == 'home' && request()->getRequestUri() == '/#about_sec') || (Route::currentRouteName() == 'about') ? 'active' : '' }}">
                                        <a href="{{ route('home') }}#about_sec" class="">About Us</a>
                                    </li>
                                    <li class="{{ (in_array(Route::currentRouteName(), ['category', 'main_categories', 'sub_categories']) ? 'active' : '') }}">
                                        <a href="javascript:void(0);" class="">Category <i class="fa-solid fa-chevron-down"></i></a>
                                        <ul class="sub-menu">
                                            @foreach (getCategories() as $category)
                                                    @php
                                                        $currentSlug = request()->segment(1); 
                                                        $currentSlug1 = request()->segment(2); 
                                                        $isActiveCategory = $currentSlug === $category->slug_name;
                                                    @endphp
                                                    <li class="{{ $isActiveCategory ? 'active' : '' }}">
                                                        <a href="{{ route('category', ['slug' => $category->slug_name]) }}" 
                                                        class="{{ $isActiveCategory ? 'active' : '' }} d-flex justify-content-between align-items-center">
                                                            {{ $category->name }}
                                                            @if (getMainCategories($category->id)->isNotEmpty())
                                                                <i class="fa-solid fa-chevron-down"></i>
                                                            @endif
                                                        </a>

                                                        @if (getMainCategories($category->id)->isNotEmpty())
                                                            <ul class="peta-menu">
                                                                @foreach (getMainCategories($category->id) as $main_category)
                                                                    @php
                                                                        // Check if the current main category is active
                                                                        $isActiveMainCategory = $currentSlug === $category->slug_name && $currentSlug1 === $main_category->slug_name;
                                                                    @endphp
                                                                    <li class="{{ $isActiveMainCategory ? 'active' : '' }}">
                                                                        <a href="{{ route('main_categories', ['slug' => $category->slug_name, 'slug1' => $main_category->slug_name]) }}" 
                                                                        class="{{ $isActiveMainCategory ? 'active' : '' }}">
                                                                            {{ $main_category->name }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    <li class="{{ Route::currentRouteName() == 'gallery' ? 'active' : '' }}"><a href="{{ route('gallery') }}" class="">Gallery</a></li>
                                    @if(!auth()->guard('auth')->check() || (auth()->guard('auth')->check() && global_plan_active() == false ))
                                    <li class="{{ (Route::currentRouteName() == 'home' && request()->getRequestUri() == '/#pricing_sec') ? 'active' : '' }}">
                                        <a href="{{ route('home') }}#pricing_sec">Pricing
                                        </a>
                                    </li>
                                    @endif
                                    <li class="{{ (Route::currentRouteName() == 'home' && request()->getRequestUri() == '/#contact_sec') ? 'active' : '' }}">
                                        <a href="{{ route('home') }}#contact_sec">Contact Us</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="col-4 col-lg-7 col-xl-5  d-none d-xl-block">
                        <div class="d-flex align-items-center gap-2 justify-content-end">
                            @if(session()->get('user_country') != "India")
                                <div class="currency_box">
                                    <select class="form-select cur_select" aria-label="Default select example">
                                        <option value="usd" {{ session()->get('user_currency') == 'usd' ? 'selected' : '' }}>USD</option>
                                        <option value="euro" {{ session()->get('user_currency') == 'euro' ? 'selected' : '' }}>EURO</option>
                                    </select>
                                </div>
                            @endif

                            <div class="d-flex position-relative search_box">
                                <select class="form-select category_select" aria-label="Default select example">
                                    <option value="" selected>All Category</option>
                                    @foreach (getCategories() as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }} </option>
                                    @endforeach
                                    {{-- <option value="1">Generic Complications </option>
                                    <option value="2">Critical/Chronic Complications</option>
                                    <option value="2">Auraguard User Customized users</option>
                                    <option value="3">True tone tuner users</option> --}}
                                </select>
                                <input type="text" class="form-control search_input" name="search" id="category_search" placeholder="Search">
                                <span><i class="fa-solid fa-magnifying-glass header_search"></i></span>
                            </div>
                            @if (auth()->guard('auth')->check() == false)
                                <div>
                                    <a href="{{ route('front_login') }}">
                                        <button type="button" class="btn_secondary sign_up_btn">SIGN UP</button>
                                    </a>
                                </div>
                            @else
                                <a href="{{ route('favourites') }}">
                                    <div class="position-relative">
                                        <button type="button" class="btn_secondary fav_btn">
                                            <i class="fa-solid fa-heart"></i>
                                        </button>
                                    </div>
                                </a>

                                <div class="position-relative">
                                        <button type="button" class="btn_secondary sign_up_btn account_btn">My Account
                                            <i class="fa-solid fa-chevron-down ms-2"></i>
                                        </button>

                                        <div class="user_menu">
                                            <ul>
                                                <li class="d-flex align-items-center justify-content-start gap-2 active">
                                                    <a href="{{ route('user_dashboard') }}" class="update_profile_menu">
                                                        <svg viewBox="0 0 32 32" style="fill: #777; color:#777;" height="25px" width="25px" xmlns="http://www.w3.org/2000/svg">
                                                            <defs></defs>
                                                            <title></title>
                                                            <g data-name="Layer 7" id="Layer_7">
                                                                <path class="" d="M19.75,15.67a6,6,0,1,0-7.51,0A11,11,0,0,0,5,26v1H27V26A11,11,0,0,0,19.75,15.67ZM12,11a4,4,0,1,1,4,4A4,4,0,0,1,12,11ZM7.06,25a9,9,0,0,1,17.89,0Z"></path>
                                                            </g>
                                                        </svg>
                                                        My Profile
                                                    </a>
                                                </li>
                                                <li class="d-flex align-items-center justify-content-start gap-2">
                                                    <a href="{{ route('front.logout') }}">
                                                        <svg version="1.1" height="18px" width="18px" style="fill: #777; color:#777; margin-right:14px;" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 113.525 122.879" enable-background="new 0 0 113.525 122.879" xml:space="preserve">
                                                            <g>
                                                                <path d="M78.098,13.509l0.033,0.013h0.008c2.908,1.182,5.699,2.603,8.34,4.226c2.621,1.612,5.121,3.455,7.467,5.491 c11.992,10.408,19.58,25.764,19.58,42.879v0.016h-0.006c-0.006,15.668-6.361,29.861-16.633,40.127 c-10.256,10.256-24.434,16.605-40.09,16.613v0.006h-0.033h-0.015v-0.006c-15.666-0.004-29.855-6.357-40.123-16.627l-0.005,0.004 C6.365,95.994,0.015,81.814,0.006,66.15H0v-0.033v-0.039h0.006c0.004-6.898,1.239-13.511,3.492-19.615 c0.916-2.486,2.009-4.897,3.255-7.21C13.144,27.38,23.649,18.04,36.356,13.142l2.634-1.017v2.817v18.875v1.089l-0.947,0.569 l-0.007,0.004l-0.008,0.005l-0.007,0.004c-1.438,0.881-2.809,1.865-4.101,2.925l0.004,0.004c-1.304,1.079-2.532,2.242-3.659,3.477 h-0.007c-5.831,6.375-9.393,14.881-9.393,24.22v0.016h-0.007c0.002,9.9,4.028,18.877,10.527,25.375l-0.004,0.004 c6.492,6.488,15.457,10.506,25.349,10.512v-0.006h0.033h0.015v0.006c9.907-0.002,18.883-4.025,25.374-10.518 S92.66,76.045,92.668,66.148H92.66v-0.033V66.09h0.008c-0.002-6.295-1.633-12.221-4.484-17.362 c-0.451-0.811-0.953-1.634-1.496-2.453c-2.719-4.085-6.252-7.591-10.359-10.266l-0.885-0.577v-1.042V15.303v-2.857L78.098,13.509 L78.098,13.509z M47.509,0h18.507h1.938v1.937v49.969v1.937h-1.938H47.509h-1.937v-1.937V1.937V0H47.509L47.509,0z"></path>
                                                            </g>
                                                        </svg>
                                                        Logout
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-3 d-block d-xl-none text-end">
                        <div class="" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                        <div class="toggle-btn">
                            <a href="javascript:void(0);">
                                <i class="fa-solid fa-bars"></i>
                            </a>
                        </div>
                        </div>
                    </div>
                    <!-- <div class="col-2">
                        <div class="nav_bar_box ms-auto" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                            <i class="fas fa-bars"></i>
                        </div>
                    </div> -->
                </div>
            </div>

        </div>

    </header>
</div>

<!-- --------- mobile menu --- -->
<div class="offcanvas offcanvas-end d-block d-xl-none" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <!-- <h3 class="category_title offcanvas_title">category</h3> -->
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="nav">
            <ul class="mobile-nav-main">
                {{-- <li><a href="{{ route('home') }}" class="">Home</a></li> --}}
                <li class="{{ Route::currentRouteName() == 'home' && Request::segment(1) ==  null ? 'active' : '' }}"><a href="{{ route('home') }}" class="">Home</a></li>
                <li class="{{ request()->is('home') && strpos(url()->current(), '#about_sec') !== false ? 'active' : '' }}"><a href="{{ Route::currentRouteName() == 'home' ? '#about_sec' : route('home','#about_sec') }}" class="">About Us</a></li>
                <li class="{{ in_array(Route::currentRouteName(), ['category', 'category.show', 'main_categories']) ? 'active' : '' }}">
                    <a href="javascript:void(0);" class="">Category <i class="fa-solid fa-chevron-down"></i></a>
                    <ul class="mobile-sub-menu">
                        @foreach (getCategories() as $category)
                                @php
                                    // Get the current URL segments
                                    $currentSlug = request()->segment(1); // First segment of the URL
                                    $currentSlug1 = request()->segment(2); // Second segment of the URL

                                    // Check if this category or its main categories are active
                                    $isActiveCategory = $currentSlug === $category->slug_name;
                                @endphp
                                <li class="{{ $isActiveCategory ? 'active' : '' }}">
                                    <!-- <a href="{{ route('category', ['slug' => $category->slug_name]) }}" 
                                    class="{{ $isActiveCategory ? 'active' : '' }} d-flex justify-content-between align-items-center"> -->
                                    <a href="{{ getMainCategories($category->id)->isNotEmpty() ? 'javascript:void(0);' : route('category', ['slug' => $category->slug_name]) }}" 
                                    class="{{ $isActiveCategory ? 'active' : '' }} d-flex justify-content-between align-items-center">
                                        {{ $category->name }}
                                        @if (getMainCategories($category->id)->isNotEmpty())
                                            <i class="fa-solid fa-chevron-down"></i>
                                        @endif
                                    </a>

                                    @if (getMainCategories($category->id)->isNotEmpty())
                                        <ul class="mobile-peta-menu">
                                            @foreach (getMainCategories($category->id) as $main_category)
                                                @php
                                                    // Check if the current main category is active
                                                    $isActiveMainCategory = $currentSlug === $category->slug_name && $currentSlug1 === $main_category->slug_name;
                                                @endphp
                                                <li class="{{ $isActiveMainCategory ? 'active' : '' }}">
                                                    <a href="{{ route('main_categories', ['slug' => $category->slug_name, 'slug1' => $main_category->slug_name]) }}" 
                                                    class="{{ $isActiveMainCategory ? 'active' : '' }}">
                                                        {{ $main_category->name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                        @endforeach
                    </ul>
                </li>
                @if (auth()->guard('auth')->check() != false)
                    <li class="{{ Route::currentRouteName() == 'favourites' ? 'active' : '' }}"><a href="{{ route('favourites') }}" class="">Favourites</a></li>
                @endif
                <li class="{{ Route::currentRouteName() == 'gallery' ? 'active' : '' }}"><a href="{{ route('gallery') }}" class="">Gallery</a></li>
                <li class="{{ (Route::currentRouteName() == 'home' && request()->getRequestUri() == '/#pricing_sec') ? 'active' : '' }}">
                        <a href="{{ route('home') }}#pricing_sec">Pricing </a> </li>
                <li  class="{{ Route::currentRouteName() == 'home' && request()->getRequestUri() == '/#contact_sec' ? 'active' : '' }}"><a href="{{ Route::currentRouteName() == 'home' ? '#contact_sec' : route('home','#contact_sec') }}">Contact us</a></li>
            </ul>
        </div>
        <div class="currency_box">
            @if(session()->get('user_country') != "India")
                <select class="form-select cur_select" aria-label="Default select example">
                    <option value="usd" {{ session()->get('user_currency') == 'usd' ? 'selected' : '' }}>USD</option>
                    <option value="euro" {{ session()->get('user_currency') == 'euro' ? 'selected' : '' }}>EURO</option>
                </select>
            @endif
        </div>
        <div class="d-flex align-items-center justify-content-start flex-column gap-2 px-0 my-3">
             <div class="d-flex position-relative search_box mb-3">
                
                    <select class="form-select category_select_mobile" aria-label="Default select example">
                        <option value="" selected> All Category</option>
                        @foreach (getCategories() as $category)
                            <option value="{{ $category->id }}">{{ $category->name }} </option>
                        @endforeach
                        {{-- <option value="1">Generic Complications </option>
                        <option value="2">Critical/Chronic Complications</option>
                        <option value="2">Auraguard User Customized users</option>
                        <option value="3">True tone tuner users</option> --}}
                    </select>
                    <input type="text" class="form-control search_input" name="search" id="category_search_mobile" placeholder="Search">
                    <span><i class="fa-solid fa-magnifying-glass header_search"></i></span>
                </div>
            @if (auth()->guard('auth')->check() == false)
                <div class="me-auto">
                    <a href="{{ route('front_login') }}">
                        <button type="button" class="btn_secondary sign_up_btn ms-0">SIGN UP</button>
                    </a>
                </div>
            @else
                <div class="me-auto position-relative">
                    <a href="#">
                        <button type="button" class="btn_secondary sign_up_btn mo_account_btn">My account
                             <i class="fa-solid fa-chevron-down ms-2"></i>
                        </button>
                    </a>

                    <div class="user_menu">
                        <ul>
                            <li class="d-flex align-items-center justify-content-start gap-2 active">
                                <a href="{{ route('user_dashboard') }}" class="update_profile_menu">
                                    <svg viewBox="0 0 32 32" style="fill: #777; color:#777;" height="25px" width="25px" xmlns="http://www.w3.org/2000/svg">
                                        <defs></defs>
                                        <title></title>
                                        <g data-name="Layer 7" id="Layer_7">
                                            <path class="" d="M19.75,15.67a6,6,0,1,0-7.51,0A11,11,0,0,0,5,26v1H27V26A11,11,0,0,0,19.75,15.67ZM12,11a4,4,0,1,1,4,4A4,4,0,0,1,12,11ZM7.06,25a9,9,0,0,1,17.89,0Z"></path>
                                        </g>
                                    </svg>
                                    My Profile
                                </a>
                            </li>
                            <li class="d-flex align-items-center justify-content-start gap-2">
                                <a href="{{ route('front.logout') }}">
                                    <svg version="1.1" height="18px" width="18px" style="fill: #777; color:#777; margin-right:14px;" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 113.525 122.879" enable-background="new 0 0 113.525 122.879" xml:space="preserve">
                                        <g>
                                            <path d="M78.098,13.509l0.033,0.013h0.008c2.908,1.182,5.699,2.603,8.34,4.226c2.621,1.612,5.121,3.455,7.467,5.491 c11.992,10.408,19.58,25.764,19.58,42.879v0.016h-0.006c-0.006,15.668-6.361,29.861-16.633,40.127 c-10.256,10.256-24.434,16.605-40.09,16.613v0.006h-0.033h-0.015v-0.006c-15.666-0.004-29.855-6.357-40.123-16.627l-0.005,0.004 C6.365,95.994,0.015,81.814,0.006,66.15H0v-0.033v-0.039h0.006c0.004-6.898,1.239-13.511,3.492-19.615 c0.916-2.486,2.009-4.897,3.255-7.21C13.144,27.38,23.649,18.04,36.356,13.142l2.634-1.017v2.817v18.875v1.089l-0.947,0.569 l-0.007,0.004l-0.008,0.005l-0.007,0.004c-1.438,0.881-2.809,1.865-4.101,2.925l0.004,0.004c-1.304,1.079-2.532,2.242-3.659,3.477 h-0.007c-5.831,6.375-9.393,14.881-9.393,24.22v0.016h-0.007c0.002,9.9,4.028,18.877,10.527,25.375l-0.004,0.004 c6.492,6.488,15.457,10.506,25.349,10.512v-0.006h0.033h0.015v0.006c9.907-0.002,18.883-4.025,25.374-10.518 S92.66,76.045,92.668,66.148H92.66v-0.033V66.09h0.008c-0.002-6.295-1.633-12.221-4.484-17.362 c-0.451-0.811-0.953-1.634-1.496-2.453c-2.719-4.085-6.252-7.591-10.359-10.266l-0.885-0.577v-1.042V15.303v-2.857L78.098,13.509 L78.098,13.509z M47.509,0h18.507h1.938v1.937v49.969v1.937h-1.938H47.509h-1.937v-1.937V1.937V0H47.509L47.509,0z"></path>
                                        </g>
                                    </svg>
                                    Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>

<!-- --------  header end ------ -->

<!-- -------------- header section end  -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const updateActiveState = () => {
            const currentUrl = window.location.href.split('#')[0]; // URL without the hash
            const currentHash = window.location.hash; // Hash part of the URL (e.g., #about_sec)

            const links = document.querySelectorAll('ul.nav-main li a,.mobile-nav-main li a');

            links.forEach(link => {
                const parentLi = link.closest('li');
                const linkUrl = link.href.split('#')[0]; // URL of the link without the hash
                const linkHash = link.hash; // Hash part of the link

                // Check if the base URL matches and the hash matches (or is empty for no-hash links)
                if (currentUrl === linkUrl && (currentHash === linkHash || (!currentHash && !linkHash))) {
                    parentLi.classList.add('active');
                    // Activate parent menus for sub-menu items
                    let ancestor = parentLi.closest('ul')?.closest('li');
                    while (ancestor) {
                        ancestor.classList.add('active');
                        ancestor = ancestor.closest('ul')?.closest('li');
                    }
                } else {
                    parentLi.classList.remove('active');
                }
            });
        };

        updateActiveState();

        // Update on hash changes or browser navigation
        window.addEventListener('hashchange', updateActiveState);
        window.addEventListener('popstate', updateActiveState);
    });
</script>
