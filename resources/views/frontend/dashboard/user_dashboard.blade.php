{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}
@extends('frontend.main_master')

@section('master')

<!-- Inner Banner -->
<div class="inner-banner inner-bg6">
    <div class="container">
        <div class="inner-title">
            <ul>
                <li>
                    <a href="{{ route('home')}}">Home</a>
                </li>
                <li><i class="bx bx-chevron-right"></i></li>
                <li>User Dashboard</li>
            </ul>
            <h3>User Dashboard</h3>
        </div>
    </div>
</div>
<!-- Inner Banner End -->

<!-- Service Details Area -->
<div class="service-details-area pt-100 pb-70">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                @include('frontend.dashboard.user_sidebar')
            </div>

            <div class="col-lg-9">
                <div class="service-article">
                    <div class="service-article-title">
                        <h2>User Dashboard</h2>
                    </div>

                    <div class="service-article-content">
                        <div class="row">
                            <div class="col-md-4">
                                <div
                                    class="card text-white bg-primary mb-3"
                                    style="max-width: 18rem"
                                >
                                    <div class="card-header">Total Booking</div>
                                    <div class="card-body">
                                        <h1
                                            class="card-title"
                                            style="font-size: 45px"
                                        >
                                            {{ $bookings }} Total
                                        </h1>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div
                                    class="card text-white bg-warning mb-3"
                                    style="max-width: 18rem"
                                >
                                    <div class="card-header">
                                        Pending Booking
                                    </div>
                                    <div class="card-body">
                                        <h1
                                            class="card-title"
                                            style="font-size: 45px"
                                        >
                                            {{ $pending }} Pending
                                        </h1>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div
                                    class="card text-white bg-success mb-3"
                                    style="max-width: 18rem"
                                >
                                    <div class="card-header">
                                        Complete Booking
                                    </div>
                                    <div class="card-body">
                                        <h1
                                            class="card-title"
                                            style="font-size: 45px"
                                        >
                                            {{ $complete }} Complete
                                        </h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Service Details Area End -->

@endsection