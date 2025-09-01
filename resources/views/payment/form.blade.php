<!DOCTYPE html>
<html>
<head>
    <title>Car Rental Payment</title>
</head>
<body>
    <h2>ادفع الآن</h2>
    <form method="POST" action="{{ route('payment.process') }}">
        @csrf
        <label>المبلغ:</label>
        <input type="text" name="amount" value="100.00">
        <button type="submit">ادفع</button>
    </form>
</body>
</html>
