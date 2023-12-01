@extends('frontend.main_master')

@section('master')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<!-- Inner Banner -->
<div class="inner-banner inner-bg9">
    <div class="container">
        <div class="inner-title">
            <ul>
                <li>
                    <a href="index.html">Home</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>Booking</li>
            </ul>
            <h3>Checkout</h3>
        </div>
    </div>
</div>
<!-- Inner Banner End -->

<!-- Checkout Area -->
<section class="checkout-area pt-100 pb-70">
    <div class="container">
        <form action="{{ route('checkout.store') }}" method="POST" id="bk_form" class="stripe_form require-validation" data-cc-on-file="false" data-stripe-publishable-key="{{ env('STRIPE_KEY') }}">

            @csrf

            <div class="row">
                <div class="col-lg-8">
                    <div class="billing-details">
                        <h3 class="title">Billing Details</h3>

                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <label>Country <span class="required">*</span></label>
                                    <div class="select-box">
                                        <select class="form-control" name="country">
                                            <option value="Italy">Italy</option>
                                            <option value="Great Beatain">Great Bretain</option>
                                            <option value="Frasnce">France</option>
                                            <option value="Germany">Germany</option>
                                            <option value="Portugal">Portugal</option>
                                            <option value="Spain">Spain</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>Name <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="name" value="{{ \Auth::user()->name }}">
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>Phone <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="phone" value="{{ \Auth::user()->phone }}">
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <label>Email<span class="required">*</span></label>
                                    <input type="email" class="form-control" name="email" value="{{ \Auth::user()->email }}">
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-6">
                                <div class="form-group">
                                    <label>Address <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="address" value="{{ \Auth::user()->address }}">
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>State<span class="required">*</span></label>
                                    <input type="text" class="form-control" name="state">
                                    @if ($errors->has('state'))
                                    <div class="text-danger">{{ $errors->first('state') }}
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label>Zip Code<span class="required">*</span></label>
                                        <input type="text" class="form-control" name="zip_code">
                                        @if ($errors->has('zip_code'))
                                        <div class="text-danger">{{ $errors->first('zip_code') }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-4">
                            <section class="checkout-area pb-70">
                                <div class="card-body">
                                    <div class="billing-details">
                                        <h3 class="title">Booking Summary</h3>
                                        <hr>

                                        <div style="display: flex">
                                            <img style="height:100px; width:120px;object-fit: cover" src=" {{ !(empty($room->image)) ? url('upload/room_images/' . $room->image) : url('upload/no_image.jpg') }}" alt="Images" alt="Images">
                                            <div style="padding-left: 10px;">
                                                <a href=" " style="font-size: 20px; color: #595959;font-weight: bold">{{ $room['roomtype']['name'] }}</a>
                                                <p><b>{{ $room->price }} / Night</b></p>
                                            </div>

                                        </div>

                                        <br>

                                        <table class="table" style="width: 100%">

                                            <tr>
                                                <td>
                                                    <p>Total Nights</p>
                                                    <p><b>( {{ $bookingData['check_in'] }} - {{ $bookingData['check_out'] }} )</b></p>
                                                </td>
                                                <td style="text-align: right">
                                                    <p>{{ $nights }} Day/s</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p>Total Room</p>
                                                </td>
                                                <td style="text-align: right">
                                                    <p>{{ $bookingData['numberOfRooms'] }}</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p>Subtotal</p>
                                                </td>
                                                <td style="text-align: right">
                                                    <p>{{ $bookingData['numberOfRooms'] * $room->price * $nights }} €</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p>Discount</p>
                                                </td>
                                                <td style="text-align:right">
                                                    <p>{{ $room->discount }} %</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p>Total</p>
                                                </td>
                                                <td style="text-align:right">
                                                    <p>{{ ($bookingData['numberOfRooms'] * $room->price * $nights) - (($bookingData['numberOfRooms'] * $room->price * $nights) / 100 * $room->discount) }} €</p>
                                                </td>
                                            </tr>
                                        </table>

                                    </div>
                                </div>
                            </section>

                        </div>


                        <div class="col-lg-8 col-md-8">
                            <div class="payment-box">
                                <div class="payment-method">
                                    <p>
                                        <input type="radio" id="cash-on-delivery" class="pay_method" name="payment_method" value="COD">
                                        <label for="cash-on-delivery">Cash On Delivery</label>
                                    </p>
                                    <p>
                                        <input type="radio" id="stripe" class="pay_method" name="payment_method" value="Stripe">
                                        <label for="stripe">Stripe</label>
                                        Pay safety with your credit/prepaid card!
                                    </p>
                                    <div id="stripe_pay" class="d-none">
                                        <br />
                                        <div class="form-row row">
                                            <div class="col-xs-12 form-group required">
                                                <label class="control-label">Name on Card</label>
                                                <input class="form-control" size="4" type="text" />
                                            </div>
                                        </div>
                                        <div class="form-row row">
                                            <div class="col-xs-12 form-group required">
                                                <label class="control-label">Card Number</label>
                                                <input autocomplete="off" class="form-control card-number" size="20" type="text" />
                                            </div>
                                        </div>
                                        <div class="form-row row">
                                            <div class="col-xs-12 col-md-4 form-group cvc required">
                                                <label class="control-label">CVC</label><input autocomplete="off" class="form-control card-cvc" placeholder="ex. 311" size="4" type="text" />
                                            </div>
                                            <div class="col-xs-12 col-md-4 form-group expiration required">
                                                <label class="control-label">Expiration Month</label><input class="form-control card-expiry-month" placeholder="MM" size="2" type="text" />
                                            </div>
                                            <div class="col-xs-12 col-md-4 form-group expiration required">
                                                <label class="control-label">Expiration Year</label><input class="form-control card-expiry-year" placeholder="YYYY" size="4" type="text" />
                                            </div>
                                        </div>
                                        <div class="form-row row">
                                            <div class="col-md-12 error form-group hide">
                                                <div class="alert-danger alert">
                                                    Please correct the errors and try again.
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <button type="submit" class="order-btn three" id="myButton">
                                    Order Now!
                                    </a>
                                </button>
                            </div>
                        </div>
                    </div>
        </form>
    </div>
</section>
<!-- Checkout Area End -->

<style>
    .hide {
        display: none
    }
</style>


<script type="text/javascript" src="https://js.stripe.com/v3/"></script>

<script type="text/javascript">
    $(document).ready(function() {

        $(".pay_method").on('click', function() {
            var payment_method = $(this).val();
            if (payment_method == 'Stripe') {
                $("#stripe_pay").removeClass('d-none');
            } else {
                $("#stripe_pay").addClass('d-none');
            }
        });

    });

    $(function() {
        var $form = $(".require-validation");
        $('form.require-validation').bind('submit', function(e) {

            var pay_method = $('input[name="payment_method"]:checked').val();
            if (pay_method == undefined) {
                alert('Please select a payment method');
                return false;
            } else if (pay_method == 'COD') {

            } else {
                document.getElementById('myButton').disabled = true;

                var $form = $(".require-validation"),
                    inputSelector = ['input[type=email]', 'input[type=password]',
                        'input[type=text]', 'input[type=file]',
                        'textarea'
                    ].join(', '),
                    $inputs = $form.find('.required').find(inputSelector),
                    $errorMessage = $form.find('div.error'),
                    valid = true;
                $errorMessage.addClass('hide');

                $('.has-error').removeClass('has-error');
                $inputs.each(function(i, el) {
                    var $input = $(el);
                    if ($input.val() === '') {
                        $input.parent().addClass('has-error');
                        $errorMessage.removeClass('hide');
                        e.preventDefault();
                    }
                });

                if (!$form.data('cc-on-file')) {

                    e.preventDefault();
                    var stripe = Stripe($form.data('stripe-publishable-key'));

                    stripe.createToken(card : {
                            number: $('.card-number').val(),
                            cvc: $('.card-cvc').val(),
                            exp_month: $('.card-expiry-month').val(),
                            exp_year: $('.card-expiry-year').val()
                        }, stripeResponseHandler);
                }
            }



        });



        function stripeResponseHandler(status, response) {
            if (response.error) {

                document.getElementById('myButton').disabled = false;

                $('.error')
                    .removeClass('hide')
                    .find('.alert')
                    .text(response.error.message);
            } else {

                document.getElementById('myButton').disabled = true;
                document.getElementById('myButton').value = 'Please Wait...';

                // token contains id, last4, and card type
                var token = response['id'];
                // insert the token into the form so it gets submitted to the server
                $form.find('input[type=text]').empty();
                $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                $form.get(0).submit();
            }
        }

    });
</script>


@endsection