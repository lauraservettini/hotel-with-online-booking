@php
    $setting = App\Models\SiteSettings::find(1);
@endphp

<footer class="footer-area footer-bg">
    <div class="container">
        <div class="footer-top pt-100 pb-70">
            <div class="row align-items-center">
                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget">
                        <div class="footer-logo">
                            <a href="{{ route('home') }}">
                                <img src="{{ !empty($setting->logo) ? asset($setting->logo) : url('upload/no_image.jpg') }}" alt="Images">
                            </a>
                        </div>
                        <p>
                            Aenean finibus convallis nisl sit amet hendrerit. Etiam blandit velit non lorem mattis, non ultrices eros bibendum .
                        </p>
                        <ul class="footer-list-contact">
                            <li>
                                <i class='bx bx-home-alt'></i>
                                <a href="#">{{ $setting->address }}</a>
                            </li>
                            <li>
                                <i class='bx bx-phone-call'></i>
                                <a href="tel:{{ $setting->phone }}">{{ $setting->phone }}</a>
                            </li>
                            <li>
                                <i class='bx bx-envelope'></i>
                                <a href="mailto:{{ $setting->email }}">{{ $setting->email }}</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget pl-5">
                        <h3>Got to:</h3>
                        <ul class="footer-list">
                            <li>
                                <a href="#team">
                                    <i class='bx bx-caret-right'></i>
                                    Team
                                </a>
                            </li> 
                            <li>
                                <a href="#testimonials">
                                    <i class='bx bx-caret-right'></i>
                                    Testimonials
                                </a>
                            </li> 
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget">
                        <h3>Links</h3>
                        <ul class="footer-list">
                            <li>
                                <a href="{{ route('home') }}" target="_blank">
                                    <i class='bx bx-caret-right'></i>
                                    Home
                                </a>
                            </li> 
                            <li>
                                <a href="{{ route('blog.list') }}" target="_blank">
                                    <i class='bx bx-caret-right'></i>
                                    Blog
                                </a>
                            </li> 
                            <li>
                                <a href="{{ route('show.gallery') }}" target="_blank">
                                    <i class='bx bx-caret-right'></i>
                                    Gallery
                                </a>
                            </li> 
                            
                            <li>
                                <a href="{{ route('contact') }}" target="_blank">
                                    <i class='bx bx-caret-right'></i>
                                    Contact Us
                                </a>
                            </li> 
                        </ul>
                    </div>
                </div>

            </div>
        </div>

        <div class="copy-right-area">
            <div class="row">
                <div class="col-lg-8 col-md-8">
                    <div class="copy-right-text text-align1">
                        <p>{{ $setting->copyright }}</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4">
                    <div class="social-icon text-align2">
                        <ul class="social-link">
                            <li>
                                <a href="{{ $setting->facebook }}" target="_blank"><i class='bx bxl-facebook'></i></a>
                            </li> 
                            <li>
                                <a href="{{ $setting->twitter }}" target="_blank"><i class='bx bxl-twitter'></i></a>
                            </li> 
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>