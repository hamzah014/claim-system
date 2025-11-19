<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Action Required: New Claim</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td align="center" style="padding: 20px 0;">
                <table border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse; background-color: #ffffff; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                    <tr>
                        <td align="center" bgcolor="#9333ea" style="padding: 10px 0; color: #ffffff; font-size: 24px; font-weight: bold;">
                            Claim System
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding: 20px 0 10px 0; font-size: 20px; color: #5B21B6;">
                            <strong>🚨 Action Required: New Overtime/Meal Claim from {{$staff_name}}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 20px 30px 40px 30px;">
                            <p style="font-size: 16px; line-height: 24px; color: #333333;">
                                Dear {{$approver_name}},
                            </p>
                            <p style="font-size: 16px; line-height: 24px; color: #333333;">
                                A new Overtime/Meal Claim has been submitted by <strong style="color: #E11D48;">{{$staff_name}}</strong> and requires your review.
                            </p>
                            <p style="font-size: 16px; line-height: 24px; color: #333333;">
                                Please review the details, attached documents, and calculated amounts in the application.
                            </p>
                            <p style="font-size: 16px; line-height: 24px; color: #333333;">
                                <strong>Claim Summary:</strong><br>
                                &bull; <strong>Staff Member:</strong> {{$staff_name}}<br>
                                &bull; <strong>Date of Submission:</strong> {{$submit_date}}<br>
                                &bull; <strong>Date of Duty:</strong> {{$duty_date}}<br>
                                &bull; <strong>Estimated Total:</strong> {{$total_amount}}
                            </p>

                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-top: 30px;">
                                <tr>
                                    <td align="center">
                                        <a href="{{$claim_link}}" style="display: inline-block; padding: 10px 20px; font-size: 16px; color: #5B21B6; background-color: #ffffff; border: 1px solid #5B21B6; border-radius: 5px; text-decoration: none;">
                                            View Claim Details
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>