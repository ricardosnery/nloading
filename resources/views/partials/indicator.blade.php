@if (filled($spinner))
    <img class="nloading-overlay__spinner-icon" src="{{ $spinner }}" alt="" />
@else
    <span class="nloading-overlay__spinner" aria-hidden="true"></span>
@endif
