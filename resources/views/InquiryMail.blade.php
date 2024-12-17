<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Inquiry</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333333; max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f4f4f4;">
    <table cellpadding="0" cellspacing="0" width="100%" style="background-color: #ffffff; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
        <tr>
            <td style="padding: 20px;">
                <h1 style="color: #0056b3; border-bottom: 2px solid #0056b3; padding-bottom: 10px; margin-top: 0;">New Contact Inquiry</h1>
                
                <table cellpadding="5" cellspacing="0" width="100%" style="margin-top: 20px;">
                    <tr>
                        <td width="30%" style="font-weight: bold;">First Name:</td>
                        <td width="70%">{{ $contactDetails['firstname'] }}</td>
                    </tr>
                    <tr style="background-color: #f8f8f8;">
                        <td width="30%" style="font-weight: bold;">Last Name:</td>
                        <td width="70%">{{ $contactDetails['lastname'] }}</td>
                    </tr>
                    <tr>
                        <td width="30%" style="font-weight: bold;">Email:</td>
                        <td width="70%"><a href="mailto:{{ $contactDetails['email'] }}" style="color: #0056b3; text-decoration: none;">{{ $contactDetails['email'] }}</a></td>
                    </tr>
                    <tr style="background-color: #f8f8f8;">
                        <td width="30%" style="font-weight: bold;">Phone Number:</td>
                        <td width="70%">{{ $contactDetails['number'] }}</td>
                    </tr>
                    <tr>
                        <td width="30%" style="font-weight: bold;">Property Name:</td>
                        <td width="70%">{{ $contactDetails['property_name'] }}</td>
                    </tr>
                    <tr style="background-color: #f8f8f8;">
                        <td width="30%" style="font-weight: bold;">Unit Type:</td>
                        <td width="70%">{{ $contactDetails['unit_type'] }}</td>
                    </tr>
                    <tr>
                        <td width="30%" style="font-weight: bold;">Property Location:</td>
                        <td width="70%">{{ $contactDetails['property_location'] }}</td>
                    </tr>
                </table>
                
                <div style="margin-top: 20px; background-color: #f8f8f8; padding: 15px; border-radius: 5px;">
                    <h2 style="color: #0056b3; margin-top: 0;">Message:</h2>
                    <p style="margin-bottom: 0;">{{ $contactDetails['message'] }}</p>
                </div>
                
                <div style="margin-top: 30px; text-align: center; font-size: 12px; color: #666666;">
                    <p>This is an automated message. Please do not reply to this email.</p>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>