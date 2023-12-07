@extends('frontend.main_master')

@section('master')

<!-- Inner Banner -->
<div class="inner-banner inner-bg9">
    <div class="container">
        <div class="inner-title">
            <ul>
                <li>
                    <a href="{{ route('contact') }}">Contact</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>Contact Us</li>
            </ul>
            <h3>Contact Us</h3>
        </div>
    </div>
</div>
<!-- Inner Banner End -->

<!-- Contact Area -->
<div class="contact-area pt-100 pb-70">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="contact-content">
                    <div class="section-title">
                        <h2>Let's Start to Give Us a Message and Contact With Us</h2>
                    </div>
                    <div class="contact-img">
                        <img src="{{ asset('frontend/assets/img/contact/contact-img1.jpg')}}" alt="Images">
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="contact-form">
                    <form action="{{ route('store.contact') }}" method="post" >
                        @csrf

                        <div class="row">
                            <div class="col-lg-6 col-sm-6">
                                <div class="form-group">
                                    <input type="text" name="name" id="name" class="form-control" required="" data-error="Please enter your name" placeholder="Name">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-sm-6">
                                <div class="form-group">
                                    <input type="email" name="email" id="email" class="form-control" required="" data-error="Please enter your email" placeholder="Email">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-sm-6">
                                <div class="form-group">
                                    <input type="text" name="phone" id="phone_number" required="" data-error="Please enter your number" class="form-control" placeholder="Phone">
                                    <div class="help-block with-errors"><ul class="list-unstyled"><li>Please enter your number</li></ul></div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-sm-6">
                                <div class="form-group">
                                    <input type="text" name="subject" id="msg_subject" class="form-control" required="" data-error="Please enter your subject" placeholder="Your Subject">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <textarea name="message" class="form-control" id="message" cols="30" rows="8" required="" data-error="Write your message" placeholder="Your Message"></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <button type="submit" class="default-btn btn-bg-three disabled" style="pointer-events: all; cursor: pointer;">
                                    Send Message
                                </button>
                                <div id="msgSubmit" class="h3 text-center hidden"></div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Contact Area End -->

<!-- contact Another -->
<div class="contact-another pb-70">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="contact-another-content">
                    <div class="section-title">
                        <h2>Contacts Info</h2>
                        <p>
                            We are one of the best hotel and we can easily make a contact
                            us anytime on the below details.
                        </p>
                    </div>

                    <div class="contact-item">
                        <ul>
                            <li>
                                <i class="bx bx-home-alt"></i>
                                <div class="content">
                                    <span>{{ $settings->address }}</span>
                                </div>
                            </li>
                            <li>
                                <i class="bx bx-phone-call"></i>
                                <div class="content">
                                    <span><a href="tel:{{ $settings->phone }}">{{ $settings->phone }}</a></span>
                                </div>
                            </li>
                            <li>
                                <i class="bx bx-envelope"></i>
                                <div class="content">
                                    <span><a href="{{ $settings->email }}">{{ $settings->email }}</a></span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>


            <div class="col-lg-6">
                <div class="contact-another-img">
                    <img src="{{ asset('frontend/assets/img/contact/contact-img2.jpg') }}" alt="Images">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- contact Another End -->

@endsection