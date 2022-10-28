<x-storefront::layout>
    
    <link rel="stylesheet" href="{{asset('theme/assets/css/order_confirmed.css')}}">

    <x-storefront::header user='{{ $user_bit }}' totalpoints='{{ $total_points }}'></x-storefront::header>

    <main class="main-section">
    <div>
      <img src="{{asset('theme/assets/img/Merch.png')}}" class="box-img" alt="Order Confirmed">
    </div>
    <h2 class="main-msg">Hurray! Your order is confirmed</h2>
    <div class="product-card">
      <img src="{{ $product->image }}" alt="product image">
      <p>{{ $product->name }}</p>
    </div>
    <p class="bottom-text">You will recieve an order confirmation email shortly with all the necessary details.</p>
    </main>
    <script>
         $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $("input[name='_token']").val()
                }
            });
    $("#logout").click(function() {
            $.ajax({
                type: 'POST',
                url: "{{ url('/logout') }}",
                success: function(data) {
                    window.location.replace('{{ url('/redemption') }}');
                }
            });
        });
        </script>


    
</x-storefront::layout>


