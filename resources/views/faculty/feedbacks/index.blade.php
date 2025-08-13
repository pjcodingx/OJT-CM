@extends('layouts.faculty')

@section('content')
<style>

    .feedback-container {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border-radius: 24px;
        padding: 2rem;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
        margin: 1rem;
    }


    .page-header {
        background: linear-gradient(135deg, #107936 0%, #0f6a2f 100%);
        color: white;
        padding: 2rem 2.5rem;
        border-radius: 20px;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(16, 121, 54, 0.2);
    }

    .page-header h2 {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        font-size: 1.875rem;
        font-weight: 700;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .page-header p {
        margin-top: 0.5rem;
        opacity: 0.9;
        font-size: 1rem;
    }


    .modern-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        table-layout: fixed;
        background: white;
    }


    .modern-table thead {
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
    }

    .modern-table thead th {
        padding: 1.5rem 1.25rem;
        color: white;
        font-weight: 600;
        text-align: left;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        user-select: none;
    }


    .modern-table thead th:nth-child(1) { width: 25%; }
    .modern-table thead th:nth-child(2) { width: 25%; }
    .modern-table thead th:nth-child(3) { width: 15%; }
    .modern-table thead th:nth-child(4) { width: 35%; }


    .modern-table tbody tr {
        background: white;
        border-bottom: 1px solid #f1f5f9;
        transition: all 0.3s ease;
    }

    .modern-table tbody tr:hover {
        background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);
        transform: translateX(4px);
        box-shadow: 0 4px 20px rgba(16, 121, 54, 0.1);
    }

    .modern-table tbody tr:last-child {
        border-bottom: none;
    }

    .modern-table tbody td {
        padding: 1.25rem;
        color: #475569;
        font-size: 0.875rem;
        line-height: 1.5;
        vertical-align: top;
        overflow: hidden;
    }


    .student-cell {
        font-weight: 600;
        color: #1e293b;
    }

    .company-cell {
        color: #107936;
        font-weight: 500;
    }

    .rating-cell {
        color: #f59e0b;
        font-size: 1.125rem;
        letter-spacing: 1px;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }


    .feedback-cell {
        position: relative;
        text-align: center;
        vertical-align: middle;
        width: 35%;
    }


    .view-feedback-btn {
        background: linear-gradient(135deg, #107936 0%, #0f6a2f 100%);
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.8125rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.025em;
        box-shadow: 0 2px 8px rgba(16, 121, 54, 0.2);
        white-space: nowrap;
        min-width: 120px;
    }

    .view-feedback-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 121, 54, 0.3);
        background: linear-gradient(135deg, #0f6a2f 0%, #0d5a28 100%);
    }

    .view-feedback-btn:active {
        transform: translateY(0);
        box-shadow: 0 2px 8px rgba(16, 121, 54, 0.2);
    }

    .view-more-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 121, 54, 0.3);
        background: linear-gradient(135deg, #0f6a2f 0%, #0d5a28 100%);
    }

    .view-more-btn:active {
        transform: translateY(0);
        box-shadow: 0 2px 8px rgba(16, 121, 54, 0.2);
    }


    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(8px);
        align-items: center;
        justify-content: center;
        animation: fadeIn 0.3s ease;
    }

    .modal.active {
        display: flex;
    }

    .modal-content {
        background: white;
        padding: 2.5rem;
        border-radius: 20px;
        max-width: 700px;
        width: 90%;
        box-shadow: 0 25px 80px rgba(0, 0, 0, 0.2);
        position: relative;
        transform: scale(0.9);
        animation: modalSlideIn 0.3s ease forwards;
    }

    .modal-header {
        background: linear-gradient(135deg, #107936 0%, #0f6a2f 100%);
        color: white;
        padding: 1.5rem 2rem;
        margin: -2.5rem -2.5rem 2rem -2.5rem;
        border-radius: 20px 20px 0 0;
        position: relative;
    }

    .modal-header h3 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 600;
    }

    .modal-close {
        position: absolute;
        top: 1.25rem;
        right: 1.5rem;
        font-size: 1.5rem;
        font-weight: bold;
        color: rgba(255, 255, 255, 0.8);
        cursor: pointer;
        transition: all 0.3s ease;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }

    .modal-close:hover {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        transform: rotate(90deg);
    }

    .modal-feedback-text {
        color: #475569;
        line-height: 1.6;
        font-size: 0.95rem;
        white-space: pre-wrap;
        word-wrap: break-word;
    }


    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes modalSlideIn {
        to {
            transform: scale(1);
            opacity: 1;
        }
    }


    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #64748b;
    }

    .empty-state svg {
        width: 64px;
        height: 64px;
        margin-bottom: 1rem;
        opacity: 0.5;
    }


    .pagination-wrapper {
        margin-top: 2rem;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.5rem;
    }

    .pagination {
        display: flex;
        list-style: none;
        margin: 0;
        padding: 0;
        gap: 0.25rem;
        align-items: center;
    }

    .pagination .page-item {
        margin: 0;
    }

    .pagination .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1rem;
        min-width: 44px;
        height: 44px;
        color: #475569;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 500;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .pagination .page-link:hover {
        color: #107936;
        background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);
        border-color: #107936;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(16, 121, 54, 0.15);
    }

    .pagination .page-item.active .page-link {
        color: white;
        background: linear-gradient(135deg, #107936 0%, #0f6a2f 100%);
        border-color: #107936;
        box-shadow: 0 4px 12px rgba(16, 121, 54, 0.25);
        font-weight: 600;
    }

    .pagination .page-item.disabled .page-link {
        color: #94a3b8;
        background: #f8fafc;
        border-color: #e2e8f0;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    .pagination .page-item.disabled .page-link:hover {
        color: #94a3b8;
        background: #f8fafc;
        border-color: #e2e8f0;
        transform: none;
        box-shadow: none;
    }


    .pagination .page-item:first-child .page-link,
    .pagination .page-item:last-child .page-link {
        padding: 0.75rem 1.25rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.025em;
        font-size: 0.8125rem;
    }

    .pagination .page-item:first-child .page-link {
        background: linear-gradient(135deg, #64748b 0%, #475569 100%);
        color: white;
        border-color: #64748b;
    }

    .pagination .page-item:last-child .page-link {
        background: linear-gradient(135deg, #64748b 0%, #475569 100%);
        color: white;
        border-color: #64748b;
    }

    .pagination .page-item:first-child .page-link:hover,
    .pagination .page-item:last-child .page-link:hover {
        background: linear-gradient(135deg, #475569 0%, #334155 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(71, 85, 105, 0.25);
    }


    .pagination-info {
        text-align: center;
        margin-top: 1rem;
        color: #64748b;
        font-size: 0.875rem;
        background: rgba(248, 250, 252, 0.8);
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(226, 232, 240, 0.5);
    }


    .results-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding: 1rem 1.5rem;
        background: rgba(255, 255, 255, 0.7);
        border-radius: 12px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(226, 232, 240, 0.5);
    }

    .results-counter {
        color: #64748b;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .results-counter .count {
        color: #107936;
        font-weight: 700;
    }


    @media (max-width: 768px) {
        .feedback-container {
            margin: 0.5rem;
            padding: 1rem;
        }

        .page-header {
            padding: 1.5rem;
        }

        .modern-table thead th,
        .modern-table tbody td {
            padding: 1rem 0.75rem;
        }

        .modal-content {
            margin: 1rem;
            width: calc(100% - 2rem);
        }

        .pagination .page-link {
            padding: 0.5rem 0.75rem;
            min-width: 40px;
            height: 40px;
            font-size: 0.8125rem;
        }

        .pagination .page-item:first-child .page-link,
        .pagination .page-item:last-child .page-link {
            padding: 0.5rem 1rem;
        }

        .results-header {
            flex-direction: column;
            gap: 0.75rem;
            align-items: flex-start;
        }
    }
    tbody td{
        text-align: center;
    }
</style>

<div class="feedback-container">
    <div class="page-header">
        <h2>Company Feedback Dashboard</h2>
        <p>Review feedback and ratings from companies for your assigned students</p>
    </div>

    <!-- Results Header -->
    {{-- <div class="results-header">
        <div class="results-counter">
            Showing {{ $students->count() }} student records
        </div>
    </div> --}}

    <table class="modern-table">
        <thead>
            <tr >
                <th style="text-align: center;">Student Name</th>
                <th style="text-align: center;">Company</th>
                <th style="text-align: center;">Rating</th>
                <th style="text-align: center;">Feedback</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $student)
                @forelse($student->ratings as $rating)
                    <tr>
                        <td class="student-cell">{{ $student->name }}</td>
                        <td class="company-cell">{{ $rating->company->name ?? 'N/A' }}</td>
                        <td class="rating-cell">{{ str_repeat('⭐', $rating->rating) }}</td>
                        <td class="feedback-cell">
                            <button
                                class="view-feedback-btn"
                                data-feedback="{{ htmlspecialchars($rating->feedback ?? '', ENT_QUOTES, 'UTF-8') }}"
                                data-student="{{ htmlspecialchars($student->name, ENT_QUOTES, 'UTF-8') }}"
                                data-company="{{ htmlspecialchars($rating->company->name ?? 'N/A', ENT_QUOTES, 'UTF-8') }}"
                            >
                                View Feedback
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="empty-state" style="color:rgb(255, 76, 76);">
                            No feedback available for {{ $student->name }}
                        </td>
                    </tr>
                @endforelse
            @empty
                <tr>
                    <td colspan="4" class="empty-state">
                        <svg fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                        <p >No student feedback data available</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>


    <div class="pagination-wrapper">
        {{ $students->withQueryString()->links('vendor.pagination.prev-next-only') }}
    </div>
</div>


<div id="feedback-modal" class="modal" aria-hidden="true" role="dialog" aria-modal="true">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Complete Feedback Details</h3>
            <span class="modal-close" aria-label="Close">&times;</span>
        </div>
        <div class="modal-body">
            <div id="modal-student-info" style="margin-bottom: 1rem; padding: 1rem; background: #f8fafc; border-radius: 10px; font-size: 0.875rem; color: #64748b;"></div>
            <div id="modal-feedback-text" class="modal-feedback-text"></div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('feedback-modal');
        const modalText = document.getElementById('modal-feedback-text');
        const modalStudentInfo = document.getElementById('modal-student-info');
        const modalClose = modal.querySelector('.modal-close');


        document.querySelectorAll('.view-feedback-btn').forEach(button => {
            button.addEventListener('click', function() {
                const feedback = this.getAttribute('data-feedback');
                const student = this.getAttribute('data-student');
                const company = this.getAttribute('data-company');

                modalStudentInfo.innerHTML = `<strong>Student:</strong> ${student} | <strong>Company:</strong> ${company}`;
                modalText.textContent = feedback;
                modal.classList.add('active');
                modal.setAttribute('aria-hidden', 'false');
                document.body.style.overflow = 'hidden';
            });
        });


        function closeModal() {
            modal.classList.remove('active');
            modal.setAttribute('aria-hidden', 'true');
            modalText.textContent = '';
            modalStudentInfo.textContent = '';
            document.body.style.overflow = 'auto';
        }

        modalClose.addEventListener('click', closeModal);


        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeModal();
            }
        });


        document.addEventListener('keydown', function(e) {
            if (e.key === "Escape" && modal.classList.contains('active')) {
                closeModal();
            }
        });
    });
</script>
@endsection
