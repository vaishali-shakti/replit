 <!-- footer section start -->

 <section class="section_main testi_sec bg-dark px-3">
     <div class="container">
         <div class="row">
             <div class="col-md-3 mb-4">
                 <a href="#"><img src="{{asset('images/logo.png')}}"
                         alt="footer-logo" width="100" class="footer-logo"></a>
                 <div class="text-white footer_disc_txt">Discount App for Food Lovers</div>
             </div>
             <div class="col-md-3 mb-4">
                 <ul class="footer_menu_main">
                    <li class="text-light"><a href="#" class="text-white">CITIES</a></li>
                     <li class="text-muted"><a class="text-white" href="#">View More...</a></li>
                     {{-- <li class="text-muted"><a class="text-white" href="surat.html">SURAT</a></li>
                   <li class="text-muted"><a class="text-white">VADODARA</a></li>
                   <li class="text-muted"><a class="text-white">AHMEDABAD</a></li> --}}
                 </ul>
             </div>
             <div class="col-md-3 mb-4">
                <ul class="footer_menu_main">
                    <li class="text-light"><a href="#" class="text-white">OTHER LINKS</a></li>
                    <li class="text-muted">
                        <a class="text-white{{ request()->segment(2) === 'faq' ? ' active' : '' }}" href="#">FAQ</a>
                    </li>
                    <li class="text-muted">
                        <a class="text-white{{ request()->segment(2) === 'about-us' ? ' active' : '' }}" href="#">ABOUT US</a>
                    </li>
                    <li class="text-muted">
                        <a class="text-white{{ request()->routeIs('contact_us') ? ' active' : '' }}" href="#">CONTACT US</a>
                    </li>
                    <li class="text-muted">
                        <a class="text-white{{ request()->segment(2) === 'privacy-policy' ? ' active' : '' }}" href="#">PRIVACY POLICY</a>
                    </li>
                    <li class="text-muted">
                        <a class="text-white{{ request()->segment(2) === 'terms-conditions' ? ' active' : '' }}" href="#">TERMS & CONDITIONS</a>
                    </li>
                </ul>
             </div>
             <div class="col-md-3 mb-4">
                 <ul class="footer_menu_main">
                 </ul>
             </div>
         </div>
     </div>
 </section>

 <div class="row g-0">
     <div class="col-12 copy_footer text-center text-uppercase">&copy; COPYRIGHT {{ date('Y') }} Skaimed &reg; - ALL RIGHTS
         RESERVED
     </div>
 </div>
