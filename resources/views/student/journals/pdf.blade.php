<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $student->name }} - Journal ({{ $journal->journal_date }})</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            line-height: 1.5;
            font-size: 14px;
            color: #111827;
            margin: 0;
            padding: 30px 40px;
        }


        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            width: 60px;
            height: 60px;
            margin: 0 auto 8px;
        }

        .school-name {
            font-size: 16px;
            font-weight: bold;
            color: #064e17;
            margin: 3px 0;
        }

        .document-title {
            font-size: 13px;
            font-weight: 600;
            color: #6b7280;
            margin-top: 5px;
        }

        /* Student Info Section */
        .student-info {
            margin: 20px 0;
        }

        .info-row {
            margin-bottom: 6px;
        }

        .info-label {
            font-weight: 600;
            color: #064e17;
            display: inline-block;
            width: 80px;
        }

        .info-value {
            color: #374151;
            display: inline;
        }

        /* Journal Content Section */
        .section-title {
            font-size: 13px;
            font-weight: bold;
            color: #064e17;
            margin: 18px 0 10px 0;
        }

        .content {
           line-height: 1.5;
    margin-top: 10px;
    text-align: justify;
        }

        .content p {
            margin: 0 0 8px 0;
        }

        /* Attachments Section */
        .attachments {
            margin-top: 18px;
        }

        .attachments-title {
            font-weight: bold;
            color: #064e17;
            margin-bottom: 8px;
            font-size: 12px;
        }

        .attachments ul {
            margin: 5px 0;
            padding-left: 20px;
        }

        .attachments li {
            margin-bottom: 4px;
            color: #6b7280;
        }

        /* Footer */
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9px;
            color: #9ca3af;
        }
    </style>
</head>
<body>
    <!-- Header with Logo -->
    <div class="header">
        <img src="{{ public_path('images/cmlogo.png') }}" alt="School Logo" class="logo">
        <div class="school-name">The College Of Maasin</div>
        <div class="document-title">Daily Journal Report</div>
    </div>

    <!-- Student Information -->
    <div class="student-info">
        <div class="info-row">
            <span class="info-label">Name:</span>
            <span class="info-value">{{ $student->name }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Email:</span>
            <span class="info-value">{{ $student->email }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Company:</span>
            <span class="info-value">{{ $student->company->name ?? 'N/A' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Location:</span>
            <span class="info-value">{{ $student->company->address ?? 'N/A' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Date:</span>
            <span class="info-value">{{ \Carbon\Carbon::parse($journal->journal_date)->format('F d, Y') }} at {{ \Carbon\Carbon::parse($journal->created_at)->format('g:i A') }}</span>
        </div>
    </div>

    <!-- Journal Content -->
    <div class="section-title">Journal Entry</div>
    <div class="content">
        {!! nl2br(e($journal->content)) !!}
    </div>

    <!-- Attachments -->
    @if($journal->attachments->count())
        <div class="attachments">
            <div class="attachments-title">Attachments ({{ $journal->attachments->count() }})</div>
            <ul>
                @foreach ($journal->attachments as $file)
                    <li>{{ basename($file->file_path) }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        Generated on {{ \Carbon\Carbon::now()->format('F d, Y g:i A') }}
    </div>
</body>
</html>
