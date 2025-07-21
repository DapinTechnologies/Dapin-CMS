<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Confirmation</title>
    <style>
        body {
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #444;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        .header {
            background: linear-gradient(135deg, #0a2463 0%, #1e4d8e 100%);
            color: white;
            padding: 40px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        .header p {
            margin: 10px 0 0;
            opacity: 0.9;
            font-size: 16px;
        }
        .content {
            padding: 40px;
        }
        .welcome-text {
            font-size: 18px;
            margin-bottom: 25px;
            color: #333;
        }
        .highlight {
            color: #1e4d8e;
            font-weight: 600;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #0a2463 0%, #1e4d8e 100%);
            color: white !important;
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 30px;
            font-weight: 600;
            margin: 20px 0;
            text-align: center;
        }
        .benefits {
            background: #f5f8ff;
            border-radius: 8px;
            padding: 20px;
            margin: 30px 0;
        }
        .benefits h3 {
            color: #0a2463;
            margin-top: 0;
        }
        .benefits ul {
            padding-left: 20px;
        }
        .benefits li {
            margin-bottom: 8px;
        }
        .footer {
            background: #f1f3f5;
            padding: 25px;
            text-align: center;
            font-size: 14px;
            color: #666;
        }
        .social-icons {
            margin: 15px 0;
        }
        .social-icons a {
            display: inline-block;
            margin: 0 8px;
        }
        .divider {
            height: 1px;
            background: #e1e5eb;
            margin: 25px 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Welcome Aboard!</h1>
            <p>Your subscription to our newsletter is confirmed</p>
        </div>
        
        <div class="content">
            <p class="welcome-text">Hi <span class="highlight"><?php echo e($email); ?></span>,</p>
            
            <p>Thank you for subscribing to our newsletter! We're thrilled to have you as part of our community.</p>
            
            <p>You'll now receive exclusive updates, valuable insights, and early access to our latest courses and events.</p>
            
            <div class="benefits">
                <h3>What to expect:</h3>
                <ul>
                    <li>Weekly curated content and industry insights</li>
                    <li>Exclusive discounts and early-bird offers</li>
                    <li>Invitations to special events and webinars</li>
                    <li>Helpful tips and resources</li>
                </ul>
            </div>
            
            <center>
                <a href="#" class="cta-button">Explore Our Courses</a>
            </center>
            
            <div class="divider"></div>
            
            <p>If you ever change your mind, you can unsubscribe at any time using the link in our emails.</p>
            
            <p>Best regards,<br><strong>The Team at Your Company Name</strong></p>
        </div>
        
        <div class="footer">
            <div class="social-icons">
                <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/124/124010.png" width="24" alt="Facebook"></a>
                <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/733/733579.png" width="24" alt="Twitter"></a>
                <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/2111/2111463.png" width="24" alt="Instagram"></a>
                <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/3536/3536505.png" width="24" alt="LinkedIn"></a>
            </div>
            <p>© 2023 College System. All rights reserved.</p>
            <p>
                <a href="#" style="color: #1e4d8e; text-decoration: none;">Privacy Policy</a> | 
                <a href="#" style="color: #1e4d8e; text-decoration: none;">Terms of Service</a> | 
                <a href="#" style="color: #1e4d8e; text-decoration: none;">Unsubscribe</a>
            </p>
            <p>123 Nairobi Dapin Street, City, Country</p>
        </div>
    </div>
</body>
</html><?php /**PATH C:\Users\User\Desktop\cms\Dapin-CMS\resources\views/emails/subscription_confirmation.blade.php ENDPATH**/ ?>