<div class="list-group">
  @foreach($commentsForSidebar as $comment)
  <a href="{{ route('posts.show', $comment->post->id) }}" class="list-group-item list-group-item-action flex-column align-items-start">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1">{{ $comment->user->name }}</h5>
      <small>{{ $comment->created_at }}</small>
    </div>
    <p class="mb-1">{{ $comment->body }}</p>
    <small>{{ $comment->post->title }}</small>
  </a>
  @endforeach
</div>
