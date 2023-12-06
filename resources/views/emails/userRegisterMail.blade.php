<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Website - Login Details</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">

    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 20px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
        <h2 style="color: #333;">Your Website - Login Details</h2>
        <p>Hello {{ $mailData['name'] }},</p>
        <p>We are delighted to extend a warm welcome to you on behalf of Shams Naturals. We value your support and contribution to our business and we encourage you to share your thoughts with us so that we can continue to improve and grow together.
            We are excited to embark on this journey to work closely with you to deliver outstanding results.</p>
        <p>Here are your login details for our website:</p>
        
        <p><strong>Username:</strong> {{ $mailData['useremail'] }}</p>
        <p><strong>Password:</strong> {{ $mailData['password'] }}</p>
        
        <p>Please keep your login details secure and do not share them with anyone.</p>
        
        <p>You can log in to your account by visiting our website at: <a href="https://shamsnaturals.com/">https://shamsnaturals.com/</a></p>
    
        
        <p>Best regards,<br>
        The Sham Naturals Team</p>
    </div>

</body>
</html>
