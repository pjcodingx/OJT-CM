<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Completion</title>
    <style>
        /* Reset and base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', serif;
            margin: 0;
            padding: 0;
            background: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* Certificate container - Full letter size landscape */
        .certificate-container {
            width: 11in;
            height: 8.5in;
            background: #ffffff;
            position: relative;
            margin: 0 auto;
            overflow: hidden;
            padding: 0;
        }

        /* Background pattern */
        .certificate-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><rect width="100" height="100" fill="white"/><path d="M0 50 L100 50 M50 0 L50 100" stroke="%23e8f5e8" stroke-width="0.5"/></svg>');
            pointer-events: none;
        }

        /* Border decoration */
        .border-decoration {
            position: absolute;
            top: 40px;
            left: 40px;
            right: 40px;
            bottom: 40px;
            border: 3px solid #2c3e50;
        }

        .border-decoration::before {
            content: '';
            position: absolute;
            top: 15px;
            left: 15px;
            right: 15px;
            bottom: 15px;
            border: 1px solid #34495e;
        }

        /* Header section - Fixed positioning */
        .header {
            position: absolute;
            top: 80px;
            left: 0;
            right: 0;
            text-align: center;
            z-index: 2;
        }

        .company-logo {
            width: 90px;
            height: 90px;
            margin: 0 auto 20px;
            display: block;
        }

        .company-name {
            font-size: 28px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 8px;
            letter-spacing: 1.5px;
        }

        .company-subtitle {
            font-size: 14px;
            color: #7f8c8d;
            margin-bottom: 30px;
        }

        .certificate-title {
            font-size: 42px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 15px;
            letter-spacing: 3px;
        }

        .certificate-subtitle {
            font-size: 20px;
            color: #34495e;
            margin-bottom: 40px;
        }

        /* Content section - Proper spacing */
        .content {
            position: absolute;
            top: 320px;
            left: 0;
            right: 0;
            text-align: center;
            z-index: 2;
            padding: 0 100px;
        }

        .presented-to {
            font-size: 16px;
            color: #7f8c8d;
            margin-bottom: 10px;
            letter-spacing: 1.5px;
        }

        .recipient-name {
            font-size: 44px;
            font-weight: bold;
            color: #2c3e50;
            margin: 5px 0 30px 0;
            padding: 0 40px 15px;
            border-bottom: 3px solid #2d7a2d;
            display: inline-block;
        }

        .description {
            font-size: 16px;
            color: #34495e;
            line-height: 1.8;
            margin: 30px auto;
            max-width: 700px;
            padding: 0 20px;
        }

        /* Footer section - Fixed at bottom */
        .footer {
            position: absolute;
            bottom: 80px;
            left: 0;
            right: 0;
            z-index: 2;
            padding: 0 100px;
        }

        .footer-table {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
        }

        .footer-table td {
            width: 33.33%;
            text-align: center;
            vertical-align: bottom;
            padding: 0 25px;
        }

        .signature-section {
            text-align: center;
        }

        .signature-line {
            border-bottom: 2px solid #2c3e50;
            height: 70px;
            position: relative;
            margin-bottom: 8px;
        }

        .signature-image {
            position: absolute;
            bottom: 5px;
            left: 50%;
            transform: translateX(-50%);
            max-width: 150px;
            max-height: 50px;
        }

        .signature-name {
            font-size: 14px;
            color: #2c3e50;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .signature-title {
            font-size: 12px;
            color: #7f8c8d;
        }

        .date-section {
            text-align: center;
            padding-top: 20px;
        }

        .date-label {
            font-size: 14px;
            color: #2c3e50;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .date-value {
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 8px;
            min-width: 150px;
            color: #2c3e50;
            font-size: 14px;
            display: inline-block;
        }

        /* Decorative elements - Better positioning */
        .corner-decoration {
            position: absolute;
            width: 50px;
            height: 50px;
            border: 4px solid #a8d3a8;
        }

        .corner-decoration.top-left {
            top: 60px;
            left: 60px;
            border-right: none;
            border-bottom: none;
        }

        .corner-decoration.top-right {
            top: 60px;
            right: 60px;
            border-left: none;
            border-bottom: none;
        }

        .corner-decoration.bottom-left {
            bottom: 60px;
            left: 60px;
            border-right: none;
            border-top: none;
        }

        .corner-decoration.bottom-right {
            bottom: 60px;
            right: 60px;
            border-left: none;
            border-top: none;
        }

        .decorative-line {
            position: absolute;
            background: #a8d3a8;
        }

        .decorative-line.top {
            top: 180px;
            left: 150px;
            right: 150px;
            height: 2px;
        }

        .decorative-line.bottom {
            bottom: 180px;
            left: 150px;
            right: 150px;
            height: 2px;
        }

        .ornamental-dot {
            position: absolute;
            width: 15px;
            height: 15px;
            border: 2px solid #a8d3a8;
            border-radius: 50%;
            background: #ffffff;
        }

        .ornamental-dot.top-center {
            top: 173px;
            left: 50%;
            margin-left: -7.5px;
        }

        .ornamental-dot.bottom-center {
            bottom: 173px;
            left: 50%;
            margin-left: -7.5px;
        }

        /* Diamond accents */
        .diamond-accent {
            position: absolute;
            width: 0;
            height: 0;
            border: 10px solid transparent;
            border-bottom: 15px solid #a8d3a8;
        }

        .diamond-accent::after {
            content: '';
            position: absolute;
            top: 15px;
            left: -10px;
            width: 0;
            height: 0;
            border: 10px solid transparent;
            border-top: 15px solid #a8d3a8;
        }

        .diamond-accent.top-left {
            top: 200px;
            left: 160px;
        }

        .diamond-accent.top-right {
            top: 200px;
            right: 160px;
        }

        .diamond-accent.bottom-left {
            bottom: 200px;
            left: 160px;
        }

        .diamond-accent.bottom-right {
            bottom: 200px;
            right: 160px;
        }

        /* Print styles */
        @media print {
            body {
                background: white;
                margin: 0;
                padding: 0;
                width: 11in;
                height: 8.5in;
            }

            .certificate-container {
                box-shadow: none;
                margin: 0;
                padding: 0;
                width: 100%;
                height: 100%;
            }
        }

        @page {
            size: 11in 8.5in landscape;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <div class="border-decoration"></div>

        <!-- Decorative elements -->
        <div class="corner-decoration top-left"></div>
        <div class="corner-decoration top-right"></div>
        <div class="corner-decoration bottom-left"></div>
        <div class="corner-decoration bottom-right"></div>

        <div class="decorative-line top"></div>
        <div class="decorative-line bottom"></div>

        <div class="ornamental-dot top-center"></div>
        <div class="ornamental-dot bottom-center"></div>

        <div class="diamond-accent top-left"></div>
        <div class="diamond-accent top-right"></div>
        <div class="diamond-accent bottom-left"></div>
        <div class="diamond-accent bottom-right"></div>

        <!-- Header content -->
        <div class="header">
            <img src="{{ public_path('favicon/cmlogo.png') }}" alt="College Logo" class="company-logo">
            <div class="company-name">THE COLLEGE OF MAASIN</div>
            <div class="company-subtitle">Nurturing Excellence Through Education</div>

            <div class="certificate-title">CERTIFICATE</div>
           <div class="presented-to">THIS IS TO CERTIFY THAT</div>
        </div>

        <!-- Main content -->
        <div class="content">

             <div class="certificate-subtitle">OF COMPLETION</div>
            <div class="recipient-name">{{ $student->name }}</div>

            <div class="description">
                has successfully completed the {{ $student->course->name }} program
                and has demonstrated proficiency in all required competencies through comprehensive
                On-the-Job Training. This achievement represents dedication to professional development
                and readiness for industry practice.
            </div>
        </div>

        <!-- Footer with signatures -->
        <div class="footer">
            <table class="footer-table">
                <tr>
                    <td>
                        <div class="signature-section">
                            <div class="signature-line">
                                <img src="{{ public_path('signatures/faculty_signature.png') }}" alt="OJT Coordinator Signature" class="signature-image">
                            </div>
                            <div class="signature-name">OJT Coordinator</div>
                            <div class="signature-title">Academic Affairs</div>
                        </div>
                    </td>
                    <td>
                        <div class="date-section">
                            <div class="date-label">Date Issued</div>
                            <div class="date-value">December 15, 2024</div>
                        </div>
                    </td>
                    <td>
                        <div class="signature-section">
                            <div class="signature-line">
                                  <img src="{{ public_path('signatures/faculty_signature.png') }}" alt="OJT Coordinator Signature" class="signature-image">
                            </div>
                            <div class="signature-name">College President</div>
                            <div class="signature-title">The College of Maasin</div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
