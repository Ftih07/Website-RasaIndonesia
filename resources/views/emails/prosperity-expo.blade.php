<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indonesia-Australia Prosperity Expo 2025 - Registration Confirmation</title>
    <!--[if mso]>
    <noscript>
        <xml>
            <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
            </o:OfficeDocumentSettings>
        </xml>
    </noscript>
    <![endif]-->
</head>

<body style="margin: 0; padding: 0; background-color: #f8fafc; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;">

    <!-- Preheader -->
    <div style="display: none; font-size: 1px; color: #f8fafc; line-height: 1px; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;">
        Your registration for Indonesia-Australia Prosperity Expo 2025 has been confirmed. We look forward to seeing you there!
    </div>

    <!-- Main Container -->
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #f8fafc;">
        <tr>
            <td align="center" style="padding: 40px 20px;">

                <!-- Email Container -->
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="600" style="max-width: 600px; background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05); overflow: hidden;">

                    <!-- Header with Gradient -->
                    <tr>
                        <td align="center" style="background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #60a5fa 100%); padding: 40px 30px;">
                            <img src="https://tasteofindonesia.com.au/assets/images/logo/IAPEX_Logo.png" alt="Indonesia-Australia Prosperity Expo 2025" style="max-width: 180px; height: auto; display: block;">
                            <h1 style="color: #ffffff; font-size: 24px; font-weight: 700; margin: 20px 0 10px 0; text-align: center; line-height: 1.3;">
                                Indonesia-Australia<br>
                                <span style="font-size: 20px; font-weight: 600;">Prosperity Expo 2025</span>
                            </h1>
                            <p style="color: #e0f2fe; font-size: 14px; margin: 0; text-align: center; opacity: 0.9;">
                                Strengthening ties through trade, culture & sustainable growth
                            </p>
                        </td>
                    </tr>

                    <!-- Success Badge -->
                    <tr>
                        <td align="center" style="padding: 0; position: relative;">
                            <div style="background-color: #10b981; color: #ffffff; padding: 12px 24px; border-radius: 25px; font-size: 14px; font-weight: 600; margin: -20px auto 0; display: inline-block; box-shadow: 0 2px 4px rgba(16, 185, 129, 0.3);">
                                ✓ Registration Confirmed
                            </div>
                        </td>
                    </tr>

                    <!-- Main Content -->
                    <tr>
                        <td style="padding: 40px 30px 30px;">

                            <!-- Greeting -->
                            <h2 style="color: #1e40af; font-size: 22px; font-weight: 600; margin: 0 0 20px 0; line-height: 1.4;">
                                Dear {{ $data->recipient_name ?? 'Valued Participant' }},
                            </h2>

                            <!-- Main Message -->
                            <p style="color: #374151; font-size: 16px; line-height: 1.6; margin: 0 0 20px 0;">
                                We are delighted to confirm your registration for the <strong style="color: #1e40af;">Indonesia-Australia Prosperity Expo 2025</strong>. Thank you for joining us as a <strong style="color: #3b82f6;">{{ $data->participant_type ?? 'participant' }}</strong> in this landmark event that celebrates bilateral cooperation and sustainable economic growth.
                            </p>

                            @if($data->company_brand)
                            <!-- Company Information Box -->
                            <div style="background-color: #f1f5f9; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; margin: 25px 0;">
                                <h3 style="color: #1e40af; font-size: 16px; font-weight: 600; margin: 0 0 8px 0;">
                                    Organization Details
                                </h3>
                                <p style="color: #4b5563; font-size: 15px; margin: 0; font-weight: 500;">
                                    {{ $data->company_brand }}
                                </p>
                            </div>
                            @endif

                            @if($data->image)
                            <!-- Event Banner -->
                            <div style="text-align: center; margin: 30px 0;">
                                <img src="{{ asset('storage/'.$data->image) }}" alt="Event Information" style="max-width: 100%; height: auto; border-radius: 8px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
                            </div>
                            @endif

                            <!-- Call to Action -->
                            <div style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border-radius: 10px; padding: 25px; margin: 30px 0; text-align: center;">
                                <h3 style="color: #1e40af; font-size: 18px; font-weight: 600; margin: 0 0 15px 0;">
                                    Next Steps
                                </h3>
                                <p style="color: #4b5563; font-size: 15px; line-height: 1.5; margin: 0 0 20px 0;">
                                    Keep this link and scan the QR code at the event entrance.
                                </p>

                                <!-- CTA Button -->
                                <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center">
                                    <tr>
                                        <td style="border-radius: 8px; background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);">
                                            <a href="{{ $data->link ?? '#' }}" style="background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); color: #ffffff; text-decoration: none; padding: 14px 28px; border-radius: 8px; font-weight: 600; font-size: 16px; display: inline-block; box-shadow: 0 4px 6px rgba(59, 130, 246, 0.3); transition: all 0.3s ease;">
                                                View My Event Pass →
                                            </a>
                                        </td>
                                    </tr>
                                </table>

                                <!-- Important Notes -->
                                <div style="margin-top: 20px; text-align: left; background: #fff; padding: 15px; border: 1px dashed #3b82f6; border-radius: 8px;">
                                    <h4 style="margin: 0 0 10px 0; font-size: 15px; color: #1e40af;">Important Notes:</h4>
                                    <ul style="margin: 0; padding-left: 20px; color: #374151; font-size: 14px; line-height: 1.5;">
                                        <li>After you receive this email, please mark it as a star for this email.</li>
                                        <li>To enter the exhibition hall, please show this email or badge on your device. You are not required to print this email.</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Event Highlights -->
                            <div style="border-top: 2px solid #e5e7eb; padding-top: 25px; margin-top: 30px;">
                                <h3 style="color: #1e40af; font-size: 16px; font-weight: 600; margin: 0 0 15px 0;">
                                    What to Expect:
                                </h3>
                                <ul style="color: #4b5563; font-size: 15px; line-height: 1.6; margin: 0; padding-left: 20px;">
                                    <li style="margin-bottom: 8px;">Expanding economic collaboration opportunities</li>
                                    <li style="margin-bottom: 8px;">Strengthening tourism and cultural initiatives</li>
                                    <li style="margin-bottom: 8px;">Multi-sector partnerships in trade, education, and technology</li>
                                    <li>Sustainable growth and innovation showcase</li>
                                </ul>
                            </div>

                            <!-- Contact Information -->
                            <div style="background-color: #f8fafc; border-radius: 8px; padding: 20px; margin: 30px 0 0 0;">
                                <p style="color: #6b7280; font-size: 14px; line-height: 1.5; margin: 0 0 15px 0;">
                                    <strong style="color: #374151;">Need assistance?</strong> Our team is ready to help with any questions you may have about the event, logistics, or your participation.
                                </p>
                                <p style="color: #1e40af; font-size: 14px; margin: 0 0 8px 0; font-weight: 500;">
                                    Contact: sales.expo@kupu-gsc.co.id
                                </p>
                                <p style="color: #1e40af; font-size: 14px; margin: 0 0 5px 0; font-weight: 500;">
                                    📞 Agi: <a href="https://wa.me/6281573000739" style="color: #1e40af; text-decoration: none;">+62 815-7300-0739</a>
                                </p>
                                <p style="color: #1e40af; font-size: 14px; margin: 0; font-weight: 500;">
                                    📞 Dewi: <a href="https://wa.me/62818201311" style="color: #1e40af; text-decoration: none;">+62 818-201-311</a>
                                </p>
                            </div>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); padding: 30px; text-align: center;">
                            <p style="color: #ffffff; font-size: 16px; font-weight: 600; margin: 0 0 10px 0;">
                                We look forward to seeing you there!
                            </p>
                            <p style="color: #e0f2fe; font-size: 14px; margin: 0 0 20px 0;">
                                <strong>The Indonesia-Australia Prosperity Expo 2025 Team</strong>
                            </p>

                            <!-- Social Links Placeholder -->
                            <div style="margin: 20px 0;">
                                <a href="https://tasteofindonesia.com.au/prosperity-expo" style="color: #ffffff; text-decoration: none; margin: 0 10px; font-size: 14px;">Register</a>
                                <span style="color: #e0f2fe;">|</span>
                                <a href="https://prosperity-expo.com/" style="color: #ffffff; text-decoration: none; margin: 0 10px; font-size: 14px;">Website</a>
                            </div>
                        </td>
                    </tr>

                    <!-- Copyright -->
                    <tr>
                        <td align="center" style="background-color: #f1f5f9; padding: 20px; border-top: 1px solid #e5e7eb;">
                            <p style="color: #6b7280; font-size: 12px; margin: 0; line-height: 1.4;">
                                © {{ date('Y') }} Indonesia-Australia Prosperity Expo. All rights reserved.<br>
                                <span style="color: #9ca3af;">This email was sent to confirm your event registration. Please do not reply to this automated message.</span>
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

    <!-- Outlook-specific styles -->
    <!--[if mso]>
    <style type="text/css">
        table {border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt;}
        td {border-collapse: collapse;}
    </style>
    <![endif]-->

</body>

</html>