<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Order Details</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">

    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 20px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
        <h2 style="color: #333;">New Order Details</h2>
        <p>Hello Admin,</p>
        <p>You have received a new order:</p>
        
        <p><strong>Order Id:</strong> {{ $mailData['order_id'] }}</p>
        <p><strong>Dealer Name:</strong> {{ $mailData['dealer_name'] }}</p>
        
        <p>You can check order details under order section.</p>
        
        <p>You can log in to your account by visiting our website at: <a href="https://shamsnaturals.com/">https://shamsnaturals.com/</a></p>
    
        
        <p>Best regards,<br>
        The Sham Naturals Team</p>
    </div>

</body>
</html>
