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
        
        @if ($mailData['delivery_type'] == 'third_party')
        <p><strong>Third Party Details:</strong> {{ ucfirst($mailData['third_party_details']) }}</p>
        @endif
       
        @if ($mailData['delivery_type'] == 'delivery')
        <p><strong>Courier/Delivery Company:</strong> {{ ucfirst($mailData['courier_company']) }}</p>
        <p><strong>AWB No.:</strong> {{ ucfirst($mailData['awb_number']) }}</p>
        <p><strong>Download AWB Bill: </strong> <a href={{ url($mailData['deliver_bill_upload']) }} target="_Blank">Click here </a></p>
        @endif
        
        <p><strong>Remarks:</strong> {{ $mailData['order_remarks'] }}</p>
        
        
        <p>You can check order details under order section.</p>
        
        <p>You can log in to your account by visiting our website at: <a href="https://shamsnaturals.com/">https://shamsnaturals.com/</a></p>
    
        
        <p>Best regards,<br>
        The Sham Naturals Team</p>
    </div>

</body>
</html>
