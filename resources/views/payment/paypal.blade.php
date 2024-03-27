<div id="paypal-button-container"></div>

<script src="https://www.paypal.com/sdk/js?client-id={{ config('paypal.' . config('paypal.mode') . '.client_id') }}&currency={{ config('paypal.currency') }}"></script>


@vite(['resources/js/payment/paypal.js'])
