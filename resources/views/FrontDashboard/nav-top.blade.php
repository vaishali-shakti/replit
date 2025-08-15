<header class="d-flex align-items-center position-relative nav-header">
    <span class="toggle-btn" onclick="toggleActive('#dmain','active');">
        <i class="icon-menuopen text-darkblue"></i>
    </span>
    <div class="w-full list-style d-flex align-items-center dhedaer-menu ms-auto h-100">
        <div class="position-relative order-4 order-md-3">
           <div class="d-flex gap-2">
                <a id="drop-profile" class="drop-profile d-flex align-items-center login_dropdown_css">
                    <div class="profile_img rounded-circle overflow-hidden">
                        <img src="{{asset('images/avatar.webp')}}" class="w-100 h-100 object-fit"  alt="profile_pic" />
                    </div>
                    <div class="profiletitel d-flex align-items-center ps-1 ps-md-2">
                        <span class="d-flex align-items-center text-18 fw-bold pe-2">
                            <span class="d-md-inline-block d-none text-capitalize">{{auth()->user()->name}}</span>
                            <i class="icon-down_arrow ms-md-2 text-darkblue anim"></i>
                        </span>
                    </div>
                </a>
           </div>
            <div class="profile_menu" id="profile_menu">
                <a href="{{ route('edit-profile') }}"
                    class="{{ in_array(Route::currentRouteName(), ['edit-profile']) ? 'active' : '' }} d-flex align-items-center">
                    <i class="fas fa-user text-18"></i>
                    <span class="d-inline-block ps-2">Update Profile</span>
                </a>
                <a href="{{ route('reset') }}"
                    class="{{ in_array(Route::currentRouteName(), ['reset']) ? 'active' : '' }} d-flex align-items-center">
                    <i class="fas fa-key text-18"></i>
                    <span class="d-inline-block ps-2">Change Password</span>
                </a>
                <a href="{{ route('logout') }}"
                    class="{{ Route::currentRouteName() == 'logout' ? 'active' : '' }} d-flex align-items-center">
                    <i class="icon-logout text-18"></i>
                    <span class="d-inline-block ps-2 fw-600">Logout</span>
                </a>
            </div>
        </div>
    </div>
</header>
