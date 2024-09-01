
@extends('layout.master')

@section('content')

<main>





  <!-- Marketing messaging and featurettes
  ================================================== -->
  <!-- Wrap the rest of the page in another container to center all the content. -->

  <div class="container marketing">

   <!-- Three columns of text below the carousel -->
<!-- Three columns of text below the carousel -->
<div class="row">
    @foreach ($contents as $content)
    <div class="col-lg-4">
        <svg class="bd-placeholder-img rounded-circle" width="140" height="140" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder" preserveAspectRatio="xMidYMid slice" focusable="false">
            <title>Placeholder</title>
            <rect width="100%" height="100%" fill="var(--bs-secondary-color)"/>
        </svg>
        <h2 class="fw-normal">{{ $content->title }}</h2>
        <p>{{ $content->description }}</p>

        <!-- Display Like and Dislike counts -->
        <p>
            Likes: <span class="badge bg-success">{{ $content->likes_count }}</span>
            Dislikes: <span class="badge bg-danger">{{ $content->dislikes_count }}</span>
        </p>

        <!-- Like and Dislike buttons -->
        <form action="{{ route('likescomments.toggleLike', $content->id) }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-success">
                Like
            </button>
        </form>

        <form action="{{ route('likescomments.toggleDislike', $content->id) }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-danger">
                Dislike
            </button>
        </form>

        <p><a class="btn btn-secondary" href="{{ route('content.show', $content->id) }}">View details &raquo;</a></p>
    </div><!-- /.col-lg-4 -->
    @endforeach
</div><!-- /.row -->


    <!-- START THE FEATURETTES -->

    <hr class="featurette-divider">
    @foreach ($contents  as $content )
    <div class="row featurette">
      <div class="col-md-7">
        <h2 class="featurette-heading fw-normal lh-1">{{$content ->title}}<span class="text-body-secondary"><br>{{$content ->created_at}}</span></h2>
        <p class="lead">{{$content ->description}}.</p>
      </div>
      <div class="col-md-5">
        <svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 500x500" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="var(--bs-secondary-bg)"/><text x="50%" y="50%" fill="var(--bs-secondary-color)" dy=".3em">500x500</text></svg>
      </div>
    </div>
    @endforeach

    <hr class="featurette-divider">

    <!-- /END THE FEATURETTES -->



  @endsection

