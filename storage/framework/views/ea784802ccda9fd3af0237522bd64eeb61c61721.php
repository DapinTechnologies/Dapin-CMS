<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>College Update</title>
    <style>
        body {
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #ffffff; /* All text white */
            margin: 0;
            padding: 0;
            background-color: #0a192f;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: linear-gradient(135deg, #0a2463 0%, #1a365d 100%);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
        .header {
            padding: 40px 20px;
            text-align: center;
            background: rgba(0, 0, 0, 0.2);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .header img {
            max-width: 180px;
            height: auto;
        }
        .header h1 {
            margin: 20px 0 0;
            font-size: 28px;
            font-weight: 600;
            color: #ffffff;
        }
        .content {
            padding: 30px;
            color: #ffffff; /* Ensure content text is white */
        }
        .message-content {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            padding: 25px;
            margin: 25px 0;
            line-height: 1.7;
            color: #ffffff; /* Message text white */
        }
        .footer {
            padding: 25px;
            text-align: center;
            background: rgba(0, 0, 0, 0.3);
            font-size: 14px;
            color: #ffffff; /* Footer text white */
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        .footer a {
            color: #a3b2d3 !important; /* Slightly lighter for links */
        }
        .cta-button {
            display: inline-block;
            background: #3a7bd5;
            color: white !important;
            text-decoration: none;
            padding: 14px 28px;
            border-radius: 30px;
            font-weight: 600;
            margin: 20px 0;
            text-align: center;
            transition: all 0.3s ease;
        }
        .cta-button:hover {
            background: #00d2ff;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 210, 255, 0.3);
        }
        .social-icons {
            margin: 25px 0;
        }
        .social-icons a {
            display: inline-block;
            margin: 0 10px;
            color: #ffffff; /* Social icons white */
        }
        .social-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            color: #ffffff; /* Social icon symbols white */
        }
        .social-icon:hover {
            background: #3a7bd5;
            transform: translateY(-3px);
        }
        .divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.1);
            margin: 30px 0;
        }
        a {
            color: #a3b2d3; /* Links slightly lighter for visibility */
            text-decoration: none;
        }
        @media only screen and (max-width: 600px) {
            .content {
                padding: 20px;
            }
            .header h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <!-- Replace with your college logo -->
            <img src="https://via.placeholder.com/180x60/0a2463/ffffff?text=COLLEGE+LOGO" alt="College Logo">
            <h1>Latest College Update</h1>
        </div>
        
        <div class="content">
            <p>Dear Subscriber,</p>
            
            <div class="message-content">
                <?php echo nl2br(e($messageContent)); ?>

            </div>
            
            <!-- Optional CTA Button -->
            <center>
                <a href="https://yourcollege.edu/portal" class="cta-button">
                    Visit Student Portal
                </a>
            </center>
            
            <div class="divider"></div>
            
            <p>Stay connected with us for more updates and announcements.</p>
            
            <div class="social-icons">
                <a href="#"><span class="social-icon">📱</span></a>
                <a href="#"><span class="social-icon">💻</span></a>
                <a href="#"><span class="social-icon">📘</span></a>
                <a href="#"><span class="social-icon">📸</span></a>
            </div>
        </div>
        
        <div class="footer">
            <p>© 2025 Your College Management. All rights reserved.</p>
            <p>
                <a href="#">Privacy Policy</a> | 
                <a href="#">Terms of Service</a> | 
                <a href="#">Unsubscribe</a>
            </p>
            <p>123 College Avenue, Campus City, CC 12345</p>
        </div>
    </div>
</body>
</html><?php /**PATH C:\Users\User\Desktop\cms\Dapin-CMS\resources\views/emails/bulk_email.blade.php ENDPATH**/ ?>