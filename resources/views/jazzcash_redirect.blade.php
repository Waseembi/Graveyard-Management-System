 {{-- <form method="post" action="https://sandbox.jazzcash.com.pk/CustomerPortal/transactionmanagement/merchantform">
    @foreach($postData as $key => $value)
        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
    @endforeach
    <button type="submit">Pay Now</button>
</form> 
  --}}

  <!DOCTYPE html>
<html>
<head>
    <title>Redirecting to JazzCash...</title>
</head>
<body onload="document.forms['jazzcash_form'].submit()">
    <p>Please wait, redirecting to JazzCash...</p>
    <form name="jazzcash_form" method="POST" action="https://sandbox.jazzcash.com.pk/CustomerPortal/transactionmanagement/merchantform">
    @foreach($postData as $key => $value)
        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
    @endforeach
    <noscript>
        <button type="submit">Click here if not redirected</button>
    </noscript>
</form>

</body>
</html>
