<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Claim Approved</title>
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
                        <td align="center" style="padding: 20px 0 10px 0; font-size: 20px; color: #10B981;">
                            <strong>✅ Claim Approved: Your Submission for {{$duty_date}}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 20px 30px 40px 30px;">
                            <p style="font-size: 16px; line-height: 24px; color: #333333;">
                                Dear {{$staff_name}},
                            </p>
                            <p style="font-size: 16px; line-height: 24px; color: #333333;">
                                Good news! Your Overtime/Meal Claim ({{$claim_refno}}) has been <strong style="color: #10B981;">Approved</strong> by {{$approver_name}}.
                            </p>
                            <p style="font-size: 16px; line-height: 24px; color: #333333;">
                                The claim has now entered the **HR processing queue**. Please allow time for HR and Payroll to process the payment according to the monthly cycle.
                            </p>
                            <p style="font-size: 16px; line-height: 24px; color: #333333; border-left: 3px solid #C084FC; padding-left: 15px;">
                                <strong>Approver Remarks (if provided):</strong><br>
                                <em>{{$approve_remark}}</em>
                            </p>

                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-top: 20px;">
                                <tr>
                                    <td align="center">
                                        <a href="{{$claim_link}}" style="display: inline-block; padding: 10px 20px; font-size: 16px; color: #ffffff; background-color: #E11D48; border-radius: 5px; text-decoration: none;">
                                            <strong>View Claim History</strong>
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#f4f4f4" align="center" style="padding: 20px 30px; font-size: 12px; color: #999999; border-top: 1px solid #eeeeee;">
                            Next Status: HR Processing.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>