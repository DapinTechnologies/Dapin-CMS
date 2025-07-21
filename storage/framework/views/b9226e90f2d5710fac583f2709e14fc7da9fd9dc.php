<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reply to Your Inquiry</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            color: #0a2463;
        }
        blockquote {
            background: #f5f5f5;
            border-left: 4px solid #0a2463;
            padding: 15px;
            margin: 20px 0;
            font-style: italic;
        }
        .footer {
            margin-top: 30px;
            color: #666;
        }
    </style>
</head>
<body>
    <h1>Dear <?php echo e($inquiry->name); ?>,</h1>
    <p>We have received your inquiry, and here is our response:</p>
    
    <blockquote>
        <?php if(is_string($replyMessage)): ?>
            <?php echo nl2br(e($replyMessage)); ?>

        <?php else: ?>
            <?php echo nl2br(e($replyMessage->toString())); ?>

        <?php endif; ?>
    </blockquote>
    
    <p>If you have any further questions, please don't hesitate to contact us.</p>
    
    <div class="footer">
        <p>Thank you for reaching out!</p>
        <p>Best Regards,<br><strong>Front Office Team</strong></p>
    </div>
</body>
</html><?php /**PATH C:\Users\User\Desktop\cms\Dapin-CMS\resources\views/emails/inquiry_reply.blade.php ENDPATH**/ ?>