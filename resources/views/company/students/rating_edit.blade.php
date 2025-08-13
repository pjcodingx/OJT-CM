@extends('layouts.company')

@section('content')
<style>

    .profile-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 30px;
        background-color: #1f2937;
        color: #fff;
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.6);
        display: flex;
        gap: 40px;
        flex-wrap: wrap;
    }

    .profile-left {
        flex: 1 1 45%;
        min-width: 300px;
    }

    .profile-right {
        flex: 1 1 45%;
        min-width: 300px;
        background-color: #374151;
        padding: 20px;
        border-radius: 10px;
        box-shadow: inset 0 0 10px #00000088;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        color: #fff;
    }

    .profile-header {
        display: flex;
        align-items: center;
        margin-bottom: 25px;
    }

    .profile-header img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid #107936;
        margin-right: 25px;
    }

    .profile-header h2 {
        margin: 0;
        font-size: 26px;
    }

    .profile-details {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .detail-box {
        flex: 1 1 45%;
        background-color: #374151;
        padding: 15px;
        border-radius: 10px;
        color: #fff;
    }

    .detail-label {
        font-size: 14px;
        color: #9ca3af;
    }

    .detail-value {
        font-size: 16px;
        margin-top: 5px;
        color: #fff;
    }


    .rating-label {
        font-weight: bold;
        margin-bottom: 8px;
    }

    #star-rating {
        font-size: 2.5rem;
        color: #ccc;
        cursor: pointer;
        user-select: none;
    }

    #star-rating .star {
        padding: 0 4px;
        transition: color 0.2s ease-in-out;
    }

    #star-rating .star.selected,
    #star-rating .star.hovered {
        color: #ffcc00;
    }

    textarea#feedback {
        width: 100%;
        margin-top: 15px;
        border-radius: 8px;
        padding: 10px;
        border: none;
        font-size: 16px;
        resize: vertical;
        min-height: 120px;
        background-color: #1f2937;
        color: white;
    }

    button.submit-btn {
        margin-top: 20px;
        background-color: #107936;
        color: white;
        border: none;
        padding: 12px;
        font-weight: bold;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button.submit-btn:hover {
        background-color: #0b5c22;
    }

    @media (max-width: 768px) {
        .profile-container {
            flex-direction: column;
            padding: 20px;
        }

        .profile-left, .profile-right {
            flex: 1 1 100%;
            min-width: unset;
        }
    }
</style>

<div class="profile-container">

    <div class="profile-left">
        <div class="profile-header">
            <img src="{{ asset('uploads/student_photos/' . ($student->photo ?? 'default.png')) }}" alt="Profile Photo" class="profile-img">
            <h2>{{ $student->name }}</h2>
        </div>

        <div class="profile-details">
            <div class="detail-box">
                <div class="detail-label">Email</div>
                <div class="detail-value">{{ $student->email }}</div>
            </div>
            <div class="detail-box">
                <div class="detail-label">Course</div>
                <div class="detail-value">{{ $student->course->name }}</div>
            </div>
            <div class="detail-box">
                <div class="detail-label">Company</div>
                <div class="detail-value">{{ $student->company->name ?? 'N/A' }}</div>
            </div>
            <div class="detail-box">
                <div class="detail-label">Company Location</div>
                <div class="detail-value">{{ $student->company->address ?? 'N/A' }}</div>
            </div>
            <div class="detail-box">
                <div class="detail-label">OJT Adviser</div>
                <div class="detail-value">{{ $student->faculty->name ?? 'N/A' }}</div>
            </div>
            <div class="detail-box">
                <div class="detail-label">Required OJT Hours</div>
                <div class="detail-value">{{ $student->required_hours }} hours</div>
            </div>
        </div>
    </div>


    <div class="profile-right">
        <form method="POST" action="{{ route('company.students.rating.update', $student->id) }}">
            @csrf

            <label class="rating-label" for="star-rating">Rate this Student:</label>
            <div id="star-rating">
                @for ($i = 1; $i <= 5; $i++)
                    <span class="star" data-value="{{ $i }}">&#9734;</span> <!-- empty star -->
                @endfor
            </div>
            <input type="hidden" name="rating" id="rating" value="{{ old('rating', $rating->rating ?? '') }}">
            @error('rating')
                <div style="color: #ff4d4f; margin-top: 5px;">{{ $message }}</div>
            @enderror

            <label for="feedback" class="rating-label" style="margin-top: 20px;">Feedback / Comments:</label>
            <textarea id="feedback" name="feedback" rows="12" maxlength="1000">{{ old('feedback', $rating->feedback ?? '') }}</textarea>
            @error('feedback')
                <div style="color: #ff4d4f; margin-top: 5px;">{{ $message }}</div>
            @enderror

            <button type="submit" class="submit-btn">Submit Rating</button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('#star-rating .star');
        const ratingInput = document.getElementById('rating');
        let currentRating = parseInt(ratingInput.value) || 0;

        function highlightStars(rating) {
            stars.forEach(star => {
                const starValue = parseInt(star.dataset.value);
                if (starValue <= rating) {
                    star.classList.add('selected');
                } else {
                    star.classList.remove('selected');
                }
            });
        }

        highlightStars(currentRating);

        stars.forEach(star => {
            star.addEventListener('mouseover', () => {
                const hoverValue = parseInt(star.dataset.value);
                highlightStars(hoverValue);
            });

            star.addEventListener('mouseout', () => {
                highlightStars(currentRating);
            });

            star.addEventListener('click', () => {
                currentRating = parseInt(star.dataset.value);
                ratingInput.value = currentRating;
                highlightStars(currentRating);
            });
        });
    });
</script>
@endsection
