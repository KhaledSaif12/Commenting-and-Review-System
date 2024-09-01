
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comment and Review System</title>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('layout/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('styles/style.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<header class="p-3 mb-3 border-bottom">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
          <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="{{ route('index') }}" class="nav-link px-2 link-secondary">Home</a></li>
          <li><a href="{{ route('profile') }}" class="nav-link px-2 link-body-emphasis">Profile</a></li>
        </ul>

        <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
          <input type="search" class="form-control" placeholder="Search..." aria-label="Search">
        </form>

        <div class="dropdown text-end">
          <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="	https://avatars.githubusercontent.com/u/129229836?v=4" alt="mdo" width="32" height="32" class="rounded-circle">
          </a>
          <ul class="dropdown-menu text-small" style="">
            <li><a class="dropdown-item" href="#">New project...</a></li>
            <li><a class="dropdown-item" href="{{ route('profile') }}">Settings</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="{{ route('logout') }}">Sign out</a></li>
          </ul>
        </div>
      </div>
    </div>
  </header>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">{{ $content->title }}</h1>
        <p>{{ $content->description }}</p>

        <!-- Average Rating Display -->
                <div class="mb-4">
                    <h4>Average Rating:</h4>
                    <div id="rating-display" class="star-rating"></div>
                    <span id="rating-value">{{ $averageRating }}</span>/5
                </div>
        <!-- Sorting and Filtering Options -->
        <form action="{{ route('content.show', $content->id) }}" method="GET" class="mb-4 d-flex justify-content-between align-items-center">
            <div>
                <label for="sort-reviews" class="form-label">Sort by:</label>
                <select id="sort-reviews" name="sort_by" class="form-select d-inline-block w-auto">
                    <option value="date-desc" {{ $sortBy == 'date-desc' ? 'selected' : '' }}>Date (Newest First)</option>
                    <option value="date-asc" {{ $sortBy == 'date-asc' ? 'selected' : '' }}>Date (Oldest First)</option>
                    <option value="rating-desc" {{ $sortBy == 'rating-desc' ? 'selected' : '' }}>Rating (Highest First)</option>
                    <option value="rating-asc" {{ $sortBy == 'rating-asc' ? 'selected' : '' }}>Rating (Lowest First)</option>
                </select>
            </div>
            <div>
                <label for="filter-rating" class="form-label">Filter by Rating:</label>
                <select id="filter-rating" name="filter_rating" class="form-select d-inline-block w-auto">
                    <option value="all" {{ $filterRating == 'all' ? 'selected' : '' }}>All Ratings</option>
                    <option value="5" {{ $filterRating == '5' ? 'selected' : '' }}>5 Stars</option>
                    <option value="4" {{ $filterRating == '4' ? 'selected' : '' }}>4 Stars & Above</option>
                    <option value="3" {{ $filterRating == '3' ? 'selected' : '' }}>3 Stars & Above</option>
                    <option value="2" {{ $filterRating == '2' ? 'selected' : '' }}>2 Stars & Above</option>
                    <option value="1" {{ $filterRating == '1' ? 'selected' : '' }}>1 Star & Above</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Apply</button>
        </form>

        <!-- Reviews Section -->
        <div id="reviews">
            <h3>Reviews</h3>
            <ul id="review-list" class="list-group">
                @forelse ($comments as $comment)
                    <li class="list-group-item">
                        <strong>{{ $comment->user->name }}</strong>
                        <div class="star-rating">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $comment->rating)
                                    <span class="star filled">★</span>
                                @else
                                    <span class="star">☆</span>
                                @endif
                            @endfor
                        </div>
                        <p>{{ $comment->comment_text }}</p>
                        @if ($comment->user_id == Auth::id())
                        <div>
                            <a href="{{ route('comments.edit', $comment->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    @endif
                        <div class="like-dislike d-flex align-items-center">
                            <!-- Like Button -->
                            <form action="{{ route('likes.toggle', ['commentId' => $comment->id]) }}" method="POST" class="me-2">
                                @csrf
                                <input type="hidden" name="content_id" value="{{ $content->id }}">
                                <button type="submit" class="btn btn-sm btn-outline-success">👍</button>
                            </form>
                            <span class="me-3">{{ $comment->likes_count }}</span>

                            <!-- Dislike Button -->
                            <form action="{{ route('dislikes.toggle', ['commentId' => $comment->id]) }}" method="POST" class="me-2">
                                @csrf
                                <input type="hidden" name="content_id" value="{{ $content->id }}">
                                <button type="submit" class="btn btn-sm btn-outline-danger">👎</button>
                            </form>
                            <span>{{ $comment->dislikes_count }}</span>
                        </div>
                    </li>
                @empty
                    <li class="list-group-item">No reviews yet.</li>
                @endforelse
            </ul>
        </div>

        <!-- Pagination Controls -->
        <div id="pagination" class="mt-4 d-flex justify-content-between">
            <button id="prev-page" class="btn btn-secondary" disabled>Previous</button>
            <button id="next-page" class="btn btn-secondary">Next</button>
        </div>

        <!-- New Review Form -->
        <div class="mt-5">
            <h3>Submit a Review</h3>
            <form id="new-review-form" action="{{ route('reviews') }}" method="POST">
                @csrf
                <input type="hidden" name="content_id" value="{{ $content->id }}">
                <div class="mb-3">
                    <label for="comment" class="form-label">Comment</label>
                    <textarea id="comment" name="comment_text" class="form-control" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="rating" class="form-label">Rating</label>
                    <div id="star-rating" class="star-rating">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="star" data-value="{{ $i }}">&#9733;</span>
                        @endfor
                    </div>
                    <input type="hidden" id="rating" name="rating" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit Review</button>
                <div id="feedback" class="mt-3"></div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="{{ asset('layout/dist/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Custom JS -->
    <script src="{{ asset('scripts/app.js') }}"></script>
</body>
</html>

