<!DOCTYPE html>
<html>
<head>
    <title>Pay with 2Checkout</title>
</head>
<body>
    <h1>Car Rental Payment</h1>
    <form method="POST" action="{{ route('payment.process') }}">
        @csrf
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Your Email" required>
        <button type="submit">Pay $100</button>
    </form>
</body>
</html>
