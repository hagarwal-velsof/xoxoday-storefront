<header>
    <div class="header container-lg">
    @csrf
        <section class="header-left">
            <a href="{{ url('/redemption') }}" ><img class="header-logo" src="{{asset('theme/assets/img/alcobrew-logo.png')}}" alt="ALCOBREW"></a>
        </section>
        <section class="header-right">
            @if($user == 1)
            <div class="action-buttons">
                <p>You Have <i class="ms-1 fa fa-arrow-right"></i> </p>
                <a class="loyality-btn">{{ $totalpoints }} Loyalty Points <i class="ms-1 fa fa-star"></i> </a>
                <x-storefront::loginbutton class="logout-btn" id="logout">Logout <i class="ms-1 fa fa-sign-out"></i> </x-storefront::loginbutton>
            </div>
            <button type="button" class="toggle-options"><i class="fa fa-bars" aria-hidden="true"></i></button>
            @else
            <p>Login here to use your Loyalty Points <i class="ms-1 fa fa-arrow-right"></i> </p>
            <x-storefront::button class="login-btn modal-button claim-btn-model" id="login_btn" value="" style="">Login <i class="ms-1 fa fa-user"></i></x-storefront::button>
            @endif
        </section>
    </div>
</header>
