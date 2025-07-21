
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enquiry Received</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333333;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 0;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: #0a2463;
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px;
        }
        .message-box {
            background: #f8f9fa;
            border-left: 4px solid #3e92cc;
            padding: 15px;
            margin: 20px 0;
        }
        .footer {
            background: #f1f1f1;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #666666;
        }
        .details {
            margin-bottom: 20px;
        }
        .details p {
            margin: 8px 0;
        }
        .highlight {
            color: #0a2463;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Enquiry Received</h1>
            <p>We appreciate you reaching out to us!</p>
        </div>
        
        <div class="content">
            <p>Dear <span class="highlight"><?php echo e($inquiry->name); ?></span>,</p>
            
            <p>Thank you for contacting us. We have received your enquiry and our Front Office team is working around the clock to review your request and provide you with feedback as soon as possible.</p>
            
            <div class="details">
                <h3>Your enquiry details:</h3>
                <p><strong>Name:</strong> <?php echo e($inquiry->name); ?></p>
                <p><strong>Phone:</strong> <?php echo e($inquiry->phone); ?></p>
                <p><strong>Email:</strong> <?php echo e($inquiry->email); ?></p>
                <p><strong>Message:</strong></p>
                <div class="message-box">
                    <p><?php echo e($inquiry->message); ?></p>
                </div>
            </div>
            
            <p>We typically respond within 24-48 hours. If you have any urgent questions, please don't hesitate to contact us directly.</p>
            
            <p>Best regards,<br>The Front Office Team</p>
        </div>
        
        <div class="footer">
            <p>© 2025 Dapin. All rights reserved.</p>
            <p>If you did not make this enquiry, please ignore this email.</p>
        </div>
    </div>
</body>
</html><?php /**PATH C:\Users\User\Desktop\cms\Dapin-CMS\resources\views/emails/received.blade.php ENDPATH**/ ?>