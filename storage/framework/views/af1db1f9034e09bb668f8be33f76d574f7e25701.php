<!DOCTYPE html>
<html>
<head>
    <title>Inquiry Received</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { color: #225691; font-size: 24px; margin-bottom: 20px; }
        .footer { margin-top: 30px; font-size: 14px; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Hello <?php echo e($inquiry->name); ?>,</div>
        
        <p>We've received your inquiry and wanted to let you know it's being processed.</p>
        
        <p><strong>Your Details:</strong></p>
        <ul>
            <li><strong>Name:</strong> <?php echo e($inquiry->name); ?></li>
            <li><strong>Phone:</strong> <?php echo e($inquiry->phone); ?></li>
            <li><strong>Email:</strong> <?php echo e($inquiry->email); ?></li>
        </ul>
        
        <p><strong>Your Message:</strong><br>
        <?php echo e($inquiry->message); ?></p>
        
        <p>Our team will review your inquiry and get back to you within 24-48 hours.</p>
        
        <div class="footer">
            <p>Best regards,<br>
            The College Front Office Team</p>
            
            <p>Contact us if you have any questions:<br>
            Email: info@college.ac.ke<br>
            Phone: +254 XXX XXX XXX</p>
        </div>
    </div>
</body>
</html><?php /**PATH C:\Users\User\Desktop\cms\Dapin-CMS\resources\views/emails/inquiry_confirmation.blade.php ENDPATH**/ ?>