<aside>
    <div class="navigation">
        <div class="w-100 h-100 d-flex flex-column">
            <!-- logo  -->
            <div class="dlogo d-flex align-items-center justify-content-center py-3">
                <a href="{{ route('admin.dashboard') }}"><img class="logo_img" src="{{ getSetting('admin-logo') != null ? url('storage/setting', getSetting('admin-logo')) : asset('images/logo.png') }}" alt="logo"></a>
                <span class="toggle-btn" onclick="toggleActive('#dmain','active');">
                    <i class="icon-menuhide text-darkblue"></i>
                </span>
            </div>
            <!-- menu  -->
            <div class="w-full list-style d-flex align-items-center justify-content-center margin-top" >
                <div class="aside-menu">
                    <div class="aside_list">
                        <ul class="main_menu menu_fix">
                            <li>
                                <a href="{{ route('admin.dashboard') }}" class="{{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}">
                                    <span class="menu-icon">
                                        <i class="fas fa-home"></i>
                                    </span>
                                    <span>Dashboard</span>
                                </a>
                            </li>
                            @can("user-list")
                                <li>
                                    <a href="{{ route('users.index') }}" class="{{ in_array(Route::currentRouteName() ,['users.index','users.edit','users.create','users.show']) ? 'active' : ''}}">
                                        <span class="menu-icon">
                                            <i class="fa-solid fa-users"></i>
                                        </span>
                                        <span>User</span>
                                    </a>
                                </li>
                            @endcan
                            @can("app-banner-list")
                            <li>
                                <a href="{{ route('app-banner.index') }}" class="{{ in_array(Route::currentRouteName() ,['app-banner.index','app-banner.edit','app-banner.create']) ? 'active' : ''}}">
                                    <span class="menu-icon">
                                        <i class="fa-solid fa-image"></i>
                                    </span>
                                    <span>App Banner</span>
                                </a>
                            </li>
                            @endcan
                            @can("banner-list")
                            <li>
                                <a href="{{ route('banner.index') }}" class="{{ in_array(Route::currentRouteName() ,['banner.index','banner.edit','banner.create']) ? 'active' : ''}}">
                                    <span class="menu-icon">
                                        <i class="fa-solid fa-images"></i>
                                    </span>
                                    <span>Banner</span>
                                </a>
                            </li>
                            @endcan
                            @can("cms-list")
                            <li>
                                <a href="{{ route('cms.index') }}" class="{{ in_array(Route::currentRouteName() ,['cms.index','cms.edit','cms.create']) ? 'active' : ''}}">
                                    <span class="menu-icon">
                                        <i class="fa-solid fa-info-circle"></i>
                                    </span>
                                    <span>CMS Management</span>
                                </a>
                            </li>
                            @endcan
                            @can("gallary-list")
                            <li>
                                <a href="{{ route('photos.index') }}" class="{{ in_array(Route::currentRouteName() ,['photos.index','photos.edit','photos.create']) ? 'active' : ''}}">
                                    <span class="menu-icon">
                                        <i class="fa-solid fa-camera-retro"></i>
                                    </span>
                                    <span>Gallery</span>
                                </a>
                            </li>
                            @endcan
                            @if (auth()->user()->can('category-list') ||auth()->user()->can('main-category-list') ||auth()->user()->can('subcategory-list'))
                            <li class="{{ in_array(Route::currentRouteName(), ['category.index', 'category.edit', 'category.create', 'main_category.index', 'main_category.edit', 'main_category.create', 'subcategory.index', 'subcategory.edit', 'subcategory.create','subcategory.show']) ? 'active' : '' }}">
                                <a href="#" class="drop-menu innerMenu {{  in_array(Route::currentRouteName(), ['category.index', 'category.edit', 'category.create', 'main_category.index', 'main_category.edit', 'main_category.create', 'subcategory.index', 'subcategory.edit', 'subcategory.create','subcategory.show']) ? 'active' : '' }}">
                                    <span class="menu-icon">
                                        <i class="fa-solid fa-list"></i>
                                    </span>
                                    <span class="title">Category</span>
                                </a>
                                    <ul class="sub-menu">
                                        @can("category-list")
                                        <li>
                                            <a href="{{ route('category.index') }}" class="{{ in_array(Route::currentRouteName() ,['category.index','category.edit','category.create']) ? 'active' : ''}}">
                                                <span class="menu-icon">
                                                    <i class="fa-solid fa-table-columns"></i>
                                                </span>
                                                <span>Super Category</span>
                                            </a>
                                        </li>
                                        @endcan
                                        @can("main-category-list")
                                        <li>
                                            <a href="{{ route('main_category.index') }}" class="{{ in_array(Route::currentRouteName() ,['main_category.index','main_category.edit','main_category.create']) ? 'active' : ''}}">
                                                <span class="menu-icon">
                                                    <i class="fa-solid fa-th-large"></i>
                                                </span>
                                                <span>Main Category</span>
                                            </a>
                                        </li>
                                        @endcan
                                        @can("subcategory-list")
                                        <li>
                                            <a href="{{ route('subcategory.index') }}" class="{{ in_array(Route::currentRouteName() ,['subcategory.index','subcategory.edit','subcategory.create','subcategory.show']) ? 'active' : ''}}">
                                                <span class="menu-icon">
                                                    <i class="fa-solid fa-th-list"></i>
                                                </span>
                                                <span>Sub Category</span>
                                            </a>
                                        </li>
                                        @endcan
                                    </ul>
                            </li>
                            @endif
                            {{-- @can("testimonial-list")
                            <li>
                                <a href="{{ route('testimonial.index') }}" class="{{ in_array(Route::currentRouteName() ,['testimonial.index','testimonial.edit','testimonial.create']) ? 'active' : ''}}">
                                    <span class="menu-icon">
                                        <i class="fa-solid fa-quote-left"></i>
                                    </span>
                                    <span>Testimonial</span>
                                </a>
                            </li>
                            @endcan --}}
                            @can("plans-list")
                                <li>
                                    <a href="{{ route('plans.index') }}" class="{{ in_array(Route::currentRouteName(),['plans.index','plans.create','plans.edit']) ? 'active' : '' }}">
                                        <span class="menu-icon">
                                            <i class="fa fa-money-check-alt"></i>
                                        </span>
                                        <span>Plans</span>
                                    </a>
                                </li>
                            @endcan
                            @can("support-list")
                                <li>
                                    <a href="{{ route('support.index') }}" class="{{ in_array(Route::currentRouteName(),['support.index','support.edit']) ? 'active' : '' }}">
                                        <span class="menu-icon">
                                             <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="#00000080" class="me-0"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>support</title> <rect width="24" height="24" fill="none"></rect> <path d="M12,2a8,8,0,0,0-8,8v1.9A2.92,2.92,0,0,0,3,14a2.88,2.88,0,0,0,1.94,2.61C6.24,19.72,8.85,22,12,22h3V20H12c-2.26,0-4.31-1.7-5.34-4.39l-.21-.55L5.86,15A1,1,0,0,1,5,14a1,1,0,0,1,.5-.86l.5-.29V11a1,1,0,0,1,1-1H17a1,1,0,0,1,1,1v5H13.91a1.5,1.5,0,1,0-1.52,2H20a2,2,0,0,0,2-2V14a2,2,0,0,0-2-2V10A8,8,0,0,0,12,2Z"></path> </g></svg>
                                        </span>
                                        <span>Support</span>
                                    </a>
                                </li>
                            @endcan
                            @can("contact-list")
                            <li>
                                <a href="{{ route('contact.index') }}" class="{{ in_array(Route::currentRouteName() ,['contact.index']) ? 'active' : ''}}">
                                    <span class="menu-icon">
                                        <i class="fa-solid fa-phone"></i>
                                    </span>
                                    <span>Contact Us</span>
                                </a>
                            </li>
                            @endcan
                            @can("email-signups-list")
                            <li>
                                <a href="{{ route('email-signups.index') }}" class="{{ in_array(Route::currentRouteName() ,['email-signups.index']) ? 'active' : ''}}">
                                    <span class="menu-icon">
                                        <i class="fa-solid fa-envelope"></i>
                                    </span>
                                    <span>Email Signups</span>
                                </a>
                            </li>
                            @endcan
                            @can("reviews-list")
                                <li>
                                    <a href="{{ route('reviews.index') }}" class="{{ in_array(Route::currentRouteName(),['reviews.index']) ? 'active' : '' }}">
                                        <span class="menu-icon">
                                            <i class="fa fa-star"></i>
                                        </span>
                                        <span>Reviews</span>
                                    </a>
                                </li>
                            @endcan
                            @can("setting-list")
                            <li>
                                <a href="{{ route('setting.index') }}" class="{{ in_array(Route::currentRouteName() ,['setting.index','setting.edit']) ? 'active' : ''}}">
                                    <span class="menu-icon">
                                        <i class="fa-solid fa-gear"></i>
                                    </span>
                                    <span>Setting</span>
                                </a>
                            </li>
                            @endcan
                            <li>
                                <a href="{{ route('logout') }}" class="{{ Route::currentRouteName() == "logout" ? 'active' : ''}}">
                                    <span class="menu-icon">
                                        <i class="fas fa-sign-out-alt"></i>
                                    </span>
                                    <span>Logout</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</aside>
