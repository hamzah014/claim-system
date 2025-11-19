<div wire:poll.60000ms="updateCountdown">
    <h2
        class="text-3xl font-extrabold @if (str_contains($countdownMessage, '24 HOURS')) text-pink-600 animate-pulse @else text-red-600 @endif">
        {{ $countdownMessage }}
    </h2>
</div>
