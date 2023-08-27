<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Update Details</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">

    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 20px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
        <h2 style="color: #333;">Order Update Details</h2>
        <p>Hello {{ $mailData['dealer_name'] }},</p>
        <p>There is an update on order id <strong>{{ $mailData['order_id']}}</strong>:</p>
        
        <p><strong>Status:</strong> {{ ucfirst($mailData['order_status']) }}</p>
        <p><strong>Remarks:</strong> {{ $mailData['order_remarks'] }}</p>
        
        <p>You can check order details under order section.</p>
        
        <p>You can log in to your account by visiting our website at: <a href="https://shamsnatural.com/">https://shamsnatural.com/</a></p>
    
        
        <p>Best regards,<br>
        The Sham Naturals Team</p>
    </div>

</body>
</html>
