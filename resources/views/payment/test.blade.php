<form action="{{ route('payment.initiate') }}" method="GET">
    <input type="hidden" name="amount" value="200.00">
    <input type="hidden" name="name" value="Hariom Birla">
    <input type="hidden" name="email" value="hariom@example.com">
    <input type="hidden" name="phone" value="9999999999">
    <button type="submit">Pay ₹200</button>
</form>