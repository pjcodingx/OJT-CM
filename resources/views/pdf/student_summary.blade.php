<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Student Summary Report</title>
    <style>
        body { font-family: Arial, sans-serif; color: #222; font-size: 12px; }
        .header { text-align: center; border-bottom: 2px solid #0b4222; padding-bottom: 8px; margin-bottom: 10px; }
        .header img { width: 70px; height: 70px; object-fit: contain; }
       .header h1 { font-size: 16px; margin-bottom: 10px;}
        .header p { font-size: 10px; margin-bottom: 5px; }

        .profile-table { width: 100%; margin-top: 12px; border-collapse: collapse; }
        .profile-left { width: 120px; vertical-align: top; padding-right: 10px; }
        .profile-left img { width: 110px; height: 110px; object-fit: cover; border: 1px solid #ccc; }
        .profile-right { vertical-align: top; padding-left: 8px; }

        .info {
            margin: 0 0 4px 0;
            font-size: 12px;
        }

        .info strong {
            color: #0b4222;
            display: inline;
            width: auto;
            min-width: 80px;
        }


        .cards-row { width: 100%; margin-top: 18px; border-collapse: collapse; }
        .cards-row td { padding: 6px; vertical-align: top; }

        .card {
            padding: 6px;
            border-radius: 4px;
            text-align: center;
            border: 1px solid #ddd;
            font-size: 11px;
        }
        .card .label { font-size: 11px; color: #333; }
       .card .value { font-size: 14px; font-weight: bold; }

        .feedbacks { margin-top: 10px; font-size: 11px; color: #333; white-space: pre-wrap; }

        .signatures { width: 100%; margin-top: 26px; }
        .sign-box { width: 45%; display:inline-block; vertical-align: top; text-align:center; padding-top: 18px; }

        .footer { margin-top: 26px; text-align: center; font-size: 11px; color: #666; }


        .page-number { position: fixed; bottom: 20px; right: 30px; font-size: 10px; color: #999; }
    </style>
</head>
<body>



    <div class="header">
            @php
                $logoPath = public_path('images/welcome/cmlogo.png');
                $logoData = null;
                if (file_exists($logoPath)) {
                    $type = pathinfo($logoPath, PATHINFO_EXTENSION);
                    $logoData = 'data:image/' . $type . ';base64,' . base64_encode(file_get_contents($logoPath));
                }
            @endphp

        <img src="{{ $logoData ?? asset('images/welcome/cmlogo.png') }}" alt="Logo">

        <h1>{{ $schoolName ?? config('app.name') }}</h1>
        <p><em>"{{ $schoolQuote ?? '' }}"</em></p>
        <p>{{ $schoolPlace ?? '' }}</p>

        <div style="margin-top:8px; font-weight:bold; font-size:14px;">OJT Summary Report</div>
        <div style="font-size:11px; margin-top:4px;">Date: {{ $date ?? now()->format('F d, Y') }}</div>
    </div>


   <table class="profile-table">
    <tr>
        <td class="profile-left">
            @if($profileImageData)
                <img src="{{ $profileImageData }}" alt="Profile" width="80" height="80">
            @else
                <span style="color:red; text-align: center;">NO IMAGE PLEASE UPLOAD!</span>
            @endif
        </td>

        <td class="profile-right">
            <table>
                <tr>
                    <td style="padding-right: 20px; vertical-align: top;">
                        <p class="info"><strong>Name:</strong> {{ $student->name }}</p>
                        <p class="info"><strong>Email:</strong> {{ $student->email }}</p>
                        <p class="info"><strong>Course:</strong> {{ $student->course->name ?? '--' }}</p>
                        <p class="info"><strong>Company:</strong> {{ $student->company->name ?? '--' }}</p>
                    </td>
                    <td style="vertical-align: top;">
                        <p class="info"><strong>Company Address:</strong> {{ $student->company->address ?? '--' }}</p>
                        <p class="info"><strong>OJT Adviser:</strong> {{ $student->faculty->name ?? '--' }}</p>
                        <p class="info"><strong>Required Hours:</strong> {{ $student->required_hours ?? 0 }}</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>



    <table class="cards-row" style="margin-top:18px;">
        <tr>
            <td style="width:25%">
                <div class="card">
                    <div class="label">Total Attendance</div>
                    <div class="value">{{ $totalAttendance }}</div>
                </div>
            </td>
            <td style="width:25%">
                <div class="card">
                    <div class="label">Absences</div>
                    <div class="value">{{ $calculateAbsences}}</div>
                </div>
            </td>
            <td style="width:25%">
                <div class="card">
                    <div class="label">Number of Appeals</div>
                    <div class="value">{{ $numberOfAppeals }}</div>
                </div>
            </td>
            <td style="width:25%">
                <div class="card">
                    <div class="label">Submitted Journals</div>
                    <div class="value">{{ $submittedJournals }}</div>
                </div>
            </td>
        </tr>

        <tr style="margin-top:6px;">
            <td style="width:25%; padding-top:8px;">
                <div class="card">
                    <div class="label">Rating</div>
                    <div class="value" style="margin-bottom: 10px;">
                        {{ $averageRating }}
                       <div style="font-family: DejaVu Sans, sans-serif; font-size: 16px; color:#f1c40f;">
                            @for ($i = 0; $i < floor($averageRating); $i++)
                                &#9733; {{-- filled star --}}
                            @endfor
                            @for ($i = 0; $i < 5 - floor($averageRating); $i++)
                                <span style="color:#ccc;">&#9734;</span> {{-- empty star --}}
                            @endfor
                        </div>

                    </div>
                </div>
            </td>

            <td style="width:50%;" colspan="2">
               <div class="card" style="margin-top:3px; text-align:left;">
                <div class="label">Feedback from {{ $student->company->name }}</div>
                <div class="feedbacks">
                    {!! nl2br(e($feedbacksText ?? '--')) !!}
                </div>
            </div>
            </td>

            <td style="width:25%; padding-top:8px;">
                <div class="card">
                    <div class="label">Accumulated OJT Hours</div>
                    <div class="value">{{ $accumulatedHours }}</div>
                </div>
            </td>


        </tr>
    </table>

     <div class="metric-item" style="grid-column: span 2;">
                <div class="label" style="margin-top: 20px;">Completion Progress</div>
                <div style="background: #ecf0f1; height: 20px; border-radius: 10px; margin: 10px 0;">
                    <div style="background: #3498db; height: 100%; width: {{ ($accumulatedHours / ($student->required_hours ?? 1)) * 100 }}%;
                         border-radius: 10px; text-align: right; padding-right: 10px; color: white; font-size: 11px; line-height: 20px;">
                        {{ round(($accumulatedHours / ($student->required_hours ?? 1)) * 100) }}%
                    </div>
                </div>
            </div>


    <div class="signatures">
        <div class="sign-box" style="float:left; width:45%; text-align:center;">
            <div style="height:60px;"></div>
            <div>_____________________________</div>
            <div>Company Representative</div>
        </div>

        <div class="sign-box" style="float:right; width:45%; text-align:center;">
            <div style="height:60px;"></div>
            <div>_____________________________</div>
            <div>OJT Adviser</div>
        </div>
        <div style="clear:both;"></div>
    </div>

    <div class="footer" style="margin-top: 10px;">
        Generated by TCM OJT Monitoring System
    </div>




</body>
</html>
