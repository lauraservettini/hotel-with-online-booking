@extends('frontend.main_master')

@section('master')

        <!-- Inner Banner -->
        <div class="inner-banner inner-bg9">
            <div class="container">
                <div class="inner-title">
                    <ul>
                        <li>
                            <a href="index.html">Home</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>Sign In</li>
                    </ul>
                    <h3>Sign In</h3>
                </div>
            </div>
        </div>
        <!-- Inner Banner End -->

        <!-- Sign In Area -->
        <div class="sign-in-area pt-100 pb-70">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="user-all-form">
                            <div class="contact-form">
                                <div class="section-title text-center">
                                    {{-- <span class="sp-color">Sign In</span> --}}
                                    <h2>Sign In to Your Account!</h2>
                                </div>
                                {{-- <form id="contactForm" action="{{ route('post.login') }}" method="POST">
                                    @csrf

                                    <div class="row">
                                        <div class="col-lg-12 ">
                                            <div class="form-group">
                                                <input type="email" name="email" id="email" class="form-control" :value="old('email')" required data-error="Please enter your email" placeholder="Username or Email">
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <input class="form-control" type="password" id="password" name="password" placeholder="Password">
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-sm-6 form-condition">
                                            <div class="agree-label">
                                                <input type="checkbox" id="chb1">
                                                <label for="chb1">
                                                    Remember Me
                                                </label>
                                            </div>
                                        </div>
            
                                        <div class="col-lg-6 col-sm-6">
                                            <a class="forget" href="{{ route('password.request') }}">Forgot My Password?</a>
                                        </div>
        
                                        <div class="col-lg-12 col-md-12 text-center">
                                            <button type="submit" class="default-btn btn-bg-three border-radius-5">
                                                Login
                                            </button>
                                        </div>

                                        <div class="col-12">
                                            <p class="account-desc">
                                                Not a Member?
                                                <a href="{{ route('register') }}">Sign Up</a>
                                            </p>
                                        </div>
                                    </div>
                                </form> --}}
                                <x-guest-layout>
                                    <!-- Session Status -->
                                    <x-auth-session-status class="" :status="session('status')" />

                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                
                                        <!-- Email Address -->
                                        <div>
                                            <x-input-label for="email" :value="__('Email')" />
                                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                                            {{-- <x-input-error :messages="$errors->get('email')" class="mt-2" /> --}}
                                        </div>
                                
                                        <!-- Password -->
                                        <div class="mt-4">
                                            <x-input-label for="password" :value="__('Password')" />
                                
                                            <x-text-input id="password" class="block mt-1 w-full"
                                                            type="password"
                                                            name="password"
                                                            required autocomplete="current-password" />
                                
                                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                        </div>
                                
                                        <!-- Remember Me -->
                                        <div class="block mt-4">
                                            <label for="remember_me" class="inline-flex items-center">
                                                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                                                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                                            </label>
                                        </div>
                                
                                        <div class="flex items-center justify-end mt-4">
                                            @if (Route::has('password.request'))
                                                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                                                    {{ __('Forgot your password?') }}
                                                </a>
                                            @endif
                                
                                            <x-primary-button class="ms-3">
                                                {{ __('Log in') }}
                                            </x-primary-button>
                                        </div>
                                        
                                        <!-- Redirect to /register -->
                                        <div class="col-12 flex items-center justify-end mt-4">
                                            <p>
                                                Not a Member?
                                                <a href="{{ route('register') }}" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Sign Up</a>
                                            </p>
                                        </div>
                                    </form>
                                </x-guest-layout>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sign In Area End -->

@endsection