<x-storefront::layout>
    @if(isset($user))
    <link rel="stylesheet" href="{{asset('storefront/css/loyality_points.css')}}">
    @else
    <link rel="stylesheet" href="{{asset('storefront/css/prizes.css')}}">
    @endif

    <x-storefront::header user='{{ $user_bit }}' totalpoints='{{ $total_points }}'></x-storefront::header>

    

    <main class="main-section">
        <section class="container-lg">
            <div class="row">
                @foreach($products as $product)
                @if(in_array($product->id,$inprogress_product))
                <x-storefront::product name="{{ $product->name }}" id='{{ $product->id }}' user='{{ $user_bit }}' progress='1' points='{{ $product->points }}' totalpoints='{{ $total_points }}' image='{{ $product->image }}' description='{{ $product->description }}'></x-storefront::product>
                @else
                <x-storefront::product name="{{ $product->name }}" id='{{ $product->id }}' user='{{ $user_bit }}' progress='0' points='{{ $product->points }}' totalpoints='{{ $total_points }}' image='{{ $product->image }}' description='{{ $product->description }}'></x-storefront::product>
                @endif
                @endforeach
            </div>
        </section>
    </main>


    <button class="redeem-points-link" data-bs-toggle="modal" data-bs-target="#Modal_Redeem">How to redeem points <i class="ms-1 fa fa-comment"></i> </button>


    <input type='hidden' value='@if(isset($user)){{$user->mobile}}@endif' id='mobile'>
    <input type='hidden' value='0' id='status'>

    <!-- Modal -->

    <x-storefront::modal id="Modal">
        <div class="modal-header">
            <h6 class="modal-title" id="ModalLabel">Login to Redeem Your Loyalty Points</h6>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div style="padding: 5px 20px;">
               @csrf

                <input type="hidden" id="selected_product" name="selected_product" />

                <div id="login_content">
                    <div class="mb-3">
                        <label for="phone" class="form-label">Enter Phone Number</label>
                        <div class="country-code">
                            <input type="text" name="" class="form-control select-code valid" readonly="readonly" value="IN +91" style="" id="mobile_isd" style="background: #D3D3D3;">
                            <x-storefront::input type="text" placeholder="Enter your mobile number" class="form-control" style="" id="mobile_no" value="" />
                        </div>
                    </div>
                    <div class="mb-3">
                        <x-storefront::buttonmodal class="" value='' id="genenrateOTP" style="width: 100%">Login</x-storefront::buttonmodal>
                    </div>
                    <div style="font-size: 12px; margin-top: 25px;">
                        By proceeding, you agree to our <a href="https://golfersshotgoodlife.com/terms-and-conditions/" target="_blank">Terms and Condition and Privacy Policy.</a>
                    </div>
                </div>
                <div id="otp_content" style="display: none;">
                    <div class="container height-100 d-flex justify-content-center align-items-center">
                        <div class="position-relative">
                            <div class="text-center">
                                <h6 style="font-size: 14px;">Please enter the one time password to verify your account</h6>
                                <div style="font-size: 14px;"><span>A code has been sent to </span><small>+91 </small><small id="otp_phone_no">9897</small></div>
                                <div id="otp" class="inputs d-flex flex-storefront::row justify-content-center mt-2"> 
                                    <input class="m-2 text-center form-control rounded" type="password" autocomplete="false" id="first" maxlength="1" /> 
                                    <input class="m-2 text-center form-control rounded" type="password" autocomplete="false" id="second" maxlength="1" /> 
                                    <input class="m-2 text-center form-control rounded" type="password" autocomplete="false" id="third" maxlength="1" /> 
                                    <input class="m-2 text-center form-control rounded" type="password" autocomplete="false" id="fourth" maxlength="1" /> 
                                </div>
                                <div id="resend_success" style="color: #089208;font-size: 14px; margin-top: 5px; display: none">
                                    <i class="fa fa-check"></i> A new OTP has been sent to your mobile number
                                </div>
                                <div id="otp_failed" style="color: #870303;font-size: 14px; margin-top: 5px; display: none">
                                    <i class="fa fa-close"></i> OTP verification failed.
                                </div>
                                <div class="mt-4"><x-storefront::buttonmodal class="" value='' id="verifyOTP" style="width: 100%">Verify OTP</x-storefront::buttonmodal></div>
                            </div>
                        </div>
                    </div>

                    <div style="margin-top: 20px;">
                        <span id='login'><span>
                        <x-storefront::input type="password" placeholder="Enter OTP" id="otp_field" style="display: none" value='' />
                        <a href="javascript://" id="resend_otp" class="bt-06" style="font-size: 12px;" disabled="true">Resend OTP</a>
                        <span id="countdown" class="countdown"></span>
                        <x-storefront::buttonmodal class="" value='' id="confirm" style="display: none; width: 100%">Confirm</x-storefront::buttonmodal>
                        <x-storefront::buttonmodal class="" value='' id="okay" style="display: none; width: 100%">Ok</x-storefront::buttonmodal>
                    </div>
                </div>

            </div>
        </div>
    </x-storefront::modal>

    <x-storefront::modal id="Modal_Redeem">
        <div class="modal-header">
            <h6 class="modal-title" id="ModalLabel">How to Reedeem</h6>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <p><b>Step 1</b></p>
        <p>Select the product you like and claim for the checkout based on your loyalty points in your account. </p> <br>
        <p><b>Step 2</b></p>
        <p>Add details for delivery at your address and proceed.</p><br>
        <p>If you have any queries, kindly contact us via Email or Whatsapp:<br>
        Email: cs@xoxoday.com<br>
        Whatsapp: +91 80 6191 5050</p>
        </div>
    </x-storefront::modal>

    <x-storefront::modal id="redeem_form">
        <div class="modal-header">
            <h6 class="modal-title" id="ModalLabel">Add Your Delivery Address</h6>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6 col-sm-12 mb-3">
                    <label for="" class="form-label">Name</label>
                    <x-storefront::input type="text" placeholder="Enter your full name" class="form-control" style="" id="redeem_name" value="{{ $name }}" />
                </div>
                <div class="col-md-6 col-sm-12 mb-3">
                    <label for="" class="form-label">Enter Phone Number </label>
                    <div class="country-code">
                        <input type="text" name="" class="form-control select-code valid" readonly="readonly" value="IN +91" style="" id="mobile_id" style="background: #D3D3D3;">
                        <x-storefront::input type="text" placeholder="Enter your mobile number" class="form-control" style="" id="reedem_mobile_no" value="{{ $mobile }}" />
                    </div>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Address Line 1</label>
                    <input type="text" placeholder="Enter Flat, House no., Building, Company, Apartment" class="form-control" id="redeem_address" />
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Address Line 2</label>
                    <input type="text" placeholder="Enter Area, Street, Sector, Village" class="form-control" id="redeem_address2" />
                </div>
                <div class="col-md-6 col-sm-12 mb-3">
                    <label for="" class="form-label">City</label>
                    <input type="text" placeholder="Enter your City" class="form-control" id="redeem_city" />
                </div>
                <div class="col-md-6 col-sm-12 mb-3">
                    <label for="" class="form-label">State</label>
                    <select  class="form-control" id="redeem_state">
                        <option value=''>Enter your State</option>
                        @foreach ($states as $state)
                            <option value='{{ $state["name"] }}'>{{ $state["name"] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 col-sm-12 mb-3">
                    <label for="" class="form-label">Pincode</label>
                    <input type="text" placeholder="Enter your Pin Code" class="form-control" id="redeem_pincode" />
                </div>
                <div class="col-md-6 col-sm-12 mb-3">
                    <label for="" class="form-label">Landmark (Optional)</label>
                    <input type="text" placeholder="Enter a nearest landmark" class="form-control" id="redeem_landmark" />
                </div>
                <div class="mb-3" id="spending_text" style="font-size: 12px">
                    You are spending <b id="required_points"></b> Loyalty Points. You have a balance of <b>{{$total_points}}</b> Points.
                </div>
                <div class="mb-3" id="spending_text" style="font-size: 12px">
                Your order will be delivered by our fulfillment partner Amazon with in 3-7 days On the day of delivery, you will receive an OTP on your mobile number from Amazon India.
                </div>
                <div class="mt-4"><x-storefront::buttonmodal class="" value='' id="deliverHere" style="width: 100%">Deliver Here</x-storefront::buttonmodal></div>
            </div>
        </div>
    </x-storefront::modal>


    <script>
        var count = 0;
        $(document).ready(function() {
            $(".claim-btn-model").click(function() {
                if ($(this).attr("data-value") != undefined) {
                    $("#selected_product").val($(this).attr("data-value"));
                } else {
                    $("#selected_product").val(0);
                }
                $("#Modal").modal('show');
                $("#login_content").show();
                $("#otp_content").hide();
            });


            $(".claim-request").click(function() {
                $("#redeem_form").modal('show');
            });

            var logged_in_mobile = $('#mobile').val();
            $.ajaxSetup({
                headers: {
                    'x-CSRF-TOKEN': $("input[name='_token']").val()
                }
            });

            $(".modal-button1").click(function() {
                $("#selected_product").val($(this).val());
                if (logged_in_mobile != '') {
                    var product_id = $('#selected_product').val();
                    var product_name = '';
                    var product_loyalty_points = '';
                    var total_points = '';
                    var otp = logged_in_mobile;
                    $.ajax({
                        type: 'POST',
                        url: "{{ url('/redemption') }}",
                        data: {
                            mobile: logged_in_mobile,
                            otp: otp,
                            product_id: product_id
                        },
                        success: function(data) {
                            if ($.isEmptyObject(data.error)) {
                                if (data.success) {
                                    $("#otp_field").hide();
                                    $("#otp_div").hide();
                                    $("#verifyOTP").hide();
                                    $("#resend_otp").hide();
                                    $("#ModalLabel").text('Confirm claim of ' + product_name + ' ?');
                                    $("#login").text('You have a balance of LP 2034/- which will be reduced by the LP 1000/- You will be connected over phone for delibery?');
                                    $("#confirm").show();

                                    if (data.product) {
                                        product_name = data.product.name;
                                        product_loyalty_points = data.product.points;
                                        total_points = data.total_points;
                                        $("#ModalLabel").text('Confirm claim of ' + product_name + ' ?');
                                        $("#login").text('You have a balance of LP ' + total_points + '/- which will be reduced by the LP ' + product_loyalty_points + '/- You will be connected over phone for delibery?');
                                        $("#confirm").show();

                                    }
                                }

                            } else {
                                $("#login").before('<span id="mobile-error" class="error">' + data.error + '<span>');
                            }
                        }
                    });
                } else {
                    $("#otp_div").hide();
                    $("#otp_field").hide();
                    $("#verifyOTP").hide();
                    $("#resend_otp").hide();
                    $("span.countdown").hide();
                    $("#mobile_no").show();
                    $("#mobile_isd").show();
                    $("#genenrateOTP").show();
                }

            });

            $("#genenrateOTP").click(function() {
                $("#verifyOTP").prop("disabled", false);
                $("#resend_otp").prop("disabled", true);
                $("#mobile-error").remove();
                $("#ModalLabel").html("Login to Redeem Your Loyalty Points");
                
                var mobile = $('#mobile_no').val();
                if (mobile == '') {
                    $(".country-code").after('<div id="mobile-error" class="error">Mobile number is required.<div>');
                    return false;
                } else if (mobile.length != 10) {
                    $(".country-code").after('<div id="mobile-error" class="error">Mobile number must be of 10 digits.<div>');
                    return false;
                } else if (isNaN(mobile)) {
                    $(".country-code").after('<div id="mobile-error" class="error">Mobile number must be of 10 digits.<div>');
                    return false;
                }

                var otp_sent = sendOtp(mobile);
                if(otp_sent == 'Failed'){
                    $(".country-code").after('<div id="mobile-error" class="error">OTP could not be sent.<div>');
                    return false;
                }

                

                /*
                $("#mobile_isd").hide();
                $("#mobile_no").hide();
                $("#genenrateOTP").hide();
                $("#otp_div").show();
                $("#otp_field").show();
                $("#verifyOTP").show();
                $("#resend_otp").show();
                $("#mobile-error").hide();
                */

                $("#login_content").hide();
                $("#otp_phone_no").html($("#mobile_no").val());
                $("#ModalLabel").html("Verify Mobile Number");
                $("#otp_content").show();

                countdown1min();
                $('#resend_otp').hide();

                setTimeout(function() {
                    $('#resend_otp').prop('disabled', false);
                    $("span.countdown").hide();
                    $('#resend_otp').show();

                }, 60000);
                //ajax request for otp here
            });
        });

        function OTPInput() {
            const inputs = document.querySelectorAll('#otp > *[id]');
            for (let i = 0; i < inputs.length; i++) {
                inputs[i].addEventListener('keydown', function(event) {
                    if (event.key === "Backspace") {
                        inputs[i].value = '';
                        if (i !== 0) inputs[i - 1].focus();
                    } else {
                        if (i === inputs.length - 1 && inputs[i].value !== '') {
                            return true;
                        } else if (event.keyCode > 47 && event.keyCode < 58) {
                            inputs[i].value = event.key;
                            if (i !== inputs.length - 1) inputs[i + 1].focus();
                            event.preventDefault();
                        } else if (event.keyCode > 64 && event.keyCode < 91) {
                            inputs[i].value = String.fromCharCode(event.keyCode);
                            if (i !== inputs.length - 1) inputs[i + 1].focus();
                            event.preventDefault();
                        }
                    }
                });
            }
        }
        OTPInput();


        $("#verifyOTP").click(function() {
            $("#verifyOTP").prop("disabled", true);
            $(".error").hide();
            var mobile = $('#mobile_no').val();
            var otp = $('#first').val() + $('#second').val() + $('#third').val() + $('#fourth').val();
            //var product_id = $('#selected_product').val();
            var product_id = '';
            var product_name = '';
            var product_loyalty_points = '';
            var total_points = '';
            $.ajax({
                type: 'POST',
                url: "{{ url('/redemption') }}",
                data: {
                    mobile: mobile,
                    otp: otp,
                    product_id: product_id
                },
                success: function(data) {
                    if ($.isEmptyObject(data.error)) {
                        if (data.success) {
                            //Reload Popup After Login

                            
                            location.reload();
                            return
                            if (product_id == '') {
                                location.reload();
                            } else {
                                $("#otp_field").hide();
                                $("#verifyOTP").hide();
                                $("#resend_otp").hide();
                                $("#ModalLabel").text('Confirm claim of ' + product_name + ' ?');
                                $("#login").text('You have a balance of LP 2034/- which will be reduced by the LP 1000/- You will be connected over phone for delibery?');
                                $("#confirm").show();
                                $("#cancel").show();
                                $('#mobile').val(mobile);

                                if (data.product) {
                                    product_name = data.product.name;
                                    product_loyalty_points = data.product.points;
                                    total_points = data.total_points;
                                    $("#status").val('1');
                                    $("#ModalLabel").text('Confirm claim of ' + product_name + ' ?');
                                    $("#login").text('You have a balance of LP ' + total_points + '/- which will be reduced by the LP ' + product_loyalty_points + '/- You will be connected over phone for delivery?');
                                    $("#confirm").show();
                                    $("#cancel").show();
                                }
                            }
                        }
                    } else {
                        $("#verifyOTP").prop("disabled", false);
                        $("#resend_success").hide();
                        $("#otp_failed").show();
                        //$("#countdown").after('<span id="mobile-error" class="error"><br>' + data.error + '<span>');
                        if (data.error == 'A claim for this product is already in process.') {
                            $("#status").val('1');
                        }
                    }


                }
            });
        });


        $("#confirm").click(function() {
            $("#confirm").prop("disabled", true);
            var mobile = $('#mobile').val();
            var product_id = $('#selected_product').val();
            $.ajax({
                type: 'POST',
                url: "{{ url('/addPoints') }}",
                data: {
                    mobile: mobile,
                    product_id: product_id
                },
                success: function(data) {
                    if ($.isEmptyObject(data.error)) {
                        $("#confirm").hide();
                        $("#cancel").hide();
                        $("#close_btn").show();
                        $("#status").val('1');
                        $("#ModalLabel").text('Request Successfully Registered');
                        $("#login").text('You will be contacted for the delivery of the product via phone.');

                    } else {
                        $("#cancel").after('<span id="mobile-error" class="error">' + data.error + '<span>');
                    }
                }
            });

        });

        $(".claim-request").click(function() {
            $("#required_points").html($(this).attr("data-points"));
            $('#selected_product').val($(this).attr("data-product"));
        });

        $("#deliverHere").click(function() {
            $(".error").hide();
            var mobile = $('#reedem_mobile_no').val();
            var name = $('#redeem_name').val();
            var address = $('#redeem_address').val();
            var address2 = $('#redeem_address2').val();
            var city = $('#redeem_city').val();
            var state = $('#redeem_state').val();
            var pincode = $('#redeem_pincode').val();
            var landmark = $('#redeem_landmark').val();
            var product_id = $('#selected_product').val();
            var error = 0;
            var hasNumber = /\d/;   
                if (mobile == '') {
                    $(".country-code").after('<div id="mobile-error" class="error">Mobile number is required.<div>');
                    error =1;
                } else if (mobile.length != 10) {
                    $(".country-code").after('<div id="mobile-error" class="error">Mobile number must be of 10 digits.<div>');
                    error =1;
                } else if (isNaN(mobile)) {
                    $(".country-code").after('<div id="mobile-error" class="error">Mobile number must be of 10 digits.<div>');
                    error =1;
                }

                if (name == '') {
                    $("#redeem_name").after('<div id="mobile-error" class="error">Name is required.<div>');
                    error =1;
                } else if (name.length > 50) {
                    $("#redeem_name").after('<div id="mobile-error" class="error">Name must be less than 50 characters.<div>');
                    error =1;
                } else if (hasNumber.test(name)) {
                    $("#redeem_name").after('<div id="mobile-error" class="error">Name does not allow number.<div>');
                    error =1;
                }

                if (address == '') {
                    $("#redeem_address").after('<div id="mobile-error" class="error">Address Line 1 is required.<div>');
                    error =1;
                }else if (address.length > 255) {
                    $("#redeem_address").after('<div id="mobile-error" class="error">Address Line 1 must be less than 255 characters.<div>');
                    error =1;
                }

                if (address2.length > 255) {
                    $("#redeem_address2").after('<div id="mobile-error" class="error">Address Line 2 must be less than 255 characters.<div>');
                    error =1;
                }

                if (city == '') {
                    $("#redeem_city").after('<div id="mobile-error" class="error">City is required.<div>');
                    error =1;
                }else if (city.length > 255) {
                    $("#redeem_city").after('<div id="mobile-error" class="error">City must be less than 255 characters.<div>');
                    error =1;
                }

                if (state == '') {
                    $("#redeem_state").after('<div id="mobile-error" class="error">State is required.<div>');
                    error =1;
                }else if (address.length > 255) {
                    $("#redeem_state").after('<div id="mobile-error" class="error">State must be less than 255 characters.<div>');
                    error =1;
                }

                if (pincode == '') {
                    $("#redeem_pincode").after('<div id="mobile-error" class="error">Pincode is required.<div>');
                    error =1;
                }else if (address.length > 255) {
                    $("#redeem_pincode").after('<div id="mobile-error" class="error">Pincode must be less than 255 characters.<div>');
                    error =1;
                }

                if (landmark.length > 255) {
                    $("#redeem_landmark").after('<div id="mobile-error" class="error">Landmark must be less than 255 characters.<div>');
                    error =1;
                }


                if(error == 1){
                    return false;
                }else{
                    $.ajax({
                type: 'POST',
                url: "{{ url('/addPoints') }}",
                data: {
                    mobile: mobile,
                    product_id: product_id,
                    address: address,
                    address2: address2,
                    city: city,
                    state: state,
                    pincode: pincode,
                    landmark: landmark
                },
                success: function(data) {
                    if ($.isEmptyObject(data.error)) {
                        window.location.replace(data.url);
                    } else {
                        $("#spending_text").after('<span id="mobile-error" class="error">' + data.error + '<span>');
                    }
                }
            });
                }
        });


        $("#logout").click(function() {
            $.ajax({
                type: 'POST',
                url: "{{ url('/logout') }}",
                success: function(data) {
                    location.reload();
                }
            });
        });

        $("#resend_otp").click(function() {
            $("#resend_otp").prop("disabled", true);
            $('#resend_otp').hide();
            countdown1min();
            $("span.countdown").show();
            $("#resend_success").show();
            $("#otp_failed").hide();
            
            setTimeout(function() {
                $('#resend_otp').prop('disabled', false);
                $("span.countdown").hide();
                $('#resend_otp').show();
                
            }, 60000);
        });

        $(".btn-close").click(function() {
            if ($("#status").val() == 1) {
                location.reload();
            }
        });


        function countdown1min() {
            seconds = 60;
            $("span.countdown").show();
            var minutes = 00;
            clearInterval(count);
            count = setInterval(function() {
                if (parseInt(minutes) < 0) {
                    clearInterval(count);
                } else {
                    jQuery("span.countdown").html("Resend OTP in " + seconds + " second(s)");
                    if (seconds == 0) {
                        clearInterval(count);
                    }
                    seconds--;
                }
            }, 1000);

        }

        function sendOtp( mobile){
            // return true;
           
            $.ajax({
                type: 'POST',
                url: "{{ url('/sendOTP') }}",
                data: {
                    mobile: mobile
                },
                success: function(data) {
                  
                  if(data == 'Success'){
                    return true;
                  }
                  return 'Failed';
                }
            });
        }
    </script>


</x-storefront::layout>