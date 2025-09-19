@extends('layouts.student')

@section('content')
<style>
    /* Modern Container */
    .feedback-container {
        max-width: 800px;
        margin: 2rem auto;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border-radius: 24px;
        padding: 2rem;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }


    .feedback-header {
        background: linear-gradient(135deg, #107936 0%, #0f6a2f 100%);
        color: white;
        padding: 2rem;
        border-radius: 20px;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(16, 121, 54, 0.2);
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .feedback-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Ccircle cx='30' cy='30' r='4'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .feedback-header h1 {
        font-size: 1.75rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
        position: relative;
        z-index: 1;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .feedback-header p {
        font-size: 1rem;
        opacity: 0.9;
        margin: 0;
        position: relative;
        z-index: 1;
    }


    .feedback-card {
        background: white;
        border-radius: 20px;
        padding: 2.5rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(226, 232, 240, 0.5);
        position: relative;
        overflow: hidden;
    }

    .feedback-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(135deg, #107936 0%, #0f6a2f 100%);
    }


    .company-profile {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 2px solid #f1f5f9;
    }

    .company-logo {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #107936;
        background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);
        flex-shrink: 0;
        box-shadow: 0 4px 16px rgba(16, 121, 54, 0.2);
        transition: all 0.3s ease;
    }

    .company-logo:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 24px rgba(16, 121, 54, 0.3);
    }

    .company-info {
        flex: 1;
    }

    .company-name {
        font-size: 1.75rem;
        font-weight: 700;
        color: #107936;
        margin: 0 0 0.5rem 0;
        user-select: none;
    }

    .company-subtitle {
        font-size: 1rem;
        color: #64748b;
        margin: 0;
        font-weight: 500;
    }


    .rating-section {
        text-align: center;
        margin-bottom: 2rem;
        padding: 1.5rem;
        background: linear-gradient(135deg, #fef7e7 0%, #fef3c7 100%);
        border-radius: 16px;
        border: 1px solid #fbbf24;
    }

    .rating-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: #92400e;
        margin-bottom: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .stars {
        font-size: 2rem;
        color: #f59e0b;
        letter-spacing: 4px;
        margin-bottom: 0.5rem;
        user-select: none;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        display: block;
    }

    .rating-text {
        font-size: 0.875rem;
        color: #92400e;
        font-weight: 500;
    }


    .feedback-content {
        position: relative;
    }

    .feedback-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .feedback-title::before {
        content: '💬';
        font-size: 1.5rem;
    }

    .feedback-text {
        font-size: 1rem;
        line-height: 1.7;
        color: #475569;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        padding: 1.5rem;
        border-radius: 12px;
        border-left: 4px solid #107936;
        font-style: italic;
        position: relative;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .feedback-text::before {
        content: '"';
        font-size: 3rem;
        color: #107936;
        position: absolute;
        top: -10px;
        left: 10px;
        opacity: 0.3;
        font-family: Georgia, serif;
    }

    .no-feedback-card {
        background: white;
        border-radius: 20px;
        padding: 3rem 2rem;
        text-align: center;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        border: 2px dashed #e2e8f0;
    }

    .no-feedback-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: #94a3b8;
    }

    .no-feedback-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #475569;
        margin-bottom: 0.75rem;
    }

    .no-feedback-text {
        font-size: 1rem;
        color: #64748b;
        line-height: 1.6;
        max-width: 400px;
        margin: 0 auto;
    }


    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.025em;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
        margin-bottom: 1rem;
    }

    .status-badge::before {
        content: '✓';
        font-size: 1rem;
    }


    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .feedback-card {
        animation: fadeInUp 0.6s ease-out;
    }

    .no-feedback-card {
        animation: fadeInUp 0.6s ease-out;
    }


    @media (max-width: 768px) {
        .feedback-container {
            margin: 1rem;
            padding: 1.5rem;
        }

        .feedback-header {
            padding: 1.5rem;
        }

        .feedback-header h1 {
            font-size: 1.5rem;
        }

        .feedback-card {
            padding: 1.5rem;
        }

        .company-profile {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }

        .company-logo {
            width: 60px;
            height: 60px;
        }

        .company-name {
            font-size: 1.5rem;
        }

        .stars {
            font-size: 1.5rem;
            letter-spacing: 2px;
        }

        .feedback-text {
            font-size: 0.9rem;
            padding: 1.25rem;
        }

        .no-feedback-card {
            padding: 2rem 1.5rem;
        }
    }
</style>

<div class="feedback-container">
    <div class="feedback-header">
        <h1>Company Feedback</h1>
        <p>Review your performance evaluation from your internship company</p>
    </div>

    @if($ratings)
        <div class="feedback-card">
            <div class="status-badge">Feedback Received</div>

            <div class="company-profile">

                <img src="{{ $companyPhoto }}" alt="{{ $ratings->company->name }} Logo" class="company-logo">
                <div class="company-info">
                    <h2 class="company-name">{{ $ratings->company->name }}</h2>
                    <p class="company-subtitle">Internship Company</p>
                </div>


            </div>

            <div class="rating-section">
                <div class="rating-title">Performance Rating</div>
                <div class="stars" aria-label="Rating: {{ $ratings->rating }} out of 5 stars">
                    {{ str_repeat('⭐', $ratings->rating) }}
                </div>
                <div class="rating-text">{{ $ratings->rating }} out of 5 stars</div>
            </div>

            <div class="feedback-content">
                <h3 class="feedback-title">Company Feedback</h3>
                <div class="feedback-text">
                    {{ $ratings->feedback ?? 'No specific feedback comments were provided, but you received a positive rating!' }}
                </div>

            </div>
        </div>
    @else
        <div class="no-feedback-card">
            <div class="no-feedback-icon">⏳</div>
            <h2 class="no-feedback-title">Feedback Pending</h2>
            <p class="no-feedback-text">
                Your internship company hasn't provided feedback yet. Once they submit their evaluation,
                you'll be able to view your rating and feedback comments here.
            </p>
        </div>
    @endif
</div>
@endsection
