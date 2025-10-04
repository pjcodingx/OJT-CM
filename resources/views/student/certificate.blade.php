@extends('layouts.student')

@section('title', 'Certificate Preview')

@section('content')
<style>
     @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Open+Sans:wght@300;400;600&display=swap');

  .certificate-container {
        margin: 0;
        padding: 20px;
        background: #f8f9fa;
        font-family: 'Open Sans', sans-serif;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .certificate {
    width: 800px;
    min-height: 600px;
    background: #ffffff;
    position: relative;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    border-radius: 8px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    justify-content: space-between; /* Ensures footer stays at bottom */
}

    .certificate::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg,
            transparent 0%,
            rgba(45, 122, 45, 0.05) 25%,
            transparent 50%,
            rgba(26, 90, 26, 0.05) 75%,
            transparent 100%);
        pointer-events: none;
    }

    .border-decoration {
        position: absolute;
        top: 20px;
        left: 20px;
        right: 20px;
        bottom: 20px;
        border: 3px solid #2c3e50;
        border-radius: 4px;
    }

    .border-decoration::before {
        content: '';
        position: absolute;
        top: 10px;
        left: 10px;
        right: 10px;
        bottom: 10px;
        border: 1px solid #34495e;
        border-radius: 2px;
    }

    .header {
        text-align: center;
        padding: 30px 60px 15px;
        position: relative;
        z-index: 2;
        margin-top: 10px;
    }

    .company-logo {
        width: 80px;
        height: 80px;

        border-radius: 50%;
        margin: 0 auto 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
        font-weight: bold;
    }

    .company-name {
        font-family: 'Playfair Display', serif;
        font-size: 22px;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 5px;
        letter-spacing: 1px;
        position: relative;
    }

    .company-subtitle {
        font-size: 12px;
        color: #7f8c8d;
        margin-bottom: 25px;
        font-weight: 300;
    }

    .certificate-title {
        font-family: 'Playfair Display', serif;
        font-size: 32px;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 10px;
        letter-spacing: 2px;
    }

    .certificate-subtitle {
        font-size: 16px;
        color: #34495e;
        margin-bottom: 30px;
        font-weight: 300;
    }

    .content {
    text-align: center;
    padding: 0 60px;
    position: relative;
    z-index: 2;
    display: flex;
    flex-direction: column;
    justify-content: center;
    margin-bottom: 10px;
}

    .presented-to {
        font-size: 14px;
        color: #7f8c8d;
        margin-bottom: 3px;
        font-weight: 300;
        letter-spacing: 1px;
    }

    .recipient-name {
        font-family: 'Playfair Display', serif;
        font-size: 36px;
        font-weight: 400;
        color: #2c3e50;
        margin-bottom: 25px;
        padding: 0 20px;
        border-bottom: 2px solid #2d7a2d;
        display: inline-block;
        padding-bottom: 5px;
    }

    .description {
        font-size: 14px;
        color: #34495e;
        line-height: 1.6;
        margin-bottom: 20px;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
    }

    .footer {
    display: flex;
    justify-content: space-between; /* spreads 3 sections evenly */
    align-items: flex-end; /* ensures all items align at bottom */
    padding: 20px 80px 30px;
    position: relative;
    z-index: 2;
    gap: 20px; /* optional spacing between sections */
}


    .signature-section {
        text-align: center;
        min-width: 150px;
    }

   .signature-line {
    border-bottom: 2px solid #2c3e50;
    height: 60px; /* fixed height to match signature image */
    display: flex;
    align-items: flex-end;
    justify-content: center;
}


    .signature-image {
        max-width: 120px;
        max-height: 40px;
        object-fit: contain;
    }

    .signature-name {
        font-size: 12px;
        color: #2c3e50;
        font-weight: 600;
        margin-bottom: 3px;
    }

    .signature-title {
        font-size: 10px;
        color: #7f8c8d;
        font-weight: 300;
          margin-bottom: 15px;
    }

    .date-issued {
        text-align: center;
        font-size: 12px;
        color: #7f8c8d;
        margin-bottom: 10px;
    }

    .unavailable-notice {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.95);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        z-index: 10;
        border-radius: 8px;
    }

    .unavailable-content {
        background: #fff5f5;
        border: 2px solid #fed7d7;
        border-radius: 10px;
        padding: 40px;
        text-align: center;
        max-width: 400px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }

    .unavailable-text {
        font-size: 20px;
        color: #e53e3e;
        margin-bottom: 15px;
        font-weight: 600;
    }

    .unavailable-description {
        font-size: 14px;
        color: #718096;
        margin-bottom: 25px;
        line-height: 1.5;
    }

    .btn {
        display: inline-block;
        padding: 12px 25px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        margin: 5px;
        background-color: #6c757d;
        color: #ffffff;
        font-size: 14px;
    }

    .btn:hover {
        background-color: #5a6268;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        color: #ffffff;
    }

    /* Decorative Elements */
    .decorative-elements {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        pointer-events: none;
        z-index: 1;
    }

    .corner-decoration {
        position: absolute;
        width: 60px;
        height: 60px;
        background: linear-gradient(45deg, #2d7a2d, #1a5a1a);
        opacity: 0.1;
    }

    .corner-decoration.top-left {
        top: 40px;
        left: 40px;
        clip-path: polygon(0 0, 100% 0, 0 100%);
    }

    .corner-decoration.top-right {
        top: 40px;
        right: 40px;
        clip-path: polygon(100% 0, 100% 100%, 0 0);
    }

    .corner-decoration.bottom-left {
        bottom: 40px;
        left: 40px;
        clip-path: polygon(0 0, 100% 100%, 0 100%);
    }

    .corner-decoration.bottom-right {
        bottom: 40px;
        right: 40px;
        clip-path: polygon(100% 0, 100% 100%, 0 100%);
    }

    .elegant-lines {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        pointer-events: none;
        z-index: 1;
        margin: 10px;
    }

    .horizontal-line {
        position: absolute;
        height: 2px;
        background: linear-gradient(90deg, transparent, #2d7a2d, transparent);
        left: 100px;
        right: 100px;
        opacity: 0.3;
    }

    .horizontal-line.top {
        top: 120px;
    }

    .horizontal-line.bottom {
        bottom: 120px;
    }

    .vertical-accent {
        position: absolute;
        width: 4px;
        height: 80px;
        background: linear-gradient(180deg, transparent, #2d7a2d, #1a5a1a, transparent);
        opacity: 0.4;
    }

    .vertical-accent.left {
        left: 70px;
        top: 50%;
        transform: translateY(-50%);
    }

    .vertical-accent.right {
        right: 70px;
        top: 50%;
        transform: translateY(-50%);
    }

    .ornamental-circle {
        position: absolute;
        width: 12px;
        height: 12px;
        border: 2px solid #2d7a2d;
        border-radius: 50%;
        background: rgba(45, 122, 45, 0.1);
        opacity: 0.6;
    }

    .ornamental-circle.top-center {
        top: 118px;
        left: 50%;
        transform: translateX(-50%);
    }

    .ornamental-circle.bottom-center {
        bottom: 118px;
        left: 50%;
        transform: translateX(-50%);
    }

    .leaf-accent {
        position: absolute;
        width: 20px;
        height: 20px;
        background: #2d7a2d;
        opacity: 0.2;
        clip-path: polygon(50% 0%, 0% 100%, 100% 100%);
    }

    .leaf-accent.top-left {
        top: 160px;
        left: 120px;
        transform: rotate(45deg);
    }

    .leaf-accent.top-right {
        top: 160px;
        right: 120px;
        transform: rotate(-45deg);
    }

    .leaf-accent.bottom-left {
        bottom: 160px;
        left: 120px;
        transform: rotate(135deg);
    }

    .leaf-accent.bottom-right {
        bottom: 160px;
        right: 120px;
        transform: rotate(-135deg);
    }

    .flourish-line {
        position: absolute;
        height: 1px;
        background: linear-gradient(90deg, transparent, #2d7a2d, #1a5a1a, #2d7a2d, transparent);
        opacity: 0.4;
    }

    .flourish-line.under-title {
        top: 200px;
        left: 250px;
        right: 250px;
    }

    .flourish-line.above-content {
        top: 290px;
        left: 180px;
        right: 180px;
    }

    @media print {
        .certificate-container {
            background: white;
            padding: 0;
        }

        .certificate {
            box-shadow: none;
            border-radius: 0;
        }

        .btn {
            display: none;
        }
    }

    @media (max-width: 900px) {
        .certificate {
            width: 90vw;
            height: auto;
            aspect-ratio: 4/3;
        }

        .header {
            padding: 30px 40px 15px;
        }

        .content {
            padding: 0 40px;
        }

        .footer {
            padding: 0 60px 30px;
        }

        .certificate-title {
            font-size: 28px;
        }

        .recipient-name {
            font-size: 28px;
        }

        .description {
            font-size: 12px;
        }
    }


</style>

    {{-- !@if($available)
        <a href="{{ route('certificate_pdf.preview', $student->id) }}"
        class="btn btn-primary"
        target="_blank">
        Download Certificate
        </a>
    @endif --}}

<div class="certificate-container">
    <div class="certificate">
        <div class="border-decoration"></div>

        <div class="decorative-elements">
            <div class="corner-decoration top-left"></div>
            <div class="corner-decoration top-right"></div>
            <div class="corner-decoration bottom-left"></div>
            <div class="corner-decoration bottom-right"></div>
        </div>

        <div class="elegant-lines">
            <div class="horizontal-line top"></div>
            <div class="horizontal-line bottom"></div>
            <div class="vertical-accent left"></div>
            <div class="vertical-accent right"></div>
            <div class="ornamental-circle top-center"></div>
            <div class="ornamental-circle bottom-center"></div>
            <div class="leaf-accent top-left"></div>
            <div class="leaf-accent top-right"></div>
            <div class="leaf-accent bottom-left"></div>
            <div class="leaf-accent bottom-right"></div>
            <div class="flourish-line under-title"></div>
            <div class="flourish-line above-content"></div>
        </div>

        <div class="header">
            <div class="company-logo"> <img src="{{ asset('images/cmlogo.png') }}" alt="OJT Coordinator Signature" class="signature-image"  style="max-width: 900px; max-height: 100px;">
            </div>
            <div class="company-name">THE COLLEGE OF MAASIN</div>
            <div class="company-subtitle">Nurturing Excellence Through Education</div>

            <div class="certificate-title">CERTIFICATE</div>
            <div class="certificate-subtitle">OF COMPLETION</div>
        </div>

        <div class="content">
            <div class="presented-to">THIS IS TO CERTIFY THAT</div>
            <div class="recipient-name">{{ $student->name }}</div>

            <div class="description">
                has successfully completed the {{ $student->course->name }} program and has demonstrated
                proficiency in all required competencies through comprehensive On-the-Job Training.
                This achievement represents dedication to professional development and readiness
                for industry practice.
            </div>
        </div>

        <div class="footer">
            <div class="signature-section">
                <div class="signature-line">
                    @if(isset($signature_path) && $signature_path)
                      <img src="{{ asset('signatures/faculty_signature.png') }}" alt="OJT Coordinator Signature" class="signature-image"  style="max-width: 900px; max-height: 100px;">

                    @endif
                </div>
                <div class="signature-name">OJT Coordinator</div>
                <div class="signature-title">Academic Affairs</div>
            </div>

            <div class="date-issued">
                <div style="margin-bottom: 10px; color: #2c3e50; font-weight: 600;">Date Issued</div>
                <div style="border-bottom: 2px solid #2c3e50; padding-bottom: 5px; min-width: 120px; color: #2c3e50;">
                    {{ $date }}
                </div>
            </div>

            <div class="signature-section">
                <div class="signature-line">
                    <img src="{{ asset('signatures/faculty_signature.png') }}" alt="OJT Coordinator Signature" class="signature-image"  style="max-width: 900px; max-height: 100px;">
                </div>
                <div class="signature-name">College President</div>
                <div class="signature-title">The College of Maasin</div>
            </div>
        </div>

        @if(!$available)
            <div class="unavailable-notice">
                <div class="unavailable-content">
                    <p class="unavailable-text">🔒 Certificate Not Available Yet</p>
                    <p class="unavailable-description">
                        Complete your OJT requirements to unlock your certificate.
                        Once approved, you'll be able to view and download your official certificate.
                    </p>
                    <a href="{{ url()->previous() }}" class="btn">Go Back</a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
