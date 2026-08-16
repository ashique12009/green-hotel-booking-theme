<?php
/**
 * Booking Confirmation Email Template
 * Variables expected:
 * $name, $room_title, $checkin, $checkout, $nights, $total_price
 */
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Booking Confirmation</title>
</head>
<body style="margin:0;padding:0;background:#f5f5f5;font-family:Arial,Helvetica,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center" style="padding:40px 0;">

            <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:6px;overflow:hidden;">
                
                <!-- Header -->
                <tr>
                    <td style="background:#1e7e34;color:#ffffff;padding:20px;text-align:center;">
                        <h1 style="margin:0;font-size:22px;">Booking Confirmed ✅</h1>
                    </td>
                </tr>

                <!-- Body -->
                <tr>
                    <td style="padding:25px;color:#333;">
                        <p style="font-size:16px;">Dear <strong><?php echo esc_html($name); ?></strong>,</p>

                        <p>Your booking has been successfully confirmed. Here are your booking details:</p>

                        <table width="100%" cellpadding="6" cellspacing="0" style="border-collapse:collapse;">
                            <tr>
                                <td><strong>Room</strong></td>
                                <td><?php echo esc_html($room_title); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Check-in</strong></td>
                                <td><?php echo esc_html($checkin); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Check-out</strong></td>
                                <td><?php echo esc_html($checkout); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Nights</strong></td>
                                <td><?php echo esc_html($nights); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Total Price</strong></td>
                                <td><strong>€<?php echo esc_html($total_price); ?></strong></td>
                            </tr>
                        </table>

                        <p style="margin-top:20px;">
                            Thank you for choosing us. We look forward to welcoming you!
                        </p>

                        <p style="margin-top:30px;">
                            Kind regards,<br>
                            <strong><?php echo esc_html(get_bloginfo('name')); ?></strong>
                        </p>
                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="background:#f0f0f0;padding:15px;text-align:center;font-size:12px;color:#777;">
                        © <?php echo date('Y'); ?> <?php echo esc_html(get_bloginfo('name')); ?>. All rights reserved.
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>