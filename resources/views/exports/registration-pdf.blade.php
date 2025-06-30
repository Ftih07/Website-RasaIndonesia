<!DOCTYPE html>
<html>

<head>
    <title>Registration Confirmation</title>
    <meta charset="UTF-8">
    {{-- This Blade view is designed to be converted into a PDF document using Barryvdh\DomPDF.
         Therefore, it uses inline CSS and direct image paths suitable for PDF rendering. --}}
    <style>
        /* Basic Body Styling for the PDF */
        body {
            font-family: Arial, sans-serif;
            /* Standard font for broad compatibility */
            margin: 40px;
            /* Margin around the entire document */
            line-height: 1.5;
            /* Standard line height for readability */
            color: #333;
            /* Dark gray text color */
        }

        /* Header Section Styling */
        .header {
            text-align: center;
            border-bottom: 3px solid #2c5aa0;
            /* Thick blue bottom border */
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        /* Logo/Main Title in Header */
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #2c5aa0;
            /* Blue color for the logo text */
            margin: 0;
        }

        /* Subtitle in Header */
        .subtitle {
            font-size: 14px;
            color: #666;
            margin: 5px 0 0 0;
        }

        /* Confirmation Title Section */
        .confirmation-title {
            font-size: 18px;
            font-weight: bold;
            color: #2c5aa0;
            margin: 20px 0 10px 0;
            text-align: center;
            background-color: #f0f4f8;
            /* Light gray background */
            padding: 10px;
            border: 1px solid #ddd;
        }

        /* Participant Information Section Wrapper */
        .participant-info {
            margin: 30px 0;
        }

        /* Section Title (e.g., "Participant Information") */
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #2c5aa0;
            margin-bottom: 15px;
            border-bottom: 1px solid #ddd;
            /* Thin bottom border */
            padding-bottom: 5px;
        }

        /* Information Table Styling */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            /* Removes spacing between table cells */
            margin-bottom: 20px;
        }

        /* Table Cell Styling */
        .info-table td {
            padding: 8px 12px;
            border: 1px solid #ddd;
            /* Light gray border for cells */
            vertical-align: top;
            /* Aligns content to the top of the cell */
        }

        /* Styling for the first column (labels) in the info table */
        .info-table td:first-child {
            background-color: #f8f9fa;
            /* Slightly darker background for labels */
            font-weight: bold;
            width: 30%;
            /* Sets width for the label column */
        }

        /* QR Section Styling */
        .qr-section {
            text-align: center;
            margin: 40px 0;
            padding: 20px;
            border: 2px solid #2c5aa0;
            /* Blue border around QR section */
            background-color: #f8f9fa;
            /* Light background */
        }

        /* QR Title */
        .qr-title {
            font-size: 16px;
            font-weight: bold;
            color: #2c5aa0;
            margin-bottom: 15px;
        }

        /* QR Code Image Container */
        .qr-code {
            margin: 15px 0;
        }

        /* Instructions Section Styling */
        .instructions {
            background-color: #fff3cd;
            /* Light yellow background */
            border: 1px solid #ffeaa7;
            /* Yellow border */
            padding: 15px;
            margin: 30px 0;
        }

        /* Instructions Title */
        .instructions-title {
            font-weight: bold;
            color: #856404;
            /* Dark yellow/brown text */
            margin-bottom: 10px;
        }

        /* Instructions Text */
        .instructions-text {
            color: #856404;
            font-size: 14px;
        }

        /* Footer Styling */
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            /* Top border for separation */
            font-size: 12px;
            color: #666;
        }

        /* Event Details Section */
        .event-details {
            margin: 20px 0;
            padding: 15px;
            background-color: #e8f4f8;
            /* Light blue background */
            border-left: 4px solid #2c5aa0;
            /* Blue left border */
        }

        .event-details h4 {
            margin: 0 0 10px 0;
            color: #2c5aa0;
        }

        .event-details p {
            margin: 5px 0;
            font-size: 14px;
        }
    </style>
</head>

<body>
    {{-- Header section of the PDF --}}
    <div class="header">
        <h1 class="logo">PROSPERITY EXPO 2025</h1>
        <p class="subtitle">Indonesia-Australia Partnership</p>
    </div>

    {{-- Confirmation title displaying success status --}}
    <div class="confirmation-title">
        REGISTRATION CONFIRMED
    </div>

    {{-- Participant Information section --}}
    <div class="participant-info">
        <h2 class="section-title">Participant Information</h2>
        <table class="info-table">
            {{-- Table row for Full Name --}}
            <tr>
                <td>Full Name</td>
                <td>{{ $participant->name }}</td>
            </tr>
            {{-- Table row for Email Address --}}
            <tr>
                <td>Email Address</td>
                <td>{{ $participant->email }}</td>
            </tr>
            {{-- Table row for Company Name --}}
            <tr>
                <td>Company</td>
                <td>{{ $participant->company_name }}</td>
            </tr>
            {{-- Table row for Position --}}
            <tr>
                <td>Position</td>
                <td>{{ $participant->position }}</td>
            </tr>
            {{-- Table row for Participant Type --}}
            <tr>
                <td>Participant Type</td>
                <td>{{ $participant->participant_type }}</td>
            </tr>
            {{-- Table row for Contact Number --}}
            <tr>
                <td>Contact Number</td>
                <td>{{ $participant->contact }}</td>
            </tr>
        </table>
    </div>

    {{-- Event Details section --}}
    <div class="event-details">
        <h4>Event Information</h4>
        <p><strong>Event:</strong> Indonesia-Australia Prosperity Expo 2025</p>
        <p><strong>Focus:</strong> Trade, Investment, Tourism, Education & Technology</p>
        <p><strong>Partnership:</strong> Strengthening Indonesia-Australia Relations</p>
    </div>

    {{-- QR Code section for event entry --}}
    <div class="qr-section">
        <h3 class="qr-title">Your Entry Pass</h3>
        <p>Present this QR code at the event entrance</p>
        <div class="qr-code">
            {{-- Image tag for the QR code.
                 The 'src' attribute uses 'file://' protocol to directly reference a local file path.
                 $qrPath is passed from the controller and points to the saved QR code image.
                 This is crucial for DomPDF to correctly embed the image. --}}
            <img src="file://{{ $qrPath }}" alt="QR Code" width="150" height="150">
        </div>
        <p><strong>Important:</strong> Keep this QR code visible and readable</p>
    </div>

    {{-- Instructions for event day --}}
    <div class="instructions">
        <div class="instructions-title">Event Day Instructions:</div>
        <div class="instructions-text">
            • Bring this PDF confirmation (printed or digital)<br>
            • Present QR code at registration desk for quick check-in<br>
            • Contact event support if you encounter any issues
        </div>
    </div>

    {{-- Footer section of the PDF --}}
    <div class="footer">
        <p><strong>Indonesia-Australia Prosperity Expo 2025</strong></p>
        <p>Building Economic Bridges • Creating Opportunities • Fostering Sustainable Growth</p>
        <p>For inquiries: info@prosperity-expo.com | www.prosperity-expo.com</p>
    </div>
</body>

</html>