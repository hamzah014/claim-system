<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Deadline Reminder</title>
</head>

<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td align="center" style="padding: 20px 0;">
                <table border="0" cellpadding="0" cellspacing="0" width="600"
                    style="border-collapse: collapse; background-color: #ffffff; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                    <tr>
                        <td align="center" bgcolor="#C084FC"
                            style="padding: 10px 0; color: #ffffff; font-size: 24px; font-weight: bold;">
                            Claim System
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding: 20px 0 10px 0; font-size: 20px; color: #5B21B6;">
                            <strong>🔔 Important Reminder: Monthly Claim Submission Deadline Approaching</strong>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 20px 30px 40px 30px;">
                            <p style="font-size: 16px; line-height: 24px; color: #333333;">
                                Dear {{ $staff_name }},
                            </p>
                            <p style="font-size: 16px; line-height: 24px; color: #333333;">
                                This is a reminder that the deadline for Overtime/Meal Claims to be processed in the
                                <strong style="color: #E11D48;">current salary cycle is the {{ $date_salary }}th of
                                    this month</strong>.
                            </p>
                            <p
                                style="font-size: 16px; line-height: 24px; color: #333333; background-color: #F3F4F6; padding: 10px; border-radius: 5px;">
                                <strong>Submission Deadline:</strong> <span
                                    style="color: #5B21B6;">{{ $dateline }}</span>, 11:59 PM
                            </p>
                            <p style="font-size: 16px; line-height: 24px; color: #333333;">
                                Claims submitted after the 9th will roll into the next month's payroll. Please ensure
                                all eligible claims are submitted soon.
                            </p>

                            <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                style="margin-top: 20px;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ $claim_link }}"
                                            style="display: inline-block; padding: 10px 20px; font-size: 16px; color: #ffffff; background-color: #E11D48; border-radius: 5px; text-decoration: none;">
                                            <strong>Quick Submit New Claim</strong>
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#f4f4f4" align="center"
                            style="padding: 20px 30px; font-size: 12px; color: #999999; border-top: 1px solid #eeeeee;">
                            Check your dashboard for your deadline countdown widget.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
