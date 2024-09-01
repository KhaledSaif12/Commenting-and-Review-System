<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Review</title>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('layout/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('styles/style.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Edit Review</h1>

        <!-- Edit Review Form -->
        <form action="{{ route('comments.update', $comment->id) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="content_id" value="{{ $comment->content_id }}">

            <div class="mb-3">
                <label for="comment" class="form-label">Comment</label>
                <textarea id="comment" name="comment_text" class="form-control" rows="3" required>{{ old('comment_text', $comment->comment_text) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="rating" class="form-label">Rating</label>
                <div id="star-rating" class="star-rating">
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="star {{ $i <= old('rating', $comment->rating) ? 'filled' : '' }}" data-value="{{ $i }}">&#9733;</span>
                    @endfor
                </div>
                <input type="hidden" id="rating" name="rating" value="{{ old('rating', $comment->rating) }}" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Review</button>
        </form>

        <div class="mt-3">
            <a href="{{ route('content.show', $comment->content_id) }}" class="btn btn-secondary">Back to Content</a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="{{ asset('layout/dist/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Custom JS -->
    <script src="{{ asset('scripts/app.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('#star-rating .star');
            const ratingInput = document.getElementById('rating');

            stars.forEach(star => {
                star.addEventListener('click', () => {
                    const value = star.getAttribute('data-value');
                    ratingInput.value = value;
                    stars.forEach(s => {
                        s.classList.toggle('filled', s.getAttribute('data-value') <= value);
                    });
                });
            });
        });
    </script>
</body>
</html>
