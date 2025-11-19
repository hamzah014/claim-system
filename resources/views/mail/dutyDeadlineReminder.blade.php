<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deadline Warning</title>
</head>

<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td align="center" style="padding: 20px 0;">
                <table border="0" cellpadding="0" cellspacing="0" width="600"
                    style="border-collapse: collapse; background-color: #ffffff; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                    <tr>
                        <td align="center" bgcolor="#9333ea"
                            style="padding: 10px 0; color: #ffffff; font-size: 24px; font-weight: bold;">
                            Claim System
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding: 20px 0 10px 0; font-size: 20px; color: #E11D48;">
                            <strong>⚠️ Warning: Claim Eligibility Deadline Approaching</strong>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 20px 30px 40px 30px;">
                            <p style="font-size: 16px; line-height: 24px; color: #333333;">
                                Dear {{$staff_name}},
                            </p>
                            <p style="font-size: 16px; line-height: 24px; color: #333333;">
                                The {{$allow_days}}-days submission window for a potential claim related to work performed on
                                <strong>{{$duty_date}}</strong> is about to expire.
                            </p>
                            <p
                                style="font-size: 16px; line-height: 24px; color: #333333; background-color: #FEF2F2; padding: 10px; border: 1px dashed #FBCFE8; border-radius: 5px;">
                                Claims must be submitted within {{$allow_days}} days from the date of duty. If you do not submit a
                                claim for this date within the next <strong style="color: #E11D48;">7 days</strong>, it
                                will no longer be valid.
                            </p>
                            <p style="font-size: 16px; line-height: 24px; color: #333333;">
                                <strong>Duty Date:</strong> {{$duty_date}}<br>
                                <strong>Final Submission Deadline:</strong> <strong
                                    style="color: #E11D48;">{{$expired_date}}</strong>
                            </p>

                            <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                style="margin-top: 20px;">
                                <tr>
                                    <td align="center">
                                        <a href="{{$claim_link}}"
                                            style="display: inline-block; padding: 10px 20px; font-size: 16px; color: #ffffff; background-color: #E11D48; border-radius: 5px; text-decoration: none;">
                                            <strong>Submit Claim for {{$duty_date}}</strong>
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#f4f4f4" align="center"
                            style="padding: 20px 30px; font-size: 12px; color: #999999; border-top: 1px solid #eeeeee;">
                            Do not miss this critical submission deadline.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
