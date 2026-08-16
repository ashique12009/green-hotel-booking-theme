<?php
/**
 * CTA Admin Notification Email Template
 * Expected variables:
 * $email
 */
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New CTA Signup</title>
</head>
<body style="font-family:Arial,Helvetica,sans-serif;background:#f5f5f5;padding:30px;">

<table width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center">

            <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:6px;">
                <tr>
                    <td style="background:#0d6efd;color:#ffffff;padding:20px;text-align:center;">
                        <h2 style="margin:0;">New CTA Signup 📩</h2>
                    </td>
                </tr>

                <tr>
                    <td style="padding:25px;color:#333;">
                        <p>A new user has subscribed via the CTA form.</p>

                        <p>
                            <strong>Email:</strong><br>
                            <?php echo esc_html($email); ?>
                        </p>
                    </td>
                </tr>

                <tr>
                    <td style="background:#f0f0f0;padding:15px;text-align:center;font-size:12px;color:#777;">
                        © <?php echo date('Y'); ?> <?php echo esc_html(get_bloginfo('name')); ?>
                    </td>
                </tr>
            </table>

        </td>
    </tr>
</table>

</body>
</html>