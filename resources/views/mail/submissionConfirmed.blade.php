<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submission Confirmed</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td align="center" style="padding: 20px 0;">
                <table border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse; background-color: #ffffff; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                    <tr>
                        <td align="center" bgcolor="#C084FC" style="padding: 10px 0; color: #ffffff; font-size: 24px; font-weight: bold;">
                            Claim System
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding: 20px 0 10px 0; font-size: 20px; color: #5B21B6;">
                            <strong>Submission Confirmed: Overtime/Meal Claim for {{$duty_date}}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 20px 30px 40px 30px;">
                            <p style="font-size: 16px; line-height: 24px; color: #333333;">
                                Dear {{$staff_name}},
                            </p>
                            <p style="font-size: 16px; line-height: 24px; color: #333333;">
                                Thank you for submitting your Overtime/Meal Claim. Your submission is now in the system and has been moved to <strong style="color: #E11D48;">Pending Approval</strong> status. Management has been notified and will review it shortly.
                            </p>
                            <p style="font-size: 16px; line-height: 24px; color: #333333;">
                                <strong>Claim Details:</strong><br>
                                &bull; <strong>Claim ID:</strong> {{$claim_referenceNo}}<br>
                                &bull; <strong>Date of Duty:</strong> {{$duty_date}}<br>
                                &bull; <strong>Type:</strong> {{$claim_type}} (Overtime, Meal, or Both)
                            </p>
                            <p style="font-size: 16px; line-height: 24px; color: #333333;">
                                You can track the claim status at any time using the link below.
                            </p>

                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-top: 20px;">
                                <tr>
                                    <td align="center">
                                        <a href="{{$claim_link}}" style="display: inline-block; padding: 10px 20px; font-size: 16px; color: #ffffff; background-color: #E11D48; border-radius: 5px; text-decoration: none;">
                                            <strong>View Claim Status</strong>
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#f4f4f4" align="center" style="padding: 20px 30px; font-size: 12px; color: #999999; border-top: 1px solid #eeeeee;">
                            This is an automated notification. Please do not reply.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>