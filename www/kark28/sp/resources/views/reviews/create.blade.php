@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Leave a Review for {{ $business->name }}</h2>

        <form action="{{ route('reviews.store') }}" method="POST">
            @csrf

            <input type="hidden" name="business_id" value="{{ $business->id }}">

            <div class="mb-3">
                <label for="rating" class="form-label">Rating:</label>
                <div id="star-rating" class="text-warning" style="font-size: 2rem; cursor: pointer;">
                    @for ($i = 1; $i <= 5; $i++)
                        <span data-value="{{ $i }}">☆</span>
                    @endfor
                </div>
                <input type="hidden" name="rating" id="rating" value="0" required>
            </div>

            <div class="mb-3">
                <label for="comment" class="form-label">Comment (optional):</label>
                <textarea name="comment" id="comment" class="form-control" rows="4"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Submit Review</button>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const stars = document.querySelectorAll('#star-rating span');
            const ratingInput = document.getElementById('rating');

            stars.forEach(star => {
                star.addEventListener('click', () => {
                    const rating = star.getAttribute('data-value');
                    ratingInput.value = rating;
                    updateStars(rating);
                });
            });

            function updateStars(rating) {
                stars.forEach(star => {
                    star.textContent = star.getAttribute('data-value') <= rating ? '★' : '☆';
                });
            }
        });
    </script>
@endpush
