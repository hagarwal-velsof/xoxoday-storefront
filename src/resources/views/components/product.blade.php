<div class="col-md-4 col-sm-6">
  <div class="prize-card">
  <div class="desc">
    <div class="image-area">
      <picture>
        <source>
        <x-storefront::img class="img" src="{{ $image }}" alt="{{ $name}}"></x-storefront::img>
      </picture>
    </div>
    <div class="content-area">
      <p>{{ $name}}</p>
      <div class="badge">{{ $points }} LP</div>
  </div>
</div>
      @if($user == 1)
        @if($progress == 1)
        <x-storefront::buttonDisabled class="btn" value="">Claim IN-PROGRESS</x-storefront::buttonDisabled>
        @elseif($totalpoints >= $points)
        <a href="javascript://" class="modal-button claim-btn claim-request" data-product='{{ $id }}' data-points='{{ $points }}'>Claim for {{ $points }} Points</a>
        @else
        <x-storefront::buttonDisabled class="" value="">Not enough points</x-storefront::buttonDisabled>
        @endif
      @else
        <a href="javascript://" class="modal-button claim-btn claim-btn-model" id='loginToClaim' data-value='{{ $id }}' style="">Login to Claim</a>
      @endif
    </div>
  
</div>