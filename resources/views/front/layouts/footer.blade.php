<!-- -------------- get update sign up now section start ------------ -->

<section style="background: linear-gradient(to right, #4c46e6, #6d68fe, #b446ff, rgb(151, 0, 255));" class="p-3 p-md-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-6">
                <h4 class="sign_up_txt">
                    Subscribe Now For New Updates!
                </h4>
            </div>
            <div class="col-lg-5 col-md-6">
                <form id="inquiry_form" action="{{ route('email_signups') }}" method="POST">
                    @csrf
                    <div class="d-flex position-relative sign_up_box">
                        <input type="email" name="email" id="email" class="form-control email_input" placeholder="Enter Your Email" autocomplete="off" required>
                        <span class="sign_submit"><button type="submit" class="submit-btn">Submit</button></span>
                    </div>
                    <span id="email_error"></span>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- ---------------  footer section start ------------ -->

<section class="footer_section pad-top pad-bottom" style="background-color: #111111;">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-xl-3 mb-3">
                <a href="{{ route('home') }}" class="mb-3 d-block">
                    {{-- {{ asset('assets/front/image/logo.png') }} --}}
                   <img src="{{ getSetting('footer-logo') != null ? url('storage/setting', getSetting('footer-logo')) : asset('assets/front/image/logo.png') }}" alt="" class="footer-logo-img" loading="lazy">
                </a>
                <p class="footer_desc">
                    {{ getSetting('footer-description') != null ? getSetting('footer-description') : 'AGNEY Foundation works in the field of Wellness, through the research & development with the support of scalar sound & light frequencies.' }}
                </p>
            </div>
            <div class="col-lg-6 col-xl-2 mb-3">
                  <p class="footer_heading">Pages</p>

                  <ul class="footer_list">
                      <li><a href="{{ route('home') }}">Home</a></li>
                      <li><a href="{{ route('home') }}#about_sec">About Us</a></li>
                      <li><a href="{{ route('gallery') }}">Gallery</a></li>
                      @if(!auth()->guard('auth')->check() || (auth()->guard('auth')->check() && global_plan_active() == false ))
                        <li><a href="{{ route('home') }}#pricing_sec">Pricing</a></li>
                      @endif
                      <li><a href="{{ route('home') }}#contact_sec">Contact Us</a></li>
                      @if (auth()->guard('auth')->check() == false)
                        <li><a href="{{ route('front_login')  }}">Login</a></li>
                        <li><a href="{{  route('front_register') }}">Register</a></li>   
                      @endif
                      @foreach (getCms() as $cms)
                            <li><a href="{{ route('cms', $cms->slug_name) }}">{{ $cms->title }}</a></li>
                      @endforeach
                  </ul>
            </div>
            <div class="col-lg-6 col-xl-3 mb-3">
                  <p class="footer_heading">Category</p>

                  <ul class="footer_list">
                      @foreach (getCategories() as $category)
                      @php
                            $currentSlug = request()->segment(1); 
                            $isActiveCategory = $currentSlug === $category->slug_name;
                      @endphp
                        <li>
                            <a href="{{ route('category', ['slug' => $category->slug_name]) }}">
                                {{ $category->name }} 
                            </a>
                        </li>
                      @endforeach
                  </ul>
            </div>
            <div class="col-lg-6 col-xl-4 mb-3">
              <p class="footer_heading">App available on</p>
              <p class="text-white mb-3 fw-semibold">Download App</p>
              <div class="d-flex align-items-center gap-3 mb-3 flex-wrap">
                @if(getSetting('google-play') != null)
                  <a href="{{ getSetting('google-play') != null ? getSetting('google-play') : '##' }}" class="app_dpwnload d-flex align-items-center" target="_blank">
                      <!-- <i class="fa-brands fa-google-play icon_slider"></i> -->
                      <svg height="20px" width="20px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 511.999 511.999" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path style="fill:#32BBFF;" d="M382.369,175.623C322.891,142.356,227.427,88.937,79.355,6.028 C69.372-0.565,57.886-1.429,47.962,1.93l254.05,254.05L382.369,175.623z"></path> <path style="fill:#32BBFF;" d="M47.962,1.93c-1.86,0.63-3.67,1.39-5.401,2.308C31.602,10.166,23.549,21.573,23.549,36v439.96 c0,14.427,8.052,25.834,19.012,31.761c1.728,0.917,3.537,1.68,5.395,2.314L302.012,255.98L47.962,1.93z"></path> <path style="fill:#32BBFF;" d="M302.012,255.98L47.956,510.035c9.927,3.384,21.413,2.586,31.399-4.103 c143.598-80.41,237.986-133.196,298.152-166.746c1.675-0.941,3.316-1.861,4.938-2.772L302.012,255.98z"></path> </g> <path style="fill:#2C9FD9;" d="M23.549,255.98v219.98c0,14.427,8.052,25.834,19.012,31.761c1.728,0.917,3.537,1.68,5.395,2.314 L302.012,255.98H23.549z"></path> <path style="fill:#29CC5E;" d="M79.355,6.028C67.5-1.8,53.52-1.577,42.561,4.239l255.595,255.596l84.212-84.212 C322.891,142.356,227.427,88.937,79.355,6.028z"></path> <path style="fill:#D93F21;" d="M298.158,252.126L42.561,507.721c10.96,5.815,24.939,6.151,36.794-1.789 c143.598-80.41,237.986-133.196,298.152-166.746c1.675-0.941,3.316-1.861,4.938-2.772L298.158,252.126z"></path> <path style="fill:#FFD500;" d="M488.45,255.98c0-12.19-6.151-24.492-18.342-31.314c0,0-22.799-12.721-92.682-51.809l-83.123,83.123 l83.204,83.205c69.116-38.807,92.6-51.892,92.6-51.892C482.299,280.472,488.45,268.17,488.45,255.98z"></path> <path style="fill:#FFAA00;" d="M470.108,287.294c12.191-6.822,18.342-19.124,18.342-31.314H294.303l83.204,83.205 C446.624,300.379,470.108,287.294,470.108,287.294z"></path> </g></svg>
                      <div class="text-start ms-2">
                          <div class="download_txt">GET IT ON</div>
                          <div class="platform_icon">Google Play</div>
                      </div>
                  </a>
                  @endif
                  @if(getSetting('app-store') != null)
                    <a href="{{ getSetting('app-store') != null ? getSetting('app-store') : '##' }}" class="app_dpwnload d-flex align-items-center">
                        <i class="fa-brands fa-apple icon_slider apple_icon"></i>
                        <div class="text-start ms-3">
                            <div class="download_txt">Available on the</div>
                            <div class="platform_icon">App Store</div>
                        </div>
                    </a>
                  @endif
              </div>
              <ul class="footer_menu_main d-flex gap-1">
                @if(getSetting('facebook') != null)
                  <li class="text-muted">
                      <a class="text-white" href="{{ getSetting('facebook') != null ? getSetting('facebook') : 'https://www.facebook.com/' }}" aria-label="facebook"><i class="fa-brands fa-square-facebook me-2"></i>
                      </a>
                  </li>
                @endif
                @if( getSetting('instagram') != null)
                  <li class="text-muted">
                      <a class="text-white" href="{{ getSetting('instagram') != null ? getSetting('instagram') : 'https://www.instagram.com/' }}" aria-label="instagram">
                        <i class="fa-brands fa-instagram me-2"></i>
                       </a>
                  </li>
                @endif
                @if( getSetting('twitter') != null)
                  <li class="text-muted">
                    <a class="text-white" href="{{ getSetting('twitter') != null ? getSetting('twitter') : 'https://twitter.com/' }}" aria-label="twitter">
                        <i class="fa-brands fa-square-twitter me-2"></i>
                    </a>
                </li>
                @endif          
                @if( getSetting('linkedin') != null)
                  <li class="text-muted">
                    <a class="text-white" href="{{ getSetting('linkedin') != null ? getSetting('linkedin') : 'https://www.linkedin.com/' }}" aria-label="linkedin">
                        <i class="fa-brands fa-linkedin me-2"></i>
                    </a>
                </li>
                @endif
               </ul>
            </div>
        </div>
    </div>

  </section>

  <div class="row g-0">
      <div class="col-12 copy_footer text-center">© COPYRIGHT {{ date('Y') }} {{ getSetting('meta-title') != null ? getSetting('meta-title') : env('APP_NAME') }} ® -  All rights reserved - Design by  <a class="footer-link" href="https://shaktiwebsolution.com/" target="_blank">Shakti Web Solutions</a>
      </div>
  </div>

  <!-- ---------------  footer section end ------------ -->
