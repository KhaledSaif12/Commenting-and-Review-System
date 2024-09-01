document.addEventListener('DOMContentLoaded', function() {
    // Handle interactive star rating input
    const stars = document.querySelectorAll('.star-rating .star');
    const ratingInput = document.getElementById('rating');

    stars.forEach(star => {
        star.addEventListener('click', function() {
            const value = this.getAttribute('data-value');
            ratingInput.value = value;

            // Update the stars
            stars.forEach(s => {
                if (s.getAttribute('data-value') <= value) {
                    s.classList.add('filled');
                } else {
                    s.classList.remove('filled');
                }
            });
        });
    });

    // Display average rating
    const averageRating = parseFloat(document.getElementById('rating-value').innerText);
    const starContainer = document.getElementById('rating-display');

    for (let i = 1; i <= 5; i++) {
        const star = document.createElement('span');
        star.classList.add('star');
        star.innerHTML = '&#9733;'; // Star character

        // Add filled class for the integer part of the average rating
        if (i <= Math.floor(averageRating)) {
            star.classList.add('filled');
        }
        // Optionally add a half star class for the fractional part
        else if (i === Math.ceil(averageRating) && averageRating % 1 !== 0) {
            star.classList.add('half-filled');
        }

        starContainer.appendChild(star);
    }
});
document.addEventListener('DOMContentLoaded', function() {
    function handleLikeDislike(commentId, type) {
        fetch('/api/like-dislike', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ comment_id: commentId, type: type })
        })
        .then(response => response.json())
        .then(data => {
            // Update UI based on response
            if (data.message === 'Like/Dislike saved successfully!') {
                // Find the relevant comment item
                const commentElement = document.querySelector(`#review-list li[data-comment-id="${commentId}"]`);
                const likeCount = commentElement.querySelector('.like-count');
                const dislikeCount = commentElement.querySelector('.dislike-count');

                // Update counts
                likeCount.textContent = data.likes_count;
                dislikeCount.textContent = data.dislikes_count;
            }
        })
        .catch(error => console.error('Error:', error));
    }
});
cript>
        document.addEventListener('DOMContentLoaded', function () {
            const stars = document.querySelectorAll('#star-rating .star');
            const ratingInput = document.getElementById('rating');

            stars.forEach(star => {
                star.addEventListener('mouseover', function () {
                    const value = this.getAttribute('data-value');
                    stars.forEach(s => s.classList.toggle('filled', s.getAttribute('data-value') <= value));
                });

                star.addEventListener('mouseout', function () {
                    const value = ratingInput.value;
                    stars.forEach(s => s.classList.toggle('filled', s.getAttribute('data-value') <= value));
                });

                star.addEventListener('click', function () {
                    const value = this.getAttribute('data-value');
                    ratingInput.value = value;
                    stars.forEach(s => s.classList.toggle('filled', s.getAttribute('data-value') <= value));
                });
            });
        });
