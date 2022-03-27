<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Pay $1000</title>
    <script src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_LIVE_CLIENT_ID') }}"></script>
</head>

<body>
    <form method="POST" action="{{ route('paypalIndex') }}">
        @csrf
        <button type="submit" class="btn btn-primary">Pay</button>
    </form>
</body>

</html>
